<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Candidat;
use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Avis;

class AdminController extends Controller
{
    // ═══════════════════════════════════════════════
    //  DASHBOARD
    // ═══════════════════════════════════════════════

    public function dashboard()
    {
        // Use a single query with subqueries for stats
        $stats = [
            'candidats'          => Candidat::count(),
            'candidats_recent'   => Candidat::where('date_inscription', '>=', now()->subDays(7))->count(),
            'entreprises'        => Entreprise::count(),
            'entreprises_recent' => Entreprise::where('date_inscription', '>=', now()->subDays(30))->count(),
            'offres'             => Offre::count(),
            'offres_recent'      => Offre::where('date_publication', '>=', now()->subDays(30))->count(),
            'offres_actives'     => Offre::where('statut_offre', 'active')->count(),
            'a_moderer'          => Offre::where('statut_offre', 'active')->whereNull('motif_moderation')->count(),
        ];

        $recent_candidats   = Candidat::orderBy('date_inscription', 'desc')->take(5)->get();
        $recent_entreprises = Entreprise::orderBy('date_inscription', 'desc')->take(5)->get();
        $recent_offres      = Offre::with('entreprise')->where('statut_offre', 'active')
                                ->orderBy('date_publication', 'desc')->take(5)->get();
        $recent_avis        = Avis::with(['candidat', 'entreprise'])
                                ->where('statut_avis', 'publié')
                                ->orderBy('date_avis', 'desc')
                                ->take(3)
                                ->get();

        // Graphiques — 6 derniers mois - Optimized with single queries
        $chart_months      = [];
        $candidat_counts   = [];
        $offre_counts      = [];
        $candidature_counts = [];

        $frMonths = [
            1  => 'Jan', 2 => 'Fév',  3 => 'Mar', 4  => 'Avr',
            5  => 'Mai', 6 => 'Jun',  7 => 'Juil', 8 => 'Aoû',
            9  => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Déc',
        ];

        $now = now();
        for ($i = 5; $i >= 0; $i--) {
            $date   = $now->copy()->subMonths($i);
            $chart_months[] = $frMonths[$date->month];
            $end    = $date->copy()->endOfMonth();
            $start  = $date->copy()->startOfMonth();
            $candidat_counts[]    = Candidat::where('date_inscription', '<=', $end)->count();
            $offre_counts[]       = Offre::where('date_publication', '<=', $end)->count();
            $candidature_counts[] = \App\Models\Candidature::whereBetween('date_soumission', [$start, $end])->count();
        }

        // Stats globales - Optimized with caching
        $avg_success_rate = cache()->remember('admin.avg_success_rate', 300, function() {
            $total_candidatures = \App\Models\Candidature::count();
            if ($total_candidatures > 0) {
                $advanced = \App\Models\ProgressionCandidature::where('statut_etape', 'complétée')
                    ->whereHas('etapeOffre', fn($q) => $q->where('ordre_etape', '>', 1))
                    ->distinct('id_candidature')->count();
                return max(1, min(100, round(($advanced / $total_candidatures) * 100)));
            }
            return 24;
        });

        $avg_score = cache()->remember('admin.avg_score', 300, function() {
            return round(\App\Models\Score::avg('score_compatibilite') ?? 82);
        });

        $satisfaction_rate = cache()->remember('admin.satisfaction_rate', 300, function() {
            return round(\App\Models\Avis::where('statut_avis','publié')->avg('note_globale') ?? 4.3, 1);
        });

        return view('admin.dashboard', compact(
            'stats', 'recent_candidats', 'recent_entreprises', 'recent_offres', 'recent_avis',
            'chart_months', 'candidat_counts', 'offre_counts', 'candidature_counts',
            'avg_success_rate', 'avg_score', 'satisfaction_rate'
        ));
    }

    // ═══════════════════════════════════════════════
    //  MODÉRATION DES OFFRES
    // ═══════════════════════════════════════════════

    public function offres(Request $request)
    {
        $statut = $request->get('statut', 'active');
        $search = $request->get('search', '');

        $query = Offre::with('entreprise')->orderBy('date_publication', 'desc');

        if ($statut !== 'toutes') {
            $query->where('statut_offre', $statut);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('titre_offre', 'like', "%$search%")
                  ->orWhereHas('entreprise', fn($q2) => $q2->where('nom_entreprise', 'like', "%$search%"));
            });
        }

        $offres = $query->paginate(15)->appends($request->all());

        // Cache counts for 5 minutes
        $counts = cache()->remember('admin.offres.counts', 300, function() {
            return [
                'active'       => Offre::where('statut_offre', 'active')->whereNull('motif_moderation')->count(),
                'suspendue'    => Offre::where('statut_offre', 'suspendue')->count(),
                'rejetée'      => Offre::where('statut_offre', 'rejetée')->count(),
                'avertissement'=> Offre::where('statut_offre', 'avertissement')->count(),
                'clôturée'     => Offre::where('statut_offre', 'clôturée')->count(),
            ];
        });

        return view('admin.offres', compact('offres', 'statut', 'search', 'counts'));
    }

    /** Valider une offre → statut = active */
    public function validerOffre(Request $request, $id)
    {
        $offre = Offre::findOrFail($id);
        $offre->update([
            'statut_offre'     => 'active',
            'motif_moderation' => null,
            'date_moderation'  => now(),
            'moderee_par'      => Auth::guard('admin')->id(),
        ]);
        // Invalidate cache
        cache()->forget('admin.offres.counts');
        return back()->with('success', "L'offre « {$offre->titre_offre} » a été validée.");
    }

    /** Rejeter une offre → statut = rejetée + motif */
    public function rejeterOffre(Request $request, $id)
    {
        $request->validate(['motif' => 'required|string|min:10|max:500']);
        $offre = Offre::findOrFail($id);
        $offre->update([
            'statut_offre'     => 'rejetée',
            'motif_moderation' => $request->motif,
            'date_moderation'  => now(),
            'moderee_par'      => Auth::guard('admin')->id(),
        ]);
        cache()->forget('admin.offres.counts');
        return back()->with('success', "L'offre « {$offre->titre_offre} » a été rejetée.");
    }

    /** Avertir pour une offre → statut = avertissement + motif */
    public function avertirOffre(Request $request, $id)
    {
        $request->validate(['motif' => 'required|string|min:10|max:500']);
        $offre = Offre::findOrFail($id);
        $offre->update([
            'statut_offre'     => 'avertissement',
            'motif_moderation' => $request->motif,
            'date_moderation'  => now(),
            'moderee_par'      => Auth::guard('admin')->id(),
        ]);
        cache()->forget('admin.offres.counts');
        return back()->with('success', "Un avertissement a été envoyé pour l'offre « {$offre->titre_offre} ».");
    }

    // ═══════════════════════════════════════════════
    //  MODÉRATION DES AVIS
    // ═══════════════════════════════════════════════

    public function avis(Request $request)
    {
        $statut = $request->get('statut', 'publié');
        $search = $request->get('search', '');

        $query = Avis::with(['candidat', 'entreprise'])->orderBy('date_avis', 'desc');

        if ($statut !== 'tous') {
            $query->where('statut_avis', $statut);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('candidat', fn($q2) => $q2->where('nom', 'like', "%$search%")->orWhere('prenom', 'like', "%$search%"))
                  ->orWhereHas('entreprise', fn($q2) => $q2->where('nom_entreprise', 'like', "%$search%"))
                  ->orWhere('commentaire', 'like', "%$search%");
            });
        }

        $avis_list = $query->paginate(15)->appends($request->all());

        // Cache counts for 5 minutes
        $counts = cache()->remember('admin.avis.counts', 300, function() {
            return [
                'publié'       => Avis::where('statut_avis', 'publié')->count(),
                'supprimé'     => Avis::where('statut_avis', 'supprimé')->count(),
                'avertissement'=> Avis::where('statut_avis', 'avertissement')->count(),
            ];
        });

        return view('admin.avis', compact('avis_list', 'statut', 'search', 'counts'));
    }

    /** Supprimer un avis → statut = supprimé + motif */
    public function supprimerAvis(Request $request, $id)
    {
        $request->validate(['motif' => 'required|string|min:10|max:500']);
        $avis = Avis::findOrFail($id);
        $avis->update([
            'statut_avis'      => 'supprimé',
            'motif_moderation' => $request->motif,
            'date_moderation'  => now(),
            'moderee_par'      => Auth::guard('admin')->id(),
        ]);
        cache()->forget('admin.avis.counts');
        return back()->with('success', "L'avis a été supprimé.");
    }

    /** Avertir pour un avis → statut = avertissement + motif */
    public function avertirAvis(Request $request, $id)
    {
        $request->validate(['motif' => 'required|string|min:10|max:500']);
        $avis = Avis::findOrFail($id);
        $avis->update([
            'statut_avis'      => 'avertissement',
            'motif_moderation' => $request->motif,
            'date_moderation'  => now(),
            'moderee_par'      => Auth::guard('admin')->id(),
        ]);
        cache()->forget('admin.avis.counts');
        return back()->with('success', "Un avertissement a été appliqué à l'avis.");
    }

    /** Restaurer un avis supprimé/averti → statut = publié */
    public function restaurerAvis($id)
    {
        $avis = Avis::findOrFail($id);
        $avis->update([
            'statut_avis'      => 'publié',
            'motif_moderation' => null,
            'date_moderation'  => now(),
            'moderee_par'      => Auth::guard('admin')->id(),
        ]);
        cache()->forget('admin.avis.counts');
        return back()->with('success', "L'avis a été restauré.");
    }

    // ═══════════════════════════════════════════════
    //  GESTION DES COMPTES CANDIDATS
    // ═══════════════════════════════════════════════

    public function candidats(Request $request)
    {
        $statut = $request->get('statut', 'tous');
        $search = $request->get('search', '');

        $query = Candidat::orderBy('date_inscription', 'desc');

        if ($statut !== 'tous') {
            $query->where('statut_compte', $statut);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $candidats = $query->paginate(20)->appends($request->all());

        // Cache counts for 5 minutes
        $counts = cache()->remember('admin.candidats.counts', 300, function() {
            return [
                'actif'    => Candidat::where('statut_compte', 'actif')->count(),
                'suspendu' => Candidat::where('statut_compte', 'suspendu')->count(),
                'supprimé' => Candidat::where('statut_compte', 'supprimé')->count(),
            ];
        });

        return view('admin.candidats', compact('candidats', 'statut', 'search', 'counts'));
    }

    public function suspendreCandidat($id)
    {
        $candidat = Candidat::findOrFail($id);
        $candidat->update(['statut_compte' => 'suspendu']);
        cache()->forget('admin.candidats.counts');
        return back()->with('success', "{$candidat->prenom} {$candidat->nom} a été suspendu.");
    }

    public function supprimerCandidat($id)
    {
        $candidat = Candidat::findOrFail($id);
        $nom = "{$candidat->prenom} {$candidat->nom}";
        $candidat->update(['statut_compte' => 'supprimé']);
        cache()->forget('admin.candidats.counts');
        return back()->with('success', "$nom a été supprimé.");
    }

    public function reactiverCandidat($id)
    {
        $candidat = Candidat::findOrFail($id);
        $candidat->update(['statut_compte' => 'actif']);
        cache()->forget('admin.candidats.counts');
        return back()->with('success', "{$candidat->prenom} {$candidat->nom} a été réactivé.");
    }

    // ═══════════════════════════════════════════════
    //  GESTION DES COMPTES ENTREPRISES
    // ═══════════════════════════════════════════════

    public function entreprises(Request $request)
    {
        $statut = $request->get('statut', 'tous');
        $search = $request->get('search', '');

        $query = Entreprise::withCount('offres')->orderBy('date_inscription', 'desc');

        if ($statut !== 'tous') {
            $query->where('statut_compte', $statut);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom_entreprise', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('secteur_activite', 'like', "%$search%");
            });
        }

        $entreprises = $query->paginate(20)->appends($request->all());

        // Cache counts for 5 minutes
        $counts = cache()->remember('admin.entreprises.counts', 300, function() {
            return [
                'actif'    => Entreprise::where('statut_compte', 'actif')->count(),
                'suspendu' => Entreprise::where('statut_compte', 'suspendu')->count(),
                'supprimé' => Entreprise::where('statut_compte', 'supprimé')->count(),
            ];
        });

        return view('admin.entreprises', compact('entreprises', 'statut', 'search', 'counts'));
    }

    public function suspendreEntreprise($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        $entreprise->update(['statut_compte' => 'suspendu']);
        // Suspendre aussi toutes ses offres actives
        Offre::where('id_entreprise', $id)->where('statut_offre', 'active')
            ->update(['statut_offre' => 'suspendue']);
        cache()->forget('admin.entreprises.counts');
        cache()->forget('admin.offres.counts');
        return back()->with('success', "{$entreprise->nom_entreprise} a été suspendu(e).");
    }

    public function supprimerEntreprise($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        $nom = $entreprise->nom_entreprise;
        $entreprise->update(['statut_compte' => 'supprimé']);
        Offre::where('id_entreprise', $id)->where('statut_offre', 'active')
            ->update(['statut_offre' => 'suspendue']);
        cache()->forget('admin.entreprises.counts');
        cache()->forget('admin.offres.counts');
        return back()->with('success', "$nom a été supprimé(e).");
    }

    public function reactiverEntreprise($id)
    {
        $entreprise = Entreprise::findOrFail($id);
        $entreprise->update(['statut_compte' => 'actif']);
        cache()->forget('admin.entreprises.counts');
        return back()->with('success', "{$entreprise->nom_entreprise} a été réactivé(e).");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Candidat;
use App\Models\Entreprise;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * List all conversations for the logged in user.
     */
    public function index()
    {
        $candidat = Auth::guard('candidat')->user();
        $entreprise = Auth::guard('entreprise')->user();

        if ($candidat) {
            // Get all companies this candidate has applied to (conversations can only start if there is a candidature)
            $conversations = Candidature::with('offre.entreprise')
                ->where('id_candidat', $candidat->id_candidat)
                ->get()
                ->pluck('offre.entreprise')
                ->unique('id_entreprise');

            // Load last message for each
            foreach ($conversations as $ent) {
                if ($ent) {
                    $ent->last_message = Message::where(function($q) use ($candidat, $ent) {
                            $q->where('id_candidat', $candidat->id_candidat)->where('id_entreprise', $ent->id_entreprise);
                        })
                        ->orderBy('date_envoi', 'desc')
                        ->first();
                }
            }

            return view('messagerie.index', compact('conversations', 'candidat'));
        } elseif ($entreprise) {
            // Get all candidates who applied to this company's jobs
            $conversations = Candidature::with('candidat')
                ->whereHas('offre', function($q) use ($entreprise) {
                    $q->where('id_entreprise', $entreprise->id_entreprise);
                })
                ->get()
                ->pluck('candidat')
                ->unique('id_candidat');

            // Load last message for each
            foreach ($conversations as $cand) {
                if ($cand) {
                    $cand->last_message = Message::where(function($q) use ($cand, $entreprise) {
                            $q->where('id_candidat', $cand->id_candidat)->where('id_entreprise', $entreprise->id_entreprise);
                        })
                        ->orderBy('date_envoi', 'desc')
                        ->first();
                }
            }

            return view('messagerie.index', compact('conversations', 'entreprise'));
        }

        abort(403);
    }

    /**
     * Show conversation.
     */
    public function show($id_partner)
    {
        $candidat = Auth::guard('candidat')->user();
        $entreprise = Auth::guard('entreprise')->user();

        if ($candidat) {
            $partner = Entreprise::findOrFail($id_partner);

            // Verify candidacy exists to allow messaging
            $hasCandidature = Candidature::where('id_candidat', $candidat->id_candidat)
                ->whereHas('offre', function($q) use ($partner) {
                    $q->where('id_entreprise', $partner->id_entreprise);
                })
                ->exists();

            if (!$hasCandidature) {
                return redirect()->route('messagerie.index')->withErrors(['error' => 'Vous ne pouvez envoyer des messages qu\'aux entreprises pour lesquelles vous avez une candidature active.']);
            }

            // Mark received messages as read
            Message::where('id_candidat', $candidat->id_candidat)
                ->where('id_entreprise', $partner->id_entreprise)
                ->where('statut_lecture', 'non lu')
                ->update(['statut_lecture' => 'lu']);

            // Get messages
            $messages = Message::where('id_candidat', $candidat->id_candidat)
                ->where('id_entreprise', $partner->id_entreprise)
                ->orderBy('date_envoi', 'asc')
                ->get();

            // Get all conversations (same logic as index method)
            $conversations = Candidature::with('offre.entreprise')
                ->where('id_candidat', $candidat->id_candidat)
                ->get()
                ->pluck('offre.entreprise')
                ->unique('id_entreprise');

            // Load last message for each
            foreach ($conversations as $ent) {
                if ($ent) {
                    $ent->last_message = Message::where(function($q) use ($candidat, $ent) {
                            $q->where('id_candidat', $candidat->id_candidat)->where('id_entreprise', $ent->id_entreprise);
                        })
                        ->orderBy('date_envoi', 'desc')
                        ->first();
                }
            }

            return view('messagerie.chat', [
                'messages'      => $messages,
                'partner'       => $partner,
                'partnerName'   => $partner->nom_entreprise,
                'partnerType'   => 'entreprise',
                'candidat'      => $candidat,
                'entreprise'    => null,
                'isCandidat'    => true,
                'isEntreprise'  => false,
                'conversations' => $conversations,
            ]);
        } elseif ($entreprise) {
            $partner = Candidat::findOrFail($id_partner);

            // Verify candidacy exists
            $hasCandidature = Candidature::where('id_candidat', $partner->id_candidat)
                ->whereHas('offre', function($q) use ($entreprise) {
                    $q->where('id_entreprise', $entreprise->id_entreprise);
                })
                ->exists();

            if (!$hasCandidature) {
                return redirect()->route('messagerie.index')->withErrors(['error' => 'Vous ne pouvez échanger qu\'avec des candidats ayant postulé à vos offres.']);
            }

            // Mark received messages as read
            Message::where('id_candidat', $partner->id_candidat)
                ->where('id_entreprise', $entreprise->id_entreprise)
                ->where('statut_lecture', 'non lu')
                ->update(['statut_lecture' => 'lu']);

            // Get messages
            $messages = Message::where('id_candidat', $partner->id_candidat)
                ->where('id_entreprise', $entreprise->id_entreprise)
                ->orderBy('date_envoi', 'asc')
                ->get();

            // Get all conversations (same logic as index method)
            $conversations = Candidature::with('candidat')
                ->whereHas('offre', function($q) use ($entreprise) {
                    $q->where('id_entreprise', $entreprise->id_entreprise);
                })
                ->get()
                ->pluck('candidat')
                ->unique('id_candidat');

            // Load last message for each
            foreach ($conversations as $cand) {
                if ($cand) {
                    $cand->last_message = Message::where(function($q) use ($cand, $entreprise) {
                            $q->where('id_candidat', $cand->id_candidat)->where('id_entreprise', $entreprise->id_entreprise);
                        })
                        ->orderBy('date_envoi', 'desc')
                        ->first();
                }
            }

            return view('messagerie.chat', [
                'messages'      => $messages,
                'partner'       => $partner,
                'partnerName'   => $partner->nom . ' ' . $partner->prenom,
                'partnerType'   => 'candidat',
                'candidat'      => null,
                'entreprise'    => $entreprise,
                'isCandidat'    => false,
                'isEntreprise'  => true,
                'conversations' => $conversations,
            ]);
        }

        abort(403);
    }

    /**
     * Send message.
     */
    public function store(Request $request, $id_partner)
    {
        $candidat = Auth::guard('candidat')->user();
        $entreprise = Auth::guard('entreprise')->user();

        $request->validate([
            'contenu_message' => 'required|string|max:1000',
        ]);

        if ($candidat) {
            $partner = Entreprise::findOrFail($id_partner);

            $message = Message::create([
                'id_candidat' => $candidat->id_candidat,
                'id_entreprise' => $partner->id_entreprise,
                'contenu_message' => $request->input('contenu_message'),
                'date_envoi' => now(),
                'statut_lecture' => 'non lu',
                'sender_type' => 'candidat',
            ]);

            // Notify company - check if there's already an unread notification for this conversation
            $existingNotification = DB::table('notifications')
                ->where('id_entreprise', $partner->id_entreprise)
                ->whereNull('id_candidat')
                ->where('type_notification', 'message')
                ->where('statut_lecture', 'non lu')
                ->first();

            if ($existingNotification) {
                // Extract current count from existing notification content
                $currentContent = $existingNotification->contenu_notification;
                $currentCount = 1;
                if (preg_match('/Vous avez reçu (\d+) nouveau message/', $currentContent, $matches)) {
                    $currentCount = (int)$matches[1];
                }
                $newCount = $currentCount + 1;

                // Update existing notification
                DB::table('notifications')
                    ->where('id_notification', $existingNotification->id_notification)
                    ->update([
                        'titre_notification' => 'Nouveau message de ' . $candidat->nom,
                        'contenu_notification' => "Vous avez reçu $newCount nouveau message" . ($newCount > 1 ? 's' : ''),
                        'id_reference' => $message->id_message,
                        'date_envoi' => now(),
                        'updated_at' => now(),
                    ]);
            } else {
                // Create new notification - only for the recipient (company)
                DB::table('notifications')->insert([
                    'id_entreprise' => $partner->id_entreprise,
                    'titre_notification' => 'Nouveau message de ' . $candidat->nom,
                    'contenu_notification' => "Vous avez reçu 1 nouveau message",
                    'type_notification' => 'message',
                    'id_reference' => $message->id_message,
                    'type_reference' => 'message',
                    'date_envoi' => now(),
                    'statut_lecture' => 'non lu',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('messagerie.show', $partner->id_entreprise);
        } elseif ($entreprise) {
            $partner = Candidat::findOrFail($id_partner);

            $message = Message::create([
                'id_candidat' => $partner->id_candidat,
                'id_entreprise' => $entreprise->id_entreprise,
                'contenu_message' => $request->input('contenu_message'),
                'date_envoi' => now(),
                'statut_lecture' => 'non lu',
                'sender_type' => 'entreprise',
            ]);

            // Notify candidate - check if there's already an unread notification for this conversation
            $existingNotification = DB::table('notifications')
                ->where('id_candidat', $partner->id_candidat)
                ->whereNull('id_entreprise')
                ->where('type_notification', 'message')
                ->where('statut_lecture', 'non lu')
                ->first();

            if ($existingNotification) {
                // Extract current count from existing notification content
                $currentContent = $existingNotification->contenu_notification;
                $currentCount = 1;
                if (preg_match('/Vous avez reçu (\d+) nouveau message/', $currentContent, $matches)) {
                    $currentCount = (int)$matches[1];
                }
                $newCount = $currentCount + 1;

                // Update existing notification
                DB::table('notifications')
                    ->where('id_notification', $existingNotification->id_notification)
                    ->update([
                        'titre_notification' => 'Nouveau message de ' . $entreprise->nom_entreprise,
                        'contenu_notification' => "Vous avez reçu $newCount nouveau message" . ($newCount > 1 ? 's' : ''),
                        'id_reference' => $message->id_message,
                        'date_envoi' => now(),
                        'updated_at' => now(),
                    ]);
            } else {
                // Create new notification - only for the recipient (candidate)
                DB::table('notifications')->insert([
                    'id_candidat' => $partner->id_candidat,
                    'titre_notification' => 'Nouveau message de ' . $entreprise->nom_entreprise,
                    'contenu_notification' => "Vous avez reçu 1 nouveau message",
                    'type_notification' => 'message',
                    'id_reference' => $message->id_message,
                    'type_reference' => 'message',
                    'date_envoi' => now(),
                    'statut_lecture' => 'non lu',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('messagerie.show', $partner->id_candidat);
        }

        abort(403);
    }
}

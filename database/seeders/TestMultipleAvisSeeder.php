<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\EtapeOffre;
use App\Models\ProgressionCandidature;
use App\Models\Avis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestMultipleAvisSeeder extends Seeder
{
    public function run()
    {
        $entreprise = Entreprise::first();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->first();
        $candidat = Candidat::first();
        
        if (!$entreprise || !$offre || !$candidat) {
            $this->command->error('Entreprise, offre ou candidat non trouvé.');
            return;
        }

        // Check if candidature exists
        $candidature = Candidature::where('id_candidat', $candidat->id_candidat)
            ->where('id_offre', $offre->id_offre)
            ->first();

        if (!$candidature) {
            $this->command->error('Aucune candidature trouvée pour ce candidat et cette offre.');
            return;
        }

        // Get the etapes for this offer
        $etapes = EtapeOffre::where('id_offre', $offre->id_offre)->get();
        
        // Create progressions if they don't exist
        $progressions = ProgressionCandidature::where('id_candidature', $candidature->id_candidature)->get();
        
        if ($progressions->isEmpty()) {
            foreach ($etapes as $etape) {
                $statut = 'en attente';
                if (str_contains(strtolower($etape->nom_etape), 'entretien')) {
                    $statut = 'complétée';
                }
                
                ProgressionCandidature::create([
                    'id_candidature' => $candidature->id_candidature,
                    'id_etape_offre' => $etape->id_etape_offre,
                    'statut_etape' => $statut,
                    'declenchement' => 'automatique',
                    'date_validation' => $statut === 'complétée' ? now()->subDays(5) : null,
                ]);
            }
            $this->command->info('Progressions créées pour simuler le stade entretien.');
        }

        // Create multiple reviews for the same company
        $reviews = [
            [
                'note_clarte_offre' => 5,
                'note_qualite_retours' => 4,
                'note_respect_processus' => 5,
                'note_professionnalisme' => 4,
                'commentaire' => 'Premier avis : Processus de recrutement très clair et professionnel.',
            ],
            [
                'note_clarte_offre' => 4,
                'note_qualite_retours' => 5,
                'note_respect_processus' => 4,
                'note_professionnalisme' => 5,
                'commentaire' => 'Deuxième avis : Excellente communication tout au long du processus.',
            ],
            [
                'note_clarte_offre' => 5,
                'note_qualite_retours' => 5,
                'note_respect_processus' => 5,
                'note_professionnalisme' => 5,
                'commentaire' => 'Troisième avis : Expérience parfaite, recommande vivement cette entreprise.',
            ],
        ];

        foreach ($reviews as $review) {
            $noteGlobale = (int) round((
                $review['note_clarte_offre'] +
                $review['note_qualite_retours'] +
                $review['note_respect_processus'] +
                $review['note_professionnalisme']
            ) / 4);

            Avis::create([
                'id_candidat' => $candidat->id_candidat,
                'id_entreprise' => $entreprise->id_entreprise,
                'id_candidature' => null,
                'note_globale' => $noteGlobale,
                'commentaire' => $review['commentaire'],
                'note_clarte_offre' => $review['note_clarte_offre'],
                'note_qualite_retours' => $review['note_qualite_retours'],
                'note_respect_processus' => $review['note_respect_processus'],
                'note_professionnalisme' => $review['note_professionnalisme'],
                'date_avis' => now(),
                'statut_avis' => 'publié',
            ]);
        }

        // Recalculate average note for the company
        $avg = Avis::where('id_entreprise', $entreprise->id_entreprise)
            ->where('statut_avis', 'publié')
            ->avg('note_globale');

        Entreprise::where('id_entreprise', $entreprise->id_entreprise)->update([
            'note_moyenne' => $avg ? round($avg, 2) : 0
        ]);

        $this->command->info('Test d avis multiples terminé avec succès !');
        $this->command->info('Candidat: ' . $candidat->email);
        $this->command->info('Entreprise: ' . $entreprise->nom_entreprise);
        $this->command->info('Nombre d avis créés: ' . count($reviews));
        $this->command->info('Note moyenne de l entreprise: ' . ($avg ? round($avg, 2) : 0));
    }
}

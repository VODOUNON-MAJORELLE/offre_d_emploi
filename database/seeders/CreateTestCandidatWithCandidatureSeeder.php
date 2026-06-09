<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\Candidature;
use App\Models\Offre;
use App\Models\Entreprise;
use App\Models\EtapeOffre;
use App\Models\ProgressionCandidature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateTestCandidatWithCandidatureSeeder extends Seeder
{
    public function run()
    {
        $entreprise = Entreprise::first();
        $offre = Offre::where('id_entreprise', $entreprise->id_entreprise)->first();
        
        if (!$entreprise || !$offre) {
            $this->command->error('Entreprise ou offre non trouvée. Veuillez d\'abord créer une entreprise et une offre.');
            return;
        }

        // Create test candidate
        $candidat = Candidat::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont2@test.com',
            'mot_de_passe' => Hash::make('password123'),
            'statut_compte' => 'actif',
            'email_verifie' => true,
            'telephone' => '0612345678',
            'ville' => 'Paris',
            'niveau_etudes' => 'Master',
            'annees_experience' => 4,
            'competences' => 'PHP, Laravel, React, Node.js',
            'date_inscription' => now(),
        ]);

        // Create candidature with required fields
        $candidature = Candidature::create([
            'id_candidat' => $candidat->id_candidat,
            'id_offre' => $offre->id_offre,
            'score_final' => 85,
            'date_soumission' => now()->subDays(10),
            'lettre_motivation' => null,
            'nom_lettre' => '',
            'type_mime_lettre' => '',
            'taille_lettre' => 0,
        ]);

        // Get the etapes for this offer
        $etapes = EtapeOffre::where('id_offre', $offre->id_offre)->get();
        
        // Create progressions to simulate interview stage passed
        foreach ($etapes as $etape) {
            $statut = 'en attente';
            if (str_contains(strtolower($etape->nom_etape), 'entretien')) {
                $statut = 'complétée'; // Interview stage completed
            }
            
            ProgressionCandidature::create([
                'id_candidature' => $candidature->id_candidature,
                'id_etape_offre' => $etape->id_etape_offre,
                'statut_etape' => $statut,
                'declenchement' => 'automatique',
                'date_validation' => $statut === 'complétée' ? now()->subDays(5) : null,
            ]);
        }

        $this->command->info('Candidat de test créé avec succès !');
        $this->command->info('Email: jean.dupont@test.com');
        $this->command->info('Mot de passe: password123');
        $this->command->info('ID Candidat: ' . $candidat->id_candidat);
        $this->command->info('ID Candidature: ' . $candidature->id_candidature);
        $this->command->info('ID Entreprise: ' . $entreprise->id_entreprise);
        $this->command->info('Étapes de progression créées pour simuler le stade entretien');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use App\Models\Candidat;
use App\Models\Offre;
use App\Models\EtapeOffre;
use App\Models\Candidature;
use App\Models\ProgressionCandidature;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Création ou récupération d'une entreprise de test
        $entreprise = Entreprise::firstOrCreate(
            ['email' => 'contact@techcorp.com'],
            [
                'nom_entreprise' => 'Tech Corp',
                'secteur_activite' => 'Informatique',
                'mot_de_passe' => bcrypt('aaa'),
                'statut_compte' => 'actif',
                'ville_entreprise' => 'Cotonou',
                'telephone' => '0022990000000',
            ]
        );

        // 2. Création ou récupération des candidats de test
        $candidat1 = Candidat::firstOrCreate(
            ['email' => 'candidat@test.com'],
            [
                'nom' => 'Doe',
                'prenom' => 'John',
                'mot_de_passe' => bcrypt('aaa'),
                'statut_compte' => 'actif',
                'telephone' => '0022960000000',
                'ville' => 'Cotonou',
                'niveau_etudes' => 'Bac+3',
                'competences' => 'PHP, Laravel, VueJS',
            ]
        );

        $candidat2 = Candidat::firstOrCreate(
            ['email' => 'marie@test.com'],
            [
                'nom' => 'Dupont',
                'prenom' => 'Marie',
                'mot_de_passe' => bcrypt('aaa'),
                'statut_compte' => 'actif',
                'telephone' => '0022961000000',
                'ville' => 'Porto-Novo',
                'niveau_etudes' => 'Bac+5',
                'competences' => 'Docker, Kubernetes, JavaScript, React',
            ]
        );

        // Helper to create an offer with its steps and return the offer
        $createOffer = function (array $data) use ($entreprise) {
            $offre = Offre::firstOrCreate(
                ['titre_offre' => $data['titre_offre']],
                $data
            );
            $etapes = ['Candidature reçue', 'Entretien RH', 'Test Technique', 'Entretien Final', 'Proposition'];
            foreach ($etapes as $index => $etape) {
                EtapeOffre::firstOrCreate([
                    'id_offre' => $offre->id_offre,
                    'nom_etape' => $etape,
                ], [
                    'ordre_etape' => $index + 1,
                ]);
            }
            return $offre;
        };

        // 3. Offres de test
        $offre1 = $createOffer([
            'id_entreprise' => $entreprise->id_entreprise,
            'titre_offre' => 'Développeur Fullstack Laravel',
            'description_offre' => 'Nous recherchons un développeur motivé.',
            'competences_requises' => 'PHP, Laravel, VueJS',
            'experience_requise' => 2,
            'niveau_etudes_requis' => 'Bac+3',
            'ville_poste' => 'Cotonou',
            'type_contrat' => 'CDI',
            'salaire_min' => 500000,
            'salaire_max' => 700000,
            'date_limite' => now()->addDays(30),
            'statut_offre' => 'active',
        ]);

        $offre2 = $createOffer([
            'id_entreprise' => $entreprise->id_entreprise,
            'titre_offre' => 'Développeur Frontend VueJS',
            'description_offre' => 'Recherche développeur VueJS.',
            'competences_requises' => 'VueJS, JavaScript',
            'experience_requise' => 1,
            'niveau_etudes_requis' => 'Bac+2',
            'ville_poste' => 'Cotonou',
            'type_contrat' => 'CDI',
            'salaire_min' => 400000,
            'salaire_max' => 600000,
            'date_limite' => now()->addDays(30),
            'statut_offre' => 'active',
        ]);

        $offre3 = $createOffer([
            'id_entreprise' => $entreprise->id_entreprise,
            'titre_offre' => 'Ingénieur DevOps',
            'description_offre' => 'Gestion des pipelines CI/CD.',
            'competences_requises' => 'Docker, Kubernetes, CI',
            'experience_requise' => 3,
            'niveau_etudes_requis' => 'Bac+4',
            'ville_poste' => 'Cotonou',
            'type_contrat' => 'CDI',
            'salaire_min' => 600000,
            'salaire_max' => 900000,
            'date_limite' => now()->addDays(45),
            'statut_offre' => 'active',
        ]);

        // 4. Candidatures de test
        $candidatures = [
            // Candidat 1 postule aux 3 offres
            ['id_candidat' => $candidat1->id_candidat, 'id_offre' => $offre1->id_offre, 'score_final' => 82, 'date' => now()->subDays(5)],
            ['id_candidat' => $candidat1->id_candidat, 'id_offre' => $offre2->id_offre, 'score_final' => 75, 'date' => now()->subDays(3)],
            ['id_candidat' => $candidat1->id_candidat, 'id_offre' => $offre3->id_offre, 'score_final' => 60, 'date' => now()->subDays(1)],
            // Candidat 2 postule à 2 offres
            ['id_candidat' => $candidat2->id_candidat, 'id_offre' => $offre1->id_offre, 'score_final' => 90, 'date' => now()->subDays(4)],
            ['id_candidat' => $candidat2->id_candidat, 'id_offre' => $offre3->id_offre, 'score_final' => 88, 'date' => now()->subDays(2)],
        ];

        foreach ($candidatures as $candData) {
            $candidature = Candidature::firstOrCreate(
                [
                    'id_candidat' => $candData['id_candidat'],
                    'id_offre' => $candData['id_offre'],
                ],
                [
                    'date_soumission' => $candData['date'],
                    'score_final' => $candData['score_final'],
                    'nom_lettre' => 'lettre_motivation.pdf',
                    'type_mime_lettre' => 'application/pdf',
                    'taille_lettre' => 0,
                ]
            );

            // Ajouter la première étape de progression (Candidature reçue)
            $premiereEtape = EtapeOffre::where('id_offre', $candData['id_offre'])
                ->orderBy('ordre_etape')
                ->first();

            if ($premiereEtape) {
                ProgressionCandidature::firstOrCreate(
                    [
                        'id_candidature' => $candidature->id_candidature,
                        'id_etape_offre' => $premiereEtape->id_etape_offre,
                    ],
                    [
                        'statut_etape' => 'complétée',
                        'declenchement' => 'manuel',
                        'date_validation' => $candData['date'],
                    ]
                );
            }
        }

    }
}

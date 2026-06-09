<?php

namespace Database\Seeders;

use App\Models\Offre;
use App\Models\EtapeOffre;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class CreateOffreWithEtapesSeeder extends Seeder
{
    public function run()
    {
        $entreprise = Entreprise::first();
        
        if (!$entreprise) {
            $this->command->error('Aucune entreprise trouvée. Veuillez d\'abord créer une entreprise.');
            return;
        }

        $offre = Offre::create([
            'id_entreprise' => $entreprise->id_entreprise,
            'titre_offre' => 'Développeur Full Stack',
            'ville_poste' => 'Paris',
            'description_offre' => 'Nous recherchons un développeur full stack expérimenté pour rejoindre notre équipe. Vous travaillerez sur des projets innovants en utilisant les dernières technologies.',
            'type_contrat' => 'CDI',
            'niveau_etudes_requis' => 'Licence',
            'experience_requise' => 3,
            'salaire_min' => 45000,
            'salaire_max' => 65000,
            'date_limite' => now()->addDays(30),
            'competences_requises' => 'PHP, Laravel, React, Node.js, MySQL',
            'statut_offre' => 'active',
            'date_publication' => now(),
            'nb_candidatures' => 0,
        ]);

        $etapes = ['Pré-sélection', 'Test technique', 'Entretien RH', 'Entretien technique', 'Offre'];
        foreach ($etapes as $index => $etapeNom) {
            EtapeOffre::create([
                'id_offre' => $offre->id_offre,
                'nom_etape' => $etapeNom,
                'ordre_etape' => $index + 1,
            ]);
        }

        $this->command->info('Offre créée avec succès !');
        $this->command->info('ID: ' . $offre->id_offre);
        $this->command->info('Titre: ' . $offre->titre_offre);
        $this->command->info('Entreprise: ' . $entreprise->nom_entreprise);
        $this->command->info('Étapes: ' . count($etapes));
    }
}

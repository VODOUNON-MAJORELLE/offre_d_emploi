<?php

namespace Database\Seeders;

use App\Models\Avis;
use Illuminate\Database\Seeder;

class TestUpdateAvisSeeder extends Seeder
{
    public function run()
    {
        // Get the first review
        $avis = Avis::first();
        
        if (!$avis) {
            $this->command->error('Aucun avis trouvé pour le test de modification.');
            return;
        }

        $oldNote = $avis->note_globale;
        $oldCommentaire = $avis->commentaire;

        // Update the review
        $avis->update([
            'note_clarte_offre' => 5,
            'note_qualite_retours' => 5,
            'note_respect_processus' => 5,
            'note_professionnalisme' => 5,
            'commentaire' => 'Avis modifié : Processus de recrutement exceptionnel après réévaluation.',
            'date_avis' => now(),
        ]);

        $newNote = $avis->note_globale;
        $newCommentaire = $avis->commentaire;

        $this->command->info('Test de modification d avis terminé avec succès !');
        $this->command->info('ID avis: ' . $avis->id_avis);
        $this->command->info('Ancienne note: ' . $oldNote);
        $this->command->info('Nouvelle note: ' . $newNote);
        $this->command->info('Ancien commentaire: ' . $oldCommentaire);
        $this->command->info('Nouveau commentaire: ' . $newCommentaire);
    }
}

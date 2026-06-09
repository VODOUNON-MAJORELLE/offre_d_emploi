<?php

namespace Database\Seeders;

use App\Models\Avis;
use Illuminate\Database\Seeder;

class TestDeleteAvisSeeder extends Seeder
{
    public function run()
    {
        // Get the last review
        $avis = Avis::orderBy('id_avis', 'desc')->first();
        
        if (!$avis) {
            $this->command->error('Aucun avis trouvé pour le test de suppression.');
            return;
        }

        $avisId = $avis->id_avis;
        $avisNote = $avis->note_globale;
        $entrepriseId = $avis->id_entreprise;

        // Delete the review
        $avis->delete();

        // Recalculate average note for the company
        $avg = Avis::where('id_entreprise', $entrepriseId)
            ->where('statut_avis', 'publié')
            ->avg('note_globale');

        \App\Models\Entreprise::where('id_entreprise', $entrepriseId)->update([
            'note_moyenne' => $avg ? round($avg, 2) : 0
        ]);

        $this->command->info('Test de suppression d avis terminé avec succès !');
        $this->command->info('ID avis supprimé: ' . $avisId);
        $this->command->info('Note de l avis supprimé: ' . $avisNote);
        $this->command->info('Nouvelle note moyenne de l entreprise: ' . ($avg ? round($avg, 2) : 0));
    }
}

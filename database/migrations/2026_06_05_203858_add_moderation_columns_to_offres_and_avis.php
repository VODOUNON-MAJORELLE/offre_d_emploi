<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Colonnes de modération pour les offres
        Schema::table('offres', function (Blueprint $table) {
            // statut_offre existant: active, suspendue, clôturée
            // On ajoute: rejetée, avertissement
            $table->text('motif_moderation')->nullable()->after('statut_offre');
            $table->timestamp('date_moderation')->nullable()->after('motif_moderation');
            $table->unsignedBigInteger('moderee_par')->nullable()->after('date_moderation');
        });

        // Colonnes de modération pour les avis
        Schema::table('avis', function (Blueprint $table) {
            // statut_avis existant: publié, supprimé
            // On ajoute: avertissement
            $table->text('motif_moderation')->nullable()->after('statut_avis');
            $table->timestamp('date_moderation')->nullable()->after('motif_moderation');
            $table->unsignedBigInteger('moderee_par')->nullable()->after('date_moderation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres_and_avis', function (Blueprint $table) {
            //
        });
    }
};

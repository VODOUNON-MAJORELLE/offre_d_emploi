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
        // Indexes for candidats table
        Schema::table('candidats', function (Blueprint $table) {
            $table->index('statut_compte');
            $table->index('date_inscription');
            $table->index('ville');
            $table->index('niveau_etudes');
        });

        // Indexes for entreprises table
        Schema::table('entreprises', function (Blueprint $table) {
            $table->index('statut_compte');
            $table->index('date_inscription');
            $table->index('secteur_activite');
        });

        // Indexes for offres table
        Schema::table('offres', function (Blueprint $table) {
            $table->index('statut_offre');
            $table->index('date_publication');
            $table->index('ville_poste');
            $table->index('niveau_etudes_requis');
            $table->index(['id_entreprise', 'statut_offre']);
        });

        // Indexes for candidatures table
        Schema::table('candidatures', function (Blueprint $table) {
            $table->index('date_soumission');
            $table->index('score_final');
            $table->index(['id_candidat', 'date_soumission']);
            $table->index(['id_offre', 'score_final']);
        });

        // Indexes for scores table
        Schema::table('scores', function (Blueprint $table) {
            $table->index(['id_candidat', 'id_offre']);
            $table->index('date_calcul');
        });

        // Indexes for avis table
        Schema::table('avis', function (Blueprint $table) {
            $table->index('statut_avis');
            $table->index('date_avis');
            $table->index(['id_entreprise', 'statut_avis']);
        });

        // Indexes for notifications table
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('statut_lecture');
            $table->index('date_envoi');
            $table->index(['id_candidat', 'statut_lecture']);
            $table->index(['id_entreprise', 'statut_lecture']);
            $table->index(['type_notification', 'statut_lecture']);
        });

        // Indexes for messages table
        Schema::table('messages', function (Blueprint $table) {
            $table->index('statut_lecture');
            $table->index('date_envoi');
            $table->index(['id_candidat', 'date_envoi']);
            $table->index(['id_entreprise', 'date_envoi']);
        });

        // Indexes for experiences table
        Schema::table('experiences', function (Blueprint $table) {
            $table->index('id_candidat');
            $table->index('annee_debut');
        });

        // Indexes for formations table
        Schema::table('formations', function (Blueprint $table) {
            $table->index('id_candidat');
            $table->index('annee_debut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->dropIndex(['statut_compte']);
            $table->dropIndex(['date_inscription']);
            $table->dropIndex(['ville']);
            $table->dropIndex(['niveau_etudes']);
        });

        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropIndex(['statut_compte']);
            $table->dropIndex(['date_inscription']);
            $table->dropIndex(['secteur_activite']);
        });

        Schema::table('offres', function (Blueprint $table) {
            $table->dropIndex(['statut_offre']);
            $table->dropIndex(['date_publication']);
            $table->dropIndex(['ville_poste']);
            $table->dropIndex(['niveau_etudes_requis']);
            $table->dropIndex(['id_entreprise', 'statut_offre']);
        });

        Schema::table('candidatures', function (Blueprint $table) {
            $table->dropIndex(['date_soumission']);
            $table->dropIndex(['score_final']);
            $table->dropIndex(['id_candidat', 'date_soumission']);
            $table->dropIndex(['id_offre', 'score_final']);
        });

        Schema::table('scores', function (Blueprint $table) {
            $table->dropIndex(['id_candidat', 'id_offre']);
            $table->dropIndex(['date_calcul']);
        });

        Schema::table('avis', function (Blueprint $table) {
            $table->dropIndex(['statut_avis']);
            $table->dropIndex(['date_avis']);
            $table->dropIndex(['id_entreprise', 'statut_avis']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['statut_lecture']);
            $table->dropIndex(['date_envoi']);
            $table->dropIndex(['id_candidat', 'statut_lecture']);
            $table->dropIndex(['id_entreprise', 'statut_lecture']);
            $table->dropIndex(['type_notification', 'statut_lecture']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['statut_lecture']);
            $table->dropIndex(['date_envoi']);
            $table->dropIndex(['id_candidat', 'date_envoi']);
            $table->dropIndex(['id_entreprise', 'date_envoi']);
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->dropIndex(['id_candidat']);
            $table->dropIndex(['annee_debut']);
        });

        Schema::table('formations', function (Blueprint $table) {
            $table->dropIndex(['id_candidat']);
            $table->dropIndex(['annee_debut']);
        });
    }
};

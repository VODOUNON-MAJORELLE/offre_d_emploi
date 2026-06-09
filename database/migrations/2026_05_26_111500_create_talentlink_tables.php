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
        // 1. CANDIDATS
        Schema::create('candidats', function (Blueprint $table) {
            $table->id('id_candidat');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->string('statut_compte')->default('actif'); // actif, suspendu, supprimé
            $table->boolean('email_verifie')->default(false);
            $table->string('token_verification')->nullable();
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamp('derniere_connexion')->nullable();
            $table->string('token_reset')->nullable();
            $table->timestamp('expiration_token')->nullable();
            $table->string('telephone');
            $table->string('ville');
            $table->string('niveau_etudes'); // Bac, Licence+2, Licence, Master, Doctorat
            $table->integer('annees_experience')->default(0);
            $table->text('competences'); // mots-clés séparés par virgule
            $table->string('photo_profil')->nullable();
            $table->timestamps();
        });

        // 2. ENTREPRISES
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id('id_entreprise');
            $table->string('nom_entreprise');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->string('statut_compte')->default('actif'); // actif, suspendu, supprimé
            $table->boolean('email_verifie')->default(false);
            $table->string('token_verification')->nullable();
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamp('derniere_connexion')->nullable();
            $table->string('token_reset')->nullable();
            $table->timestamp('expiration_token')->nullable();
            $table->string('secteur_activite');
            $table->string('ville_entreprise');
            $table->text('description')->nullable();
            $table->string('telephone');
            $table->string('logo')->nullable();
            $table->decimal('note_moyenne', 3, 2)->default(0);
            $table->timestamps();
        });

        // 3. ADMINISTRATEURS
        Schema::create('administrateurs', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->timestamp('date_inscription')->useCurrent();
            $table->timestamp('derniere_connexion')->nullable();
            $table->timestamps();
        });

        // 4. CV
        Schema::create('cvs', function (Blueprint $table) {
            $table->id('id_cv');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->string('nom_fichier');
            $table->binary('contenu_fichier');
            $table->string('type_mime')->default('application/pdf');
            $table->integer('taille_fichier');
            $table->boolean('est_principal')->default(false);
            $table->timestamp('date_upload')->useCurrent();
            $table->string('statut')->default('actif');
            $table->timestamps();
        });

        // 5. OFFRES
        Schema::create('offres', function (Blueprint $table) {
            $table->id('id_offre');
            $table->foreignId('id_entreprise')->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->string('titre_offre');
            $table->text('description_offre');
            $table->text('competences_requises');
            $table->string('niveau_etudes_requis');
            $table->integer('experience_requise')->default(0);
            $table->string('type_contrat');
            $table->integer('salaire_min')->nullable();
            $table->integer('salaire_max')->nullable();
            $table->string('ville_poste');
            $table->timestamp('date_limite');
            $table->timestamp('date_publication')->useCurrent();
            $table->string('statut_offre')->default('active'); // active, suspendue, clôturée
            $table->integer('nb_candidatures')->default(0);
            $table->timestamps();
        });

        // 6. CANDIDATURES
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id('id_candidature');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_offre')->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->foreignId('id_cv')->nullable()->constrained('cvs', 'id_cv')->onDelete('set null');
            $table->binary('lettre_motivation');
            $table->string('nom_lettre');
            $table->string('type_mime_lettre');
            $table->integer('taille_lettre');
            $table->timestamp('date_soumission')->useCurrent();
            $table->text('note_interne')->nullable();
            $table->string('motif_refus')->nullable();
            $table->integer('score_questionnaire')->nullable();
            $table->integer('score_final');
            $table->timestamps();

            $table->unique(['id_candidat', 'id_offre']);
        });

        // 7. SCORES
        Schema::create('scores', function (Blueprint $table) {
            $table->id('id_score');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_offre')->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->integer('score_competences');
            $table->integer('score_experience');
            $table->integer('score_etudes');
            $table->integer('score_localisation');
            $table->integer('score_compatibilite');
            $table->timestamp('date_calcul')->useCurrent();
            $table->timestamps();

            $table->unique(['id_candidat', 'id_offre']);
        });

        // 8. QUESTIONNAIRES
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id('id_questionnaire');
            $table->foreignId('id_offre')->unique()->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->string('titre_questionnaire');
            $table->timestamps();
        });

        // 9. QUESTIONS
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id_question');
            $table->foreignId('id_questionnaire')->constrained('questionnaires', 'id_questionnaire')->onDelete('cascade');
            $table->text('enonce_question');
            $table->string('type_question'); // QCM, reponse_courte
            $table->integer('points_question')->default(0);
            $table->timestamps();
        });

        // 10. OPTIONS_REPONSES
        Schema::create('options_reponses', function (Blueprint $table) {
            $table->id('id_option');
            $table->foreignId('id_question')->constrained('questions', 'id_question')->onDelete('cascade');
            $table->string('contenu_option');
            $table->boolean('est_bonne_reponse')->default(false);
            $table->integer('ordre_option');
            $table->timestamps();
        });

        // 11. REPONSES
        Schema::create('reponses', function (Blueprint $table) {
            $table->id('id_reponse');
            $table->foreignId('id_question')->constrained('questions', 'id_question')->onDelete('cascade');
            $table->foreignId('id_candidature')->constrained('candidatures', 'id_candidature')->onDelete('cascade');
            $table->text('contenu_reponse');
            $table->boolean('est_correcte')->nullable();
            $table->integer('score_manuel')->nullable();
            $table->integer('score_reponse')->default(0);
            $table->timestamps();

            $table->unique(['id_question', 'id_candidature']);
        });

        // 12. ETAPES_OFFRES
        Schema::create('etapes_offres', function (Blueprint $table) {
            $table->id('id_etape_offre');
            $table->foreignId('id_offre')->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->string('nom_etape'); // Candidature reçue, En cours d'examen, Entretien planifié, Test technique, Réponse finale
            $table->integer('ordre_etape');
            $table->boolean('est_obligatoire')->default(false);
            $table->timestamps();

            $table->unique(['id_offre', 'ordre_etape']);
        });

        // 13. PROGRESSION_CANDIDATURES
        Schema::create('progression_candidatures', function (Blueprint $table) {
            $table->id('id_progression');
            $table->foreignId('id_candidature')->constrained('candidatures', 'id_candidature')->onDelete('cascade');
            $table->foreignId('id_etape_offre')->constrained('etapes_offres', 'id_etape_offre')->onDelete('cascade');
            $table->string('statut_etape')->default('en attente'); // en attente, en cours, complétée
            $table->string('declenchement'); // automatique, manuel
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();

            $table->unique(['id_candidature', 'id_etape_offre']);
        });

        // 14. MESSAGES
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id_message');
            $table->foreignId('id_candidat')->nullable()->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_entreprise')->nullable()->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->text('contenu_message');
            $table->timestamp('date_envoi')->useCurrent();
            $table->string('statut_lecture')->default('non lu');
            $table->timestamps();
        });

        // 15. AVIS
        Schema::create('avis', function (Blueprint $table) {
            $table->id('id_avis');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_entreprise')->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->foreignId('id_candidature')->constrained('candidatures', 'id_candidature')->onDelete('cascade');
            $table->integer('note_globale');
            $table->text('commentaire')->nullable();
            $table->integer('note_clarte_offre');
            $table->integer('note_qualite_retours');
            $table->integer('note_respect_processus');
            $table->integer('note_professionnalisme');
            $table->timestamp('date_avis')->useCurrent();
            $table->string('statut_avis')->default('publié'); // publié, supprimé
            $table->timestamps();

            $table->unique(['id_candidat', 'id_entreprise', 'id_candidature']);
        });

        // 16. NOTIFICATIONS
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('id_notification');
            $table->foreignId('id_candidat')->nullable()->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_entreprise')->nullable()->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->foreignId('id_admin')->nullable()->constrained('administrateurs', 'id_admin')->onDelete('cascade');
            $table->string('titre_notification');
            $table->text('contenu_notification');
            $table->string('type_notification'); // candidature, statut, message, moderation
            $table->integer('id_reference')->nullable();
            $table->string('type_reference')->nullable();
            $table->timestamp('date_envoi')->useCurrent();
            $table->string('statut_lecture')->default('non lu');
            $table->timestamps();
        });

        // Modify blob columns to mediumblob for large PDF files
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE cvs MODIFY contenu_fichier MEDIUMBLOB');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE candidatures MODIFY lettre_motivation MEDIUMBLOB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('avis');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('progression_candidatures');
        Schema::dropIfExists('etapes_offres');
        Schema::dropIfExists('reponses');
        Schema::dropIfExists('options_reponses');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('questionnaires');
        Schema::dropIfExists('scores');
        Schema::dropIfExists('candidatures');
        Schema::dropIfExists('offres');
        Schema::dropIfExists('cvs');
        Schema::dropIfExists('administrateurs');
        Schema::dropIfExists('entreprises');
        Schema::dropIfExists('candidats');
    }
};

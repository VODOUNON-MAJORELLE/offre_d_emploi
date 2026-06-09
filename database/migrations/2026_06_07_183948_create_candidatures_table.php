<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id('id_candidature');
            $table->foreignId('id_candidat')->constrained('candidats', 'id_candidat')->onDelete('cascade');
            $table->foreignId('id_offre')->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->string('id_cv')->nullable();
            $table->text('lettre_motivation')->nullable();
            $table->timestamp('date_soumission')->useCurrent();
            $table->text('note_interne')->nullable();
            $table->text('motif_refus')->nullable();
            $table->float('score_questionnaire')->default(0);
            $table->float('score_final')->default(0);
            $table->enum('statut', ['nouveau','en_cours','entretien_planifie','pre_selectionne','refuse'])->default('nouveau');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('candidatures'); }
};
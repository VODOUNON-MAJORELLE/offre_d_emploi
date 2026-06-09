<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('offres', function (Blueprint $table) {
            $table->id('id_offre');
            $table->foreignId('id_entreprise')->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->string('titre_offre');
            $table->text('description_offre');
            $table->text('competences_requises')->nullable();
            $table->string('niveau_etudes_requis')->nullable();
            $table->integer('experience_requise')->default(0);
            $table->enum('type_contrat', ['CDI', 'CDD', 'stage', 'freelance'])->default('CDI');
            $table->float('salaire_min')->nullable();
            $table->float('salaire_max')->nullable();
            $table->string('ville_poste')->nullable();
            $table->date('date_limite')->nullable();
            $table->timestamp('date_publication')->nullable();
            $table->enum('statut_offre', ['en_attente', 'active', 'suspendue', 'cloturee'])->default('en_attente');
            $table->integer('nb_candidatures')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('offres'); }
};
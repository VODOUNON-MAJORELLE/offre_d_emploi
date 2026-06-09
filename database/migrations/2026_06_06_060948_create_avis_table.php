<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('avis', function (Blueprint $table) {
            $table->id('id_avis');
            $table->unsignedBigInteger('id_candidat');
            $table->foreignId('id_entreprise')->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->unsignedBigInteger('id_candidature');
            $table->integer('note_globale')->default(0);
            $table->text('commentaire')->nullable();
            $table->integer('note_clarte_offre')->default(0);
            $table->integer('note_qualite_retours')->default(0);
            $table->integer('note_respect_processus')->default(0);
            $table->integer('note_professionnalisme')->default(0);
            $table->timestamp('date_avis')->useCurrent();
            $table->enum('statut_avis', ['en_attente', 'publie', 'supprime'])->default('en_attente');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('avis'); }
};
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
        // Add valeurs column to entreprises table
        Schema::table('entreprises', function (Blueprint $table) {
            $table->text('valeurs')->nullable()->after('description');
        });

        // Create media_entreprises table
        Schema::create('media_entreprises', function (Blueprint $table) {
            $table->id('id_media');
            $table->foreignId('id_entreprise')->constrained('entreprises', 'id_entreprise')->onDelete('cascade');
            $table->string('titre')->nullable();
            $table->string('categorie')->default('locaux'); // locaux, equipes, projets, environnement, evenements
            $table->string('chemin_fichier');
            $table->string('type_mime');
            $table->integer('taille_fichier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_entreprises');
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn('valeurs');
        });
    }
};

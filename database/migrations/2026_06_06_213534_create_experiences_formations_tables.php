<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id('id_experience');
            $table->unsignedBigInteger('id_candidat');
            $table->string('poste', 255);
            $table->string('entreprise', 255);
            $table->string('annee_debut', 10);
            $table->string('annee_fin', 10)->nullable(); // null = "Présent"
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('id_candidat')
                  ->references('id_candidat')
                  ->on('candidats')
                  ->onDelete('cascade');
        });

        Schema::create('formations', function (Blueprint $table) {
            $table->id('id_formation');
            $table->unsignedBigInteger('id_candidat');
            $table->string('diplome', 255);
            $table->string('etablissement', 255);
            $table->string('annee_debut', 10);
            $table->string('annee_fin', 10)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('id_candidat')
                  ->references('id_candidat')
                  ->on('candidats')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
        Schema::dropIfExists('experiences');
    }
};

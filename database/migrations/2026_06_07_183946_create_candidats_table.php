<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id('id_candidat');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('ville')->nullable();
            $table->string('niveau_etudes')->nullable();
            $table->integer('annees_experience')->default(0);
            $table->text('competences')->nullable();
            $table->string('photo_profil')->nullable();
            $table->enum('statut_compte', ['actif','suspendu'])->default('actif');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('candidats'); }
};
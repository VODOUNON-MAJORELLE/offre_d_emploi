<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id('id_entreprise');
            $table->string('nom_entreprise');
            $table->string('email')->unique();
            $table->string('mot_de_passe');
            $table->string('secteur_activite')->nullable();
            $table->string('ville_entreprise')->nullable();
            $table->text('description')->nullable();
            $table->string('telephone')->nullable();
            $table->string('logo')->nullable();
            $table->float('note_moyenne')->default(0);
            $table->enum('statut_compte', ['actif', 'suspendu', 'en_attente'])->default('en_attente');
            $table->boolean('email_verifie')->default(false);
            $table->string('token_verification')->nullable();
            $table->string('token_reset')->nullable();
            $table->timestamp('expiration_token')->nullable();
            $table->timestamp('derniere_connexion')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
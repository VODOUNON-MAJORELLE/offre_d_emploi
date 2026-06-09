<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id_message');
            $table->unsignedBigInteger('id_candidature')->nullable();
            $table->unsignedBigInteger('id_candidat_expediteur')->nullable();
            $table->unsignedBigInteger('id_entreprise_expediteur')->nullable();
            $table->unsignedBigInteger('id_candidat_destinataire')->nullable();
            $table->unsignedBigInteger('id_entreprise_destinataire')->nullable();
            $table->text('contenu_message');
            $table->timestamp('date_envoi')->useCurrent();
            $table->enum('statut_lecture', ['non_lu', 'lu'])->default('non_lu');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('messages'); }
};
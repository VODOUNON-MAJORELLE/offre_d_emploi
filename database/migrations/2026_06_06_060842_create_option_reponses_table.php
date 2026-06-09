<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('option_reponses', function (Blueprint $table) {
            $table->id('id_option');
            $table->foreignId('id_question')->constrained('questions', 'id_question')->onDelete('cascade');
            $table->string('contenu_option');
            $table->boolean('est_bonne_reponse')->default(false);
            $table->integer('ordre_option')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('option_reponses'); }
};
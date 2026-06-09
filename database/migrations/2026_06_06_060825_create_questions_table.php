<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id_question');
            $table->foreignId('id_questionnaire')->constrained('questionnaires', 'id_questionnaire')->onDelete('cascade');
            $table->text('enonce_question');
            $table->enum('type_question', ['qcm', 'reponse_courte'])->default('qcm');
            $table->integer('points_question')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('questions'); }
};
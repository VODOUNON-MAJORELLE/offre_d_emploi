<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id('id_questionnaire');
            $table->foreignId('id_offre')->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->string('titre_questionnaire');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('questionnaires'); }
};
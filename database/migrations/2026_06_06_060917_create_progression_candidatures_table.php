<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('progression_candidatures', function (Blueprint $table) {
            $table->id('id_progression');
            $table->unsignedBigInteger('id_candidature');
            $table->foreignId('id_etape_offre')->constrained('etape_offres', 'id_etape_offre')->onDelete('cascade');
            $table->enum('statut_etape', ['en_attente', 'en_cours', 'validee', 'refusee'])->default('en_attente');
            $table->enum('declenchement', ['automatique', 'manuel'])->default('manuel');
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('progression_candidatures'); }
};
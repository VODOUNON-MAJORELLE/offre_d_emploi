<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('etape_offres', function (Blueprint $table) {
            $table->id('id_etape_offre');
            $table->foreignId('id_offre')->constrained('offres', 'id_offre')->onDelete('cascade');
            $table->string('nom_etape');
            $table->integer('ordre_etape')->default(1);
            $table->boolean('est_obligatoire')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('etape_offres'); }
};
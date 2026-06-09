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
        // First, make the column nullable if it's not already
        Schema::table('offres', function (Blueprint $table) {
            $table->string('niveau_etudes_requis')->nullable()->change();
        });
        
        // Then set all existing values to NULL to avoid data truncation
        DB::statement("UPDATE offres SET niveau_etudes_requis = NULL");
        
        // Finally, modify the column to enum
        Schema::table('offres', function (Blueprint $table) {
            $table->enum('niveau_etudes_requis', ['Bac', 'Licence', 'Master', 'Doctorat'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->string('niveau_etudes_requis')->nullable()->change();
        });
    }
};

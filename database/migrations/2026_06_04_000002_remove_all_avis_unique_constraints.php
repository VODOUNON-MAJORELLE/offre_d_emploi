<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the unique constraint completely to allow multiple reviews
        try {
            DB::statement('ALTER TABLE avis DROP INDEX avis_id_candidat_id_entreprise_unique');
        } catch (\Exception $e) {
            // Constraint might not exist, continue
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the unique constraint
        Schema::table('avis', function (Blueprint $table) {
            $table->unique(['id_candidat', 'id_entreprise']);
        });
    }
};

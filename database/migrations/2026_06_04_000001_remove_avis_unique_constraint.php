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
        // Drop the foreign key constraint if it exists
        try {
            DB::statement('ALTER TABLE avis DROP FOREIGN KEY avis_id_candidature_foreign');
        } catch (\Exception $e) {
            // Foreign key might not exist, continue
        }

        // Drop the unique constraint
        try {
            DB::statement('ALTER TABLE avis DROP INDEX avis_id_candidat_id_entreprise_id_candidature_unique');
        } catch (\Exception $e) {
            // Unique constraint might not exist, continue
        }

        // Make id_candidature nullable
        Schema::table('avis', function (Blueprint $table) {
            $table->foreignId('id_candidature')->nullable()->change();
        });

        // Recreate the foreign key constraint with nullable
        DB::statement('ALTER TABLE avis ADD CONSTRAINT avis_id_candidature_foreign FOREIGN KEY (id_candidature) REFERENCES candidatures(id_candidature) ON DELETE CASCADE');

        // Add new unique constraint without id_candidature (allows multiple reviews per company)
        Schema::table('avis', function (Blueprint $table) {
            $table->unique(['id_candidat', 'id_entreprise']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new unique constraint
        Schema::table('avis', function (Blueprint $table) {
            $table->dropUnique(['id_candidat', 'id_entreprise']);
        });

        // Drop the foreign key constraint
        DB::statement('ALTER TABLE avis DROP FOREIGN KEY avis_id_candidature_foreign');

        // Make id_candidature not nullable again
        Schema::table('avis', function (Blueprint $table) {
            $table->foreignId('id_candidature')->nullable(false)->change();
        });

        // Recreate the foreign key constraint
        DB::statement('ALTER TABLE avis ADD CONSTRAINT avis_id_candidature_foreign FOREIGN KEY (id_candidature) REFERENCES candidatures(id_candidature) ON DELETE CASCADE');

        // Restore the original unique constraint
        Schema::table('avis', function (Blueprint $table) {
            $table->unique(['id_candidat', 'id_entreprise', 'id_candidature']);
        });
    }
};

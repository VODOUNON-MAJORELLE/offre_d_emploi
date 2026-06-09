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
        // Add currency field to entreprises table
        Schema::table('entreprises', function (Blueprint $table) {
            $table->string('devise')->default('FCFA')->after('ville_entreprise');
            $table->string('pays')->default('Bénin')->after('ville_entreprise');
        });

        // Add currency field to offres table
        Schema::table('offres', function (Blueprint $table) {
            $table->string('devise')->default('FCFA')->after('salaire_max');
            $table->string('pays')->default('Bénin')->after('ville_poste');
        });

        // Update existing records to have default values
        DB::statement("UPDATE entreprises SET devise = 'FCFA' WHERE devise IS NULL OR devise = ''");
        DB::statement("UPDATE entreprises SET pays = 'Bénin' WHERE pays IS NULL OR pays = ''");
        DB::statement("UPDATE offres SET devise = 'FCFA' WHERE devise IS NULL OR devise = ''");
        DB::statement("UPDATE offres SET pays = 'Bénin' WHERE pays IS NULL OR pays = ''");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres', function (Blueprint $table) {
            $table->dropColumn(['devise', 'pays']);
        });

        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn(['devise', 'pays']);
        });
    }
};

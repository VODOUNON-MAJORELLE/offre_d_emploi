<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrateur;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing admin with this email
        Administrateur::where('email', 'admin@talentlink.com')->delete();
        
        // Create new admin
        Administrateur::create([
            'nom' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@talentlink.com',
            'mot_de_passe' => bcrypt('admin123'),
        ]);
    }
}

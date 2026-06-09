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
        // Fix sender_type for existing messages by alternating senders
        // First message in each conversation is from candidate, second from company, etc.
        
        // Get all unique conversation pairs
        $conversations = DB::table('messages')
            ->select('id_candidat', 'id_entreprise')
            ->distinct()
            ->get();
        
        foreach ($conversations as $conv) {
            // Get all messages for this conversation ordered by date
            $messages = DB::table('messages')
                ->where('id_candidat', $conv->id_candidat)
                ->where('id_entreprise', $conv->id_entreprise)
                ->orderBy('date_envoi', 'asc')
                ->get();
            
            $isCandidateTurn = true;
            foreach ($messages as $message) {
                DB::table('messages')
                    ->where('id_message', $message->id_message)
                    ->update(['sender_type' => $isCandidateTurn ? 'candidat' : 'entreprise']);
                
                $isCandidateTurn = !$isCandidateTurn;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset all to candidat
        DB::table('messages')->update(['sender_type' => 'candidat']);
    }
};

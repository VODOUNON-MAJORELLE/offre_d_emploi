<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications_jobconnect', function (Blueprint $table) {
            $table->id('id_notification');
            $table->unsignedBigInteger('id_candidat')->nullable();
            $table->unsignedBigInteger('id_entreprise')->nullable();
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->string('titre_notification');
            $table->text('contenu_notification');
            $table->string('type_notification');
            $table->unsignedBigInteger('id_reference')->nullable();
            $table->string('type_reference')->nullable();
            $table->timestamp('date_envoi')->useCurrent();
            $table->enum('statut_lecture', ['non_lu', 'lu'])->default('non_lu');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notifications_jobconnect'); }
};
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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // Ex: "Document ajouté"
            $table->string('description'); // Ex: "Rapport_2024.pdf"
            $table->string('icon')->nullable(); // Pour les emojis ou icônes
            $table->unsignedBigInteger('user_id')->nullable(); // Optionnel, pour lier l'action à un utilisateur
            $table->boolean('confidentiel');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

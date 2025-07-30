<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('licences', function (Blueprint $table) {
            $table->id();
            $table->string('licence_key');
            $table->timestamp('expiration_date');
            $table->boolean('verifier')->default(false);
            $table->timestamps();
        });

        // Appeler le seeder ici
        Artisan::call('db:seed', [
            '--class' => 'DatabaseSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licences');
    }
};

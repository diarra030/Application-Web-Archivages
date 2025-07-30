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
    Schema::create('user_permissions', function (Blueprint $table) {
    $table->id();
    $table->string('user')->nullable();
    $table->unsignedBigInteger('user_id');
    $table->string('folder')->nullable();
    $table->unsignedBigInteger('folder_id')->nullable();
    $table->string('document')->nullable();
    $table->unsignedBigInteger('document_id')->nullable();
    $table->string('permission')->nullable(); // L, E, LE
    $table->timestamps();
// 
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
    $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};

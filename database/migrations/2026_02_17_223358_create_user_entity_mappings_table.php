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
        Schema::create('user_entity_mappings', function (Blueprint $table) {
            $table->id('MappingID');

    $table->unsignedBigInteger('UserID');
    $table->unsignedBigInteger('EntityID');

    $table->timestamps();

    $table->foreign('UserID')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');

    $table->foreign('EntityID')
          ->references('EntityID')
          ->on('entities')
          ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_entity_mappings');
    }
};

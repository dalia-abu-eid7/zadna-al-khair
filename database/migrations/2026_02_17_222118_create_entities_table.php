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
        Schema::create('entities', function (Blueprint $table) {
            $table->id('EntityID');
            $table->string('EntityName');
            $table->string('EntityType');
            $table->string('LicenseNumber')->nullable();
            $table->string('Address')->nullable();
            $table->string('ContactPerson')->nullable();
            $table->string('ContactEmail')->nullable();
            $table->string('Status')->default('Pending');
            $table->unsignedBigInteger('ActivatedByUserID')->nullable();
            $table->foreign('ActivatedByUserID')
          ->references('id')
          ->on('users')
          ->onDelete('set null');

           $table->timestamp('ActivationDate')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};

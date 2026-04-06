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
        Schema::create('donations', function (Blueprint $table) {
            $table->id('DonationID');

    $table->unsignedBigInteger('DonatingEntityID')->nullable();;
    $table->unsignedBigInteger('ReceivingEntityID')->nullable();;

    $table->string('Description');
    $table->string('Quantity')->nullable();

     $table->string('Unit')->nullable(); 
         $table->string('PickupTimeSuggestion')->nullable();

    $table->string('ExpiryInfo')->nullable();

    $table->unsignedBigInteger('StatusID')->nullable();;
    $table->unsignedBigInteger('AcceptedByUserID')->nullable();

    $table->timestamps();




    $table->foreign('DonatingEntityID')->references('EntityID')->on('entities');
    $table->foreign('ReceivingEntityID')->references('EntityID')->on('entities');
    $table->foreign('StatusID')->references('StatusID')->on('donation_statuses');
    $table->foreign('AcceptedByUserID')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

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
        Schema::create('donation_history', function (Blueprint $table) {
            $table->id('HistoryID');

    $table->unsignedBigInteger('DonationID');
    $table->unsignedBigInteger('StatusID');
    $table->unsignedBigInteger('ChangedByUserID');

    $table->timestamp('ChangeTimestamp')->useCurrent();
    $table->string('Notes')->nullable();

    $table->timestamps();

    $table->foreign('DonationID')
          ->references('DonationID')
          ->on('donations')
          ->onDelete('cascade');

    $table->foreign('StatusID')
          ->references('StatusID')
          ->on('donation_statuses');

    $table->foreign('ChangedByUserID')
          ->references('id')
          ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_history');
    }
};

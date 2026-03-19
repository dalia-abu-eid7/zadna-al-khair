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
         Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('RoleID')->after('id');
        $table->string('PhoneNumber')->nullable()->after('password');
        $table->boolean('IsActive')->default(true)->after('PhoneNumber');
        $table->dateTime('LastLogin')->nullable()->after('IsActive');

        $table->foreign('RoleID')->references('RoleID')->on('roles');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

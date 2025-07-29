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
        Schema::table('chat', function (Blueprint $table) {
             $table->foreign('sender_id')->references('id')->on('users')->inDelete('cascade');
            $table->foreign('reciever_id')->references('id')->on('users')->inDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat', function (Blueprint $table) {
            //
        });
    }
};

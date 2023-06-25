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
        Schema::create('signups', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->bigInteger('mobile');
            $table->tinyInteger('active_status');
            $table->tinyInteger('deleted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signups');
    }
};

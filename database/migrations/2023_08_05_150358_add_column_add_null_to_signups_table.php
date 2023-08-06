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
        Schema::table('signups', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->bigInteger('mobile')->nullable()->change();
            $table->string('google_id')->unique()->after('mobile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signups', function (Blueprint $table) {
            //
        });
    }
};

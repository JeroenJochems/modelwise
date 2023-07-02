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
        Schema::table('models', function (Blueprint $table) {
            $table->string("city")->change()->nullable();
            $table->string("country")->change()->nullable();
            $table->string("tiktok")->change()->nullable();
            $table->string("instagram")->change()->nullable();
            $table->string("website")->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('models', function (Blueprint $table) {
            $table->string("tiktok")->change();
            $table->string("instagram")->change();
            $table->string("website")->change();
        });
    }
};

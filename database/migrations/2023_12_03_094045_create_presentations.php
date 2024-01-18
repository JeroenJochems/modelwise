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
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->json('applications');
            $table->boolean('should_show_casting_media')->default(false);
            $table->boolean('should_show_digitals')->default(false);
            $table->boolean('should_show_socials')->default(false);
            $table->boolean('should_show_cover_letter')->default(false);
            $table->boolean('should_show_conflicts')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentations');
    }
};

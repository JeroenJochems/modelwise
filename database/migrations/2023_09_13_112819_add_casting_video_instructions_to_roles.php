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
        Schema::table('roles', function (Blueprint $table) {
            $table->json('extra_fields')->nullable();
            $table->text('casting_photo_instructions')->nullable();
            $table->text('casting_video_instructions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('extra_fields');
            $table->dropColumn('casting_photo_instructions');
            $table->dropColumn('casting_video_instructions');
        });
    }
};

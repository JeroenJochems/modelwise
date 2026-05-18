<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presentations', function (Blueprint $table) {
            $table->boolean('should_show_height')->default(true);
            $table->boolean('should_show_waist')->default(true);
            $table->boolean('should_show_hips')->default(true);
            $table->boolean('should_show_hair_color')->default(true);
            $table->boolean('should_show_eye_color')->default(true);
            $table->boolean('should_show_clothing_size')->default(true);
            $table->boolean('should_show_shoe_size')->default(true);
            $table->boolean('should_show_cup_size')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('presentations', function (Blueprint $table) {
            $table->dropColumn([
                'should_show_height',
                'should_show_waist',
                'should_show_hips',
                'should_show_hair_color',
                'should_show_eye_color',
                'should_show_clothing_size',
                'should_show_shoe_size',
                'should_show_cup_size',
            ]);
        });
    }
};

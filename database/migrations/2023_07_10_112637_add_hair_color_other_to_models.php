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
            $table->string("hair_color_other")->nullable()->after("hair_color");
            $table->boolean("tattoos")->nullable()->after("hair_color");
            $table->boolean("piercings")->nullable()->after("hair_color");
            $table->string("cup_size")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn("hair_color_other");
            $table->dropColumn("tattoos");
            $table->dropColumn("piercings");
            $table->dropColumn("cup_size");
        });
    }
};

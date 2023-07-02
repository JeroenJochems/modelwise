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
            $table->decimal("shoe_size", 3, 1)->nullable();
            $table->decimal("height", 4, 1)->nullable();
            $table->decimal("chest", 4, 1)->nullable();
            $table->decimal("waist", 4, 1)->nullable();
            $table->decimal("hips", 4, 1)->nullable();
            $table->string("hair_color")->nullable();
            $table->string("ethnicity")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn("shoe_size");
            $table->dropColumn("height");
            $table->dropColumn("chest");
            $table->dropColumn("waist");
            $table->dropColumn("hips");
            $table->dropColumn("hair_color");
            $table->dropColumn("ethnicity");
        });
    }
};

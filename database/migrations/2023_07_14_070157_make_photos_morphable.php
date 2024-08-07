<?php

use Domain\Profiles\Models\Media;
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
        Schema::table("photos", function(Blueprint $table) {
            $table->nullableMorphs("photoable");
        });

        Schema::table("photos", function(Blueprint $table) {
            $table->dropColumn("model_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("photos", function(Blueprint $table) {
            $table->unsignedBigInteger("model_id")->nullable()->after("id");
        });

        Schema::table("photos", function(Blueprint $table) {
            $table->dropMorphs("photoable");
        });
    }
};

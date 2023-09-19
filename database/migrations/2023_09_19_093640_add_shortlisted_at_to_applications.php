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
        Schema::table('applications', function (Blueprint $table) {
            $table->dateTime("shortlisted_at")->nullable()->after("model_id");
            $table->dateTime("rejected_at")->nullable()->after("shortlisted_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn("shortlisted_at");
            $table->dropColumn("rejected_at");
        });
    }
};

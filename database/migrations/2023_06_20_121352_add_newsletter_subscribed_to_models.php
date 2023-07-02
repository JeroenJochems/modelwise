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
            $table->boolean("is_subscribed_to_newsletter")->default(false);
            $table->boolean("has_completed_onboarding")->default(false);
            $table->boolean("is_accepted")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn("is_subscribed_to_newsletter");
            $table->dropColumn("has_completed_onboarding");
            $table->dropColumn("is_accepted");
        });
    }
};

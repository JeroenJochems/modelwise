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
        Schema::dropIfExists('role_model');

        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('model_id');
            $table->string('role_id');
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('extended_application_at')->nullable();
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('shortlisted_at')->nullable();
            $table->timestamp('hired_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->string('cover_letter')->nullable();
            $table->string('brand_conflicted')->nullable();
            $table->json('available_dates')->nullable();
            $table->text('casting_questions')->nullable();
            $table->timestamps();
            $table->unique(['role_id', 'model_id'], 'role_model_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};

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
        Schema::rename("shortlisted_models", "longlisted_models");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename("longlisted_models", "shortlisted_models");
    }
};

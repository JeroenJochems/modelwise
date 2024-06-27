<?php

use Domain\Work2\RoleAggregate;
use Domain\Work2\RoleRepository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('work_events')->truncate();
    }
};

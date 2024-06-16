<?php

use Domain\Jobs\Models\Role;
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
        Role::all()->each(function ($role) {
            app(RoleRepository::class)->persist(RoleAggregate::init($role));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('work_events')->truncate();
    }
};

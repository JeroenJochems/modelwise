<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('mux_upload_id')->nullable()->after('mux_asset_id');
            $table->string('mux_status')->default('ready')->after('mux_upload_id');
            $table->string('mux_error')->nullable()->after('mux_status');

            $table->index('mux_upload_id');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex(['mux_upload_id']);
            $table->dropColumn(['mux_upload_id', 'mux_status', 'mux_error']);
        });
    }
};

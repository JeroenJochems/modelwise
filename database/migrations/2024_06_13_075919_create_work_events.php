<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_id');
            $table->uuid('aggregate_root_id');
            $table->integer('version');
            $table->json('payload');
            $table->index(['aggregate_root_id', 'version'], 'reconstitution_index');
            $table->unique(['aggregate_root_id', 'version'], 'idempotency_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_events');
    }
};

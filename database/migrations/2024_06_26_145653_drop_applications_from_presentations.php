<?php

use Domain\Present\Models\Presentation;
use Domain\Work2\Models\Listing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (Presentation::all() as $presentation)
        {
            $applications = DB::table("applications")
                ->whereIn('id', $presentation->applications)
                ->orderBy('order_column')
                ->get();

            foreach ($applications as $application) {

                $listing = Listing::query()
                    ->whereRoleId($presentation->role_id)
                    ->whereModelId($application->model_id)
                    ->first();

                $presentation->presentationListings()->create([
                    'listing_id' => $listing->id,
                    'order_column' => $presentation->presentationListings()->count() + 1,
                ]);
            }
        }

        Schema::table('presentations', function (Blueprint $table) {
            $table->dropColumn('applications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('presentation_listings')->truncate();
        Schema::table('presentations', function (Blueprint $table) {
            $table->json('applications')->nullable();
        });
    }
};

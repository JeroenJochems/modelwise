<?php

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
        $applications = DB::table('applications')->get();

        foreach ($applications as $application) {

            $rejection = DB::table('rejections')
                ->where('application_id', $application->id)
                ->first();

            $hire = DB::table('hires')
                ->where('application_id', $application->id)
                ->first();

            $invite = DB::table('invites')
                ->where('role_id', $application->role_id)
                ->where('model_id', $application->model_id)
                ->first();

            $listing = \Domain\Work2\Models\Listing::create([
                'model_id' => $application->model_id,
                'role_id' => $application->role_id,
                'rejected_at' => $rejection ? $rejection->created_at : null,
                'hired_at' => $hire ? $hire->created_at : null,
                'favorited_at' => $application->prelisted_at,
                'invited_at' => $invite ? $invite->created_at : null,
                'shortlisted_at' => $application->shortlisted_at,
                'applied_at' => $application->created_at,
                'cover_letter' => $application->cover_letter,
                'brand_conflicted' => $application->brand_conflicted,
                'available_dates' => [],
                'casting_questions' => $application->casting_questions,
            ]);

            $photos = DB::table("photos")
                ->where('photoable_type', 'application')
                ->where('photoable_id', $application->id)
                ->get();

            foreach ($photos as $photo) {
                print "Copying photo {$photo->id} to listing {$listing->id}\n";

                DB::table("photos")->where('id', $photo->id)->update([
                    'photoable_id' => $listing->id,
                    'photoable_type' => 'listing',
                    'folder' => $photo->folder === 'Application' ? 'Listing' : $photo->folder,
                ]);
            }

            $videos = DB::table("videos")
                ->where('videoable_id', $application->id)
                ->where('videoable_type', 'application')
                ->get();

            foreach ($videos as $video) {
                DB::table("videos")->where('id', $video->id)->update([
                    'videoable_id' => $listing->id,
                    'videoable_type' => 'listing',
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
};

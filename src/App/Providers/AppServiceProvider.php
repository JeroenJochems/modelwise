<?php

namespace App\Providers;

use Domain\Jobs\Models\Brand;
use Domain\Jobs\Models\Client;
use Domain\Jobs\Models\Invite;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Models\Role;
use Domain\Present\Models\Presentation;
use Domain\Present\Models\PresentationListing;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Model as ModelClass;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Models\Video;
use Domain\Work\Models\Application;
use Domain\Work2\Models\Listing;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Spatie\Onboard\Facades\Onboard;
use Spatie\Tags\Tag;
use Support\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'model' => Model::class,
            'job' => Job::class,
            'photo' => Photo::class,
            'video' => Video::class,
            'role' => Role::class,
            'brand' => Brand::class,
            'user' => User::class,
            'application' => Application::class,
            'longlist-model' => Invite::class,
            'client' => Client::class,
            'tag' => Tag::class,
            'presentation' => Presentation::class,
            'model-role' => Listing::class,
            'presentation-listing' => PresentationListing::class,
        ]);

        Onboard::addStep('Personal details')
            ->link("onboarding/personal-details")
            ->completeIf(function (Model $model) {
                return !!$model->first_name;
            });


        Onboard::addStep('Profile picture')
            ->link("onboarding/profile-picture")
            ->completeIf(function (Model $model) {
                return !!$model->profile_picture;
            });

        Onboard::addStep('Portfolio')
            ->link("onboarding/portfolio")
            ->completeIf(function (Model $model) {
                return !!$model->photos()->count();
            });

        Onboard::addStep('Activities')
            ->link("onboarding/activities")
            ->completeIf(function (Model $model) {
                return $model->photos()->where('folder', Photo::FOLDER_ACTIVITIES)->count() > 0;
            });

        Onboard::addStep('Socials')
            ->link("onboarding/socials")
            ->completeIf(function (Model $model) {
                return !(is_null($model->instagram) && is_null($model->tiktok));
            });

        Onboard::addStep('Characteristics')
            ->link("onboarding/characteristics")
            ->completeIf(function (Model $model) {
                return $model->height > 0;
            });

        Onboard::addStep('Exclusive countries')
            ->link("onboarding/exclusive-countries")
            ->completeIf(function (Model $model) {
                return !!$model->seen_exclusive_countries;
            });

        Onboard::addStep('Professional background')
            ->link("onboarding/professional-experience")
            ->completeIf(function (Model $model) {
                return $model
                        ->tagsWithType(ModelClass::TAG_TYPE_MODEL_EXPERIENCE)
                        ->count() > 0;
            });
    }
}

<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Model\OnboardingController;
use App\Http\Controllers\Model\ProfessionalExperienceController;
use App\Http\Controllers\PassController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Model\CharacteristicsController;
use App\Http\Controllers\Model\DigitalsController;
use App\Http\Controllers\Model\ExclusiveCountriesController;
use App\Http\Controllers\Model\ExperienceController;
use App\Http\Controllers\Model\PersonalDetailsController;
use App\Http\Controllers\Model\PortfolioController;
use App\Http\Controllers\Model\ProfilePictureController;
use App\Http\Controllers\Model\SocialsController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\VaporSignedStorageUrl;
use App\Http\Controllers\VideosController;
use Illuminate\Support\Facades\Route;

Route::get('test', function() {
    $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
    $nonPrivateAccountMedias = $instagram->getMedias('arnbraun');
    dd($nonPrivateAccountMedias[0]->getImageHighResolutionUrl());

});

if (!function_exists("onboardingRoutes")) {
    function onboardingRoutes()
    {
        Route::get('personal-details', [PersonalDetailsController::class, "index"])->name("personal-details");
        Route::get('profile-picture', [ProfilePictureController::class, "index"])->name("profile-picture");
        Route::get('portfolio', [PortfolioController::class, "index"])->name("portfolio");
        Route::get('digitals', [DigitalsController::class, "index"])->name("digitals");
        Route::get('socials', [SocialsController::class, "index"])->name("socials");
        Route::get('characteristics', [CharacteristicsController::class, "index"])->name("characteristics");
        Route::get('exclusive-countries', [ExclusiveCountriesController::class, "index"])->name("exclusive-countries");
        Route::get('exclusive-countries/done', [ExclusiveCountriesController::class, "done"])->name("exclusive-countries.done");
        Route::get('professional-experience', [ProfessionalExperienceController::class, "index"])->name("professional-experience");

        Route::post('personal-details', [PersonalDetailsController::class, 'store'])->name("personal-details.store");
        Route::post('profile-picture', [ProfilePictureController::class, 'store'])->name("profile-picture.store");
        Route::post('portfolio', [PortfolioController::class, 'store'])->name("portfolio.store");
        Route::post('digitals', [DigitalsController::class, 'store'])->name("digitals.store");
        Route::post('socials', [SocialsController::class, 'store'])->name("socials.store");
        Route::post('exclusive-countries', [ExclusiveCountriesController::class, "store"])->name("exclusive-countries.store");
        Route::delete('exclusive-countries/{country}/delete', [ExclusiveCountriesController::class, "delete"])->name("exclusive-countries.delete");
        Route::post('characteristics', [CharacteristicsController::class, "store"])->name("characteristics.store");
        Route::post('photos/sort', [PhotosController::class, 'sort'])->name("photos.sort");
        Route::post('professional-experience', [ProfessionalExperienceController::class, "store"])->name("professional-experience.store");
        Route::delete('photos/{photo}/delete', [PhotosController::class, "delete"])->name("photos.delete");
        Route::delete('videos/{videos}/delete', [VideosController::class, "delete"])->name("videos.delete");
    }
}

Route::get('/', [LandingController::class, "index"] )->name("landing");
Route::get('/login', [AuthenticatedSessionController::class, "create"] )->name("login");
Route::post('/contact', [ContactController::class, "store"] )->name("contact");


Route::get('about-modelwise', [OnboardingController::class, "index"])->name("onboarding.index");

Route::resource('roles', RoleController::class, ["index", "view"])->name("index", "jobs");
Route::get('presentations/{presentation}', [PresentationController::class, "show"])->name("presentations.show");

Route::middleware(['auth'])->group(callback: function () {

    Route::resource("applications", ApplicationController::class)->only(["index", "show", "update"])
        ->name("index", "applications")
        ->name("show", "applications.show")
        ->name("upate", "applications.update");

    Route::resource('roles/{role}/applications', ApplicationController::class)->only(["create", "store"])
        ->name("create", "roles.apply")
        ->name("store", "roles.apply.store");

    Route::resource('roles/{role}/pass', PassController::class, ["store"])
        ->name("store", "roles.pass.store");


    Route::middleware("onboarding")->group(function() {
        Route::get('dashboard', DashboardController::class)->name("dashboard");
        Route::get('account', [ModelController::class, "index"])->name("account.index");
    });

    Route::post('signed-url', VaporSignedStorageUrl::class.'@store');

    Route::name("account.")->prefix("account")->group(function() {
        onboardingRoutes();
    });

    Route::name("onboarding.")->prefix("onboarding")->group(function() {
        onboardingRoutes();

        Route::get('thanks', [ModelController::class, "thanks"])->name("thanks");
        Route::get('not-accepted', [ModelController::class, "notAccepted"])->name("not-accepted");
        Route::post('subscribe', [ModelController::class, "subscribe"])->name("subscribe");
    });
});

require __DIR__.'/auth.php';

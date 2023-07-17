<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
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
use App\Http\Controllers\VaporSignedStorageUrl;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
        Route::get('experience', [ExperienceController::class, "index"])->name("experience");
    }
}

Route::get('/', [AuthenticatedSessionController::class, "create"] );

Route::resource('roles/{role}/applications', ApplicationController::class, ["create", "store"])
    ->name("index", "roles.applications")
    ->name("create", "roles.apply");

Route::resource('roles', RoleController::class, ["index", "view"])->name("index", "jobs");

Route::middleware(['auth'])->group(callback: function () {

    Route::middleware("onboarding")->group(function() {
        Route::get('dashboard', DashboardController::class)->name("dashboard");
        Route::get('account', [ModelController::class, "index"])->name("account.index");
    });

    Route::post('photos/signed-url', VaporSignedStorageUrl::class.'@store');


    Route::name("account.")->prefix("account")->group(function() {
        onboardingRoutes();

        Route::post('personal-details', [PersonalDetailsController::class, 'store'])->name("personal-details.store");
        Route::post('profile-picture', [ProfilePictureController::class, 'store'])->name("profile-picture.store");
        Route::post('portfolio', [PortfolioController::class, 'store'])->name("portfolio.store");
        Route::post('digitals', [DigitalsController::class, 'store'])->name("digitals.store");
        Route::post('socials', [SocialsController::class, 'store'])->name("socials.store");
        Route::post('exclusive-countries', [ExclusiveCountriesController::class, "store"])->name("exclusive-countries.store");
        Route::delete('exclusive-countries/{country}/delete', [ExclusiveCountriesController::class, "delete"])->name("exclusive-countries.delete");
        Route::post('characteristics', [CharacteristicsController::class, "store"])->name("characteristics.store");
        Route::post('photos/sort', [PhotosController::class, 'sort'])->name("photos.sort");
        Route::delete('photos/{photo}/delete', [PhotosController::class, "delete"])->name("photos.delete");
    });

    Route::name("onboarding.")->prefix("onboarding")->group(function() {
        onboardingRoutes();

        Route::get('thanks', [ModelController::class, "thanks"])->name("thanks");
        Route::get('not-accepted', [ModelController::class, "notAccepted"])->name("not-accepted");
        Route::post('subscribe', [ModelController::class, "subscribe"])->name("subscribe");
    });


    Route::get('jobs/{job}/applications/create', [ApplicationController::class, "create"])->name('jobs.apply');
});

require __DIR__.'/auth.php';

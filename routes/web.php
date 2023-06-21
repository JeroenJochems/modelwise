<?php

use App\Http\Controllers\Models\OnboardingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth'])->group(function () {

    Route::middleware("onboarding")->group(function() {
        Route::get('/model/dashboard', \App\Http\Controllers\Models\DashboardController::class)->name("dashboard");
    });

    Route::get('/model/onboarding/personal-details', [OnboardingController::class, "personalDetails"])->name("onboarding.personal-details");
    Route::post('/model/onboarding/personal-details', [OnboardingController::class, 'storePersonalDetails']);
    Route::get('/model/onboarding/profile-picture', [OnboardingController::class, "profilePicture"])->name("onboarding.profile-picture");
    Route::post('/model/onboarding/profile-picture', [OnboardingController::class, 'storeProfilePicture']);
    Route::get('/model/onboarding/photos', [OnboardingController::class, "photos"])->name("onboarding.photos");
    Route::post('/model/onboarding/photos', [OnboardingController::class, 'storePhotos']);
    Route::get('/model/onboarding/digitals', [OnboardingController::class, "digitals"])->name("onboarding.digitals");
    Route::post('/model/onboarding/digitals', [OnboardingController::class, 'storeDigitals']);
    Route::get('/model/onboarding/socials', [OnboardingController::class, "socials"])->name("onboarding.socials");
    Route::post('/model/onboarding/socials', [OnboardingController::class, 'storeSocials']);
    Route::get('/model/onboarding/thanks', [OnboardingController::class, "thanks"])->name("onboarding.thanks");
    Route::get('/model/onboarding/not-accepted', [OnboardingController::class, "notAccepted"])->name("onboarding.not-accepted");
    Route::post('/model/onboarding/subscribe', [OnboardingController::class, "subscribe"])->name("onboarding.subscribe");
});

require __DIR__.'/auth.php';

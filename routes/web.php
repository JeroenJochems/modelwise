<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Models\OnboardingController;
use App\Http\Controllers\Models\PhotosController;
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

Route::resource('jobs', JobController::class);
Route::post('jobs/{job}/applications', [ApplicationController::class, "store"])->name('jobs.apply.store');


Route::middleware(['auth'])->group(callback: function () {

    Route::get('jobs/{job}/applications/create', [ApplicationController::class, "create"])->name('jobs.apply');

    Route::middleware("onboarding")->group(function() {
        Route::get('/model/dashboard', \App\Http\Controllers\Models\DashboardController::class)->name("dashboard");
    });

    Route::get('/model/onboarding/personal-details', [OnboardingController::class, "personalDetails"])->name("onboarding.personal-details");
    Route::post('/model/onboarding/personal-details', [OnboardingController::class, 'storePersonalDetails']);
    Route::get('/model/onboarding/profile-picture', [OnboardingController::class, "profilePicture"])->name("onboarding.profile-picture");
    Route::post('/model/onboarding/profile-picture', [OnboardingController::class, 'storeProfilePicture']);
    Route::delete('/model/onboarding/digitals/{digital}/delete', [OnboardingController::class, "deleteDigital"])->name("onboarding.digitals.delete");
    Route::get('/model/onboarding/photos', [OnboardingController::class, "photos"])->name("onboarding.photos");
    Route::get('/model/onboarding/digitals', [OnboardingController::class, "digitals"])->name("onboarding.digitals");
    Route::post('/model/onboarding/digitals', [OnboardingController::class, 'storeDigitals']);
    Route::get('/model/onboarding/socials', [OnboardingController::class, "socials"])->name("onboarding.socials");
    Route::post('/model/onboarding/socials', [OnboardingController::class, 'storeSocials']);
    Route::get('/model/onboarding/thanks', [OnboardingController::class, "thanks"])->name("onboarding.thanks");
    Route::get('/model/onboarding/not-accepted', [OnboardingController::class, "notAccepted"])->name("onboarding.not-accepted");
    Route::post('/model/onboarding/subscribe', [OnboardingController::class, "subscribe"])->name("onboarding.subscribe");

    Route::post('/model/photos', [PhotosController::class, 'store'])->name("model.photos.store");
    Route::post('/model/photos/sort', [PhotosController::class, 'sort'])->name("model.photos.sort");
    Route::delete('/model/photos/{photo}/delete', [PhotosController::class, "delete"])->name("model.photos.delete");
});

require __DIR__.'/auth.php';

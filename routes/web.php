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


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Controllers\Models\DashboardController::class)->name("dashboard");

    Route::get('/model/onboarding/personal-details', [OnboardingController::class, "personalDetails"])->name("onboarding.personal-details");
    Route::post('/model/onboarding/personal-details', [OnboardingController::class, 'storePersonalDetails']);
    Route::get('/model/onboarding/profile-picture', [OnboardingController::class, "profilePicture"])->name("onboarding.profile-picture");
    Route::post('/model/onboarding/profile-picture', [OnboardingController::class, 'storeProfilePicture']);
    Route::get('/model/onboarding/photos', [OnboardingController::class, "photos"])->name("onboarding.photos");
    Route::post('/model/onboarding/photos', [OnboardingController::class, 'storePhotos']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

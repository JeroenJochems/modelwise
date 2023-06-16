<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', \App\Http\Livewire\Models\Onboarding\Step1::class);
    Route::get('/model/onboarding/2', \App\Http\Livewire\Models\Onboarding\Step2::class)->name("model.onboarding.2");

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('register', \App\Http\Livewire\Register::class)->name("register");
});

require __DIR__.'/auth.php';

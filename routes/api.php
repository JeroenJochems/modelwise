<?php

use App\Http\Controllers\Api\ListingApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api-key')
    ->prefix('listings')
    ->controller(ListingApiController::class)
    ->group(function () {
        // Single-item actions
        Route::post('/roles/{role}/add/{model}', 'addToRole');
        Route::post('/roles/{role}/invite/{model}', 'invite');
        Route::post('/{listing}/shortlist', 'shortlist');
        Route::post('/{listing}/hire', 'hire');
        Route::post('/{listing}/reject', 'reject');
        Route::post('/{listing}/reinvite', 'reinvite');
        Route::delete('/{listing}', 'destroy');
        Route::post('/{listing}/toggle-favorited', 'toggleFavorited');
        Route::patch('/roles/{role}/reorder', 'reorder');

        // Bulk actions
        Route::post('/roles/{role}/bulk-invite', 'bulkInvite');
        Route::post('/roles/{role}/bulk-shortlist', 'bulkShortlist');
        Route::post('/roles/{role}/bulk-hire', 'bulkHire');
        Route::post('/roles/{role}/bulk-reject', 'bulkReject');
        Route::delete('/roles/{role}/bulk-delete', 'bulkDelete');
    });

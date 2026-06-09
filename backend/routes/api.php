<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CompanionController;
use App\Http\Controllers\Api\EscrowController;
use App\Http\Controllers\Api\FleetController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\VenueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| VelvetHour API v1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // ── Auth (public) ──────────────────────────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login',    [AuthController::class, 'login']);
        Route::post('/refresh',  [AuthController::class, 'refresh']);

        Route::middleware('auth:api')->group(function () {
            Route::delete('/logout', [AuthController::class, 'logout']);
            Route::get('/me',        [AuthController::class, 'me']);
        });
    });

    // ── Public browse (no auth required) ───────────────────────────────
    Route::prefix('companions')->group(function () {
        Route::get('/',          [CompanionController::class, 'index']);
        Route::get('/ai-match',  [CompanionController::class, 'aiMatch']);
        Route::get('/{id}',      [CompanionController::class, 'show']);
    });

    Route::prefix('venues')->group(function () {
        Route::get('/',              [VenueController::class, 'index']);
        Route::get('/{id}',          [VenueController::class, 'show']);
        Route::get('/{id}/slots',    [VenueController::class, 'slots']);
        Route::get('/{id}/pricing',  [VenueController::class, 'pricingCalculator']);
    });

    Route::prefix('fleet')->group(function () {
        Route::get('/',           [FleetController::class, 'index']);
        Route::get('/{id}',       [FleetController::class, 'show']);
        Route::get('/{id}/drivers', [FleetController::class, 'drivers']);
    });

    // ── Authenticated client routes ─────────────────────────────────────
    Route::middleware(['auth:api', 'role:client,admin'])->group(function () {

        // Bookings
        Route::prefix('bookings')->group(function () {
            Route::get('/',          [BookingController::class, 'index']);
            Route::get('/{id}',      [BookingController::class, 'show']);
            Route::patch('/{id}/cancel',   [BookingController::class, 'cancel']);
            Route::patch('/{id}/complete', [BookingController::class, 'complete']);
        });

        // Book a companion
        Route::post('/companions/{id}/book', [CompanionController::class, 'book']);
        Route::post('/venues/{id}/book',     [VenueController::class, 'book']);
        Route::post('/fleet/{id}/book',      [FleetController::class, 'book']);

        // Payments
        Route::prefix('payments')->group(function () {
            Route::post('/intent',   [PaymentController::class, 'createIntent']);
            Route::post('/confirm',  [PaymentController::class, 'confirm']);
            Route::get('/{id}',      [PaymentController::class, 'show']);
        });

        // Escrow
        Route::prefix('escrow')->group(function () {
            Route::get('/{id}',         [EscrowController::class, 'show']);
            Route::post('/{id}/release', [EscrowController::class, 'release']);
            Route::post('/{id}/dispute', [EscrowController::class, 'dispute']);
        });
    });

    // ── Admin-only routes ───────────────────────────────────────────────
    Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {
        Route::post('/escrow/{id}/resolve',   [EscrowController::class, 'resolve']);
        Route::get('/bookings',               [BookingController::class, 'adminIndex']);
        Route::patch('/companions/{id}/verify', [CompanionController::class, 'verify']);
        Route::patch('/companions/{id}/feature', [CompanionController::class, 'feature']);
    });

    // ── Companion-facing routes ─────────────────────────────────────────
    Route::middleware(['auth:api', 'role:companion'])->prefix('companion')->group(function () {
        Route::get('/bookings',               [BookingController::class, 'companionBookings']);
        Route::patch('/availability',         [CompanionController::class, 'updateAvailability']);
        Route::patch('/profile',              [CompanionController::class, 'updateProfile']);
        Route::post('/photos',                [CompanionController::class, 'uploadPhoto']);
    });
});

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserVerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses Guest/Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/auctions', [AuctionController::class, 'index'])
    ->name('auctions.index');

Route::get('/auctions/{auction}', [AuctionController::class, 'show'])
    ->name('auctions.show');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Hanya untuk Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('auctions', AdminAuctionController::class)
            ->except(['show']);

        Route::get('/user-verification', [UserVerificationController::class, 'index'])
            ->name('users.verify.index');

        Route::post('/user-verification/{user}/approve', [UserVerificationController::class, 'approve'])
            ->name('users.verify.approve');

        Route::post('/user-verification/{user}/reject', [UserVerificationController::class, 'reject'])
            ->name('users.verify.reject');
    });


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Harus Login: User Biasa & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- [FIXED] FEATURE BIDDING & BUYOUT ---
    // Route ini menggunakan AuctionController yang baru kita edit
    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])
        ->name('auctions.bid');
        
    Route::post('/auctions/{auction}/buyout', [BidController::class, 'buyout'])
        ->name('auctions.buyout');
    // ----------------------------------------

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');

        Route::get('/my-items', function() {
    return "Halaman My Items belum dibuat"; // Placeholder sementara
})->name('items.index');

// Tambahkan ini di routes/web.php
Route::get('/history', function() {
    return "Halaman History belum dibuat";
})->name('history.index');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
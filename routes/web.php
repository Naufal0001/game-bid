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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/auctions', [AuctionController::class, 'index'])
    ->name('auctions.index');

Route::get('/auctions/{auction}', [AuctionController::class, 'show'])
    ->name('auctions.show');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/home', [AdminDashboardController::class, 'index'])
            ->name('home');

        Route::resource('auctions', AdminAuctionController::class)
            ->except(['show']);

        Route::get('/user-verification', [UserVerificationController::class, 'index'])
            ->name('users.verify.index');

        Route::post('/user-verification/{user}/approve', [UserVerificationController::class, 'approve'])
            ->name('users.verify.approve');

        Route::post('/user-verification/{user}/reject', [UserVerificationController::class, 'reject'])
            ->name('users.verify.reject');
    });

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/auctions', [AuctionController::class, 'index'])
        ->middleware('permission:view auction')
        ->name('auctions.index');

    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])
        ->middleware('permission:bid auction')
        ->name('bids.store');

    Route::post('/auctions/{auction}/buyout', [BidController::class, 'buyout'])
        ->middleware('permission:buyout auction')
        ->name('auctions.buyout');

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->middleware('permission:view transaction')
        ->name('transactions.index');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// Route::middleware('auth')->group(function () {
//     Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
//     Route::get('/auctions/{id}', [AuctionController::class, 'show'])->name('auctions.show');
//     Route::post('/auctions/{id}/bids', [BidController::class, 'store'])->name('bids.store');
//     Route::post('/auctions/{auction}/buyout', [BidController::class, 'buyout'])->name('auctions.buyout');

//     Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

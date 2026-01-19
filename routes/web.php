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
use App\Http\Controllers\Auth\SocialiteController; 
use App\Http\Controllers\ItemController; // <--- Jangan lupa import di paling atas


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC ROUTES (Bisa diakses Guest & User)
// =========================================================================

Route::get('/', [HomeController::class, 'index'])->name('home');

// PENTING: Ditaruh di sini agar tombol "VIEW ALL AUCTIONS" di halaman depan bisa jalan
Route::get('/auctions', [AuctionController::class, 'index'])
    ->name('auctions.index');

// --- GOOGLE SOCIALITE LOGIN ---

Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);
// =========================================================================
// 2. ADMIN ROUTES (Khusus Admin)
// =========================================================================
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


// =========================================================================
// 3. AUTHENTICATED ROUTES (Harus Login)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])
        ->name('dashboard'); // Biasanya /home itu dashboard user
    Route::get('/my-items', [ItemController::class, 'index'])->name('items.index');
    
    // Kemungkinan route ini juga belum ada (lihat navbar baris 18)
    Route::get('/history', function() { return 'History'; })->name('history.index');
    // --- FITUR LELANG (Create & Store) ---
    // Route ini WAJIB ada di atas route "show" agar tidak bentrok
    Route::get('/auctions/create', [AuctionController::class, 'create'])
        ->name('auctions.create');

    Route::post('/auctions', [AuctionController::class, 'store'])
        ->name('auctions.store');

    // --- FITUR BID & BUYOUT ---
    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])
        ->middleware('permission:bid auction')
        ->name('bids.store');

    Route::post('/auctions/{auction}/buyout', [BidController::class, 'buyout'])
        ->middleware('permission:buyout auction')
        ->name('auctions.buyout');

    // --- TRANSAKSI & PROFILE ---
    Route::get('/transactions', [TransactionController::class, 'index'])
        ->middleware('permission:view transaction')
        ->name('transactions.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// =========================================================================
// 4. PUBLIC DETAIL ROUTE (Paling Bawah)
// =========================================================================
// Ditaruh paling bawah supaya tidak menganggap kata "create" sebagai ID lelang.
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])
    ->name('auctions.show');


require __DIR__.'/auth.php';
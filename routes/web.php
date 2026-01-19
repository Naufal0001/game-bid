<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HistoryController;
// Admin Controllers
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PaymentVerificationController;
use App\Http\Controllers\Admin\UserVerificationController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController; // <--- [BARU] Controller Transaksi Admin
use App\Http\Controllers\Admin\ReportController as AdminReportController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses Guest/Tanpa Login)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/auctions', [AuctionController::class, 'index'])
    ->name('auctions.index');

// PENTING: Tambahkan 'whereNumber' agar tidak bentrok dengan route /auctions/create
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])
    ->name('auctions.show')
    ->whereNumber('auction');


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

        // =========================
        // USER MANAGEMENT
        // =========================
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/{user}', [AdminUserController::class, 'show'])
            ->name('users.show');

        Route::patch('/users/{user}/status',[AdminUserController::class, 'updateStatus'])
            ->name('users.status');

        // =========================
        // AUCTION MANAGEMENT
        // =========================
        Route::get('/auctions', [AdminAuctionController::class, 'index'])
            ->name('auctions.index');

        //edit auction
        Route::get('/auctions/{auction}/edit', [AdminAuctionController::class, 'edit'])
            ->name('auctions.edit');

        Route::post('/auctions', [AdminAuctionController::class, 'store'])
            ->name('auctions.store');

        Route::put('/auctions/{auction}', [AdminAuctionController::class, 'update'])
            ->name('auctions.update');

        Route::patch('/auctions/{auction}/close', [AdminAuctionController::class, 'close'])
            ->name('auctions.close');

        Route::delete('/auctions/{auction}', [AdminAuctionController::class, 'destroy'])
            ->name('auctions.destroy');

        // =========================
        // USER VERIFICATION
        // =========================
        Route::get('/user-verification', [UserVerificationController::class, 'index'])
            ->name('users.verify.index');

        Route::post('/user-verification/{user}/approve',
            [UserVerificationController::class, 'approve'])
            ->name('users.verify.approve');

        Route::post('/user-verification/{user}/reject',
            [UserVerificationController::class, 'reject'])
            ->name('users.verify.reject');

        // =========================
        // ITEM VERIFICATION
        // =========================
        Route::get('/items-verification', [AdminItemController::class, 'index'])
            ->name('items.index');

        Route::post('/items-verification/{item}/approve',
            [AdminItemController::class, 'approve'])
            ->name('items.approve');

        Route::post('/items-verification/{item}/reject',
            [AdminItemController::class, 'reject'])
            ->name('items.reject');

        // =========================
        // TRANSACTION MANAGEMENT
        // =========================
        Route::get('/transactions', [AdminTransactionController::class, 'index'])
            ->name('transactions.index');

        Route::post('/transactions/{transaction}/approve',
            [AdminTransactionController::class, 'approve'])
            ->name('transactions.approve');

        Route::post('/transactions/{transaction}/reject',
            [AdminTransactionController::class, 'reject'])
            ->name('transactions.reject');

        Route::get('/reports/transactions', [AdminReportController::class, 'transactions'])
            ->name('reports.transactions');
    });



/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Harus Login: User Biasa & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- ITEM MANAGEMENT (MY ITEMS / INVENTORY) ---
    Route::resource('items', ItemController::class);

    // --- FEATURE MY AUCTIONS & CREATE ---
    Route::get('/my-auctions', [AuctionController::class, 'myAuctions'])
        ->name('auctions.my_auctions');

    Route::get('/auctions/create', [AuctionController::class, 'create'])
        ->name('auctions.create');

    Route::post('/auctions', [AuctionController::class, 'store'])
        ->name('auctions.store');


    // --- FEATURE BIDDING & BUYOUT ---
    Route::post('/auctions/{auction}/bid', [AuctionController::class, 'bid'])
        ->name('auctions.bid');
        
    Route::post('/auctions/{auction}/buyout', [AuctionController::class, 'buyout'])
        ->name('auctions.buyout');


    // --- [BARU] PEMBAYARAN / CHECKOUT (USER) ---
    // Halaman form bayar
    Route::get('/auctions/{auction}/checkout', [TransactionController::class, 'checkout'])
        ->name('transactions.checkout');
    
    // Proses upload bukti bayar
    Route::post('/auctions/{auction}/checkout', [TransactionController::class, 'store'])
        ->name('transactions.store');
    
    // List transaksi user (Opsional jika ingin melihat riwayat bayar)
    Route::get('/transactions/{transaction}', [PaymentController::class, 'show'])
        ->name('transactions.show');
    
    Route::post('/transactions/{transaction}/upload-proof',
        [PaymentController::class, 'uploadProof']
        )->name('transactions.uploadProof');

    Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index');


    // --- HISTORY ---
    Route::get('/history', [HistoryController::class, 'index'])
        ->name('history.index');

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
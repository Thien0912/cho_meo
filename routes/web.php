<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CoinController;

Auth::routes();

// Route mặc định sau khi đăng nhập
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Các route admin cần xác thực
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('pages', PageController::class);
    Route::resource('posts', PostController::class);
    Route::resource('uploads', UploadController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::get('/coin-history', [CoinController::class, 'showCoinHistory'])->name('coin_history');
    Route::get('/add-coins', [CoinController::class, 'addCoinsForm'])->name('add_coins');
    Route::post('/add-coins', [CoinController::class, 'processAddCoins'])->name('process_add_coins');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{id}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{id}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
});

Route::get('/visitors', [VisitorController::class, 'getVisitors']);

Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit.show');
Route::post('/deposit', [TransactionController::class, 'store'])->name('deposit.store');

// Giao diện tải ảnh lên
Route::get('/chat', function () {
    return view('chat');
})->name('chat');

// API xử lý ảnh upload
Route::post('/chatbot/ask', [ChatController::class, 'ask'])->name('chat.ask');
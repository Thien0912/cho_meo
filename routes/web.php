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
use App\Http\Controllers\Controller;
use App\Http\Controllers\EditController;
use App\Http\Controllers\LLMController;
use App\Http\Controllers\ApkController;
use App\Http\Controllers\BreedController;
use Illuminate\Support\Facades\Http;

Auth::routes();

// Route mặc định sau khi đăng nhập
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route đăng xuất
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Các route admin cần xác thực
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/apk', [ApkController::class, 'index'])->name('apk.index');
    Route::post('/apk', [ApkController::class, 'store'])->name('apk.store');
    Route::post('/apk/select', [ApkController::class, 'select'])->name('apk.select');
    Route::get('/llm', [LLMController::class, 'index'])->name('llm.index');
    Route::post('/llm/update', [LLMController::class, 'update'])->name('llm.update');
    Route::resource('users', UserController::class);
    Route::match(['get', 'post'], '/page', [PageController::class, 'index'])->name('pages.index');
    Route::resource('posts', PostController::class);
    Route::resource('uploads', UploadController::class);
    Route::get('/coin-history', [CoinController::class, 'showCoinHistory'])->name('coin_history');
    Route::get('/add-coins', [CoinController::class, 'addCoinsForm'])->name('add_coins');
    Route::post('/add-coins', [CoinController::class, 'processAddCoins'])->name('process_add_coins');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{id}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{id}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
    Route::get('/breeds', [BreedController::class, 'indexAdmin'])->name('breeds.index');
    Route::get('/breeds/create', [BreedController::class, 'create'])->name('breeds.create');
    Route::post('/breeds', [BreedController::class, 'store'])->name('breeds.store');
    Route::get('/breeds/{breed}/edit', [BreedController::class, 'edit'])->name('breeds.edit');
    Route::put('/breeds/{breed}', [BreedController::class, 'update'])->name('breeds.update');
    Route::delete('/breeds/{breed}', [BreedController::class, 'destroy'])->name('breeds.destroy');
});

Route::post('/chat/upload', [ChatController::class, 'handleUpload'])->middleware('auth');
Route::get('edit', [EditController::class, 'edit'])->name('edit');
Route::post('edit', [EditController::class, 'update']);
Route::get('/get-transactions', [VisitorController::class, 'getTransactions']);
Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit.show');
Route::post('/deposit', [TransactionController::class, 'store'])->name('deposit.store');
Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.like');
Route::get('/posts', [PostController::class, 'publicIndex'])->name('posts.index');
Route::get('/breed', [BreedController::class, 'index'])->name('breed.index');

// Giao diện tải ảnh lên
Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/user/coins', [Controller::class, 'getUserCoins'])->name('user.coins');

Route::get('/download-current-apk', function () {
    $apiKey = env('FASTAPI_KEY', 'iAtteKj8TSqUK4kdrHHC2QlIldEdfMjk');
    $response = Http::withHeaders(['API-Key' => $apiKey])
                    ->get('http://localhost:55010/upload-file/apks/current/download/');
    
    if ($response->successful()) {
        return response($response->body())
               ->header('Content-Type', 'application/vnd.android.package-archive')
               ->header('Content-Disposition', $response->header('Content-Disposition'));
    }
    return redirect()->back()->with('error', 'Failed to download APK: ' . $response->json()['detail'] ?? 'Unknown error');
})->name('download.apk');

Route::get('/timezone', function () {
    return now()->toDateTimeString() . ' ' . config('app.timezone');
});
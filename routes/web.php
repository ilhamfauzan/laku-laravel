<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckOwnerRole;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\CheckAllRole;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/unauthorized', function () {
    return view('unauthorized');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', CheckAllRole::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/laundries', LaundryController::class);
    Route::get('/laundries', [LaundryController::class, 'index'])->name('laundries.index');
    Route::put('/laundries/{laundry}/finish', [LaundryController::class, 'finish'])->name('laundries.finish');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/paid', [TransactionController::class, 'markAsPaid'])->name('transactions.paid');
    Route::post('/transactions/{laundry}/markAsPaid', [TransactionController::class, 'markAsPaid'])->name('transactions.markAsPaid');
    Route::get('/transactions/{transaction}/printReceipt', [TransactionController::class, 'printReceipt'])->name('transactions.printReceipt');
});

Route::middleware(['auth', CheckOwnerRole::class])->group(function () {
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
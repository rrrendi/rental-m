<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        $totalCars = \App\Models\Car::count();
        $totalUsers = \App\Models\User::count();
        $totalTransactions = \App\Models\Transaction::count();
        return view('dashboard', compact('totalCars', 'totalUsers', 'totalTransactions'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::patch('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::patch('/transactions/{transaction}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::get('/mobil', [CarController::class, 'index'])->name('mobil.index');
    Route::get('/mobil/create', [CarController::class, 'create'])->name('mobil.create');
    Route::post('/mobil', [CarController::class, 'store'])->name('mobil.store');
    Route::get('/mobil/{car}/edit', [CarController::class, 'edit'])->name('mobil.edit');
    Route::put('/mobil/{car}', [CarController::class, 'update'])->name('mobil.update');
    Route::delete('/mobil/{car}', [CarController::class, 'destroy'])->name('mobil.destroy');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/laporan', function () {
        $reports = \App\Models\Transaction::with(['car', 'user'])->where('status', 'selesai')->latest()->get();
        $totalPendapatan = $reports->sum('total_harga');
        return view('reports.index', compact('reports', 'totalPendapatan'));
    })->name('laporan.index');
});

require __DIR__.'/auth.php';
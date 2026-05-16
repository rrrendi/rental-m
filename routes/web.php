<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FrontEndController;
use Illuminate\Support\Facades\Route;
use App\Models\Car;
use App\Models\User;
use App\Models\Transaction;

// Mengarah ke Landing Page
Route::get('/', [FrontEndController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        $totalCars = Car::count();
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        return view('dashboard', compact('totalCars', 'totalUsers', 'totalTransactions'));
    })->name('dashboard');

    Route::resource('cars', CarController::class);
    Route::resource('users', UserController::class)->except(['show']);

    Route::resource('transactions', TransactionController::class)->except(['create', 'show', 'edit', 'update']);
    Route::patch('transactions/{transaction}/complete', [TransactionController::class, 'complete'])->name('transactions.complete');
    
    Route::get('/reports', function () {
        $reports = Transaction::with(['car', 'user'])->where('status', 'selesai')->latest()->get();
        $totalPendapatan = $reports->sum('total_harga');
        return view('reports.index', compact('reports', 'totalPendapatan'));
    })->name('reports.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
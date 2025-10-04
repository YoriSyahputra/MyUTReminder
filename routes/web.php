<?php

use App\Http\Controllers\MataKuliahController; 
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- TAMBAHKAN SEMUA ROUTE INI ---
    Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('/matakuliah/create', [MataKuliahController::class, 'create'])->name('matakuliah.create');
    Route::post('/matakuliah', [MataKuliahController::class, 'store'])->name('matakuliah.store');
});


require __DIR__.'/auth.php';

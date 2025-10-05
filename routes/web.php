<?php

use App\Http\Controllers\MataKuliahController; 
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $allMataKuliahs = Auth::user()->mataKuliahs()->latest()->get();

    $uniqueMataKuliahs = $allMataKuliahs->unique('nama_matkul');

    $totalSks = $uniqueMataKuliahs->sum('sks');
    $totalUniqueMataKuliah = $uniqueMataKuliahs->count(); // Ganti nama variabel agar lebih jelas
    $tugasSelesai = $allMataKuliahs->where('status', 'Selesai')->count();
    $tugasBelumSelesai = $allMataKuliahs->where('status', 'Belum Selesai')->count();

    // 5. Kirim semua variabel ke view 'dashboard'
    return view('dashboard', [
        // Data untuk Box 1
        'totalMataKuliah' => $totalUniqueMataKuliah, // Kirim nama yang konsisten
        'totalSks' => $totalSks,
        'tugasSelesai' => $tugasSelesai,
        'tugasBelumSelesai' => $tugasBelumSelesai,
        // Data BARU untuk Box 2
        'allMataKuliahsForJs' => $allMataKuliahs,
        'uniqueMataKuliahsForFilter' => $uniqueMataKuliahs
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- TAMBAHKAN SEMUA ROUTE INI ---
    Route::get('/matakuliah', [MataKuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('/matakuliah/create', [MataKuliahController::class, 'create'])->name('matakuliah.create');
    Route::post('/matakuliah', [MataKuliahController::class, 'store'])->name('matakuliah.store');
    Route::patch('/matakuliah/{matakuliah}/status', [MataKuliahController::class, 'updateStatus'])->name('matakuliah.updateStatus');
});


require __DIR__.'/auth.php';

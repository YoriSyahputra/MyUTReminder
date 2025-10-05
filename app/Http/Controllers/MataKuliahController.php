<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataKuliahController extends Controller
{
    /**
     * Menampilkan halaman DAFTAR mata kuliah.
     * Mengirimkan variabel $mataKuliahs ke view 'index'.
     */
    public function index()
    {
        $mataKuliahs = Auth::user()->mataKuliahs()->latest()->get();
        return view('matakuliah.index', compact('mataKuliahs'));
    }

    /**
     * Menampilkan halaman FORM tambah mata kuliah.
     * Mengirimkan variabel $daftarMatkul ke view 'create'.
     */
    public function create()
    {
        $daftarMatkul = [
            ['nama' => 'Pendidikan Agama Islam', 'sks' => 3],
            ['nama' => 'Pendidikan Kewarganegaraan', 'sks' => 2],
            ['nama' => 'Matematika Dasar', 'sks' => 3],
            ['nama' => 'Sistem Operasi', 'sks' => 3],
            ['nama' => 'Pengantar Sistem Informasi', 'sks' => 3],
            ['nama' => 'Algoritma Dan Pemograman', 'sks' => 3],
        ];
        // Mengarahkan ke view 'create.blade.php'
        return view('matakuliah.create', ['daftarMatkul' => $daftarMatkul]);
    }

    /**
     * Menyimpan data dari form ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_matkul' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
            'jadwal' => 'required|date',
            'tugas' => 'required|string',
        ]);
        
        $validatedData['status'] = 'Belum Selesai';

        Auth::user()->mataKuliahs()->create($request->all());

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan!');
    }
}


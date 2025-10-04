<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Casts\Encrypted;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // Enkripsi hanya boleh pada data yang tidak dipakai untuk pencarian
        'name' => Encrypted::class,

        // --- PERBAIKAN UTAMA ADA DI SINI ---
        // Enkripsi pada 'email' dan 'nim' harus dihapus agar bisa login.
        // 'email' => Encrypted::class,
        // 'nim' => Encrypted::class,
    ];

  public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class);
    }
}


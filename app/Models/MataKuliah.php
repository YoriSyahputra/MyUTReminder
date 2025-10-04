<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_matkul',
        'sks',
        'jadwal',
        'tugas',
        'status',
    ];
}

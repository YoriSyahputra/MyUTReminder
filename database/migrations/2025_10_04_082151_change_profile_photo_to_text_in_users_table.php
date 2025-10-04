<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengubah kolom profile_photo menjadi tipe TEXT
            $table->text('profile_photo')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengembalikan ke tipe VARCHAR jika migrasi di-rollback
            $table->string('profile_photo')->nullable()->change();
        });
    }
};
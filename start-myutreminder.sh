#!/bin/bash
# Load nvm agar node & npm dikenali
export NVM_DIR="$HOME/.nvm"
source "$NVM_DIR/nvm.sh"

# Masuk ke folder project Laravel
cd /home/ysw/laravel/UTReminder

# Jalankan server Laravel di background
nohup php artisan serve > /dev/null 2>&1 &

# Tunggu sebentar biar environment siap
sleep 5

# Jalankan Vite (npm run dev) di background
nohup npm run dev > /dev/null 2>&1 &

# Buka browser otomatis, sembunyikan pesan GTK
GTK_MODULES= xdg-open http://127.0.0.1:8000 > /dev/null 2>&1


# Absensi Backend - Fleetify Challenge

## 📋 Deskripsi
Sistem absensi untuk perusahaan dengan lebih dari 50 karyawan dan multi-departemen, dibuat menggunakan Laravel (Backend) dan MySQL.

## 🚀 Fitur
- CRUD Karyawan
- CRUD Departemen
- Absen Masuk (Clock In)
- Absen Keluar (Clock Out)
- Log Absensi (dengan ketepatan waktu)
- Filter by Tanggal & Departemen

## ⚙️ Teknologi
- Laravel 10
- MySQL
- Bootstrap (jika frontend pakai Blade)
- RESTful API

## 🔧 Instalasi

```bash
git clone https://github.com/namamu/absensi-backend-namamu.git
cd absensi-backend-namamu
composer install
cp .env.example .env
php artisan key:generate
# Buat database lalu atur DB di .env
php artisan migrate --seed
php artisan serve

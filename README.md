<div align="center">

# 🍽️ Smart Inventory — Remaja Kuring BSD

### Sistem Pendukung Keputusan Pengadaan Bahan Baku  
### Menggunakan Metode **Simple Additive Weighting (SAW)**

---

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

</div>

---

## 📖 Tentang Proyek

**Smart Inventory Remaja Kuring BSD** adalah aplikasi web berbasis Laravel yang dirancang untuk membantu manajemen restoran dalam menentukan **prioritas pengadaan bahan baku** secara cerdas menggunakan metode **Simple Additive Weighting (SAW)**.

Proyek ini dikembangkan sebagai **Tugas Akhir / Skripsi** dengan studi kasus di Restoran Remaja Kuring, BSD City.

### 🎯 Masalah yang Diselesaikan
- ❌ Pembelian bahan yang tidak terstruktur (hanya mengandalkan intuisi)  
- ❌ Bahan baku sering busuk sebelum digunakan (pemborosan)  
- ❌ Tidak ada sistem peringatan ketika stok mendekati habis  
- ✅ **Solusi:** Ranking prioritas berbasis 3 kriteria ilmiah (C1, C2, C3)

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
|---|---|
| 📊 **Dashboard** | Ringkasan stok kritis dan statistik bahan baku |
| 🏆 **Ranking SAW** | Peringkat prioritas pengadaan berdasarkan skor SAW |
| ⚠️ **Peringatan Stok** | Notifikasi bahan yang mendekati atau sudah habis |
| 📦 **Manajemen Bahan Baku** | CRUD lengkap data bahan baku + nilai kriteria |
| 🔐 **Multi-Role Login** | Akses berbeda untuk Manajer, Koki, dan Staff |

---

## 🧮 Metode SAW — Kriteria Penilaian

Sistem menggunakan **3 kriteria** dengan bobot yang telah ditentukan berdasarkan hasil wawancara:

| Kode | Kriteria | Sifat | Bobot |
|---|---|---|---|
| **C1** | Batas Minimum Sisa Stok | COST (rasio stok/batas minimum) | **40%** |
| **C2** | Tingkat Kadaluarsa / Pembusukan | BENEFIT (skala 1–5) | **30%** |
| **C3** | Tingkat Kebutuhan Harian | BENEFIT (skala 1–5) | **30%** |

### Skala Penilaian C2 (Tingkat Kadaluarsa)
| Skor | Kategori | Contoh Bahan |
|---|---|---|
| 5 | Sangat Rentan | Sayur daun (Kangkung, Selada, Kemangi) |
| 4 | Rentan | Protein segar (Ikan, Daging, Udang) |
| 3 | Sedang | Sayur keras/umbi (Wortel, Kentang, Labu) |
| 2 | Awet | Freezer / Bumbu saset basah |
| 1 | Sangat Awet | Sembako kering & botolan |

### Skala Penilaian C3 (Kebutuhan Harian)
| Skor | Kategori | Contoh Bahan |
|---|---|---|
| 5 | Sangat Tinggi | "Nyawa" restoran (Gurame, Beras, Kangkung, Ayam) |
| 4 | Tinggi | Bahan pelengkap tiap masakan (Minyak, Bawang, Cabai) |
| 3 | Sedang | Menu sekunder / minuman (Sirup, Cumi) |
| 2 | Rendah | Bumbu tambahan sesekali |
| 1 | Sangat Rendah | Bumbu kering pelengkap (Lada, Ketumbar, Cengkeh) |

---

## 🛠️ Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Database:** MySQL 8.0
- **Frontend:** Blade Template + CSS Vanilla
- **Server Lokal:** Laragon
- **Version Control:** Git + GitHub

---

## 🚀 Cara Instalasi

### Prasyarat
Pastikan sudah terinstall:
- [Laragon Full](https://laragon.org/download/) *(include PHP, MySQL, Apache)*
- [Composer](https://getcomposer.org/download/)
- [Git](https://git-scm.com/downloads)

### Langkah-Langkah

**1. Clone Repository**
```bash
cd C:\laragon\www
git clone https://github.com/Shafwanarkaa/smart-inventoryRK.git Remaja_Kuring
cd Remaja_Kuring
```

**2. Install Dependencies**
```bash
composer install
```

**3. Setup Environment**
```bash
copy .env.example .env
php artisan key:generate
```

**4. Konfigurasi Database**  
Edit file `.env`, sesuaikan bagian berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_remaja_kuring
DB_USERNAME=root
DB_PASSWORD=
```

**5. Buat Database**  
Buka `http://localhost/phpmyadmin` → Buat database baru bernama `spk_remaja_kuring`

**6. Migrasi & Seeding Data**
```bash
php artisan migrate:fresh --seed
```

**7. Jalankan Aplikasi**
```bash
php artisan serve
```

Buka browser: **http://127.0.0.1:8000** 🎉

---

## 🔑 Akun Default

| Role | Username | Password | Akses |
|---|---|---|---|
| 👑 **Manajer** | `manajer` | `manajer123` | Full akses (Dashboard, SAW, Laporan) |
| 👨‍🍳 **Koki** | `koki` | `koki123` | Lihat stok & peringatan |
| 📋 **Staff** | `staff` | `staff123` | Input & update bahan baku |

---

## 📁 Struktur Proyek

```
Remaja_Kuring/
├── app/
│   ├── Http/Controllers/
│   │   ├── SpkController.php       # Logika SAW & perhitungan ranking
│   │   ├── BahanBakuController.php # CRUD Bahan Baku
│   │   └── AuthController.php      # Login & Logout
│   └── Models/
│       ├── BahanBaku.php
│       ├── Kategori.php
│       └── Supplier.php
├── database/
│   ├── migrations/                 # Skema tabel
│   └── seeders/
│       └── DatabaseSeeder.php      # Data awal 98 bahan baku
├── resources/views/
│   └── manajer/
│       ├── dashboard.blade.php
│       ├── ranking-saw.blade.php
│       ├── peringatan-stok.blade.php
│       └── bahan-baku/
└── routes/web.php
```

---

## 🔄 Cara Update (Untuk Anggota Tim)

Jika ada update baru dari repository:
```bash
git pull origin main
composer install
php artisan migrate:fresh --seed
```

> ⚠️ **Perhatian:** `migrate:fresh --seed` akan **mereset semua data**. Jangan jalankan jika ada data penting!

---

## ❓ Troubleshooting

| Error | Penyebab | Solusi |
|---|---|---|
| `No connection... port 3306` | MySQL belum jalan | Buka Laragon → **Start All** |
| `Class not found` | Belum install dependencies | Jalankan `composer install` |
| `Unknown database` | Database belum dibuat | Buat `spk_remaja_kuring` di phpMyAdmin |
| `APP_KEY is missing` | Belum generate key | Jalankan `php artisan key:generate` |
| `php not recognized` | PHP tidak di PATH | Gunakan terminal bawaan Laragon |

---

## 📊 Alur Kerja Sistem

```
Pengecekan Stok Dapur
        ↓
  Laporan ke Bagian PO
        ↓
  Input ke Sistem SPK
        ↓
  Hitung Ranking SAW
        ↓
Prioritas Pembelian Otomatis
        ↓
  Purchase Order ke Supplier
```

*(Berdasarkan hasil wawancara dengan pihak dapur Restoran Remaja Kuring BSD)*

---

## 👥 Tim Pengembang

> Proyek Tugas Akhir — Program Studi Sistem Informasi

Dikembangkan dengan ❤️ untuk **Restoran Remaja Kuring BSD**

---

<div align="center">

**⭐ Jika proyek ini membantu, jangan lupa beri bintang di GitHub! ⭐**

[![GitHub](https://img.shields.io/badge/GitHub-Shafwanarkaa/smart--inventoryRK-181717?style=for-the-badge&logo=github)](https://github.com/Shafwanarkaa/smart-inventoryRK)

</div>

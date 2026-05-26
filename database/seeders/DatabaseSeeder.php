<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\BahanBaku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SEEDER USERS
        $users = [
            ['username' => 'manajer', 'password' => Hash::make('manajer123'), 'role' => 'manajer'],
            ['username' => 'koki', 'password' => Hash::make('koki123'), 'role' => 'koki'],
            ['username' => 'staff', 'password' => Hash::make('staff123'), 'role' => 'staff'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // 2. SEEDER KATEGORI
        $kategoris = [
            ['nama_kategori' => 'Sayur-sayuran'],
            ['nama_kategori' => 'Buah-buahan'],
            ['nama_kategori' => 'Bumbu Dapur'],
            ['nama_kategori' => 'Daging & Seafood'],
            ['nama_kategori' => 'Bahan Kering'],
            ['nama_kategori' => 'Bahan Cair'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // 3. SEEDER SUPPLIER
        $suppliers = [
            ['nama_supplier' => 'CV. Sumber Rezeki', 'kontak' => 'Budi Santoso', 'no_telp' => '0813-1234-5678'],
            ['nama_supplier' => 'UD. Berkah Jaya', 'kontak' => 'Rina Marlina', 'no_telp' => '0822-9876-5432'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

       // 4. SEEDER BAHAN BAKU (DIPERBAIKI SESUAI WAWANCARA & LOGIKA)
$bahanBakus = [
    // ==========================================
    // 1. SAYUR-SAYURAN (Kategori ID: 1)
    // C1: 2 kg atau 3 ikat (dari wawancara: "sayur dibawah 2 kilo")
    // C2: 5 (daun), 3-4 (umbi/batang)
    // C3: 5 (menu utama), 3-4 (pelengkap), 1-2 (jarang)
    // ==========================================
    
    // SAYURAN DAUN (Sangat Mudah Basi - C2=5)
    ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Sayur Kangkung', 'satuan' => 'Ikat', 'stok_saat_ini' => 2, 'nilai_c1' => 3, 'nilai_c2' => 5, 'nilai_c3' => 5], // Menu utama (dari wawancara)
    ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Selada', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 2, 'nilai_c2' => 5, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Sawi Putih', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 2, 'nilai_c2' => 5, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Caisin', 'satuan' => 'Ikat', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 5, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Kemangi', 'satuan' => 'Ikat', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 5, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Daun Pisang', 'satuan' => 'Ikat', 'stok_saat_ini' => 0, 'nilai_c1' => 3, 'nilai_c2' => 5, 'nilai_c3' => 3],
    ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Daun Bawang', 'satuan' => 'Kg', 'stok_saat_ini' => 7, 'nilai_c1' => 2, 'nilai_c2' => 5, 'nilai_c3' => 4],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Seledri', 'satuan' => 'Ikat', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 5, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Daun Melinjo', 'satuan' => 'Ikat', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 5, 'nilai_c3' => 2],
    
    // SAYURAN BERAIR (Mudah Basi - C2=4)
    ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Tomat', 'satuan' => 'Kg', 'stok_saat_ini' => 7, 'nilai_c1' => 2, 'nilai_c2' => 4, 'nilai_c3' => 4],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Timun', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 2, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Tauge', 'satuan' => 'Kg', 'stok_saat_ini' => 7, 'nilai_c1' => 2, 'nilai_c2' => 5, 'nilai_c3' => 3],
    
    // SAYURAN KERAS/UMBI (Sedang - C2=3)
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Kol', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Wortel', 'satuan' => 'Kg', 'stok_saat_ini' => 2, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kentang', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 4],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Terong Sayur', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Terong Lalap', 'satuan' => 'Kg', 'stok_saat_ini' => 7, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kacang Panjang', 'satuan' => 'Ikat', 'stok_saat_ini' => 1, 'nilai_c1' => 3, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Brokoly (Brokoli)', 'satuan' => 'Kg', 'stok_saat_ini' => 1, 'nilai_c1' => 2, 'nilai_c2' => 4, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kembang Kol', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 2, 'nilai_c2' => 4, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Jagung Muda', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Jagung Manis', 'satuan' => 'Pcs', 'stok_saat_ini' => 6, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Bunga Pepaya', 'satuan' => 'Kg', 'stok_saat_ini' => 2, 'nilai_c1' => 2, 'nilai_c2' => 4, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Labu Parang', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Buah Melinjo', 'satuan' => 'Kg', 'stok_saat_ini' => 1, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Labu Siam', 'satuan' => 'Kg', 'stok_saat_ini' => 5, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],

    // ==========================================
    // 2. BUAH-BUAHAN (Kategori ID: 2)
    // C1: 2 kg atau 5 pcs
    // C2: 3-4 (mudah basi tapi tidak se-ekstrem sayuran daun)
    // C3: 3 (pelengkap menu)
    // ==========================================
    // ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Buah Pepaya', 'satuan' => 'Pcs', 'stok_saat_ini' => 7, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Mangga', 'satuan' => 'Kg', 'stok_saat_ini' => 2, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Melon', 'satuan' => 'Pcs', 'stok_saat_ini' => 5, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Nanas', 'satuan' => 'Pcs', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Semangka', 'satuan' => 'Pcs', 'stok_saat_ini' => 0, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Jeruk Peras', 'satuan' => 'Kg', 'stok_saat_ini' => 5, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 4],
    // ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Jeruk Nipis', 'satuan' => 'Kg', 'stok_saat_ini' => 1, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 4],
    // ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Jeruk Lemon Cui', 'satuan' => 'Kg', 'stok_saat_ini' => 1, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Alpukat', 'satuan' => 'Kg', 'stok_saat_ini' => 2, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Strawbery', 'satuan' => 'Pack', 'stok_saat_ini' => 5, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 2],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Sirsak', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Nangka', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Kelapa Muda', 'satuan' => 'Buah', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 3],
    // ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Pisang', 'satuan' => 'Sisir', 'stok_saat_ini' => 3, 'nilai_c1' => 5, 'nilai_c2' => 3, 'nilai_c3' => 3],

    // ==========================================
    // 3. BUMBU DAPUR (Kategori ID: 3)
    // C1: 2 kg (basah), 500 gram (kering), 3 botol (kemasan)
    // C2: 2 (basah), 1 (kering/botolan - sangat awet)
    // C3: 1-2 (kebutuhan rendah, bumbu pelengkap)
    // ==========================================
    
    // BUMBU BASAH
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Buah Asem', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 2, 'nilai_c2' => 2, 'nilai_c3' => 2],
    // ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Sereh', 'satuan' => 'Ikat', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 3],
    // ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Jahe', 'satuan' => 'Kg', 'stok_saat_ini' => 5, 'nilai_c1' => 2, 'nilai_c2' => 2, 'nilai_c3' => 3],
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Lengkuas', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 2, 'nilai_c2' => 2, 'nilai_c3' => 3],
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Kunyit', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 2, 'nilai_c2' => 2, 'nilai_c3' => 2],
    
    // BUMBU KERING (Sangat Awet - C2=1)
    ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Ketumbar', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Jinten', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Kayu Manis', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Pala', 'satuan' => 'Kg', 'stok_saat_ini' => 7, 'nilai_c1' => 10, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Cengkeh', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Asem Jawa', 'satuan' => 'Bungkus', 'stok_saat_ini' => 3, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Masako', 'satuan' => 'Bungkus', 'stok_saat_ini' => 1, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 3],
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Sasa', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Lada Hitam', 'satuan' => 'Botol', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 3],

    // ==========================================
    // 4. DAGING & SEAFOOD (Kategori ID: 4)
    // C1: 5 kg (dari wawancara: "daging dibawah 5 kilo")
    // C2: 4 (Rentan - perlu freezer)
    // C3: 5 (menu utama), 3-4 (pelengkap)
    // ==========================================
    
    // MENU UTAMA (C3=5)
    ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Gurame', 'satuan' => 'Kg', 'stok_saat_ini' => 15, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 5], // Menu utama (dari wawancara)
    // ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Daging Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 10, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 5],
    ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Daging Ayam', 'satuan' => 'Kg', 'stok_saat_ini' => 2, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 5], // Menu utama (dari wawancara)
    
    // PELENGKAP (C3=3-4)
    // ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Kue (Cue)', 'satuan' => 'Kg', 'stok_saat_ini' => 5, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 4],
    // ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Bandeng', 'satuan' => 'Kg', 'stok_saat_ini' => 3, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 4],
    // ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Rahang Tuna', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Tude (Kembung)', 'satuan' => 'Kg', 'stok_saat_ini' => 7, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Roa', 'satuan' => 'Kg', 'stok_saat_ini' => 5, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Asin Jambal', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 2, 'nilai_c3' => 2], // Ikan asin lebih awet
    // ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Cumi', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Udang', 'satuan' => 'Kg', 'stok_saat_ini' => 0, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 4],
    // ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Bunyut Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 3],
    // ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Iga Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 4],
    // ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Kepala Ikan Kakap', 'satuan' => 'Pcs', 'stok_saat_ini' => 1, 'nilai_c1' => 5, 'nilai_c2' => 4, 'nilai_c3' => 3],

    // ==========================================
    // 5. BAHAN KERING (Kategori ID: 5)
    // C1: 10 kg (bahan pokok besar), 5 kg (bahan kering lain)
    // C2: 1 (sangat awet), 2 (tahu/tempe agak rentan)
    // C3: 5 (menu utama seperti beras), 1-2 (pelengkap)
    // ==========================================
    // ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Sagu', 'satuan' => 'Kg', 'stok_saat_ini' => 0, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Gula', 'satuan' => 'Kg', 'stok_saat_ini' => 0, 'nilai_c1' => 10, 'nilai_c2' => 1, 'nilai_c3' => 4],
    ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Beras', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 10, 'nilai_c2' => 1, 'nilai_c3' => 5], // Menu utama (dari wawancara)
    // ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Tepung Beras', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 3],
    // ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Baking Powder', 'satuan' => 'Pcs', 'stok_saat_ini' => 5, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Custard', 'satuan' => 'Pcs', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 1],
    ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Tahu', 'satuan' => 'Pcs', 'stok_saat_ini' => 4, 'nilai_c1' => 10, 'nilai_c2' => 3, 'nilai_c3' => 4], // Agak rentan
    // ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Tempe', 'satuan' => 'Papan', 'stok_saat_ini' => 7, 'nilai_c1' => 10, 'nilai_c2' => 3, 'nilai_c3' => 4], // Agak rentan
    // ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Kacang Tanah', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Kacang Merah', 'satuan' => 'Kg', 'stok_saat_ini' => 0, 'nilai_c1' => 5, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Ubi Manis', 'satuan' => 'Kg', 'stok_saat_ini' => 4, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Singkong', 'satuan' => 'Kg', 'stok_saat_ini' => 5, 'nilai_c1' => 2, 'nilai_c2' => 3, 'nilai_c3' => 2],
    // ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Garam', 'satuan' => 'Kg', 'stok_saat_ini' => 14, 'nilai_c1' => 10, 'nilai_c2' => 1, 'nilai_c3' => 4],

    // ==========================================
    // 6. BAHAN CAIR (Kategori ID: 6)
    // C1: 3 botol (dari wawancara: "bumbu botolan")
    // C2: 2 (kecap/saus basah), 1 (botol tertutup awet)
    // C3: 2-4 (bumbu pelengkap sering dipakai)
    // ==========================================
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Kecap Inggris', 'satuan' => 'Botol', 'stok_saat_ini' => 2, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Hitam', 'satuan' => 'Botol', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 3],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Minyak Wijen', 'satuan' => 'Botol', 'stok_saat_ini' => 1, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Anci', 'satuan' => 'Botol', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 1],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Asin', 'satuan' => 'Botol', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 3],
    ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Manis', 'satuan' => 'Botol', 'stok_saat_ini' => 1, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 4],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Sambal ABC', 'satuan' => 'Botol', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 3],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Sambal Delmonte', 'satuan' => 'Botol', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Sambal Belibis', 'satuan' => 'Botol', 'stok_saat_ini' => 1, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Saus Tomat ABC', 'satuan' => 'Botol', 'stok_saat_ini' => 1, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 4],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Matahari', 'satuan' => 'Botol', 'stok_saat_ini' => 0, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Saus Tiram', 'satuan' => 'Botol', 'stok_saat_ini' => 0, 'nilai_c1' => 3, 'nilai_c2' => 2, 'nilai_c3' => 3],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Cuka', 'satuan' => 'Botol', 'stok_saat_ini' => 2, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Sirup ABC Orange', 'satuan' => 'Botol', 'stok_saat_ini' => 2, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 3],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Sirup ABC Leci', 'satuan' => 'Botol', 'stok_saat_ini' => 3, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 3],
    // ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Marjan Vanila', 'satuan' => 'Botol', 'stok_saat_ini' => 4, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 2],
    // ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Marjan Cocopandan', 'satuan' => 'Botol', 'stok_saat_ini' => 1, 'nilai_c1' => 3, 'nilai_c2' => 1, 'nilai_c3' => 2],
];

        foreach ($bahanBakus as $bahan) {
            BahanBaku::create($bahan);
        }

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📊 Created: 3 Users, 6 Kategori, 2 Suppliers, 98 Bahan Baku');
        $this->command->table(
            ['Role', 'Username', 'Password'],
            [
                ['Manajer', 'manajer', 'manajer123'],
                ['Koki', 'koki', 'koki123'],
                ['Staff', 'staff', 'staff123'],
            ]
        );
    }
}
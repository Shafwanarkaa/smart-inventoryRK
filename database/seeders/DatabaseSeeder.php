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

        // 4. SEEDER BAHAN BAKU (98 DATA LENGKAP - RAPI SESUAI KATEGORI)
        $bahanBakus = [
            // ==========================================
            // 1. Sayur-sayuran (Kategori ID: 1)
            // ==========================================
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Tauge', 'satuan' => 'Kg', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 3, 'nilai_c3' => 40],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Sayur Kangkung', 'satuan' => 'Ikat', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 2, 'nilai_c3' => 50],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Selada', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 2, 'nilai_c3' => 35],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Kol', 'satuan' => 'Kg', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 4, 'nilai_c3' => 40],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kacang Panjang', 'satuan' => 'Ikat', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 3, 'nilai_c3' => 35],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Terong Sayur', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 3, 'nilai_c3' => 28],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Terong Lalap', 'satuan' => 'Kg', 'stok_saat_ini' => 16, 'nilai_c1' => 16, 'nilai_c2' => 3, 'nilai_c3' => 25],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Brokoly (Brokoli)', 'satuan' => 'Kg', 'stok_saat_ini' => 14, 'nilai_c1' => 14, 'nilai_c2' => 3, 'nilai_c3' => 22],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kembang Kol', 'satuan' => 'Kg', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 3, 'nilai_c3' => 23],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Caisin', 'satuan' => 'Ikat', 'stok_saat_ini' => 19, 'nilai_c1' => 19, 'nilai_c2' => 2, 'nilai_c3' => 32],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Sawi Putih', 'satuan' => 'Kg', 'stok_saat_ini' => 21, 'nilai_c1' => 21, 'nilai_c2' => 3, 'nilai_c3' => 34],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Wortel', 'satuan' => 'Kg', 'stok_saat_ini' => 28, 'nilai_c1' => 28, 'nilai_c2' => 5, 'nilai_c3' => 38],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kentang', 'satuan' => 'Kg', 'stok_saat_ini' => 45, 'nilai_c1' => 45, 'nilai_c2' => 6, 'nilai_c3' => 60],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Jagung Muda', 'satuan' => 'Kg', 'stok_saat_ini' => 24, 'nilai_c1' => 24, 'nilai_c2' => 3, 'nilai_c3' => 36],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Jagung Manis', 'satuan' => 'Pcs', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 4, 'nilai_c3' => 42],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Bunga Pepaya', 'satuan' => 'Kg', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 2, 'nilai_c3' => 18],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Labu Parang', 'satuan' => 'Kg', 'stok_saat_ini' => 26, 'nilai_c1' => 26, 'nilai_c2' => 5, 'nilai_c3' => 35],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Daun Melinjo', 'satuan' => 'Ikat', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 28],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Buah Melinjo', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 4, 'nilai_c3' => 30],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Timun', 'satuan' => 'Kg', 'stok_saat_ini' => 32, 'nilai_c1' => 32, 'nilai_c2' => 3, 'nilai_c3' => 45],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Tomat', 'satuan' => 'Kg', 'stok_saat_ini' => 35, 'nilai_c1' => 35, 'nilai_c2' => 3, 'nilai_c3' => 48],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Labu Siam', 'satuan' => 'Kg', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 4, 'nilai_c3' => 32],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kemangi', 'satuan' => 'Ikat', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 2, 'nilai_c3' => 24],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Daun Pisang', 'satuan' => 'Ikat', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 3, 'nilai_c3' => 35],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Daun Bawang', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 2, 'nilai_c3' => 32],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Seledri', 'satuan' => 'Ikat', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 28],

            // ==========================================
            // 2. Buah-buahan (Kategori ID: 2)
            // ==========================================
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Buah Pepaya', 'satuan' => 'Pcs', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 3, 'nilai_c3' => 15],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Mangga', 'satuan' => 'Kg', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 3, 'nilai_c3' => 18],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Melon', 'satuan' => 'Pcs', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 3, 'nilai_c3' => 12],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Nanas', 'satuan' => 'Pcs', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 4, 'nilai_c3' => 14],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Semangka', 'satuan' => 'Pcs', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 3, 'nilai_c3' => 10],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Jeruk Peras', 'satuan' => 'Kg', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 3, 'nilai_c3' => 20],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Jeruk Nipis', 'satuan' => 'Kg', 'stok_saat_ini' => 16, 'nilai_c1' => 16, 'nilai_c2' => 4, 'nilai_c3' => 15],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Jeruk Lemon Cui', 'satuan' => 'Kg', 'stok_saat_ini' => 14, 'nilai_c1' => 14, 'nilai_c2' => 4, 'nilai_c3' => 12],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Alpukat', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 3, 'nilai_c3' => 14],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Strawbery', 'satuan' => 'Pack', 'stok_saat_ini' => 10, 'nilai_c1' => 10, 'nilai_c2' => 2, 'nilai_c3' => 8],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Sirsak', 'satuan' => 'Kg', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 3, 'nilai_c3' => 10],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Nangka', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 4, 'nilai_c3' => 15],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Kelapa Muda', 'satuan' => 'Buah', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 3, 'nilai_c3' => 25],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Pisang', 'satuan' => 'Sisir', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 3, 'nilai_c3' => 45],

            // ==========================================
            // 3. Bumbu Dapur (Kategori ID: 3)
            // ==========================================
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Buah Asem', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 7, 'nilai_c3' => 22],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Sereh', 'satuan' => 'Ikat', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 5, 'nilai_c3' => 28],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Jahe', 'satuan' => 'Kg', 'stok_saat_ini' => 24, 'nilai_c1' => 24, 'nilai_c2' => 8, 'nilai_c3' => 18],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Lengkuas', 'satuan' => 'Kg', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 8, 'nilai_c3' => 16],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Kunyit', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 8, 'nilai_c3' => 14],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Ketumbar', 'satuan' => 'Gram', 'stok_saat_ini' => 500, 'nilai_c1' => 500, 'nilai_c2' => 9, 'nilai_c3' => 200],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Jinten', 'satuan' => 'Gram', 'stok_saat_ini' => 400, 'nilai_c1' => 400, 'nilai_c2' => 9, 'nilai_c3' => 150],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Kayu Manis', 'satuan' => 'Gram', 'stok_saat_ini' => 300, 'nilai_c1' => 300, 'nilai_c2' => 9, 'nilai_c3' => 100],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Pala', 'satuan' => 'Biji', 'stok_saat_ini' => 50, 'nilai_c1' => 50, 'nilai_c2' => 9, 'nilai_c3' => 20],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Cengkeh', 'satuan' => 'Gram', 'stok_saat_ini' => 250, 'nilai_c1' => 250, 'nilai_c2' => 9, 'nilai_c3' => 80],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Asem Jawa', 'satuan' => 'Bungkus', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 7, 'nilai_c3' => 15],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Masako', 'satuan' => 'Bungkus', 'stok_saat_ini' => 40, 'nilai_c1' => 40, 'nilai_c2' => 9, 'nilai_c3' => 50],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Sasa', 'satuan' => 'Kg', 'stok_saat_ini' => 35, 'nilai_c1' => 35, 'nilai_c2' => 9, 'nilai_c3' => 40],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Lada Hitam', 'satuan' => 'Botol', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 9, 'nilai_c3' => 15],

            // ==========================================
            // 4. Daging & Seafood (Kategori ID: 4)
            // ==========================================
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Gurame', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 2, 'nilai_c3' => 35],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Kue (Cue)', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 30],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Bandeng', 'satuan' => 'Kg', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 2, 'nilai_c3' => 32],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Rahang Tuna', 'satuan' => 'Kg', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 2, 'nilai_c3' => 25],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Tude (Kembung)', 'satuan' => 'Kg', 'stok_saat_ini' => 19, 'nilai_c1' => 19, 'nilai_c2' => 2, 'nilai_c3' => 28],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Roa', 'satuan' => 'Kg', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 2, 'nilai_c3' => 20],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Asin Jambal', 'satuan' => 'Kg', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 7, 'nilai_c3' => 18],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Cumi', 'satuan' => 'Kg', 'stok_saat_ini' => 16, 'nilai_c1' => 16, 'nilai_c2' => 2, 'nilai_c3' => 28],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Udang', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 30],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Daging Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 2, 'nilai_c3' => 40],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Daging Ayam', 'satuan' => 'Kg', 'stok_saat_ini' => 35, 'nilai_c1' => 35, 'nilai_c2' => 2, 'nilai_c3' => 55],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Bunyut Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 1, 'nilai_c3' => 20],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Iga Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 28],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Kepala Ikan Kakap', 'satuan' => 'Pcs', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 1, 'nilai_c3' => 22],

            // ==========================================
            // 5. Bahan Kering (Kategori ID: 5)
            // ==========================================
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Sagu', 'satuan' => 'Kg', 'stok_saat_ini' => 50, 'nilai_c1' => 50, 'nilai_c2' => 9, 'nilai_c3' => 20],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Gula', 'satuan' => 'Kg', 'stok_saat_ini' => 80, 'nilai_c1' => 80, 'nilai_c2' => 10, 'nilai_c3' => 50],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Beras', 'satuan' => 'Kg', 'stok_saat_ini' => 120, 'nilai_c1' => 120, 'nilai_c2' => 10, 'nilai_c3' => 200],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Tepung Beras', 'satuan' => 'Kg', 'stok_saat_ini' => 40, 'nilai_c1' => 40, 'nilai_c2' => 9, 'nilai_c3' => 30],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Baking Powder', 'satuan' => 'Pcs', 'stok_saat_ini' => 35, 'nilai_c1' => 35, 'nilai_c2' => 9, 'nilai_c3' => 15],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Custard', 'satuan' => 'Pcs', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 9, 'nilai_c3' => 12],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Tahu', 'satuan' => 'Pcs', 'stok_saat_ini' => 60, 'nilai_c1' => 60, 'nilai_c2' => 3, 'nilai_c3' => 80],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Tempe', 'satuan' => 'Papan', 'stok_saat_ini' => 55, 'nilai_c1' => 55, 'nilai_c2' => 3, 'nilai_c3' => 75],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Kacang Tanah', 'satuan' => 'Kg', 'stok_saat_ini' => 35, 'nilai_c1' => 35, 'nilai_c2' => 7, 'nilai_c3' => 45],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Kacang Merah', 'satuan' => 'Kg', 'stok_saat_ini' => 28, 'nilai_c1' => 28, 'nilai_c2' => 8, 'nilai_c3' => 22],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Ubi Manis', 'satuan' => 'Kg', 'stok_saat_ini' => 40, 'nilai_c1' => 40, 'nilai_c2' => 6, 'nilai_c3' => 35],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Singkong', 'satuan' => 'Kg', 'stok_saat_ini' => 55, 'nilai_c1' => 55, 'nilai_c2' => 5, 'nilai_c3' => 50],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Garam', 'satuan' => 'Kg', 'stok_saat_ini' => 60, 'nilai_c1' => 60, 'nilai_c2' => 10, 'nilai_c3' => 30],

            // ==========================================
            // 6. Bahan Cair (Kategori ID: 6)
            // ==========================================
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Inggris', 'satuan' => 'Botol', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 8, 'nilai_c3' => 15],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Kecap Hitam', 'satuan' => 'Botol', 'stok_saat_ini' => 28, 'nilai_c1' => 28, 'nilai_c2' => 8, 'nilai_c3' => 18],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Minyak Wijen', 'satuan' => 'Botol', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 8, 'nilai_c3' => 12],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Anci', 'satuan' => 'Botol', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 7, 'nilai_c3' => 10],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Asin', 'satuan' => 'Botol', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 8, 'nilai_c3' => 16],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Kecap Manis', 'satuan' => 'Botol', 'stok_saat_ini' => 32, 'nilai_c1' => 32, 'nilai_c2' => 8, 'nilai_c3' => 25],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Sambal ABC', 'satuan' => 'Botol', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 8, 'nilai_c3' => 14],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Sambal Delmonte', 'satuan' => 'Botol', 'stok_saat_ini' => 16, 'nilai_c1' => 16, 'nilai_c2' => 8, 'nilai_c3' => 12],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Sambal Belibis', 'satuan' => 'Botol', 'stok_saat_ini' => 14, 'nilai_c1' => 14, 'nilai_c2' => 8, 'nilai_c3' => 11],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Saus Tomat ABC', 'satuan' => 'Botol', 'stok_saat_ini' => 26, 'nilai_c1' => 26, 'nilai_c2' => 8, 'nilai_c3' => 20],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Matahari', 'satuan' => 'Botol', 'stok_saat_ini' => 24, 'nilai_c1' => 24, 'nilai_c2' => 8, 'nilai_c3' => 18],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Saus Tiram', 'satuan' => 'Botol', 'stok_saat_ini' => 28, 'nilai_c1' => 28, 'nilai_c2' => 8, 'nilai_c3' => 22],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Cuka', 'satuan' => 'Botol', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 8, 'nilai_c3' => 12],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Sirup ABC Orange', 'satuan' => 'Botol', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 8, 'nilai_c3' => 15],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Sirup ABC Leci', 'satuan' => 'Botol', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 8, 'nilai_c3' => 14],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Marjan Vanila', 'satuan' => 'Botol', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 8, 'nilai_c3' => 12],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Marjan Cocopandan', 'satuan' => 'Botol', 'stok_saat_ini' => 16, 'nilai_c1' => 16, 'nilai_c2' => 8, 'nilai_c3' => 11],
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
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
        // 1. SEEDER USERS - 3 Akun Default
        $users = [
            [
                'username' => 'manajer',
                'password' => Hash::make('manajer123'),
                'role' => 'manajer',
            ],
            [
                'username' => 'koki',
                'password' => Hash::make('koki123'),
                'role' => 'koki',
            ],
            [
                'username' => 'staff',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
            ],
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
            ['nama_kategori' => 'Bahan Kering (Tepung/Beras)'],
            ['nama_kategori' => 'Bahan Cair (Minyak/Susu)'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // 3. SEEDER SUPPLIER
        $suppliers = [
            [
                'nama_supplier' => 'CV. Sumber Rezeki',
                'kontak' => 'Budi Santoso',
                'no_telp' => '0813-1234-5678',
            ],
            [
                'nama_supplier' => 'UD. Berkah Jaya',
                'kontak' => 'Rina Marlina',
                'no_telp' => '0822-9876-5432',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // 4. SEEDER BAHAN BAKU (30 Data Awal - Nanti bisa ditambah hingga 98)
        $bahanBakus = [
            // Sayur-sayuran (Kategori ID: 1)
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Kangkung', 'satuan' => 'Ikat', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 8, 'nilai_c3' => 50],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Bayam', 'satuan' => 'Ikat', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 7, 'nilai_c3' => 30],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Sawi Hijau', 'satuan' => 'Kg', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 6, 'nilai_c3' => 25],
            ['kategori_id' => 1, 'supplier_id' => 2, 'nama_bahan' => 'Kol', 'satuan' => 'Kg', 'stok_saat_ini' => 8, 'nilai_c1' => 8, 'nilai_c2' => 5, 'nilai_c3' => 20],
            ['kategori_id' => 1, 'supplier_id' => 1, 'nama_bahan' => 'Terong', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 7, 'nilai_c3' => 35],

            // Buah-buahan (Kategori ID: 2)
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Tomat', 'satuan' => 'Kg', 'stok_saat_ini' => 30, 'nilai_c1' => 30, 'nilai_c2' => 6, 'nilai_c3' => 45],
            ['kategori_id' => 2, 'supplier_id' => 2, 'nama_bahan' => 'Jeruk Nipis', 'satuan' => 'Kg', 'stok_saat_ini' => 10, 'nilai_c1' => 10, 'nilai_c2' => 5, 'nilai_c3' => 15],
            ['kategori_id' => 2, 'supplier_id' => 1, 'nama_bahan' => 'Mangga', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 4, 'nilai_c3' => 25],

            // Bumbu Dapur (Kategori ID: 3)
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Bawang Merah', 'satuan' => 'Kg', 'stok_saat_ini' => 35, 'nilai_c1' => 35, 'nilai_c2' => 9, 'nilai_c3' => 60],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Bawang Putih', 'satuan' => 'Kg', 'stok_saat_ini' => 28, 'nilai_c1' => 28, 'nilai_c2' => 9, 'nilai_c3' => 55],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Cabai Merah', 'satuan' => 'Kg', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 8, 'nilai_c3' => 40],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Jahe', 'satuan' => 'Kg', 'stok_saat_ini' => 12, 'nilai_c1' => 12, 'nilai_c2' => 7, 'nilai_c3' => 20],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Lengkuas', 'satuan' => 'Kg', 'stok_saat_ini' => 9, 'nilai_c1' => 9, 'nilai_c2' => 6, 'nilai_c3' => 18],
            ['kategori_id' => 3, 'supplier_id' => 2, 'nama_bahan' => 'Kunyit', 'satuan' => 'Kg', 'stok_saat_ini' => 14, 'nilai_c1' => 14, 'nilai_c2' => 7, 'nilai_c3' => 22],
            ['kategori_id' => 3, 'supplier_id' => 1, 'nama_bahan' => 'Kemiri', 'satuan' => 'Kg', 'stok_saat_ini' => 6, 'nilai_c1' => 6, 'nilai_c2' => 5, 'nilai_c3' => 10],

            // Daging & Seafood (Kategori ID: 4)
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ayam Kampung', 'satuan' => 'Kg', 'stok_saat_ini' => 45, 'nilai_c1' => 45, 'nilai_c2' => 3, 'nilai_c3' => 70],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Ikan Gurame', 'satuan' => 'Kg', 'stok_saat_ini' => 20, 'nilai_c1' => 20, 'nilai_c2' => 2, 'nilai_c3' => 35],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Ikan Nila', 'satuan' => 'Kg', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 2, 'nilai_c3' => 40],
            ['kategori_id' => 4, 'supplier_id' => 2, 'nama_bahan' => 'Udang', 'satuan' => 'Kg', 'stok_saat_ini' => 15, 'nilai_c1' => 15, 'nilai_c2' => 1, 'nilai_c3' => 25],
            ['kategori_id' => 4, 'supplier_id' => 1, 'nama_bahan' => 'Daging Sapi', 'satuan' => 'Kg', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 30],

            // Bahan Kering (Kategori ID: 5)
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Beras Premium', 'satuan' => 'Kg', 'stok_saat_ini' => 120, 'nilai_c1' => 120, 'nilai_c2' => 10, 'nilai_c3' => 200],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Tepung Terigu', 'satuan' => 'Kg', 'stok_saat_ini' => 50, 'nilai_c1' => 50, 'nilai_c2' => 9, 'nilai_c3' => 80],
            ['kategori_id' => 5, 'supplier_id' => 1, 'nama_bahan' => 'Tepung Beras', 'satuan' => 'Kg', 'stok_saat_ini' => 25, 'nilai_c1' => 25, 'nilai_c2' => 8, 'nilai_c3' => 40],
            ['kategori_id' => 5, 'supplier_id' => 2, 'nama_bahan' => 'Gula Pasir', 'satuan' => 'Kg', 'stok_saat_ini' => 40, 'nilai_c1' => 40, 'nilai_c2' => 9, 'nilai_c3' => 65],

            // Bahan Cair (Kategori ID: 6)
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Minyak Goreng', 'satuan' => 'Liter', 'stok_saat_ini' => 60, 'nilai_c1' => 60, 'nilai_c2' => 8, 'nilai_c3' => 100],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Manis', 'satuan' => 'Botol', 'stok_saat_ini' => 32, 'nilai_c1' => 32, 'nilai_c2' => 7, 'nilai_c3' => 50],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Santan Kelapa', 'satuan' => 'Liter', 'stok_saat_ini' => 18, 'nilai_c1' => 18, 'nilai_c2' => 2, 'nilai_c3' => 30],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Susu Segar', 'satuan' => 'Liter', 'stok_saat_ini' => 22, 'nilai_c1' => 22, 'nilai_c2' => 1, 'nilai_c3' => 35],
            ['kategori_id' => 6, 'supplier_id' => 1, 'nama_bahan' => 'Saus Tomat', 'satuan' => 'Botol', 'stok_saat_ini' => 28, 'nilai_c1' => 28, 'nilai_c2' => 6, 'nilai_c3' => 45],
            ['kategori_id' => 6, 'supplier_id' => 2, 'nama_bahan' => 'Kecap Asin', 'satuan' => 'Botol', 'stok_saat_ini' => 24, 'nilai_c1' => 24, 'nilai_c2' => 7, 'nilai_c3' => 40],
        ];

        foreach ($bahanBakus as $bahan) {
            BahanBaku::create($bahan);
        }

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📊 Created: 3 Users, 6 Kategori, 2 Suppliers, 30 Bahan Baku');
        $this->command->info('🔐 Login Credentials:');
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

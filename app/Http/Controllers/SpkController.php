<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    // Bobot kriteria (BISA PAKAI APAPUN, misal 40-30-30 atau 80-10-10)
    const BOBOT = [
        'w1' => 0.40, // C1: Sisa Stok (COST)
        'w2' => 0.30, // C2: Tingkat Kadaluarsa (BENEFIT)
        'w3' => 0.30, // C3: Kebutuhan Harian (BENEFIT)
    ];

    /**
     * Dashboard - Tampilkan Top 30 Peringatan Stok (Kritis & Rendah)
     */
    public function dashboard()
    {
        $peringatanStok = BahanBaku::with(['kategori', 'supplier'])
            ->whereRaw('stok_saat_ini <= 50')
            ->orderBy('stok_saat_ini', 'asc')
            ->take(30)
            ->get();

        $totalBahan = BahanBaku::count();
        $jumlahPeringatan = BahanBaku::whereRaw('stok_saat_ini <= 50')->count();

        return view('manajer.dashboard', compact('peringatanStok', 'totalBahan', 'jumlahPeringatan'));
    }

    /**
     * Halaman Ranking SAW Lengkap (dengan pagination)
     */
    public function rankingSAW()
    {
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->orderBy('skor_saw', 'desc') // Sort by skor_saw (yang sudah pakai multiplier)
            ->paginate(20);

        return view('manajer.ranking-saw', compact('bahanBakus'));
    }

    /**
     * Halaman Peringatan Stok Lengkap (dengan pagination)
     */
    public function peringatanStok()
    {
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->whereRaw('stok_saat_ini <= 50')
            ->orderByRaw("CASE 
                WHEN stok_saat_ini <= 10 THEN 1
                WHEN stok_saat_ini <= 50 THEN 2
                ELSE 3
            END")
            ->orderBy('stok_saat_ini', 'asc')
            ->paginate(20);

        return view('manajer.peringatan-stok', compact('bahanBakus'));
    }

    /**
     * Hitung SAW dengan MULTIPLIER dan Update Skor ke Database
     */
    public function hitungSAW()
    {
        try {
            DB::beginTransaction();

            $bahanBakus = BahanBaku::all();

            if ($bahanBakus->isEmpty()) {
                return back()->with('error', 'Tidak ada data bahan baku untuk dihitung.');
            }

            // Cari nilai min dan max untuk normalisasi
            $minC1 = $bahanBakus->min('nilai_c1');
            $maxC2 = $bahanBakus->max('nilai_c2');
            $maxC3 = $bahanBakus->max('nilai_c3');

            if ($minC1 == 0 || $maxC2 == 0 || $maxC3 == 0) {
                DB::rollBack();
                return back()->with('error', 'Nilai C1, C2, atau C3 tidak valid (ada yang bernilai 0).');
            }

            // Proses normalisasi dan hitung skor SAW
            foreach ($bahanBakus as $bahan) {
                // Normalisasi
                $r1 = $minC1 / $bahan->nilai_c1; // COST
                $r2 = $bahan->nilai_c2 / $maxC2; // BENEFIT
                $r3 = $bahan->nilai_c3 / $maxC3; // BENEFIT

                // Hitung skor SAW ASLI (tanpa multiplier)
                $skorSAW = (self::BOBOT['w1'] * $r1) + 
                           (self::BOBOT['w2'] * $r2) + 
                           (self::BOBOT['w3'] * $r3);

                // ========================================
                // TAMBAHKAN MULTIPLIER BERDASARKAN STATUS
                // ========================================
                
                $skorFinal = $skorSAW; // Default
                
                if ($bahan->stok_saat_ini <= 10) {
                    // KRITIS: Dapat bonus +10 poin
                    $skorFinal = $skorSAW + 10.0;
                    
                } elseif ($bahan->stok_saat_ini <= 50) {
                    // RENDAH: Dapat bonus +5 poin
                    $skorFinal = $skorSAW + 5.0;
                    
                } else {
                    // AMAN: Tidak dapat bonus (+0)
                    $skorFinal = $skorSAW + 0.0;
                }

                // Update skor FINAL ke database
                $bahan->update([
                    'skor_saw' => round($skorFinal, 4)
                ]);
            }

            DB::commit();

            return back()->with('success', 'Perhitungan SAW berhasil! Ranking telah diperbarui dengan sistem multiplier (Kritis +10, Rendah +5, Aman +0).');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
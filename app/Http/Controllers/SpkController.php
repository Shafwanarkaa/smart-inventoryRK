<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    // Bobot kriteria SAW
    const BOBOT = [
        'w1' => 0.40, // C1: Sisa Stok / Threshold Minimum (COST)
        'w2' => 0.30, // C2: Tingkat Kadaluarsa, skala 1-5 (BENEFIT) — 5=sangat mudah basi
        'w3' => 0.30, // C3: Kebutuhan Harian, skala 1-5 (BENEFIT) — 5=kebutuhan sangat tinggi
    ];

    // Skala maksimum tetap untuk C2 dan C3 (skala 1-5)
    const MAX_SKALA = 5;

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

            // Cari nilai min C1 untuk normalisasi COST
            $minC1 = $bahanBakus->min('nilai_c1');

            if ($minC1 == 0) {
                DB::rollBack();
                return back()->with('error', 'Nilai C1 tidak valid (ada yang bernilai 0).');
            }

            // Validasi C2 dan C3 harus dalam skala 1-5
            $invalidC2 = $bahanBakus->filter(fn($b) => $b->nilai_c2 < 1 || $b->nilai_c2 > 5)->count();
            $invalidC3 = $bahanBakus->filter(fn($b) => $b->nilai_c3 < 1 || $b->nilai_c3 > 5)->count();
            if ($invalidC2 > 0 || $invalidC3 > 0) {
                DB::rollBack();
                return back()->with('error', 'Ada data C2 atau C3 yang di luar skala 1-5. Harap edit terlebih dahulu.');
            }

            // Proses normalisasi dan hitung skor SAW
            foreach ($bahanBakus as $bahan) {
                // Normalisasi SAW:
                // C1 = COST  → min/xi (semakin kecil stok vs threshold, makin prioritas)
                // C2 = BENEFIT skala 1-5 → xi/MAX_SKALA (semakin mudah basi = makin tinggi = makin prioritas)
                // C3 = BENEFIT skala 1-5 → xi/MAX_SKALA (semakin tinggi kebutuhan = makin prioritas)
                $r1 = $minC1 / $bahan->nilai_c1;                // COST (dynamic min)
                $r2 = $bahan->nilai_c2 / self::MAX_SKALA;       // BENEFIT (tetap /5)
                $r3 = $bahan->nilai_c3 / self::MAX_SKALA;       // BENEFIT (tetap /5)

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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    // Bobot kriteria SAW
    const BOBOT = [
        'w1' => 0.40, // C1: Sisa Stok (COST)
        'w2' => 0.30, // C2: Tingkat Kadaluarsa - skala 1-5 (BENEFIT)
        'w3' => 0.30, // C3: Kebutuhan Harian - skala 1-5 (BENEFIT)
    ];

    /**
     * Dashboard - Tampilkan Top 30 Peringatan Stok (Kritis & Rendah)
     */
    public function dashboard()
    {
        // Menampilkan bahan baku yang fisiknya Rendah atau Kritis (Stok <= Batas C1)
        $peringatanStok = BahanBaku::with(['kategori', 'supplier'])
            ->whereRaw('stok_saat_ini <= nilai_c1')
            ->orderByRaw('(stok_saat_ini / nilai_c1) ASC') // Urutkan dari rasio paling kritis
            ->take(30)
            ->get();

        $totalBahan = BahanBaku::count();
        $jumlahPeringatan = BahanBaku::whereRaw('stok_saat_ini <= nilai_c1')->count();

        return view('manajer.dashboard', compact('peringatanStok', 'totalBahan', 'jumlahPeringatan'));
    }

    /**
     * Halaman Ranking SAW Lengkap (dengan pagination)
     */
    public function rankingSAW()
    {
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->orderBy('skor_saw', 'desc') // Semua bahan diranking
            ->paginate(20);

        return view('manajer.ranking-saw', compact('bahanBakus'));
    }

    /**
     * Halaman Peringatan Stok Lengkap (dengan pagination)
     */
    public function peringatanStok()
    {
        // Halaman Peringatan Stok (Menampilkan semua bahan, diurutkan dari yang paling kritis)
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->orderByRaw('(stok_saat_ini / nilai_c1) ASC') // Urutkan dari rasio paling kritis
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

            // Hitung rasio stok (Stok Saat Ini / Batas Minimum)
            // Sifat: COST (makin kecil rasio = makin mendesak)
            $rasioStoks = [];
            foreach ($bahanBakus as $bahan) {
                // Hindari division by zero
                $batasMin = max(1, $bahan->nilai_c1);
                $stok = $bahan->stok_saat_ini;
                
                // Jika stok habis (0), set rasio jadi sangat kecil (misal 0.01) agar bisa di-COST-kan
                $rasio = ($stok <= 0) ? 0.01 : ($stok / $batasMin);
                $rasioStoks[$bahan->id] = $rasio;
            }

            // Nilai min rasio C1 untuk normalisasi COST
            $minRasioC1 = min($rasioStoks);

            // C2 dan C3 sekarang pakai skala 1-5 (fixed), max selalu = 5
            $maxC2 = 5;
            $maxC3 = 5;

            // Proses normalisasi dan hitung skor SAW
            foreach ($bahanBakus as $bahan) {
                // Normalisasi
                $r1 = $minRasioC1 / $rasioStoks[$bahan->id]; // COST
                $r2 = $bahan->nilai_c2 / $maxC2; // BENEFIT
                $r3 = $bahan->nilai_c3 / $maxC3; // BENEFIT

                // Hitung skor SAW
                $skorSAW = (self::BOBOT['w1'] * $r1) + 
                           (self::BOBOT['w2'] * $r2) + 
                           (self::BOBOT['w3'] * $r3);

                // Simpan skor SAW ke database
                $bahan->update([
                    'skor_saw' => round($skorSAW, 4)
                ]);
            }

            DB::commit();

            return back()->with('success', 'Perhitungan SAW berhasil! Ranking telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
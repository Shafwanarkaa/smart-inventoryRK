<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\DB;

class SpkController extends Controller
{
    // Bobot kriteria
    const BOBOT = [
        'w1' => 0.40, // C1: Sisa Stok (COST)
        'w2' => 0.30, // C2: Tingkat Kadaluarsa (BENEFIT)
        'w3' => 0.30, // C3: Batas Kebutuhan Harian (BENEFIT)
    ];

    /**
     * Tampilkan Dashboard dengan Ranking SAW
     */
    public function dashboard()
    {
        // Ambil semua bahan baku dengan relasi
        $bahanBakus = BahanBaku::with(['kategori', 'supplier'])
            ->orderBy('skor_saw', 'desc')
            ->get();

        // Hitung statistik
        $totalBahan = $bahanBakus->count();
        $peringatanStok = $bahanBakus->filter(function ($item) {
            return $item->stok_saat_ini <= 20;
        })->count();

        return view('manajer.dashboard', compact('bahanBakus', 'totalBahan', 'peringatanStok'));
    }

    /**
     * Hitung SAW dan Update Skor ke Database
     */
    public function hitungSAW()
    {
        try {
            DB::beginTransaction();

            // Ambil semua data bahan baku
            $bahanBakus = BahanBaku::all();

            if ($bahanBakus->isEmpty()) {
                return back()->with('error', 'Tidak ada data bahan baku untuk dihitung.');
            }

            // Cari nilai min dan max untuk normalisasi
            $minC1 = $bahanBakus->min('nilai_c1');
            $maxC2 = $bahanBakus->max('nilai_c2');
            $maxC3 = $bahanBakus->max('nilai_c3');

            // Validasi untuk menghindari division by zero
            if ($minC1 == 0 || $maxC2 == 0 || $maxC3 == 0) {
                DB::rollBack();
                return back()->with('error', 'Nilai C1, C2, atau C3 tidak valid (ada yang bernilai 0).');
            }

            // Proses normalisasi dan hitung skor SAW
            foreach ($bahanBakus as $bahan) {
                // Normalisasi
                // C1 adalah COST: semakin kecil semakin baik -> Min(C1) / C1
                $r1 = $minC1 / $bahan->nilai_c1;

                // C2 adalah BENEFIT: semakin besar semakin baik -> C2 / Max(C2)
                $r2 = $bahan->nilai_c2 / $maxC2;

                // C3 adalah BENEFIT: semakin besar semakin baik -> C3 / Max(C3)
                $r3 = $bahan->nilai_c3 / $maxC3;

                // Hitung skor SAW
                $skorSAW = (self::BOBOT['w1'] * $r1) +
                    (self::BOBOT['w2'] * $r2) +
                    (self::BOBOT['w3'] * $r3);

                // Update skor ke database
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

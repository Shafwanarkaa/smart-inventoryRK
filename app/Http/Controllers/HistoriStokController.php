<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriStok;
use App\Models\BahanBaku;
use App\Models\User;
use App\Exports\HistoriStokExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoriStokController extends Controller
{
    /**
     * Ambil data + terapkan filter (dipakai oleh index, export excel, export pdf)
     */
    private function buildQuery(Request $request)
    {
        $preset = $request->get('preset');
        $dari   = $request->get('dari');
        $sampai = $request->get('sampai');
        $tipe   = $request->get('tipe');

        if ($preset === 'hari_ini') {
            $dari = $sampai = now()->toDateString();
        } elseif ($preset === 'minggu_ini') {
            $dari   = now()->startOfWeek()->toDateString();
            $sampai = now()->endOfWeek()->toDateString();
        } elseif ($preset === 'bulan_ini') {
            $dari   = now()->startOfMonth()->toDateString();
            $sampai = now()->endOfMonth()->toDateString();
        }

        $query = HistoriStok::with(['bahanBaku', 'bahanBaku.kategori', 'user'])
            ->orderByDesc('created_at');

        if ($dari)   $query->whereDate('created_at', '>=', $dari);
        if ($sampai) $query->whereDate('created_at', '<=', $sampai);
        if ($tipe)   $query->where('tipe', $tipe);

        return compact('query', 'preset', 'dari', 'sampai', 'tipe');
    }

    /**
     * Halaman histori transaksi stok untuk Manajer
     */
    public function index(Request $request)
    {
        ['query' => $query, 'preset' => $preset, 'dari' => $dari, 'sampai' => $sampai] = $this->buildQuery($request);

        $historis         = $query->paginate(25);
        $bahanList        = BahanBaku::orderBy('nama_bahan')->get(['id', 'nama_bahan']);
        $userList         = User::orderBy('username')->get(['id', 'username', 'role']);
        $totalLog         = HistoriStok::count();
        $pemakaianHariIni = HistoriStok::where('tipe', 'pemakaian')->whereDate('created_at', today())->count();
        $pembelianHariIni = HistoriStok::where('tipe', 'pembelian')->whereDate('created_at', today())->count();

        return view('manajer.histori-stok', compact(
            'historis', 'bahanList', 'userList', 'totalLog',
            'pemakaianHariIni', 'pembelianHariIni',
            'preset', 'dari', 'sampai'
        ));
    }

    /**
     * Export ke Excel (.xlsx)
     */
    public function exportExcel(Request $request)
    {
        $filters  = $request->only(['preset', 'dari', 'sampai', 'tipe']);
        $preset   = $filters['preset'] ?? '';
        $filename = 'histori-stok-' . ($preset ?: ($filters['dari'] ?? 'semua')) . '-' . now()->format('Ymd') . '.xlsx';

        return Excel::download(new HistoriStokExport($filters), $filename);
    }

    /**
     * Export ke PDF
     */
    public function exportPdf(Request $request)
    {
        ['query' => $query, 'preset' => $preset, 'dari' => $dari, 'sampai' => $sampai, 'tipe' => $tipe] = $this->buildQuery($request);

        $historis       = $query->get();
        $totalPemakaian = $historis->where('tipe', 'pemakaian')->count();
        $totalPembelian = $historis->where('tipe', 'pembelian')->count();

        $labelPeriode = match($preset) {
            'hari_ini'   => 'Hari Ini',
            'minggu_ini' => 'Minggu Ini',
            'bulan_ini'  => 'Bulan Ini',
            default      => ($dari ? "{$dari} s/d {$sampai}" : 'Semua Waktu'),
        };

        $labelTipe = match($tipe) {
            'pemakaian' => 'Pemakaian (Koki)',
            'pembelian' => 'Pembelian (Manajer)',
            default     => 'Semua Transaksi',
        };

        $pdf = Pdf::loadView('manajer.histori-stok-pdf', compact(
            'historis', 'preset', 'dari', 'sampai', 'tipe',
            'labelPeriode', 'labelTipe', 'totalPemakaian', 'totalPembelian'
        ))->setPaper('a4', 'landscape');

        $filename = 'laporan-histori-stok-' . now()->format('Ymd-Hi') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Reset (hapus semua) data histori stok
     */
    public function resetHistori()
    {
        $jumlah = HistoriStok::count();
        HistoriStok::truncate();

        return redirect()->route('manajer.histori-stok')
            ->with('success', "Berhasil menghapus {$jumlah} data histori stok.");
    }
}

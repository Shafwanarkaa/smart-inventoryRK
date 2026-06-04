<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriStok;
use App\Models\BahanBaku;
use App\Models\User;

class HistoriStokController extends Controller
{
    /**
     * Halaman histori transaksi stok untuk Manajer
     */
    public function index(Request $request)
    {
        $query = HistoriStok::with(['bahanBaku', 'bahanBaku.kategori', 'user'])
            ->orderByDesc('created_at');

        // Filter bahan baku
        if ($request->filled('bahan_baku_id')) {
            $query->where('bahan_baku_id', $request->bahan_baku_id);
        }

        // Filter user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter tanggal dari
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }

        // Filter tanggal sampai
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        // Filter arah perubahan
        if ($request->filled('arah')) {
            if ($request->arah === 'naik') {
                $query->where('selisih', '>', 0);
            } elseif ($request->arah === 'turun') {
                $query->where('selisih', '<', 0);
            } elseif ($request->arah === 'tetap') {
                $query->where('selisih', 0);
            }
        }

        $historis   = $query->paginate(25);
        $bahanList  = BahanBaku::orderBy('nama_bahan')->get(['id', 'nama_bahan']);
        $userList   = User::orderBy('username')->get(['id', 'username', 'role']);
        $totalLog   = HistoriStok::count();

        return view('manajer.histori-stok', compact('historis', 'bahanList', 'userList', 'totalLog'));
    }
}

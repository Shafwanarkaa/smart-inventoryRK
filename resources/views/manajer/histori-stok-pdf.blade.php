<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Histori Stok</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1f2937; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #10b981; padding-bottom: 12px; }
        .header h1 { font-size: 16px; font-weight: bold; color: #065f46; }
        .header p  { font-size: 9px; color: #6b7280; margin-top: 3px; }

        .meta { margin-bottom: 14px; }
        .meta table { width: 100%; font-size: 9px; }
        .meta td { padding: 2px 6px; }
        .meta td:first-child { font-weight: bold; width: 130px; color: #374151; }

        .badge { display: inline-block; padding: 2px 7px; border-radius: 10px; font-size: 8px; font-weight: bold; }
        .badge-orange { background: #fed7aa; color: #9a3412; }
        .badge-green  { background: #bbf7d0; color: #14532d; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.data thead tr { background-color: #10b981; color: white; }
        table.data thead th { padding: 6px 5px; text-align: left; font-size: 9px; font-weight: bold; }
        table.data tbody tr:nth-child(even) { background-color: #f9fafb; }
        table.data tbody tr:nth-child(odd)  { background-color: #ffffff; }
        table.data tbody td { padding: 5px 5px; font-size: 9px; border-bottom: 1px solid #e5e7eb; vertical-align: middle; }

        .jumlah-plus  { color: #16a34a; font-weight: bold; }
        .jumlah-minus { color: #dc2626; font-weight: bold; }

        .footer { margin-top: 20px; text-align: right; font-size: 8px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 8px; }
        .summary { margin-bottom: 14px; display: flex; gap: 10px; }
        .summary-card { border: 1px solid #e5e7eb; border-radius: 6px; padding: 8px 14px; flex: 1; text-align: center; }
        .summary-card .val { font-size: 18px; font-weight: bold; color: #065f46; }
        .summary-card .lbl { font-size: 8px; color: #6b7280; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>📋 Laporan Histori Transaksi Stok</h1>
        <p>Restoran Remaja Kuring — Dicetak: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    {{-- Meta info filter --}}
    <div class="meta">
        <table>
            <tr>
                <td>Periode</td>
                <td>:
                    @if($labelPeriode === 'Hari Ini') Hari Ini ({{ now()->format('d/m/Y') }})
                    @elseif($labelPeriode === 'Minggu Ini') Minggu Ini ({{ now()->startOfWeek()->format('d/m') }} – {{ now()->endOfWeek()->format('d/m/Y') }})
                    @elseif($labelPeriode === 'Bulan Ini') Bulan Ini ({{ now()->format('F Y') }})
                    @elseif($dari) {{ $dari }} s/d {{ $sampai }}
                    @else Semua Waktu
                    @endif
                </td>
            </tr>
            <tr>
                <td>Tipe Transaksi</td>
                <td>: {{ $labelTipe }}</td>
            </tr>
            <tr>
                <td>Total Data</td>
                <td>: {{ $historis->count() }} transaksi</td>
            </tr>
        </table>
    </div>

    {{-- Summary counts --}}
    <table style="width:100%; margin-bottom: 14px;">
        <tr>
            <td style="width:33%; padding: 8px; border: 1px solid #d1fae5; background: #ecfdf5; border-radius: 4px; text-align:center;">
                <div style="font-size:18px; font-weight:bold; color:#065f46;">{{ $totalPemakaian }}</div>
                <div style="font-size:8px; color:#6b7280;">🍳 Pemakaian</div>
            </td>
            <td style="width:4%;"></td>
            <td style="width:33%; padding: 8px; border: 1px solid #bbf7d0; background: #f0fdf4; border-radius: 4px; text-align:center;">
                <div style="font-size:18px; font-weight:bold; color:#14532d;">{{ $totalPembelian }}</div>
                <div style="font-size:8px; color:#6b7280;">🛒 Pembelian</div>
            </td>
            <td style="width:4%;"></td>
            <td style="width:26%; padding: 8px; border: 1px solid #e5e7eb; background: #f9fafb; border-radius: 4px; text-align:center;">
                <div style="font-size:18px; font-weight:bold; color:#374151;">{{ $historis->count() }}</div>
                <div style="font-size:8px; color:#6b7280;">📋 Total</div>
            </td>
        </tr>
    </table>

    {{-- Data Table --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width:4%;">No</th>
                <th style="width:12%;">Tanggal & Jam</th>
                <th style="width:16%;">Bahan Baku</th>
                <th style="width:11%;">Kategori</th>
                <th style="width:11%;">Dicatat Oleh</th>
                <th style="width:10%; text-align:center;">Tipe</th>
                <th style="width:10%; text-align:center;">Jumlah</th>
                <th style="width:10%; text-align:center;">Sisa Stok</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historis as $i => $h)
            <tr>
                <td style="text-align:center; color:#9ca3af;">{{ $i + 1 }}</td>
                <td>
                    {{ $h->created_at->format('d/m/Y') }}<br>
                    <span style="color:#9ca3af;">{{ $h->created_at->format('H:i') }} WIB</span>
                </td>
                <td><strong>{{ $h->bahanBaku->nama_bahan }}</strong></td>
                <td style="color:#6b7280;">{{ $h->bahanBaku->kategori->nama_kategori ?? '-' }}</td>
                <td>
                    {{ $h->user->username }}<br>
                    <span style="color:#9ca3af; font-size:8px;">{{ ucfirst($h->user->role) }}</span>
                </td>
                <td style="text-align:center;">
                    @if(($h->tipe ?? 'pemakaian') === 'pembelian')
                        <span class="badge badge-green">Pembelian</span>
                    @else
                        <span class="badge badge-orange">Pemakaian</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    @if($h->selisih > 0)
                        <span class="jumlah-plus">+{{ $h->selisih }} {{ $h->bahanBaku->satuan }}</span>
                    @else
                        <span class="jumlah-minus">-{{ abs($h->selisih) }} {{ $h->bahanBaku->satuan }}</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <strong>{{ $h->stok_sesudah }}</strong>
                    <span style="color:#9ca3af;">{{ $h->bahanBaku->satuan }}</span>
                </td>
                <td style="color:#6b7280; font-style:italic;">{{ $h->keterangan ?: '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; color:#9ca3af; padding:20px;">Tidak ada data untuk periode ini</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh Sistem Remaja Kuring · {{ now()->format('d/m/Y H:i') }} WIB
    </div>

</body>
</html>

<?php

namespace App\Exports;

use App\Models\HistoriStok;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HistoriStokExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Histori Stok';
    }

    public function query()
    {
        $query = HistoriStok::with(['bahanBaku', 'bahanBaku.kategori', 'user'])
            ->orderByDesc('created_at');

        // Terapkan filter
        $preset = $this->filters['preset'] ?? null;
        $dari   = $this->filters['dari']   ?? null;
        $sampai = $this->filters['sampai'] ?? null;
        $tipe   = $this->filters['tipe']   ?? null;

        if ($preset === 'hari_ini') {
            $dari = $sampai = now()->toDateString();
        } elseif ($preset === 'minggu_ini') {
            $dari   = now()->startOfWeek()->toDateString();
            $sampai = now()->endOfWeek()->toDateString();
        } elseif ($preset === 'bulan_ini') {
            $dari   = now()->startOfMonth()->toDateString();
            $sampai = now()->endOfMonth()->toDateString();
        }

        if ($dari)   $query->whereDate('created_at', '>=', $dari);
        if ($sampai) $query->whereDate('created_at', '<=', $sampai);
        if ($tipe)   $query->where('tipe', $tipe);

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Jam',
            'Nama Bahan',
            'Kategori',
            'Dicatat Oleh',
            'Role',
            'Tipe Transaksi',
            'Jumlah',
            'Satuan',
            'Stok Sebelum',
            'Stok Sesudah',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->created_at->format('d/m/Y'),
            $row->created_at->format('H:i'),
            $row->bahanBaku->nama_bahan,
            $row->bahanBaku->kategori->nama_kategori ?? '-',
            $row->user->username,
            ucfirst($row->user->role),
            ucfirst($row->tipe ?? 'pemakaian'),
            abs($row->selisih),
            $row->bahanBaku->satuan,
            $row->stok_sebelum,
            $row->stok_sesudah,
            $row->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row bold + background
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF10B981']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}

<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DB::table('orders')
            ->leftJoin('carts', 'carts.id', '=', 'orders.cart_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'users.id', '=', 'carts.user_id')
            ->select(
                'orders.nama_customer',
                'orders.tanggal',
                'products.name as name',
                'orders.qty as qty',
                DB::raw('SUM(products.price * orders.qty) as total_price')
            )
            ->where('orders.status', 1);

        if ($this->tahun && $this->bulan) {
            $query->whereYear('orders.tanggal', $this->tahun)
                ->whereMonth('orders.tanggal', $this->bulan);
        } elseif ($this->tahun) {
            $query->whereYear('orders.tanggal', $this->tahun);
        }

        return $query->groupBy('orders.tanggal', 'products.name', 'orders.qty', 'orders.nama_customer')
            ->get();
    }

    public function headings(): array
    {
        return [
            [
                'Nama Customer',
                'Nama Barang',
                'Jumlah',
                'Tanggal',
                'Total',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $cellRange = 'A1:' . $lastColumn . $lastRow;

        return [
            $cellRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function map($report): array
    {
        return [
            $report->nama_customer,
            $report->name,
            $report->qty,
            $report->tanggal,
            $report->total_price,
        ];
    }
}

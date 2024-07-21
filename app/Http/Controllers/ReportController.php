<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        // Query for the first table
        $items = DB::table('orders')
            ->leftJoin('carts', 'carts.id', '=', 'orders.cart_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'users.id', '=', 'carts.user_id')
            ->select(
                'orders.nama_customer',
                'orders.tanggal',
                'products.name as name',
                'orders.qty as qty',
                'orders.ongkir',
                'orders.bukti',
                DB::raw('SUM(products.price * orders.qty) as total_price'),
                DB::raw('SUM(products.price * orders.qty) + IFNULL(orders.ongkir, 0) as total_harga')
            )
            ->whereIn('orders.status', [1, 5]) // Include status 1 and 5
            ->groupBy('orders.nama_customer', 'orders.tanggal', 'products.name', 'orders.qty', 'orders.ongkir', 'orders.bukti')
            ->get();

        // Query for the second table
        $salesSummary = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                DB::raw('SUM(orders.qty) as total_qty_sold'),
                'products.price as product_price',
                DB::raw('SUM(orders.qty * products.price) as total_sales')
            )
            ->whereIn('orders.status', [1, 5]) // Include status 1 and 5
            ->groupBy('products.name', 'products.price')
            ->get();

        return view('dashboard.laporan.index', compact('items', 'salesSummary'));
    }

    public function pdf(Request $request)
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
                'orders.ongkir',
                'orders.bukti',
                DB::raw('SUM(products.price * orders.qty) as total_price'),
                DB::raw('SUM(products.price * orders.qty) + IFNULL(orders.ongkir, 0) as total_harga')
            )
            ->whereIn('orders.status', [1, 5]) // Include status 1 and 5
            ->groupBy('orders.nama_customer', 'orders.tanggal', 'products.name', 'orders.qty', 'orders.ongkir', 'orders.bukti');

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('orders.tanggal', $request->tahun)
                ->whereMonth('orders.tanggal', $request->bulan);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('orders.tanggal', $request->tahun);
        }

        $items = $query->get();

        if ($items->count() <= 0) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $pdf = Pdf::loadView('dashboard.laporan.export', ['items' => $items]);

        return $pdf->download('Laporan.pdf');
    }

    public function excel(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $query = DB::table('orders')
            ->leftJoin('carts', 'carts.id', '=', 'orders.cart_id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->leftJoin('users', 'users.id', '=', 'carts.user_id')
            ->select(
                'orders.nama_customer',
                'orders.tanggal',
                'products.name as name',
                'orders.qty as qty',
                'orders.ongkir',
                'orders.bukti',
                DB::raw('SUM(products.price * orders.qty) as total_price'),
                DB::raw('SUM(products.price * orders.qty) + IFNULL(orders.ongkir, 0) as total_harga')
            )
            ->whereIn('orders.status', [1, 5]) // Include status 1 and 5
            ->groupBy('orders.nama_customer', 'orders.tanggal', 'products.name', 'orders.qty', 'orders.ongkir', 'orders.bukti');

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('orders.tanggal', $request->tahun)
                ->whereMonth('orders.tanggal', $request->bulan);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('orders.tanggal', $request->tahun);
        }

        $items = $query->get();

        if ($items->count() <= 0) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        return Excel::download(new ReportExport($bulan, $tahun), 'Laporan.xlsx');
    }
}

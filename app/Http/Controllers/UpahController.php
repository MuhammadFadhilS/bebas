<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpahController extends Controller
{
    public function index()
    {
        $items = DB::table('orders')
            ->join('carts', 'orders.cart_id', '=', 'carts.id')
            ->join('couriers', 'couriers.id', '=', 'carts.courier_id')
            ->select(
                'couriers.name as courier_name',
                DB::raw('COUNT(DISTINCT CONCAT(DATE(orders.created_at), " ", TIME(orders.created_at))) as total_orders')
            )
            ->where('carts.status', 5)
            ->groupBy('couriers.name')
            ->orderBy('total_orders', 'desc')
            ->get();

        // Ambil nilai upah per order dari tabel konfigurasi
        $wagePerOrder = DB::table('configurations')->where('key', 'wage_per_order')->value('value');

        return view('dashboard.upah.index', compact('items', 'wagePerOrder'));
    }

    public function updateWage(Request $request)
    {
        $request->validate([
            'wage' => 'required|numeric|min:0',
        ]);

        $wage = $request->input('wage');

        // Update nilai upah per order di tabel konfigurasi
        DB::table('configurations')->updateOrInsert(
            ['key' => 'wage_per_order'],
            ['value' => $wage, 'updated_at' => now()]
        );

        return redirect()->route('data-upah')->with('success', 'Harga upah berhasil diperbarui.');
    }
}


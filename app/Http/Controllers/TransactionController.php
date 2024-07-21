<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Courier;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $orders = DB::table('carts')
            ->join('orders', 'orders.cart_id', '=', 'carts.id')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->leftJoin('couriers', 'couriers.id', '=', 'carts.courier_id')
            ->join('users', 'users.id', '=', 'carts.user_id')
            ->select(
                'orders.batch as id',
                'users.name as name',
                'users.address as address',
                DB::raw('GROUP_CONCAT(products.name SEPARATOR ", ") as product_names'),
                DB::raw('SUM(products.price * carts.qty) as total_price'),
                'carts.status',
                'orders.notes as notes',
                'couriers.name as courier',
                'orders.method as method',
                'couriers.telepon as courier_telepon',
                'carts.bukti_refund',
                'carts.alasan_refund',
                'orders.ongkir',
                'orders.created_at as order_time' // Tambahkan baris ini
            )
            ->where('carts.status', '>=', '3')
            ->groupBy(
                'orders.batch',
                'users.name',
                'users.address',
                'carts.status',
                'orders.notes',
                'couriers.name',
                'orders.method',
                'carts.alasan_refund',
                'carts.bukti_refund',
                'couriers.telepon',
                'orders.ongkir',
                'orders.created_at'
            )
            ->orderBy('orders.created_at', 'desc') // Add this line to sort by date in descending order
            ->get();

        return view('dashboard.transaksi.index', compact('orders'));
    }

    public function edit($id)
    {
        $couriers = Courier::all();
        $cart = Order::where('batch', $id)->first();

        return view('dashboard.transaksi.edit', compact('id', 'couriers', 'cart'));
    }

    public function update(Request $request, $id)
    {
        $orders = Order::where('batch', $id)->get();

        foreach ($orders as $order) {
            Cart::where('id', intval($order->cart_id))->update([
                'status' => 4,
                'courier_id' => $request->courier_id
            ]);
        }

        return redirect()->route('transaction.index')->with('Success', 'Data berhasil disimpan');
    }

    public function confirmation($id)
{
    $orders = Order::where('batch', $id)->get();

    foreach ($orders as $order) {
        $product = Product::findOrFail($order->product_id);

        // Kurangi stok produk
        $product->update([
            'stock' => $product->stock - $order->qty
        ]);

        // Update status pesanan dan item di keranjang
        Cart::where('id', $order->cart_id)->update([
            'status' => 5 // Status untuk pesanan yang dikonfirmasi
        ]);

        Order::where('batch', $id)->update([
            'status' => 2 // Misalnya, status 2 untuk pesanan yang dikonfirmasi
        ]);
    }

    return back()->with('success', 'Pesanan berhasil dikonfirmasi.');
}

public function rejectOrder(Request $request, $id)
{
    $orders = Order::where('batch', $id)->get();

    foreach ($orders as $order) {
        $product = Product::findOrFail($order->product_id);

        // Kembalikan stok produk
        $product->update([
            'stock' => $product->stock + $order->qty
        ]);

        // Update status pesanan dan item di keranjang
        Cart::where('id', $order->cart_id)->update([
            'status' => 9 // Status untuk pesanan yang ditolak
        ]);
    }

    return back()->with('success', 'Pesanan berhasil ditolak.');
}
}

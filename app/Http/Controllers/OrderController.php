<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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
            'orders.tanggal as tanggal', // Include tanggal in the select statement
            'users.name as name',
            'users.address as address',
            DB::raw('GROUP_CONCAT(products.name SEPARATOR ", ") as product_names'),
            DB::raw('SUM(products.price * carts.qty) as total_price'),
            'carts.status',
            'orders.notes as notes',
            'couriers.name as courier',
            'couriers.telepon as courier_telepon',
            'orders.ongkir' // Include ongkir in the select statement
        )
        ->where('carts.status', '>=', '3')
        ->groupBy(
            'orders.batch',
            'orders.tanggal', // Group by tanggal
            'users.name',
            'users.address',
            'carts.status',
            'orders.notes',
            'couriers.name',
            'couriers.telepon',
            'orders.ongkir' // Group by ongkir
        )
        ->get();

    return view('dashboard.order.index', compact('orders'));
}



    public function destroy($id)
    {
        $orders = Order::where('batch', $id)->get();

        foreach ($orders as $order) {
            $product = Product::where('id', $order->product_id)->first();

            $product->update([
                'stock' => $product->stock + $order->qty
            ]);

            $deleteItem = Cart::findOrFail($order->cart_id);
            $deleteItem->delete();
            Order::where('batch', $id)->delete();
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }

    public function confirmation($id)
    {
        $orders = Order::where('batch', $id)->get();

        foreach ($orders as $order) {
            $orders = Cart::where('id', $order->cart_id)->update([
                'status' => 5
            ]);

            Order::where('batch', $id)->update([
                'status' => 1
            ]);
        }

        return back()->with('success', 'Barang telah diterima');
    }

    public function create()
    {
        $products = Product::where('status', 1)->where('stock', '>', 0)->get();

        return view('dashboard.order.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1'
        ]);
    
        DB::transaction(function () use ($request) {
            foreach ($request->product_id as $index => $product_id) {
                $product = Product::findOrFail($product_id);
                $product->decrement('stock', $request->qty[$index]);
    
                Order::create([
                    'nama_customer' => $request->nama_customer,
                    'method' => 'COD',
                    'product_id' => $product_id,
                    'tanggal' => $request->tanggal,
                    'qty' => $request->qty[$index],
                    'source' => 'offline',
                    'status' => 1
                ]);
            }
        });
    
        return redirect()->route('product.index')->with('success', 'Data berhasil disimpan');
        // $request->validate([
        //     'product_id' => 'required',
        //     'tanggal' => 'required',
        //     'qty' => 'required',
        //     'bukti' => 'required',
        //     'nama_customer' => 'required'
        // ]);

        // $image = $request->file('bukti');
        // $image->storeAs('public/photos', $image->hashName());

        // $product = Product::where('id', $request->product_id)->first();

        // $product->update([
        //     'stock' => $product->stock - $request->qty
        // ]);

        // Order::create([
        //     'nama_customer' => $request->nama_customer,
        //     'method' => 'QRIS',
        //     'product_id' => $request->product_id,
        //     'tanggal' => $request->tanggal,
        //     'qty' => $request->qty,
        //     'source' => 'offline',
        //     'bukti' => $image->hashName(),
        //     'status' => 1
        // ]);

        // return redirect()->route('product.index')->with('success', 'Data berhasil disimpan');
    }
}
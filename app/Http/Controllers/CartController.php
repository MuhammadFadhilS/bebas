<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('product')->where('status', '<=', 2)->where('user_id', Auth::id())->get();
        return view('dashboard.keranjang.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.keranjang.order');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request untuk memastikan semua data yang diperlukan ada
        $request->validate([
            'items' => 'required',
            'wilayah' => 'required',
            'method' => 'required',
            'notes' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $items = explode(",", $request->items);
        $ongkir = $request->input('ongkir');
        $total = $request->input('total');

        $id = Order::latest()->first();

        foreach ($items as $item) {
            $itemKeranjang = Cart::findOrFail($item);

            if ($request->has('bukti')) {
                $image = $request->file('bukti');
                $buktiPath = $image->storeAs('public/photos', $image->hashName());

                $itemKeranjang->update(['status' => '3']);
                $updateProductStock = Product::findOrFail($itemKeranjang->product_id);
                $updateProductStock->update(['stock' => $updateProductStock->stock - $itemKeranjang->qty]);
                $user_name = User::findOrFail($itemKeranjang->user_id);

                Order::create([
                    'cart_id' => $itemKeranjang->id,
                    'product_id' => $itemKeranjang->product_id,
                    'nama_customer' => $user_name->name,
                    'tanggal' => $itemKeranjang->updated_at,
                    'notes' => $request->notes,
                    'method' => $request->method,
                    'bukti' => $image->hashName(),
                    'qty' => $itemKeranjang->qty,
                    'source' => 'online',
                    'status' => 0,
                    'batch' => $id ? $id->batch + 1 : 1,
                    'ongkir' => $ongkir, // Simpan ongkir ke database
                ]);
            } else {
                $itemKeranjang->update(['status' => '3']);
                $updateProductStock = Product::findOrFail($itemKeranjang->product_id);
                $updateProductStock->update(['stock' => $updateProductStock->stock - $itemKeranjang->qty]);
                $user_name = User::findOrFail($itemKeranjang->user_id);

                Order::create([
                    'cart_id' => $itemKeranjang->id,
                    'product_id' => $itemKeranjang->product_id,
                    'nama_customer' => $user_name->name,
                    'tanggal' => $itemKeranjang->updated_at,
                    'notes' => $request->notes,
                    'method' => $request->method,
                    'qty' => $itemKeranjang->qty,
                    'source' => 'online',
                    'status' => 0,
                    'batch' => $id ? $id->batch + 1 : 1,
                    'ongkir' => $ongkir, // Simpan ongkir ke database
                ]);
            }
        }

        // Redirect setelah menyimpan pesanan
        return redirect()->route('order.index')->with('success', 'Pesanan berhasil dibuat');
    }

    public function addCart(Request $request, $id)
    {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'status' => '1',
            'qty' => $request->qty
        ]);

        return redirect()->route('cart.index')->with('success', 'Berhasil ditambahkan ke dalam keranjang');
    }

    public function updateStatus(Request $request)
    {
        try {
            $selectedItems = $request->items;

            foreach ($selectedItems as $item) {
                Cart::where('id', $item['id'])->update([
                    'status' => 2,
                    'qty' => $item['qty']
                ]);
            }

            return response()->json(['message' => 'Berhasil memperbarui status barang'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memperbarui status barang'], 500);
        }
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Barang berhasil dihapus dari keranjang');
    }
}

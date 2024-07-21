<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function safety()
    {
        if (Auth::user()->role != 'admin') {
            abort('401');
        }
    }

    public function index()
    {
        $this->safety();

        $products = Product::all();

        return view('dashboard.produk.index', compact('products'));
    }

    public function create()
    {
        $this->safety();

        $categories = Category::all();

        return view('dashboard.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->safety();
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'photo' => 'required',
            'kode_barang' => 'required',
            'harga_awal' => 'nullable|numeric'  // Validate harga_awal
        ]);

        $photo = $request->file('photo');
        $photo->storeAs('public/photos', $photo->hashName());

        Product::create([
            'photo' => $photo->hashName(),
            'name'  => $request->name,
            'category_id'  => $request->category_id,
            'brand'  => $request->brand,
            'price'  => $request->price,
            'expired'  => $request->expired,
            'description'  => $request->description,
            'stock'  => $request->stock,
            'status' => $request->status,
            'kode_barang' => $request->kode_barang,
            'harga_awal' => $request->harga_awal  // Add harga_awal
        ]);

        return redirect()->route('product.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        $products = Product::all()->except($id);

        return view('dashboard.produk.show', compact('product', 'products'));
    }

    public function edit(Product $product)
    {
        $this->safety();

        $categories = Category::all();

        return view('dashboard.produk.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->safety();

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
            'harga_awal' => 'nullable|numeric'  // Validate harga_awal
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo->storeAs('public/photos', $photo->hashName());

            $product->update([
                'photo' => $photo->hashName(),
                'name'  => $request->name,
                'category_id'  => $request->category_id,
                'brand'  => $request->brand,
                'price'  => $request->price,
                'expired'  => $request->expired,
                'description'  => $request->description,
                'stock'  => $request->stock,
                'status'  => $request->status,
                'kode_barang' => $request->kode_barang,
                'harga_awal' => $request->harga_awal  // Update harga_awal
            ]);
        } else {
            $product->update([
                'name'  => $request->name,
                'category_id'  => $request->category_id,
                'brand'  => $request->brand,
                'price'  => $request->price,
                'expired'  => $request->expired,
                'description'  => $request->description,
                'stock'  => $request->stock,
                'status'  => $request->status,
                'kode_barang' => $request->kode_barang,
                'harga_awal' => $request->harga_awal  // Update harga_awal
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Data berhasil disimpan');
    }
    public function destroy(Product $product)
    {
        $this->safety();

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Data berhasil dihapus');
    }
}

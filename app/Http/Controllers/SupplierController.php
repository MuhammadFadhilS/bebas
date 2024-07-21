<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('dashboard.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboard.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'product_name' => 'required|string|max:255',
            'product_brand' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'expired' => 'required|date',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->product_name = $request->product_name;
        $supplier->product_brand = $request->product_brand;
        $supplier->quantity = $request->quantity;
        $supplier->price = $request->price;
        $supplier->expired = $request->expired;

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = $file->hashName();
            $file->storeAs('public/photos', $filename);
            $supplier->payment_proof = $filename;
        }

        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('dashboard.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'product_name' => 'required|string|max:255',
        'product_brand' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|integer|min:1',
        'expired' => 'required|date|after_or_equal:today',
        'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
    ]);

    $supplier = Supplier::findOrFail($id);

    $supplier->name = $request->name;
    $supplier->phone = $request->phone;
    $supplier->product_name = $request->product_name;
    $supplier->product_brand = $request->product_brand;
    $supplier->quantity = $request->quantity;
    $supplier->price = $request->price;
    $supplier->expired = \Carbon\Carbon::parse($request->expired)->format('Y-m-d');

    if ($request->hasFile('payment_proof')) {
        $paymentProofPath = $request->file('payment_proof')->store('photos', 'public');
        $supplier->payment_proof = $paymentProofPath;
    }

    $supplier->save();

    return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully');
}

    public function destroy(Supplier $supplier)
    {
        if ($supplier->payment_proof) {
            Storage::delete('public/photos/' . $supplier->payment_proof);
        }

        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}

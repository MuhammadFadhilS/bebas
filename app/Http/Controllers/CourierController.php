<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CourierController extends Controller
{
    public function safety()
    {
        if (Auth::user()->role != 'admin') {
            abort('401');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->safety();

        $couriers = Courier::all();

        return view('dashboard.kurir.index', compact('couriers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->safety();

        return view('dashboard.kurir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->safety();

        $request->validate([
            'name' => 'required',
            'motor' => 'required',
            'gender' => 'required',
            'no_motor' => 'required',
            'telepon' => 'required',
            'photo' => 'required'
        ]);

        $photo = $request->file('photo');
        $photo->storeAs('public/photos', $photo->hashName());

        Courier::create([
            'name' => $request->name,
            'motor' => $request->motor,
            'gender' => $request->gender,
            'no_motor' => $request->no_motor,
            'telepon' => $request->telepon,
            'photo' => $photo->hashName()
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->name) . '@tokowildan.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'telepon' => $request->telepon
        ]);

        return redirect()->route('courier.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        return view('dashboard.kurir.edit', compact('courier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        $this->safety();

        $request->validate([
            'name' => 'required',
            'motor' => 'required',
            'gender' => 'required',
            'no_motor' => 'required',
            'telepon' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo->storeAs('public/photos', $photo->hashName());

            $courier->update([
                'name' => $request->name,
                'motor' => $request->motor,
                'gender' => $request->gender,
                'no_motor' => $request->no_motor,
                'telepon' => $request->telepon,
                'photo' => $photo->hashName()
            ]);
        } else {
            $courier->update([
                'name' => $request->name,
                'motor' => $request->motor,
                'gender' => $request->gender,
                'no_motor' => $request->no_motor,
                'telepon' => $request->telepon,
            ]);
        }

        return redirect()->route('courier.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        $this->safety();

        $courier->delete();

        return redirect()->route('courier.index')->with('success', 'Data berhasil disimpan');
    }

    public function paket()
    {
        // Hanya kurir yang sedang login
        $courierName = Auth::user()->name;

        $items = DB::table('carts')
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
                'carts.alasan_refund'
            )
            ->where('couriers.name', $courierName) // Filter berdasarkan nama kurir yang sedang login
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
                'couriers.telepon'
            )
            ->get();

        return view('dashboard.kurir.paket', compact('items'));
    }

    public function confirmation($id)
    {
        $orders = DB::table('orders')
            ->join('carts', 'orders.cart_id', '=', 'carts.id')
            ->where('orders.batch', $id)
            ->select('carts.id as cart_id')
            ->get();

        foreach ($orders as $order) {
            DB::table('carts')
                ->where('id', $order->cart_id)
                ->update(['status' => 5]);
        }

        return redirect()->route('courier.paket')->with('success', 'Barang telah diterima');
    }
}
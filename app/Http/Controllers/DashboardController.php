<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Courier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function safety()
    {
        if (Auth::user()->role != 'admin' && Auth::user()->role != 'operator' && Auth::user()->role != 'kurir' && Auth::user()->role != 'owner') {
            abort(401);
        }
    }

    public function index()
    {
        $this->safety();

        $products = Product::count();
        $categories = Category::count();
        $couriers = Courier::count();
        $admin = User::where('role', 'admin')->count();
        $operator = User::where('role', 'operator')->count();

        $order = DB::table('orders')
            ->select(
                'orders.id',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->groupBy('orders.id')
            ->get();

        $totalOrders = $order->sum('total_orders');

        $paket = DB::table('orders')
            ->select(
                DB::raw('COUNT(DISTINCT orders.id) as total_orders')
            )
            ->where('status', 1)
            ->groupBy('orders.id')
            ->get();

        $totalPaket = $paket->sum('total_orders');

        return view('dashboard.dashboard', compact('products', 'categories', 'couriers', 'admin', 'operator', 'totalOrders', 'totalPaket'));
    }
}

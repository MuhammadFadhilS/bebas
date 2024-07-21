<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UpahController;
use App\Http\Controllers\SupplierController;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'operator' || Auth::user()->role == 'kurir' || Auth::user()->role == 'owner') {
            return redirect()->route('admin');
        }
    }


    // if (Auth::check()) {
    //     if (Auth::user()->role == 'admin' || Auth::user()->role == 'operator' || Auth::user()->role == 'kurir') {
    //         return redirect()->route('admin');
    //     }
    // }

    

    $categories = Category::all();
    $keyword = $request->input('keyword');

    if ($request->has('category')) {
        $products = Product::where('status', 1)
            ->where('category_id', $request->category)
            ->where('stock', '>', 0)
            ->get();
    } else {
        $query = Product::where('status', 1)
            ->where('stock', '>', 0);

        if (!empty($keyword)) {
            $products = $query->where('name', 'like', '%' . $keyword . '%')->get();
        } else {
            $products = $query->get();
        }
    }
    return view('dashboard', compact('categories', 'products'));
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Dashboard Admin, Owner, Operator, Kurir
    Route::get('/dashboard-TokoWildan', [DashboardController::class, 'index'])->name('admin');
    

    // Produk
    Route::resource('product', ProductController::class);
    Route::get('product/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('product/{product}', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('product.show');
    Route::get('product/penjualan/offline', [OrderController::class, 'create'])->name('order.create');

    // Kategori
    Route::resource('category', CategoryController::class);
    Route::get('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Kurir
    Route::resource('courier', CourierController::class);
    Route::get('courier/{courier}', [CourierController::class, 'destroy'])->name('courier.destroy');
    Route::get('daftar-paket', [CourierController::class, 'paket'])->name('courier.paket');
    Route::get('/courier/confirmation/{id}', [CourierController::class, 'confirmation'])->name('courier.confirmation');

    // Admin
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('admin/edit/{admin}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('admin/update/{admin}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('admin/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');

    // Operator
    Route::get('operator', [OperatorController::class, 'index'])->name('operator.index');
    Route::get('operator/create', [OperatorController::class, 'create'])->name('operator.create');
    Route::post('operator/store', [OperatorController::class, 'store'])->name('operator.store');
    Route::get('operator/edit/{operator}', [OperatorController::class, 'edit'])->name('operator.edit');
    Route::put('operator/update/{operator}', [OperatorController::class, 'update'])->name('operator.update');
    Route::get('operator/{operator}', [OperatorController::class, 'destroy'])->name('operator.destroy');

    // Keranjang
    Route::post('cart/add/{id}', [CartController::class, 'addCart'])->middleware(['auth', 'verified'])->name('cart.add');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/order', [CartController::class, 'create'])->name('cart.create');
    Route::post('/update-status-barang', [CartController::class, 'updateStatus'])->name('update-status-barang');
    Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
    Route::get('cart/destroy/{id}', [CartController::class, 'destroy'])->name('cart-destroy');

    // Order
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order/cancel/{id?}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('order/confirmation/{id?}', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::post('report/store', [OrderController::class, 'store'])->name('order.store');

    // Transaksi
    Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::get('transaction/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
    Route::put('transaction/edit/{id}', [TransactionController::class, 'update'])->name('transaction.update');
    Route::post('/transaction/{id}/reject', [TransactionController::class, 'rejectOrder'])->name('transaction.reject');

    // Laporan
    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::get('report-pdf', [ReportController::class, 'pdf'])->name('report.pdf');
    Route::get('report-excel', [ReportController::class, 'excel'])->name('report.excel');

    // Upah
    Route::get('upah', [UpahController::class, 'index'])->name('upah.index');
    Route::get('/data-upah', [UpahController::class, 'index'])->name('data-upah');
    Route::post('/update-wage', [UpahController::class, 'updateWage'])->name('update-wage');

    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');

    // About
    Route::get('about', function () {
        return view('about');
    });

    // Refund
    Route::post('refund', function (Request $request) {
        $orders = Order::where('batch', $request->id)->get();
        foreach ($orders as $order) {
            $image = $request->file('bukti_refund');
            $image->storeAs('public/photos', $image->hashName());

            Cart::where('id', $order->cart_id)->update([
                'status' => 6,
                'alasan_refund' => $request->alasan_refund,
                'bukti_refund' => $image->hashName()
            ]);
        }

        return redirect()->route('order.index')->with('success', 'Berhasil mengajukan refund');
    })->name('refund');

    Route::get('reject-refund/{id}', function ($id) {
        $orders = Order::where('batch', $id)->get();

        foreach ($orders as $order) {
            Cart::where('id', $order->cart_id)->update([
                'status' => 7,
            ]);

            Order::where('batch', $id)->update([
                'status' => 1
            ]);
        }

        return redirect()->route('transaction.index')->with('success', 'Pengajuan refund ditolak');
    })->name('refund.reject');

    Route::get('accept-refund/{id}', function ($id) {
        $orders = Order::where('batch', $id)->get();

        foreach ($orders as $order) {
            Cart::where('id', $order->cart_id)->update([
                'status' => 8,
            ]);

            Order::where('batch', $id)->update([
                'status' => 0
            ]);
        }

        return redirect()->route('transaction.index')->with('success', 'Pengajuan refund diterima');
    })->name('refund.accept');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
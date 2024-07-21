<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role','admin')->simplePaginate(10);

        return view('dashboard.admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'gender' => 'required',
            'telepon' => 'required',
            'address' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin',
            'password' => Hash::make('password'),
            'address' => $request->address,
            'telepon' => $request->telepon,
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('dashboard.admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'gender' => 'required',
            'telepon' => 'required',
            'address' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'telepon' => $request->telepon,
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'Data berhasil dihapus');
    }
}

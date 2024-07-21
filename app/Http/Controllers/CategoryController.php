<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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

        $categories = Category::all();

        return view('dashboard.kategori.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->safety();

        return view('dashboard.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->safety();

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Category::create($validated);

        return redirect()->route('category.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $this->safety();

        return view('dashboard.kategori.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->safety();

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
       $category->delete();

       return redirect()->route('category.index')->with('success', 'Data berhasil dihapus');
    }
}

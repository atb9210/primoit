<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'producer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'drive' => 'nullable|string|max:255',
            'operating_system' => 'nullable|string|max:255',
            'gpu' => 'nullable|string|max:255',
            'has_box' => 'boolean',
            'color' => 'nullable|string|max:255',
            'screen_size' => 'nullable|string|max:255',
            'lcd_quality' => 'nullable|string|max:255',
            'battery' => 'nullable|string|max:255',
            'visual_grade' => 'nullable|string|max:255',
            'info' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'producer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'drive' => 'nullable|string|max:255',
            'operating_system' => 'nullable|string|max:255',
            'gpu' => 'nullable|string|max:255',
            'has_box' => 'boolean',
            'color' => 'nullable|string|max:255',
            'screen_size' => 'nullable|string|max:255',
            'lcd_quality' => 'nullable|string|max:255',
            'battery' => 'nullable|string|max:255',
            'visual_grade' => 'nullable|string|max:255',
            'info' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}

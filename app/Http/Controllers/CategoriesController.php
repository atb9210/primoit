<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its products.
     */
    public function show(Category $category)
    {
        // Load the category with its products
        $category->load(['products' => function($query) {
            $query->where('status', 'active')
                  ->orderBy('created_at', 'desc');
        }]);
        
        return view('categories.show', compact('category'));
    }
} 
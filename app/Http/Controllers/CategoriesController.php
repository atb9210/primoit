<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::withCount('batches')->orderBy('name')->get();
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its batches.
     */
    public function show(Category $category)
    {
        // Load the category with its batches
        $category->load(['batches' => function($query) {
            $query->where('status', 'active')
                  ->orderBy('created_at', 'desc');
        }]);
        
        return view('categories.show', compact('category'));
    }
} 
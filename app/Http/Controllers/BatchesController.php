<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchesController extends Controller
{
    /**
     * Display a listing of the batches.
     */
    public function index(Request $request)
    {
        $query = Batch::query()->withCount('products');
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to showing only active batches
            $query->where('status', 'active');
        }
        
        if ($request->filled('min_price')) {
            $query->where('total_price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('total_price', '<=', $request->max_price);
        }
        
        // Only show available batches by default
        $query->where(function ($query) {
            $query->whereNull('available_until')
                ->orWhere('available_until', '>=', now());
        });
        
        $query->where(function ($query) {
            $query->whereNull('available_from')
                ->orWhere('available_from', '<=', now());
        });
        
        // Get results with pagination
        $batches = $query->orderBy('created_at', 'desc')->paginate(9);
        
        return view('batches.index', compact('batches'));
    }

    /**
     * Display the specified batch.
     */
    public function show(Batch $batch)
    {
        // Load the batch with its products
        $batch->load('products');
        
        return view('batches.show', compact('batch'));
    }
} 
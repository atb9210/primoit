<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Product;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the batches.
     */
    public function index()
    {
        $batches = Batch::withCount('products')->paginate(15);
        return view('admin.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new batch.
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('admin.batches.create', compact('products'));
    }

    /**
     * Store a newly created batch in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,reserved,sold',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'unit_prices' => 'required|array',
            'unit_prices.*' => 'numeric|min:0',
        ]);

        // Create the batch
        $batch = Batch::create([
            'name' => $validated['name'],
            'reference_code' => $validated['reference_code'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'available_from' => $validated['available_from'],
            'available_until' => $validated['available_until'],
            'total_price' => 0, // Will be calculated after attaching products
            'total_quantity' => 0, // Will be calculated after attaching products
        ]);

        // Attach products to the batch
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($validated['products'] as $index => $productId) {
            $quantity = $validated['quantities'][$index];
            $unitPrice = $validated['unit_prices'][$index];
            
            $batch->products()->attach($productId, [
                'quantity' => $quantity,
                'unit_price' => $unitPrice
            ]);
            
            $totalPrice += $unitPrice * $quantity;
            $totalQuantity += $quantity;
        }

        // Update batch totals
        $batch->update([
            'total_price' => $totalPrice,
            'total_quantity' => $totalQuantity
        ]);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch created successfully.');
    }

    /**
     * Display the specified batch.
     */
    public function show(Batch $batch)
    {
        $batch->load('products');
        return view('admin.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified batch.
     */
    public function edit(Batch $batch)
    {
        $products = Product::where('quantity', '>', 0)->get();
        $batchProducts = $batch->products()->get();
        return view('admin.batches.edit', compact('batch', 'products', 'batchProducts'));
    }

    /**
     * Update the specified batch in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,reserved,sold',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'quantities' => 'required|array',
            'quantities.*' => 'integer|min:1',
            'unit_prices' => 'required|array',
            'unit_prices.*' => 'numeric|min:0',
        ]);

        // Update the batch
        $batch->update([
            'name' => $validated['name'],
            'reference_code' => $validated['reference_code'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'available_from' => $validated['available_from'],
            'available_until' => $validated['available_until'],
        ]);

        // Detach all products
        $batch->products()->detach();

        // Attach products to the batch
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($validated['products'] as $index => $productId) {
            $quantity = $validated['quantities'][$index];
            $unitPrice = $validated['unit_prices'][$index];
            
            $batch->products()->attach($productId, [
                'quantity' => $quantity,
                'unit_price' => $unitPrice
            ]);
            
            $totalPrice += $unitPrice * $quantity;
            $totalQuantity += $quantity;
        }

        // Update batch totals
        $batch->update([
            'total_price' => $totalPrice,
            'total_quantity' => $totalQuantity
        ]);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch updated successfully.');
    }

    /**
     * Remove the specified batch from storage.
     */
    public function destroy(Batch $batch)
    {
        $batch->products()->detach();
        $batch->delete();

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch deleted successfully.');
    }
}

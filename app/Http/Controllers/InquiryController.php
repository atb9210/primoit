<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Store a newly created inquiry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);
        
        Inquiry::create($validated);
        
        return back()->with('success', 'Your inquiry has been submitted. We will contact you soon.');
    }
    
    /**
     * Store a newly created product inquiry.
     */
    public function storeProductInquiry(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);
        
        $validated['product_id'] = $product->id;
        
        Inquiry::create($validated);
        
        return back()->with('success', 'Your inquiry about this product has been submitted. We will contact you soon.');
    }
}

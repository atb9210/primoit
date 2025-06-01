<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::available()->with('primaryImage', 'category');
        
        // Apply category filter
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Apply condition filter
        if ($request->has('condition') && $request->condition) {
            $query->where('condition', $request->condition);
        }
        
        // Search term
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('batch_number', 'like', "%{$search}%");
            });
        }
        
        $products = $query->latest()->paginate(12);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Load product with relationships
        $product->load('specifications', 'images', 'category');
        
        // Get related products from the same category
        $relatedProducts = Product::available()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('primaryImage')
            ->take(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }
    
    /**
     * Reserve a product.
     */
    public function reserve(Request $request, Product $product)
    {
        // Check if product is available
        if ($product->status !== 'available') {
            return back()->with('error', 'This product is no longer available.');
        }
        
        // Check minimum order quantity
        $quantity = $request->quantity ?? 1;
        if ($quantity < $product->min_order_quantity) {
            return back()->with('error', "Minimum order quantity is {$product->min_order_quantity}");
        }
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total_amount' => $product->price * $quantity,
            'notes' => $request->notes
        ]);
        
        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price
        ]);
        
        // Update product status
        $product->update(['status' => 'reserved']);
        
        return redirect()->route('my-reservations')->with('success', 'Product reserved successfully. We will contact you soon.');
    }
    
    /**
     * Display user's reservations.
     */
    public function myReservations()
    {
        $orders = Auth::user()->orders()->with('items.product.primaryImage')->latest()->get();
        
        return view('products.reservations', compact('orders'));
    }
}

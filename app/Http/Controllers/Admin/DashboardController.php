<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get recent stats
        $totalProducts = Product::count();
        $availableProducts = Product::where('status', 'available')->count();
        $reservedProducts = Product::where('status', 'reserved')->count();
        $soldProducts = Product::where('status', 'sold')->count();
        
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        $totalCustomers = User::where('role', 'customer')->count();
        $pendingApproval = User::where('role', 'customer')->where('is_approved', false)->count();
        
        $newInquiries = Inquiry::where('status', 'new')->count();
        
        // Get recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Get recent inquiries
        $recentInquiries = Inquiry::with('product')
            ->latest()
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalProducts', 
            'availableProducts', 
            'reservedProducts', 
            'soldProducts',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalCustomers',
            'pendingApproval',
            'newInquiries',
            'recentOrders',
            'recentInquiries'
        ));
    }
}

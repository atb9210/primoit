<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        // Get active and available batches for the homepage
        $featuredBatches = Batch::with('products')
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('available_until')
                    ->orWhere('available_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('available_from')
                    ->orWhere('available_from', '<=', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            
        return view('home', compact('featuredBatches'));
    }
    
    /**
     * Display the about us page.
     */
    public function about()
    {
        return view('about');
    }
    
    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('contact');
    }
    
    /**
     * Display the terms of service page.
     */
    public function terms()
    {
        return view('terms');
    }
    
    /**
     * Display the privacy policy page.
     */
    public function privacy()
    {
        return view('privacy');
    }
    
    /**
     * Display the cookie policy page.
     */
    public function cookies()
    {
        return view('cookies');
    }
}

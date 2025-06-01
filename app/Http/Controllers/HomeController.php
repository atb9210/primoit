<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $featuredProducts = Product::available()
            ->with('primaryImage')
            ->latest()
            ->take(6)
            ->get();
            
        return view('home', compact('featuredProducts'));
    }
    
    /**
     * Display the about page
     */
    public function about()
    {
        return view('about');
    }
    
    /**
     * Display the how it works page
     */
    public function howItWorks()
    {
        return view('how-it-works');
    }
    
    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('contact');
    }
}

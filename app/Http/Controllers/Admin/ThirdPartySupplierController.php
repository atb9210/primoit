<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThirdPartySupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ThirdPartySupplierController extends Controller
{
    /**
     * Display a listing of the suppliers.
     */
    public function index()
    {
        $suppliers = ThirdPartySupplier::orderBy('name')->get();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new supplier.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created supplier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'integration_type' => 'required|in:api,scraping,manual,other',
            'is_active' => 'nullable|boolean',
        ]);
        
        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('supplier-logos', 'public');
            $validated['logo'] = $path;
        }
        
        // Set is_active default value
        $validated['is_active'] = $request->has('is_active');
        
        $supplier = ThirdPartySupplier::create($validated);
        
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified supplier.
     */
    public function show(ThirdPartySupplier $supplier)
    {
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified supplier.
     */
    public function edit(ThirdPartySupplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified supplier in storage.
     */
    public function update(Request $request, ThirdPartySupplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'integration_type' => 'required|in:api,scraping,manual,other',
            'is_active' => 'nullable|boolean',
        ]);
        
        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($supplier->logo) {
                Storage::disk('public')->delete($supplier->logo);
            }
            
            $path = $request->file('logo')->store('supplier-logos', 'public');
            $validated['logo'] = $path;
        }
        
        // Set is_active value
        $validated['is_active'] = $request->has('is_active');
        
        $supplier->update($validated);
        
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified supplier from storage.
     */
    public function destroy(ThirdPartySupplier $supplier)
    {
        // Delete logo if exists
        if ($supplier->logo) {
            Storage::disk('public')->delete($supplier->logo);
        }
        
        $supplier->delete();
        
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    /**
     * Show the form for configuring supplier credentials.
     */
    public function configureCredentials(ThirdPartySupplier $supplier)
    {
        return view('admin.suppliers.configure', compact('supplier'));
    }

    /**
     * Update the supplier credentials.
     */
    public function updateCredentials(Request $request, ThirdPartySupplier $supplier)
    {
        $validated = $request->validate([
            'credentials' => 'required|array',
            'logo' => 'nullable|image|max:2048',
        ]);
        
        $updateData = ['credentials' => $validated['credentials']];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($supplier->logo) {
                Storage::disk('public')->delete($supplier->logo);
            }
            
            $path = $request->file('logo')->store('supplier-logos', 'public');
            $updateData['logo'] = $path;
        }
        
        $supplier->update($updateData);
        
        return redirect()->route('admin.suppliers.index')->with('success', 'Credentials updated successfully.');
    }

    /**
     * Show the ITSale.pl scraping interface.
     */
    public function showItsaleScraper(ThirdPartySupplier $supplier)
    {
        // Check if this is actually ITSale.pl supplier
        if ($supplier->slug !== 'itsale-pl') {
            return redirect()->route('admin.suppliers.index')
                ->with('error', 'This scraper is only available for ITSale.pl');
        }
        
        // Redirect to dedicated ITSale controller
        return redirect()->route('admin.itsale.index', $supplier);
    }
}

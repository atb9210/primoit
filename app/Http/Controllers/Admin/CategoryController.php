<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon_svg' => 'nullable|string',
            'icon_image' => 'nullable|image|max:2048', // Max 2MB
            'attributes_json' => 'nullable|string',
        ]);
        
        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Process icon image if uploaded
        if ($request->hasFile('icon_image')) {
            $path = $request->file('icon_image')->store('category-icons', 'public');
            $validated['icon_image'] = $path;
        }
        
        // Process attributes
        $attributes = $request->input('attributes', []);
        
        // Add additional JSON attributes if provided
        if (!empty($validated['attributes_json'])) {
            try {
                $jsonAttributes = json_decode($validated['attributes_json'], true);
                if (is_array($jsonAttributes)) {
                    $attributes = array_merge($attributes, $jsonAttributes);
                }
            } catch (\Exception $e) {
                // If JSON parsing fails, continue without the additional attributes
            }
        }
        
        // Convert portable attribute to boolean if it exists
        if (isset($attributes['portable'])) {
            $attributes['portable'] = $attributes['portable'] == '1';
        }
        
        // Remove attributes_json from validated data as it's not a column
        unset($validated['attributes_json']);
        
        // Set the attributes field
        $validated['attributes'] = !empty($attributes) ? $attributes : null;
        
        $category = Category::create($validated);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category, Request $request)
    {
        $configureParams = $request->query('configure') === 'params';
        return view('admin.categories.edit', compact('category', 'configureParams'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon_svg' => 'nullable|string',
            'icon_image' => 'nullable|image|max:2048', // Max 2MB
            'attributes_json' => 'nullable|string',
        ]);
        
        // Process attributes
        $attributes = $category->attributes ?? [];
        
        // Check if we're updating parameters
        if ($request->has('parameters')) {
            $parameters = array_filter($request->input('parameters', []), function($value) {
                return !empty(trim($value));
            });
            
            // Save parameters to attributes
            $attributes['parameters'] = array_values($parameters);
            
            // If this is a parameters update, don't update other fields
            if ($request->query('configure') === 'params') {
                $category->attributes = $attributes;
                $category->save();
                
                return redirect()->route('admin.categories.index')
                    ->with('success', 'Category parameters updated successfully.');
            }
        }
        
        // Continue with normal update if not a parameters update
        
        // Generate slug from name
        $validated['slug'] = Str::slug($validated['name']);
        
        // Process icon image if uploaded
        if ($request->hasFile('icon_image')) {
            // Delete old image if exists
            if ($category->icon_image) {
                Storage::disk('public')->delete($category->icon_image);
            }
            
            $path = $request->file('icon_image')->store('category-icons', 'public');
            $validated['icon_image'] = $path;
        }
        
        // Add form attributes
        $formAttributes = $request->input('attributes', []);
        
        // Add additional JSON attributes if provided
        if (!empty($validated['attributes_json'])) {
            try {
                $jsonAttributes = json_decode($validated['attributes_json'], true);
                if (is_array($jsonAttributes)) {
                    $attributes = array_merge($attributes, $jsonAttributes);
                }
            } catch (\Exception $e) {
                // If JSON parsing fails, continue without the additional attributes
            }
        }
        
        // Merge form attributes
        $attributes = array_merge($attributes, $formAttributes);
        
        // Convert portable attribute to boolean if it exists
        if (isset($attributes['portable'])) {
            $attributes['portable'] = $attributes['portable'] == '1';
        }
        
        // Remove attributes_json from validated data as it's not a column
        unset($validated['attributes_json']);
        
        // Set the attributes field
        $validated['attributes'] = !empty($attributes) ? $attributes : null;
        
        $category->update($validated);
        
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category that has products.');
        }
        
        // Delete icon image if exists
        if ($category->icon_image) {
            Storage::disk('public')->delete($category->icon_image);
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}

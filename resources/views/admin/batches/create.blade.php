<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Batch') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.batches.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Batches') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.batches.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Basic Batch Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch Information</h3>
                                
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="reference_code" class="block text-sm font-medium text-gray-700 mb-1">Reference Code</label>
                                    <input type="text" name="reference_code" id="reference_code" value="{{ old('reference_code') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('reference_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                                        <select name="category_id" id="category_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select a category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="unit_quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                        <input type="number" name="unit_quantity" id="unit_quantity" value="{{ old('unit_quantity', 1) }}" min="1" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('unit_quantity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-1">Unit Price (€) *</label>
                                        <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', 0) }}" min="0" step="0.01" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('unit_price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                        <select name="status" id="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="available_from" class="block text-sm font-medium text-gray-700 mb-1">Available From</label>
                                        <input type="date" name="available_from" id="available_from" value="{{ old('available_from') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('available_from')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="available_until" class="block text-sm font-medium text-gray-700 mb-1">Available Until</label>
                                        <input type="date" name="available_until" id="available_until" value="{{ old('available_until') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('available_until')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Images Section -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Images</h3>
                                
                                <div class="mb-4">
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload files</span>
                                                    <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="image-preview-container" class="mt-2 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Image Preview</label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="image-preview">
                                        <!-- Image previews will be inserted here -->
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Click on an image to set it as default</p>
                                    <input type="hidden" name="default_image_index" id="default_image_index" value="{{ old('default_image_index', 0) }}">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Batch Source -->
                        <div class="mt-6 bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch Source</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="source_type" class="block text-sm font-medium text-gray-700 mb-1">Source Type</label>
                                    <select name="source_type" id="source_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleSupplierField()">
                                        <option value="internal" {{ old('source_type') == 'internal' ? 'selected' : '' }}>Internal (Our Stock)</option>
                                        <option value="external" {{ old('source_type') == 'external' ? 'selected' : '' }}>External (3rd Party Supplier)</option>
                                    </select>
                                    @error('source_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div id="supplier_container">
                                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                                    <select name="supplier" id="supplier" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select a supplier</option>
                                        <option value="ITSale" {{ old('supplier') == 'ITSale' ? 'selected' : '' }}>ITSale</option>
                                        <option value="Foxway" {{ old('supplier') == 'Foxway' ? 'selected' : '' }}>Foxway</option>
                                        <option value="Ecorefurb" {{ old('supplier') == 'Ecorefurb' ? 'selected' : '' }}>Ecorefurb</option>
                                        <option value="Other" {{ old('supplier') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('supplier')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-1 md:col-span-2">
                                    <label for="source_reference" class="block text-sm font-medium text-gray-700 mb-1">Source Reference</label>
                                    <input type="text" name="source_reference" id="source_reference" value="{{ old('source_reference') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Supplier reference number, invoice, or link">
                                    @error('source_reference')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="batch_cost" class="block text-sm font-medium text-gray-700 mb-1">Batch Cost (€)</label>
                                    <input type="number" name="batch_cost" id="batch_cost" value="{{ old('batch_cost', 0) }}" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('batch_cost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost (€)</label>
                                    <input type="number" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', 0) }}" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('shipping_cost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="tax_amount" class="block text-sm font-medium text-gray-700 mb-1">Tax Amount (€)</label>
                                    <input type="number" name="tax_amount" id="tax_amount" value="{{ old('tax_amount', 0) }}" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tax_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="total_cost" class="block text-sm font-medium text-gray-700 mb-1">Total Cost (€)</label>
                                    <input type="number" name="total_cost" id="total_cost" value="{{ old('total_cost', 0) }}" step="0.01" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" readonly>
                                    <p class="text-xs text-gray-500 mt-1">This value is calculated automatically.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Product Batch Parameters -->
                        <div class="mt-8 border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Product Batch Parameters</h3>
                                <button type="button" id="add-parameter" class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Parameter
                                </button>
                            </div>
                            
                            <!-- Fixed Parameters Input (Hidden) -->
                            <div class="hidden">
                                <input type="text" name="product_manufacturer" id="product_manufacturer" value="{{ old('product_manufacturer') }}" required>
                                <input type="text" name="product_model" id="product_model" value="{{ old('product_model') }}" required>
                                <select name="condition_grade" id="condition_grade">
                                    <option value="">None</option>
                                    <option value="A" {{ old('condition_grade') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('condition_grade') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('condition_grade') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('condition_grade') == 'D' ? 'selected' : '' }}>D</option>
                                </select>
                                <input type="number" name="price" id="price" value="{{ old('price', 0) }}" step="0.01" min="0">
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1">
                                <select name="tech_grade" id="tech_grade">
                                    <option value="Working" {{ old('tech_grade') == 'Working' ? 'selected' : '' }}>Working</option>
                                    <option value="Working*" {{ old('tech_grade') == 'Working*' ? 'selected' : '' }}>Working*</option>
                                    <option value="Not Working" {{ old('tech_grade') == 'Not Working' ? 'selected' : '' }}>Not Working</option>
                                </select>
                            </div>
                            
                            <!-- Required Parameters as Tags -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Required Parameters</h4>
                                
                                <div class="flex flex-wrap items-center gap-3">
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full flex items-center">
                                        <span class="text-sm">Manufacturer</span>
                                    </div>
                                    
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full flex items-center">
                                        <span class="text-sm">Model</span>
                                    </div>
                                    
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full flex items-center">
                                        <span class="text-sm">Grade</span>
                                    </div>
                                    
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full flex items-center">
                                        <span class="text-sm">Price</span>
                                    </div>
                                    
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full flex items-center">
                                        <span class="text-sm">Quantity</span>
                                    </div>
                                    
                                    <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full flex items-center">
                                        <span class="text-sm">Tech Grade</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dynamic Parameters Section (Additional) -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Additional Parameters</h4>
                                <p class="text-xs text-gray-500 mb-4">Add parameters as simple tags. Each parameter will be stored as a key in JSON data.</p>
                                
                                <div id="dynamic-parameters" class="flex flex-wrap gap-2 mb-4">
                                    <!-- Existing parameters will be displayed here -->
                                    @if(old('param_keys'))
                                        @foreach(old('param_keys') as $index => $key)
                                            <div class="dynamic-param-tag bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full flex items-center">
                                                <span class="text-sm mr-2">{{ $key }}</span>
                                                <input type="hidden" name="param_keys[]" value="{{ $key }}">
                                                <input type="hidden" name="param_values[]" value="true">
                                                <button type="button" class="remove-param text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="text" id="new-param-input" placeholder="Type a parameter name and press Enter" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Parameter Suggestions Based on Category -->
                        <div class="mt-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="text-sm font-semibold text-blue-700 mb-2">Suggested Parameters</h4>
                                <div id="suggested-params" class="text-sm text-blue-600">
                                    <p>Select a category to see suggested parameters.</p>
                                </div>
                                <div class="mt-2">
                                    <button type="button" id="add-suggested-params" class="text-xs text-blue-700 font-medium hover:text-blue-900 hidden">
                                        <span class="underline">Add all suggested parameters</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Images -->
                        <div class="mt-8 border-t pt-6 hidden">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Images</h3>
                            
                            <div class="mb-6">
                                <label for="images-hidden" class="block text-sm font-medium text-gray-700 mb-1">Upload Images</label>
                                <input type="file" name="images-hidden[]" id="images-hidden" multiple accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">You can upload multiple images. Maximum size: 2MB per image.</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" id="save-batch-btn" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Batch
                            </button>
                        </div>
                    </form>
                    
                    <!-- Template for new parameters (hidden) -->
                    <template id="param-tag-template">
                        <div class="dynamic-param-tag bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full flex items-center">
                            <span class="text-sm mr-2"></span>
                            <input type="hidden" name="param_keys[]">
                            <input type="hidden" name="param_values[]" value="true">
                            <button type="button" class="remove-param text-blue-600 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const dynamicParamsContainer = document.getElementById('dynamic-parameters');
            const paramTemplate = document.getElementById('param-tag-template');
            const addParamButton = document.getElementById('add-parameter');
            const newParamInput = document.getElementById('new-param-input');
            const suggestedParamsContainer = document.getElementById('suggested-params');
            const addSuggestedParamsButton = document.getElementById('add-suggested-params');
            
            // Fixed parameters handling
            const manufacturerInput = document.getElementById('product_manufacturer');
            const modelInput = document.getElementById('product_model');
            const gradeSelect = document.getElementById('condition_grade');
            
            // Image preview functionality
            const imageInput = document.getElementById('images');
            const imagePreviewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');
            const defaultImageIndex = document.getElementById('default_image_index');
            
            // Batch Source fields
            const sourceTypeSelect = document.getElementById('source_type');
            const supplierContainer = document.getElementById('supplier_container');
            const batchCostInput = document.getElementById('batch_cost');
            const shippingCostInput = document.getElementById('shipping_cost');
            const taxAmountInput = document.getElementById('tax_amount');
            const totalCostInput = document.getElementById('total_cost');
            
            // Toggle supplier field based on source type
            function toggleSupplierField() {
                if (sourceTypeSelect.value === 'internal') {
                    supplierContainer.classList.add('hidden');
                } else {
                    supplierContainer.classList.remove('hidden');
                }
            }
            
            // Calculate total cost
            function calculateTotalCost() {
                const batchCost = parseFloat(batchCostInput.value) || 0;
                const shippingCost = parseFloat(shippingCostInput.value) || 0;
                const taxAmount = parseFloat(taxAmountInput.value) || 0;
                
                const total = batchCost + shippingCost + taxAmount;
                totalCostInput.value = total.toFixed(2);
            }
            
            // Add event listeners for cost calculations
            if (batchCostInput) {
                batchCostInput.addEventListener('input', calculateTotalCost);
            }
            
            if (shippingCostInput) {
                shippingCostInput.addEventListener('input', calculateTotalCost);
            }
            
            if (taxAmountInput) {
                taxAmountInput.addEventListener('input', calculateTotalCost);
            }
            
            // Initialize supplier field visibility
            toggleSupplierField();
            
            // Initialize total cost calculation
            calculateTotalCost();
            
            // Add event listener for source type changes
            if (sourceTypeSelect) {
                sourceTypeSelect.addEventListener('change', toggleSupplierField);
            }
            
            // Rendi il campo unit_quantity readonly poiché ora è calcolato automaticamente
            const unitQuantityInput = document.getElementById('unit_quantity');
            unitQuantityInput.readOnly = true;
            unitQuantityInput.classList.add('bg-gray-100');
            unitQuantityInput.value = 0; // Inizialmente zero, verrà aggiornato quando si aggiungono prodotti
            
            // Aggiungi una nota che spiega che il campo è calcolato automaticamente
            const quantityNote = document.createElement('p');
            quantityNote.className = 'text-xs text-gray-500 mt-1';
            quantityNote.textContent = 'Questo valore viene calcolato automaticamente in base alla somma delle quantità dei prodotti.';
            unitQuantityInput.parentNode.appendChild(quantityNote);
            
            // Image preview functionality
            imageInput.addEventListener('change', function() {
                // Clear the preview
                imagePreview.innerHTML = '';
                
                if (this.files && this.files.length > 0) {
                    imagePreviewContainer.classList.remove('hidden');
                    
                    // Create previews for each image
                    Array.from(this.files).forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative group cursor-pointer border rounded-md overflow-hidden';
                            div.dataset.index = index;
                            
                            // Check if this is the default image
                            const isDefault = parseInt(defaultImageIndex.value) === index;
                            
                            // Add a border if it's the default image
                            if (isDefault) {
                                div.classList.add('ring-2', 'ring-indigo-500');
                            }
                            
                            div.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" class="h-24 w-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-white text-xs font-medium">Set as default</p>
                                </div>
                                ${isDefault ? '<div class="absolute top-0 right-0 bg-indigo-500 text-white text-xs px-2 py-1">Default</div>' : ''}
                            `;
                            
                            div.addEventListener('click', function() {
                                // Remove highlight from all images
                                document.querySelectorAll('#image-preview > div').forEach(el => {
                                    el.classList.remove('ring-2', 'ring-indigo-500');
                                    el.querySelector('.absolute.top-0.right-0')?.remove();
                                });
                                
                                // Highlight this one
                                this.classList.add('ring-2', 'ring-indigo-500');
                                
                                // Add the "Default" badge
                                if (!this.querySelector('.absolute.top-0.right-0')) {
                                    const badge = document.createElement('div');
                                    badge.className = 'absolute top-0 right-0 bg-indigo-500 text-white text-xs px-2 py-1';
                                    badge.textContent = 'Default';
                                    this.appendChild(badge);
                                }
                                
                                // Update the hidden input
                                defaultImageIndex.value = this.dataset.index;
                            });
                            
                            imagePreview.appendChild(div);
                        };
                        
                        reader.readAsDataURL(file);
                    });
                } else {
                    imagePreviewContainer.classList.add('hidden');
                }
            });
            
            // Add parameter when Enter is pressed in the input
            newParamInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const paramKey = this.value.trim();
                    if (paramKey) {
                        addParamTag(paramKey);
                        this.value = '';
                    }
                }
            });
            
            // Add parameter when Add Parameter button is clicked
            addParamButton.addEventListener('click', function() {
                const paramKey = newParamInput.value.trim();
                if (paramKey) {
                    addParamTag(paramKey);
                    newParamInput.value = '';
                } else {
                    newParamInput.focus();
                }
            });
            
            // Remove parameter tag when button is clicked
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-param')) {
                    e.target.closest('.dynamic-param-tag').remove();
                }
            });
            
            // Show suggested parameters based on category
            function updateSuggestedParams() {
                const categoryId = categorySelect.value;
                
                // Clear current suggestions
                suggestedParamsContainer.innerHTML = '';
                addSuggestedParamsButton.classList.add('hidden');
                
                if (!categoryId) {
                    suggestedParamsContainer.innerHTML = '<p>Select a category to see suggested parameters.</p>';
                    return;
                }

                // Find the selected category name
                const selectedCategory = categorySelect.options[categorySelect.selectedIndex].text;
                
                let suggestions = [];
                
                // Suggest parameters based on category
                if (selectedCategory.includes('LAPTOP') || selectedCategory.includes('MACBOOK') || selectedCategory.includes('PC')) {
                    suggestions = [
                        'CPU',
                        'RAM',
                        'Storage',
                        'GPU',
                        'OS',
                        'Screen Size',
                        'Screen Resolution'
                    ];
                } else if (selectedCategory.includes('SMARTPHONE') || selectedCategory.includes('TABLET')) {
                    suggestions = [
                        'Internal Memory',
                        'RAM',
                        'Camera',
                        'Battery Capacity',
                        'OS',
                        'Screen Size'
                    ];
                } else if (selectedCategory.includes('HDD') || selectedCategory.includes('SSD') || selectedCategory.includes('STORAGE')) {
                    suggestions = [
                        'Capacity',
                        'Type',
                        'Interface',
                        'Speed'
                    ];
                }
                
                if (suggestions.length > 0) {
                    const list = document.createElement('ul');
                    list.className = 'list-disc list-inside';
                    
                    suggestions.forEach(suggestion => {
                        const item = document.createElement('li');
                        item.textContent = suggestion;
                        list.appendChild(item);
                    });
                    
                    suggestedParamsContainer.appendChild(list);
                    addSuggestedParamsButton.classList.remove('hidden');
                    
                    // Add event listener to "Add all suggested parameters" button
                    addSuggestedParamsButton.onclick = function() {
                        suggestions.forEach(suggestion => {
                            addParamTag(suggestion);
                        });
                    };
                } else {
                    suggestedParamsContainer.innerHTML = '<p>No specific parameters suggested for this category.</p>';
                }
            }
            
            categorySelect.addEventListener('change', updateSuggestedParams);
            
            // Initialize on page load
            updateSuggestedParams();
            
            // Initialize event listeners for existing remove buttons
            document.querySelectorAll('.dynamic-param-tag .remove-param').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.dynamic-param-tag').remove();
                });
            });
            
            // Modifica per compilare automaticamente i campi nascosti richiesti
            const saveButton = document.getElementById('save-batch-btn');
            
            saveButton.addEventListener('click', function(e) {
                // Impedisci l'invio del form se mancano valori nei campi nascosti obbligatori
                if (!manufacturerInput.value) {
                    manufacturerInput.value = "Apple"; // Valore predefinito
                }
                
                if (!modelInput.value) {
                    modelInput.value = "iPhone"; // Valore predefinito
                }
                
                if (!gradeSelect.value) {
                    gradeSelect.value = "A"; // Valore predefinito
                }
                
                // Continua con l'invio del form
                return true;
            });
            
            // Add parameter tag
            function addParamTag(key) {
                if (!key || key.trim() === '') return;
                
                // Check if the parameter already exists
                const existingParams = Array.from(dynamicParamsContainer.querySelectorAll('input[name="param_keys[]"]')).map(input => input.value);
                if (existingParams.includes(key)) return;
                
                const newTag = paramTemplate.content.cloneNode(true);
                const tagSpan = newTag.querySelector('span');
                const tagInput = newTag.querySelector('input[name="param_keys[]"]');
                
                tagSpan.textContent = key;
                tagInput.value = key;
                
                // Add event listener to remove button
                const removeButton = newTag.querySelector('.remove-param');
                removeButton.addEventListener('click', function() {
                    this.closest('.dynamic-param-tag').remove();
                });
                
                // Append to container
                dynamicParamsContainer.appendChild(newTag);
            }
            
            // Calculate total price based on unit price and quantity
            const unitPriceInput = document.getElementById('unit_price');
            
            function updateTotalPrice() {
                const quantity = parseFloat(unitQuantityInput.value) || 0;
                const price = parseFloat(unitPriceInput.value) || 0;
                const total = quantity * price;
                
                // You can update a total display element here if needed
            }
            
            // Nuova funzione per sincronizzare la quantità totale del batch con la somma delle quantità dei prodotti
            function syncBatchQuantityWithProducts() {
                // Nella pagina di creazione non ci sono ancora prodotti, quindi questa funzione
                // verrà utile principalmente quando si aggiungeranno prodotti dinamicamente
                
                // Per ora, imposta il valore a 0 dato che non ci sono prodotti
                unitQuantityInput.value = 0;
                
                // In futuro, se si aggiunge supporto per l'aggiunta di prodotti durante la creazione,
                // qui aggiungeremo il codice per calcolare la somma delle quantità
                
                // Aggiorna anche il prezzo totale
                updateTotalPrice();
            }
            
            unitPriceInput.addEventListener('input', updateTotalPrice);
            
            // Inizializza la sincronizzazione
            syncBatchQuantityWithProducts();
        });
    </script>
</x-admin-layout> 
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

            <!-- Errori di upload delle immagini -->
            @if ($errors->has('upload_errors'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-red-700 mb-1">Errori nel caricamento delle immagini:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->get('upload_errors') as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
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
                                    <input type="text" name="reference_code" id="reference_code" value="{{ old('reference_code') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Lascia vuoto per generazione automatica (BT-0001 + ID)">
                                    <p class="text-xs text-gray-500 mt-1">Se lasciato vuoto, verrà generato automaticamente nel formato BT-0001 seguito dall'ID del batch.</p>
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
                                        <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', 0) }}" min="0" step="0.01" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" readonly>
                                        <p class="text-xs text-gray-500 mt-1">Questo valore viene calcolato automaticamente in base al prezzo totale e alla quantità.</p>
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
                                    <!-- Debug info per drag and drop -->
                                    <div id="drag-drop-debug" class="mt-2 p-2 bg-gray-50 border border-gray-200 rounded text-sm">
                                        <p class="font-medium text-gray-700">File selezionati:</p>
                                        <div id="debug-info" class="text-xs text-gray-600 mt-1">Nessun file selezionato</div>
                                    </div>
                                    <!-- Controllo dimensione immagini e compressione -->
                                    <div id="image-size-control" class="mt-3 hidden">
                                        <div class="bg-yellow-50 p-3 rounded-md border border-yellow-200">
                                            <p class="text-sm font-medium text-yellow-800">Attenzione: alcune immagini superano i 2MB</p>
                                            <p class="text-xs text-yellow-700 mt-1">Le immagini troppo grandi potrebbero non essere caricate correttamente.</p>
                                            <button type="button" id="compress-images" class="mt-2 inline-flex items-center px-3 py-1.5 border border-yellow-300 text-xs font-medium rounded-md text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Comprimi immagini
                                            </button>
                                            <div id="compression-progress" class="mt-2 hidden">
                                                <div class="w-full bg-yellow-200 rounded-full h-1.5">
                                                    <div id="compression-bar" class="bg-yellow-500 h-1.5 rounded-full" style="width: 0%"></div>
                                                </div>
                                                <p id="compression-status" class="text-xs text-yellow-700 mt-1">Compressione in corso...</p>
                                            </div>
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
                                
                                <div x-data="{ 
                                    profitMargin: {{ old('profit_margin', 16) }},
                                    totalCost: {{ old('total_cost', 0) }},
                                    salePrice: {{ old('sale_price', 0) }},
                                    calculateSalePrice() {
                                        if (this.totalCost > 0 && this.profitMargin > 0) {
                                            this.salePrice = (this.totalCost * (1 + (this.profitMargin / 100))).toFixed(2);
                                        }
                                    },
                                    calculateMargin() {
                                        if (this.totalCost > 0 && this.salePrice > 0) {
                                            this.profitMargin = (((this.salePrice / this.totalCost) - 1) * 100).toFixed(0);
                                        }
                                    }
                                }" 
                                x-init="
                                    totalCost = parseFloat(document.getElementById('total_cost').value) || 0;
                                    $watch('totalCost', value => calculateSalePrice());
                                    $watch('profitMargin', value => calculateSalePrice());
                                    $watch('salePrice', value => calculateMargin());
                                    
                                    // Aggiungi listener per aggiornare totalCost quando cambia il campo nel DOM
                                    document.getElementById('total_cost').addEventListener('change', function() {
                                        totalCost = parseFloat(this.value) || 0;
                                        calculateSalePrice();
                                    });
                                ">
                                    <label for="profit_margin" class="block text-sm font-medium text-gray-700 mb-1">Profit Margin (%)</label>
                                    <input type="number" name="profit_margin" id="profit_margin" x-model="profitMargin" min="0" step="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('profit_margin')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Sale Price (€)</label>
                                    <input type="number" name="sale_price" id="sale_price" x-model="salePrice" min="0" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" readonly>
                                    <input type="hidden" name="sale_price_backup" value="{{ old('sale_price', 0) }}">
                                    @error('sale_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                    
                    <!-- Script per calcolare automaticamente il unit_price -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const unitQuantityInput = document.getElementById("unit_quantity");
                            const unitPriceInput = document.getElementById("unit_price");
                            const salePriceInput = document.getElementById("sale_price");
                            
                            // Funzione per calcolare unit_price
                            function calculateUnitPrice() {
                                const salePrice = parseFloat(salePriceInput.value) || 0;
                                const quantity = parseFloat(unitQuantityInput.value) || 1; // Usa 1 come fallback per evitare divisioni per zero
                                
                                if (salePrice > 0 && quantity > 0) {
                                    const unitPrice = (salePrice / quantity).toFixed(2);
                                    unitPriceInput.value = unitPrice;
                                }
                            }
                            
                            // Aggiungi event listeners
                            if (unitQuantityInput) {
                                unitQuantityInput.addEventListener("input", calculateUnitPrice);
                            }
                            
                            if (salePriceInput) {
                                salePriceInput.addEventListener("input", calculateUnitPrice);
                                salePriceInput.addEventListener("change", calculateUnitPrice);
                                
                                // Quando profit_margin cambia, aspetta che sale_price venga aggiornato e poi calcola unit_price
                                const profitMarginInput = document.getElementById("profit_margin");
                                if (profitMarginInput) {
                                    profitMarginInput.addEventListener("input", function() {
                                        setTimeout(calculateUnitPrice, 100);
                                    });
                                }
                            }
                            
                            // Aggiungi event listeners per le variabili che influenzano indirettamente sale_price
                            const batchCostInput = document.getElementById("batch_cost");
                            const shippingCostInput = document.getElementById("shipping_cost");
                            const taxAmountInput = document.getElementById("tax_amount");
                            
                            if (batchCostInput) {
                                batchCostInput.addEventListener("input", function() {
                                    setTimeout(calculateUnitPrice, 200);
                                });
                            }
                            
                            if (shippingCostInput) {
                                shippingCostInput.addEventListener("input", function() {
                                    setTimeout(calculateUnitPrice, 200);
                                });
                            }
                            
                            if (taxAmountInput) {
                                taxAmountInput.addEventListener("input", function() {
                                    setTimeout(calculateUnitPrice, 200);
                                });
                            }
                            
                            // Calcola il prezzo unitario all'avvio
                            calculateUnitPrice();
                        });
                    </script>
                    
                    <!-- Script per calcolare automaticamente il sale price -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const totalCostInput = document.getElementById("total_cost");
                            const profitMarginInput = document.getElementById("profit_margin");
                            const salePriceInput = document.getElementById("sale_price");
                            
                            // Function to calculate sale price
                            function calculateSalePrice() {
                                const totalCost = parseFloat(totalCostInput.value) || 0;
                                const profitMargin = parseFloat(profitMarginInput.value) || 0;
                                
                                if (totalCost > 0 && profitMargin > 0) {
                                    const salePrice = (totalCost * (1 + (profitMargin / 100))).toFixed(2);
                                    salePriceInput.value = salePrice;
                                    
                                    // Aggiorna anche il campo backup
                                    document.querySelector('input[name="sale_price_backup"]').value = salePrice;
                                }
                            }
                            
                            // Add event listeners
                            if (profitMarginInput) {
                                profitMarginInput.addEventListener("input", calculateSalePrice);
                            }
                            
                            if (totalCostInput) {
                                totalCostInput.addEventListener("change", calculateSalePrice);
                                
                                // Triggerare l'evento change quando cambia batch_cost, shipping_cost e tax_amount
                                document.getElementById("batch_cost").addEventListener("input", function() {
                                    // Calcola il total_cost (questa funzione dovrebbe essere già definita altrove)
                                    const batchCost = parseFloat(document.getElementById("batch_cost").value) || 0;
                                    const shippingCost = parseFloat(document.getElementById("shipping_cost").value) || 0;
                                    const taxAmount = parseFloat(document.getElementById("tax_amount").value) || 0;
                                    
                                    const total = batchCost + shippingCost + taxAmount;
                                    totalCostInput.value = total.toFixed(2);
                                    
                                    setTimeout(calculateSalePrice, 50);
                                });
                                
                                document.getElementById("shipping_cost").addEventListener("input", function() {
                                    // Calcola il total_cost
                                    const batchCost = parseFloat(document.getElementById("batch_cost").value) || 0;
                                    const shippingCost = parseFloat(document.getElementById("shipping_cost").value) || 0;
                                    const taxAmount = parseFloat(document.getElementById("tax_amount").value) || 0;
                                    
                                    const total = batchCost + shippingCost + taxAmount;
                                    totalCostInput.value = total.toFixed(2);
                                    
                                    setTimeout(calculateSalePrice, 50);
                                });
                                
                                document.getElementById("tax_amount").addEventListener("input", function() {
                                    // Calcola il total_cost
                                    const batchCost = parseFloat(document.getElementById("batch_cost").value) || 0;
                                    const shippingCost = parseFloat(document.getElementById("shipping_cost").value) || 0;
                                    const taxAmount = parseFloat(document.getElementById("tax_amount").value) || 0;
                                    
                                    const total = batchCost + shippingCost + taxAmount;
                                    totalCostInput.value = total.toFixed(2);
                                    
                                    setTimeout(calculateSalePrice, 50);
                                });
                            }
                            
                            // Initialize on page load
                            calculateSalePrice();
                        });
                    </script>
                    
                    <!-- Script per il debug del drag and drop -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const imageInput = document.getElementById('images');
                            const debugInfo = document.getElementById('debug-info');
                            const form = document.querySelector('form');
                            const imageSizeControl = document.getElementById('image-size-control');
                            
                            // Array per tenere traccia delle immagini originali e compresse
                            let selectedFiles = [];
                            let compressedFiles = [];
                            let oversizedImages = false;
                            
                            // Mostra info quando vengono selezionati i file
                            imageInput.addEventListener('change', function(e) {
                                if (this.files && this.files.length > 0) {
                                    selectedFiles = Array.from(this.files);
                                    updateFileInfo();
                                } else {
                                    debugInfo.innerHTML = 'Nessun file selezionato';
                                    imageSizeControl.classList.add('hidden');
                                    selectedFiles = [];
                                    compressedFiles = [];
                                    oversizedImages = false;
                                }
                            });
                            
                            function updateFileInfo() {
                                let fileInfo = `<p class="text-green-600 font-medium">File selezionati: ${selectedFiles.length}</p>`;
                                oversizedImages = false;
                                
                                selectedFiles.forEach((file, index) => {
                                    const fileSizeKB = (file.size / 1024).toFixed(2);
                                    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                                    const isOversized = file.size > 2 * 1024 * 1024; // 2MB
                                    
                                    if (isOversized) {
                                        oversizedImages = true;
                                        fileInfo += `<p>File ${index + 1}: ${file.name} <span class="text-red-600 font-medium">(${fileSizeMB} MB)</span></p>`;
                                    } else {
                                        fileInfo += `<p>File ${index + 1}: ${file.name} (${fileSizeKB} KB)</p>`;
                                    }
                                });
                                
                                debugInfo.innerHTML = fileInfo;
                                
                                // Mostra il controllo dimensione se ci sono immagini troppo grandi
                                if (oversizedImages) {
                                    imageSizeControl.classList.remove('hidden');
                                } else {
                                    imageSizeControl.classList.add('hidden');
                                }
                            }
                            
                            // Intercetta l'invio del form per mostrare info
                            form.addEventListener('submit', function(e) {
                                // Se ci sono immagini troppo grandi e non sono state compresse, blocca l'invio
                                if (oversizedImages && compressedFiles.length === 0) {
                                    e.preventDefault();
                                    alert('Alcune immagini superano i 2MB. Per favore, comprimi le immagini prima di inviare il form.');
                                    return false;
                                }
                                
                                // Altrimenti continua normalmente
                                const formData = new FormData(this);
                                const hasImages = formData.getAll('images[]').some(file => file.name !== '');
                                
                                if (hasImages) {
                                    debugInfo.innerHTML += `<p class="text-blue-600 font-medium mt-2">Form inviato con ${formData.getAll('images[]').filter(file => file.name !== '').length} immagini</p>`;
                                    
                                    // Verifica che l'elemento input file abbia effettivamente i file
                                    if (imageInput.files && imageInput.files.length > 0) {
                                        debugInfo.innerHTML += `<p class="text-green-600">Input file ha ${imageInput.files.length} file</p>`;
                                    } else {
                                        debugInfo.innerHTML += `<p class="text-red-600">ATTENZIONE: Input file è vuoto nonostante FormData contenga immagini!</p>`;
                                    }
                                } else {
                                    debugInfo.innerHTML += `<p class="text-red-600 font-medium mt-2">Form inviato senza immagini</p>`;
                                }
                            });
                            
                            // Aggiungi supporto per il drag and drop
                            const dropZone = document.querySelector('.border-dashed');
                            
                            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                                dropZone.addEventListener(eventName, preventDefaults, false);
                            });
                            
                            function preventDefaults(e) {
                                e.preventDefault();
                                e.stopPropagation();
                            }
                            
                            ['dragenter', 'dragover'].forEach(eventName => {
                                dropZone.addEventListener(eventName, highlight, false);
                            });
                            
                            ['dragleave', 'drop'].forEach(eventName => {
                                dropZone.addEventListener(eventName, unhighlight, false);
                            });
                            
                            function highlight() {
                                dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
                                debugInfo.innerHTML = 'File in arrivo...';
                            }
                            
                            function unhighlight() {
                                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                            }
                            
                            dropZone.addEventListener('drop', handleDrop, false);
                            
                            function handleDrop(e) {
                                const dt = e.dataTransfer;
                                const files = dt.files;
                                
                                if (files && files.length > 0) {
                                    imageInput.files = files;
                                    selectedFiles = Array.from(files);
                                    updateFileInfo();
                                }
                            }
                            
                            // Gestione compressione immagini
                            const compressButton = document.getElementById('compress-images');
                            const compressionProgress = document.getElementById('compression-progress');
                            const compressionBar = document.getElementById('compression-bar');
                            const compressionStatus = document.getElementById('compression-status');
                            
                            compressButton.addEventListener('click', async function() {
                                if (!selectedFiles.length || !oversizedImages) return;
                                
                                // Mostra la barra di progresso
                                compressionProgress.classList.remove('hidden');
                                compressButton.disabled = true;
                                
                                // Carica la libreria browser-image-compression dinamicamente
                                if (!window.imageCompression) {
                                    const script = document.createElement('script');
                                    script.src = 'https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.js';
                                    script.async = true;
                                    
                                    script.onload = function() {
                                        compressImages();
                                    };
                                    
                                    document.head.appendChild(script);
                                } else {
                                    compressImages();
                                }
                                
                                async function compressImages() {
                                    compressedFiles = [];
                                    let processed = 0;
                                    
                                    // Opzioni di compressione
                                    const options = {
                                        maxSizeMB: 1.9, // Poco meno di 2MB per sicurezza
                                        maxWidthOrHeight: 1920, // Limita anche la dimensione
                                        useWebWorker: true,
                                        fileType: 'image/jpeg' // Converti tutto in JPEG
                                    };
                                    
                                    // Comprimi ogni immagine
                                    for (let i = 0; i < selectedFiles.length; i++) {
                                        const file = selectedFiles[i];
                                        
                                        // Salta i file che sono già abbastanza piccoli
                                        if (file.size <= 2 * 1024 * 1024) {
                                            compressedFiles.push(file);
                                            processed++;
                                            updateProgress(processed / selectedFiles.length * 100);
                                            continue;
                                        }
                                        
                                        try {
                                            compressionStatus.textContent = `Compressione ${i+1}/${selectedFiles.length}: ${file.name}`;
                                            const compressedFile = await window.imageCompression(file, options);
                                            
                                            // Crea un nuovo File con lo stesso nome ma formato .jpg
                                            const fileName = file.name.replace(/\.[^/.]+$/, "") + ".jpg";
                                            const newFile = new File([compressedFile], fileName, {
                                                type: 'image/jpeg',
                                                lastModified: new Date().getTime()
                                            });
                                            
                                            compressedFiles.push(newFile);
                                        } catch (error) {
                                            console.error('Errore durante la compressione:', error);
                                            // In caso di errore, usa il file originale
                                            compressedFiles.push(file);
                                        }
                                        
                                        processed++;
                                        updateProgress(processed / selectedFiles.length * 100);
                                    }
                                    
                                    // Aggiorna l'input file con i file compressi
                                    updateFileInputWithCompressedFiles();
                                }
                            });
                            
                            function updateProgress(percent) {
                                compressionBar.style.width = `${percent}%`;
                            }
                            
                            function updateFileInputWithCompressedFiles() {
                                if (!compressedFiles.length) return;
                                
                                // Crea un nuovo DataTransfer per aggiornare l'input file
                                const dataTransfer = new DataTransfer();
                                
                                // Aggiungi tutti i file compressi
                                compressedFiles.forEach(file => {
                                    dataTransfer.items.add(file);
                                });
                                
                                // Aggiorna l'input file
                                imageInput.files = dataTransfer.files;
                                
                                // Aggiorna la UI
                                selectedFiles = compressedFiles;
                                oversizedImages = false;
                                updateFileInfo();
                                
                                // Aggiorna lo stato della compressione
                                compressionStatus.textContent = 'Compressione completata!';
                                compressionBar.style.width = '100%';
                                
                                // Riabilita il pulsante dopo un po'
                                setTimeout(() => {
                                    compressButton.disabled = false;
                                    compressionProgress.classList.add('hidden');
                                }, 2000);
                            }
                        });
                    </script>
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
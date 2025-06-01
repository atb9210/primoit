<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Batch') }}: {{ $batch->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.batches.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Batches') }}
                </a>
                <a href="{{ route('admin.batches.show', $batch) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ __('View Batch') }}
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
                    <form action="{{ route('admin.batches.update', $batch) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Batch Basic Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch Information</h3>
                                
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $batch->name) }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="reference_code" class="block text-sm font-medium text-gray-700 mb-1">Reference Code</label>
                                    <input type="text" name="reference_code" id="reference_code" value="{{ old('reference_code', $batch->reference_code) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('reference_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $batch->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Batch Status and Availability -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status & Availability</h3>
                                
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                                    <select name="status" id="status" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="draft" {{ old('status', $batch->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="active" {{ old('status', $batch->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="reserved" {{ old('status', $batch->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                        <option value="sold" {{ old('status', $batch->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="available_from" class="block text-sm font-medium text-gray-700 mb-1">Available From</label>
                                    <input type="date" name="available_from" id="available_from" value="{{ old('available_from', $batch->available_from ? $batch->available_from->format('Y-m-d') : '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('available_from')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="available_until" class="block text-sm font-medium text-gray-700 mb-1">Available Until</label>
                                    <input type="date" name="available_until" id="available_until" value="{{ old('available_until', $batch->available_until ? $batch->available_until->format('Y-m-d') : '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('available_until')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Products Section -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Products in this Batch</h3>
                            
                            <div class="mb-4 flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    Current total: <span class="font-medium">@formatPrice($batch->total_price)</span> / 
                                    <span class="font-medium">{{ $batch->total_quantity }}</span> units
                                </div>
                                <button type="button" id="add-product-row" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Product
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200" id="products-table">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price (€)</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="product-rows">
                                        @foreach($batchProducts as $index => $product)
                                            <tr class="product-row">
                                                <td class="px-4 py-3">
                                                    <select name="products[]" class="product-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                        <option value="">Select a product</option>
                                                        @foreach($products as $availableProduct)
                                                            <option value="{{ $availableProduct->id }}" {{ $product->id == $availableProduct->id ? 'selected' : '' }}>
                                                                {{ $availableProduct->producer }} {{ $availableProduct->model }} ({{ $availableProduct->quantity }} available)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="quantities[]" value="{{ $product->pivot->quantity }}" min="1" class="quantity-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="unit_prices[]" value="{{ (float)$product->pivot->unit_price }}" min="0" step="0.01" class="price-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="row-total text-sm font-medium text-gray-900">
                                                        €{{ number_format((float)$product->pivot->unit_price * $product->pivot->quantity, 2) }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <button type="button" class="remove-row text-red-600 hover:text-red-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-6 flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-500">Total batch value: <span id="batch-total" class="font-medium text-gray-900"></span></p>
                                    <p class="text-sm text-gray-500">Total units: <span id="batch-quantity" class="font-medium text-gray-900"></span></p>
                                </div>
                                <div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Save Batch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cache elements
            const productRows = document.getElementById('product-rows');
            const addProductButton = document.getElementById('add-product-row');
            const batchTotalElement = document.getElementById('batch-total');
            const batchQuantityElement = document.getElementById('batch-quantity');
            
            // Function to update row total
            function updateRowTotal(row) {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const total = quantity * price;
                row.querySelector('.row-total').textContent = '€' + total.toFixed(2);
            }
            
            // Function to update batch totals
            function updateBatchTotals() {
                let totalPrice = 0;
                let totalQuantity = 0;
                
                document.querySelectorAll('.product-row').forEach(row => {
                    const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    
                    totalPrice += quantity * price;
                    totalQuantity += quantity;
                });
                
                batchTotalElement.textContent = '€' + totalPrice.toFixed(2);
                batchQuantityElement.textContent = totalQuantity;
            }
            
            // Function to create a new product row
            function createProductRow() {
                const rowTemplate = `
                    <tr class="product-row">
                        <td class="px-4 py-3">
                            <select name="products[]" class="product-select w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->producer }} {{ $product->model }} ({{ $product->quantity }} available)
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="quantities[]" value="1" min="1" class="quantity-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="unit_prices[]" value="0.00" min="0" step="0.01" class="price-input w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </td>
                        <td class="px-4 py-3">
                            <div class="row-total text-sm font-medium text-gray-900">€0.00</div>
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" class="remove-row text-red-600 hover:text-red-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                `;
                
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = rowTemplate;
                const newRow = tempDiv.firstElementChild;
                
                // Add event listeners to the new row
                addRowEventListeners(newRow);
                
                // Append the new row
                productRows.appendChild(newRow);
                
                // Update totals
                updateBatchTotals();
            }
            
            // Function to add event listeners to a row
            function addRowEventListeners(row) {
                const quantityInput = row.querySelector('.quantity-input');
                const priceInput = row.querySelector('.price-input');
                const removeButton = row.querySelector('.remove-row');
                
                quantityInput.addEventListener('input', function() {
                    updateRowTotal(row);
                    updateBatchTotals();
                });
                
                priceInput.addEventListener('input', function() {
                    updateRowTotal(row);
                    updateBatchTotals();
                });
                
                removeButton.addEventListener('click', function() {
                    if (document.querySelectorAll('.product-row').length > 1 || confirm('Are you sure you want to remove the last product?')) {
                        row.remove();
                        updateBatchTotals();
                    }
                });
            }
            
            // Add event listener to the "Add Product" button
            addProductButton.addEventListener('click', createProductRow);
            
            // Add event listeners to existing rows
            document.querySelectorAll('.product-row').forEach(addRowEventListeners);
            
            // Initial calculation
            updateBatchTotals();
        });
    </script>
</x-admin-layout> 
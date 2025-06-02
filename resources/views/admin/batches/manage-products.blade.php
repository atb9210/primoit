<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Products in Batch') }}: {{ $batch->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.batches.show', $batch) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Batch Details') }}
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

            <!-- Add New Product Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Product</h3>
                    
                    <form action="{{ route('admin.batches.add-product', $batch) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Details -->
                            <div>
                                <div class="grid grid-cols-1 gap-4 mb-4">
                                    <div>
                                        <label for="manufacturer" class="block text-sm font-medium text-gray-700 mb-1">Manufacturer *</label>
                                        <input type="text" name="manufacturer" id="manufacturer" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('manufacturer', $batch->product_manufacturer) }}">
                                        @error('manufacturer')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model *</label>
                                        <input type="text" name="model" id="model" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('model', $batch->product_model) }}">
                                        @error('model')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Condition Grade</label>
                                            <select name="grade" id="grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="">Select a grade</option>
                                                <option value="A" {{ old('grade') == 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                                <option value="B" {{ old('grade') == 'B' ? 'selected' : '' }}>B (Good)</option>
                                                <option value="C" {{ old('grade') == 'C' ? 'selected' : '' }}>C (Fair)</option>
                                                <option value="D" {{ old('grade') == 'D' ? 'selected' : '' }}>D (Poor)</option>
                                            </select>
                                            @error('grade')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="tech_grade" class="block text-sm font-medium text-gray-700 mb-1">Tech Grade</label>
                                            <select name="tech_grade" id="tech_grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleProblemsField()">
                                                <option value="Working" {{ old('tech_grade') == 'Working' ? 'selected' : '' }}>Working</option>
                                                <option value="Working*" {{ old('tech_grade') == 'Working*' ? 'selected' : '' }}>Working*</option>
                                                <option value="Not Working" {{ old('tech_grade') == 'Not Working' ? 'selected' : '' }}>Not Working</option>
                                            </select>
                                            @error('tech_grade')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Problems field (conditionally shown) -->
                                    <div id="problems_container" class="mt-3 hidden">
                                        <label for="problems" class="block text-sm font-medium text-gray-700 mb-1">Problems</label>
                                        <textarea name="problems" id="problems" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe the issues with this product...">{{ old('problems') }}</textarea>
                                        <p class="mt-1 text-xs text-gray-500">Please describe what problems or issues the product has.</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (€) *</label>
                                            <input type="number" name="price" id="price" min="0" step="0.01" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('price', $batch->unit_price) }}">
                                            @error('price')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                            <input type="number" name="quantity" id="quantity" min="1" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('quantity', 1) }}">
                                            @error('quantity')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Product Images and Parameters -->
                            <div>
                                <!-- Product Images Section -->
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Product Images (Max 4)</h4>
                                    
                                    <div class="mt-1 flex justify-center px-4 py-3 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="product_images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    <span>Upload</span>
                                                    <input id="product_images" name="product_images[]" type="file" class="sr-only" multiple accept="image/*">
                                                </label>
                                                <p class="pl-1">or drag images</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="product-image-preview-container" class="mt-2 hidden">
                                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" id="product-image-preview">
                                            <!-- Image previews will be inserted here -->
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Click on an image to set it as default</p>
                                        <input type="hidden" name="product_default_image" id="product_default_image" value="0">
                                    </div>
                                </div>
                                
                                <!-- Parameters Section (based on batch specifications) -->
                                @if(is_array($batch->specifications) && count($batch->specifications) > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-3">Additional Parameters</h4>
                                        <div class="grid grid-cols-2 gap-3">
                                            @foreach($batch->specifications as $key => $value)
                                                <div>
                                                    <label for="param_{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                    <input type="text" id="param_{{ $key }}" name="param_keys[]" value="{{ $key }}" hidden>
                                                    <input type="text" name="param_values[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter value">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('Add Product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Products List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Products in Batch</h3>
                    
                    @if(is_array($batch->products) && count($batch->products) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Images</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Manufacturer</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Model</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Grade</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Tech Grade</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Problems</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Price</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">Quantity</th>
                                        
                                        @if(is_array($batch->specifications))
                                            @foreach($batch->specifications as $key => $value)
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                            @endforeach
                                        @endif
                                        
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($batch->products as $index => $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-center border-r">
                                                @if(isset($product['images']) && !empty($product['images']))
                                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 cursor-pointer" onclick="openProductImagesModal({{ $index }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">{{ $product['manufacturer'] }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">{{ $product['model'] }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">{{ $product['grade'] ?? '-' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">{{ $product['tech_grade'] ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">{{ $product['problems'] ?? '-' }}</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">@formatPrice($product['price'])</td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">{{ $product['quantity'] }}</td>
                                            
                                            @if(is_array($batch->specifications))
                                                @foreach($batch->specifications as $key => $value)
                                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 border-r">
                                                        @if(isset($product['parameters']) && is_array($product['parameters']) && isset($product['parameters'][$key]))
                                                            {{ $product['parameters'][$key] }}
                                                        @else
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            @endif
                                            
                                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('admin.batches.remove-product', ['batch' => $batch->id, 'index' => $index]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-gray-500">No products have been added to this batch yet. Use the form above to add products.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<!-- Product Images Modal -->
<div id="productImagesModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full max-h-[90vh] overflow-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Product Images</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeProductImagesModal()">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="flex flex-col space-y-4">
            <!-- Main Image Display -->
            <div id="modalMainImage" class="relative border rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center h-auto">
                <img src="" alt="Main product image" class="max-h-[50vh] w-auto mx-auto object-contain" id="currentMainImage">
                
                <!-- Navigation Buttons -->
                <button id="prevImageBtn" class="absolute left-2 bg-white bg-opacity-75 rounded-full p-2 shadow-md opacity-0 hover:opacity-100 transition-opacity focus:outline-none" onclick="navigateImages(-1)">
                    <svg class="h-6 w-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button id="nextImageBtn" class="absolute right-2 bg-white bg-opacity-75 rounded-full p-2 shadow-md opacity-0 hover:opacity-100 transition-opacity focus:outline-none" onclick="navigateImages(1)">
                    <svg class="h-6 w-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
                
                <!-- Zoom Button -->
                <button id="zoomToggleBtn" class="absolute bottom-2 right-2 bg-white bg-opacity-75 rounded-full p-2 shadow-md opacity-0 hover:opacity-100 transition-opacity focus:outline-none" onclick="toggleZoom()">
                    <svg class="h-6 w-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="zoomIcon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Thumbnails -->
            <div id="imageThumbnails" class="grid grid-cols-4 gap-2">
                <!-- Thumbnails will be dynamically populated -->
            </div>
            
            <!-- Default Image Indicator -->
            <div class="text-center text-sm text-gray-500">
                <span id="defaultImageIndicator"></span>
            </div>
        </div>
        
        <div class="flex justify-end mt-6">
            <button type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md" onclick="closeProductImagesModal()">Close</button>
        </div>
    </div>
</div>

<script>
    // Prodotti JSON per uso JavaScript
    const products = @json($batch->products ?? []);
    let currentProductIndex = 0;
    let currentImageIndex = 0;
    let productImagePaths = [];
    let isZoomed = false;
    
    function openProductImagesModal(productIndex) {
        currentProductIndex = productIndex;
        const modal = document.getElementById('productImagesModal');
        const thumbnailsContainer = document.getElementById('imageThumbnails');
        const mainImage = document.getElementById('currentMainImage');
        const defaultIndicator = document.getElementById('defaultImageIndicator');
        
        // Reset zoom state
        isZoomed = false;
        updateZoomButton();
        
        // Clear previous content
        thumbnailsContainer.innerHTML = '';
        mainImage.src = '';
        
        const product = products[productIndex];
        if (!product || !product.images) return;
        
        // Get all image paths (skip the 'default' key)
        productImagePaths = Object.entries(product.images)
            .filter(([key]) => key !== 'default')
            .map(([_, path]) => path);
        
        // Get default image if exists
        const defaultImage = product.images.default || (productImagePaths.length > 0 ? productImagePaths[0] : null);
        
        if (productImagePaths.length === 0) {
            thumbnailsContainer.innerHTML = '<p class="col-span-4 text-center text-gray-500">No images available for this product.</p>';
            defaultIndicator.textContent = '';
            
            // Hide navigation buttons
            document.getElementById('prevImageBtn').style.display = 'none';
            document.getElementById('nextImageBtn').style.display = 'none';
        } else {
            // Set main image to default
            currentImageIndex = defaultImage ? productImagePaths.indexOf(defaultImage) : 0;
            if (currentImageIndex === -1) currentImageIndex = 0;
            
            mainImage.src = `/storage/${productImagePaths[currentImageIndex]}`;
            
            // Show/hide navigation buttons based on number of images
            document.getElementById('prevImageBtn').style.display = productImagePaths.length > 1 ? 'block' : 'none';
            document.getElementById('nextImageBtn').style.display = productImagePaths.length > 1 ? 'block' : 'none';
            
            // Create thumbnails
            productImagePaths.forEach((path, index) => {
                const isDefaultImage = path === defaultImage;
                const thumbnailDiv = document.createElement('div');
                thumbnailDiv.className = `border rounded p-1 cursor-pointer ${isDefaultImage ? 'ring-2 ring-indigo-500' : ''}`;
                thumbnailDiv.onclick = () => selectMainImage(index);
                
                thumbnailDiv.innerHTML = `
                    <div class="relative">
                        <img src="/storage/${path}" alt="Thumbnail" class="w-full h-16 object-contain">
                        ${isDefaultImage ? '<div class="absolute bottom-0 right-0 bg-indigo-500 text-white text-xs p-1 rounded-tl">Default</div>' : ''}
                    </div>
                `;
                
                thumbnailsContainer.appendChild(thumbnailDiv);
            });
            
            // Set default image indicator
            if (defaultImage) {
                defaultIndicator.textContent = 'Default image is highlighted with blue border';
            } else {
                defaultIndicator.textContent = 'No default image set';
            }
        }
        
        // Show modal
        modal.classList.remove('hidden');
    }
    
    function selectMainImage(index) {
        if (index < 0 || index >= productImagePaths.length) return;
        
        currentImageIndex = index;
        document.getElementById('currentMainImage').src = `/storage/${productImagePaths[index]}`;
        
        // Reset zoom when changing image
        isZoomed = false;
        updateZoomButton();
    }
    
    function navigateImages(direction) {
        let newIndex = currentImageIndex + direction;
        
        // Handle wrap-around
        if (newIndex < 0) newIndex = productImagePaths.length - 1;
        if (newIndex >= productImagePaths.length) newIndex = 0;
        
        selectMainImage(newIndex);
    }
    
    function toggleZoom() {
        const mainImage = document.getElementById('currentMainImage');
        isZoomed = !isZoomed;
        
        if (isZoomed) {
            // Salva le dimensioni originali per il reset
            if (!mainImage.dataset.originalWidth) {
                mainImage.dataset.originalWidth = mainImage.offsetWidth;
                mainImage.dataset.originalHeight = mainImage.offsetHeight;
            }
            
            // Applica lo zoom
            mainImage.classList.remove('max-h-[50vh]');
            mainImage.classList.add('max-h-none', 'h-auto', 'scale-150', 'cursor-move');
            
            // Aggiungi il listener per il pan
            mainImage.addEventListener('mousemove', handleImagePan);
            
            // Aggiungi overlay per aiutare l'utente a capire che può spostare l'immagine
            const container = mainImage.parentElement;
            if (!container.querySelector('.zoom-overlay')) {
                const overlay = document.createElement('div');
                overlay.className = 'zoom-overlay absolute inset-0 bg-black bg-opacity-10 pointer-events-none flex items-center justify-center';
                overlay.innerHTML = '<span class="text-white text-sm px-2 py-1 bg-black bg-opacity-50 rounded">Move image with mouse</span>';
                container.appendChild(overlay);
                
                // Nascondi l'overlay dopo 2 secondi
                setTimeout(() => {
                    overlay.classList.add('opacity-0', 'transition-opacity');
                    setTimeout(() => overlay.remove(), 1000);
                }, 2000);
            }
        } else {
            // Rimuovi lo zoom
            mainImage.classList.add('max-h-[50vh]');
            mainImage.classList.remove('max-h-none', 'h-auto', 'scale-150', 'cursor-move');
            mainImage.style.transform = '';
            
            // Rimuovi il listener per il pan
            mainImage.removeEventListener('mousemove', handleImagePan);
            
            // Rimuovi eventuali overlay
            const overlay = mainImage.parentElement.querySelector('.zoom-overlay');
            if (overlay) overlay.remove();
        }
        
        updateZoomButton();
    }
    
    function handleImagePan(e) {
        if (!isZoomed) return;
        
        const image = e.target;
        const container = image.parentElement;
        
        // Calcola la posizione relativa del mouse all'interno del container
        const rect = container.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        // Calcola la percentuale della posizione
        const xPercent = (x / rect.width);
        const yPercent = (y / rect.height);
        
        // Limita il movimento per non mostrare spazi vuoti ai bordi
        const imageWidth = image.offsetWidth * 1.5; // considerando lo scale 1.5
        const imageHeight = image.offsetHeight * 1.5;
        const containerWidth = rect.width;
        const containerHeight = rect.height;
        
        // Calcola il massimo spostamento possibile in pixel
        const maxMoveX = Math.max(0, (imageWidth - containerWidth) / 2);
        const maxMoveY = Math.max(0, (imageHeight - containerHeight) / 2);
        
        // Mappa la percentuale in uno spostamento tra -maxMove e +maxMove
        const moveX = maxMoveX > 0 ? maxMoveX - (xPercent * maxMoveX * 2) : 0;
        const moveY = maxMoveY > 0 ? maxMoveY - (yPercent * maxMoveY * 2) : 0;
        
        // Applica la trasformazione
        image.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.5)`;
    }
    
    function updateZoomButton() {
        const zoomIcon = document.getElementById('zoomIcon');
        
        if (isZoomed) {
            zoomIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>';
        } else {
            zoomIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>';
        }
    }
    
    function closeProductImagesModal() {
        const modal = document.getElementById('productImagesModal');
        modal.classList.add('hidden');
        
        // Reset zoom when closing
        isZoomed = false;
        const mainImage = document.getElementById('currentMainImage');
        mainImage.classList.remove('scale-150', 'cursor-move');
        mainImage.style.transform = '';
        mainImage.removeEventListener('mousemove', handleImagePan);
    }

    // Image preview functionality
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('product_images');
        const imagePreviewContainer = document.getElementById('product-image-preview-container');
        const imagePreview = document.getElementById('product-image-preview');
        const defaultImageIndex = document.getElementById('product_default_image');
        
        // Inizializza il campo Problems in base al valore attuale di Tech Grade
        toggleProblemsField();
        
        // Drag and drop functionality
        const dropZone = imageInput.closest('.border-dashed');
        
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
        }
        
        function unhighlight() {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        }
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            imageInput.files = files;
            handleFiles(files);
        }
        
        function handleFiles(files) {
            // Clear the preview
            imagePreview.innerHTML = '';
            
            if (files && files.length > 0) {
                imagePreviewContainer.classList.remove('hidden');
                
                // Limit to 4 images
                const filesToProcess = Array.from(files).slice(0, 4);
                
                // Create previews for each image
                filesToProcess.forEach((file, index) => {
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
                            document.querySelectorAll('#product-image-preview > div').forEach(el => {
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
        }
        
        // Image preview on file input change
        imageInput.addEventListener('change', function() {
            handleFiles(this.files);
        });
    });

    function toggleProblemsField() {
        const problemsContainer = document.getElementById('problems_container');
        const techGrade = document.getElementById('tech_grade').value;
        
        if (techGrade === 'Working*' || techGrade === 'Not Working') {
            problemsContainer.classList.remove('hidden');
        } else {
            problemsContainer.classList.add('hidden');
        }
    }
</script> 
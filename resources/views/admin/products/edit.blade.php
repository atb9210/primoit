<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Product') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.products.show', $product) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ __('View Product') }}
                </a>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Products') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h3>
                                
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                    <input type="text" name="type" id="type" value="{{ old('type', $product->type) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="producer" class="block text-sm font-medium text-gray-700 mb-1">Producer</label>
                                    <input type="text" name="producer" id="producer" value="{{ old('producer', $product->producer) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('producer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                                    <input type="text" name="model" id="model" value="{{ old('model', $product->model) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('model')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                                    <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number', $product->batch_number) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('batch_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Pricing and Availability -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pricing and Availability</h3>
                                
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (€)</label>
                                    <input type="number" name="price" id="price" value="{{ old('price', (float)$product->price) }}" min="0" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" min="0" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="reserved" {{ old('status', $product->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                        <option value="sold" {{ old('status', $product->status) == 'sold' ? 'selected' : '' }}>Sold</option>
                                        <option value="unavailable" {{ old('status', $product->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                                    <select name="condition" id="condition" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="like-new" {{ old('condition', $product->condition) == 'like-new' ? 'selected' : '' }}>Like New</option>
                                        <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                    </select>
                                    @error('condition')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="visual_grade" class="block text-sm font-medium text-gray-700 mb-1">Visual Grade</label>
                                    <select name="visual_grade" id="visual_grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select a grade</option>
                                        <option value="A+" {{ old('visual_grade', $product->visual_grade) == 'A+' ? 'selected' : '' }}>A+ (Perfect)</option>
                                        <option value="A" {{ old('visual_grade', $product->visual_grade) == 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                        <option value="B+" {{ old('visual_grade', $product->visual_grade) == 'B+' ? 'selected' : '' }}>B+ (Very Good)</option>
                                        <option value="B" {{ old('visual_grade', $product->visual_grade) == 'B' ? 'selected' : '' }}>B (Good)</option>
                                        <option value="C" {{ old('visual_grade', $product->visual_grade) == 'C' ? 'selected' : '' }}>C (Fair)</option>
                                        <option value="D" {{ old('visual_grade', $product->visual_grade) == 'D' ? 'selected' : '' }}>D (Poor)</option>
                                    </select>
                                    @error('visual_grade')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Technical Specifications -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Technical Specifications</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="mb-4">
                                    <label for="cpu" class="block text-sm font-medium text-gray-700 mb-1">CPU</label>
                                    <input type="text" name="cpu" id="cpu" value="{{ old('cpu', $product->cpu) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('cpu')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="ram" class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                                    <input type="text" name="ram" id="ram" value="{{ old('ram', $product->ram) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('ram')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="drive" class="block text-sm font-medium text-gray-700 mb-1">Storage</label>
                                    <input type="text" name="drive" id="drive" value="{{ old('drive', $product->drive) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('drive')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="operating_system" class="block text-sm font-medium text-gray-700 mb-1">Operating System</label>
                                    <input type="text" name="operating_system" id="operating_system" value="{{ old('operating_system', $product->operating_system) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('operating_system')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="gpu" class="block text-sm font-medium text-gray-700 mb-1">GPU</label>
                                    <input type="text" name="gpu" id="gpu" value="{{ old('gpu', $product->gpu) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('gpu')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="screen_size" class="block text-sm font-medium text-gray-700 mb-1">Screen Size</label>
                                    <input type="text" name="screen_size" id="screen_size" value="{{ old('screen_size', $product->screen_size) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('screen_size')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="lcd_quality" class="block text-sm font-medium text-gray-700 mb-1">LCD Quality</label>
                                    <input type="text" name="lcd_quality" id="lcd_quality" value="{{ old('lcd_quality', $product->lcd_quality) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('lcd_quality')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="battery" class="block text-sm font-medium text-gray-700 mb-1">Battery</label>
                                    <input type="text" name="battery" id="battery" value="{{ old('battery', $product->battery) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('battery')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                    <input type="text" name="color" id="color" value="{{ old('color', $product->color) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('color')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4 flex items-center">
                                    <input type="checkbox" name="has_box" id="has_box" value="1" {{ old('has_box', $product->has_box) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="has_box" class="ml-2 block text-sm font-medium text-gray-700">Includes Original Box</label>
                                    @error('has_box')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Information -->
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h3>
                            
                            <div class="mb-4">
                                <label for="info" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                                <textarea name="info" id="info" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('info', $product->info) }}</textarea>
                                @error('info')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t pt-8">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
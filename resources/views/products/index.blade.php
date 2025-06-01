<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Stock') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">Available Stock</h1>
                
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Filters Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <h2 class="font-semibold text-lg mb-3">Filters</h2>
                            
                            <form action="{{ route('products.index') }}" method="GET">
                                <!-- Search -->
                                <div class="mb-4">
                                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </div>
                                
                                <!-- Category Filter -->
                                <div class="mb-4">
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category" id="category" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Condition Filter -->
                                <div class="mb-4">
                                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                                    <select name="condition" id="condition" 
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">All Conditions</option>
                                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="like-new" {{ request('condition') == 'like-new' ? 'selected' : '' }}>Like New</option>
                                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="refurbished" {{ request('condition') == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Apply Filters
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Products Grid -->
                    <div class="lg:col-span-3">
                        @if($products->isEmpty())
                            <div class="bg-gray-50 p-8 rounded-lg text-center">
                                <p class="text-gray-500 mb-4">No products found matching your criteria.</p>
                                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Clear all filters</a>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($products as $product)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                        <div class="h-48 overflow-hidden">
                                            @if($product->primaryImage)
                                                <img src="{{ asset('storage/' . $product->primaryImage->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400">No image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <div class="flex justify-between items-start mb-2">
                                                <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ ucfirst($product->condition) }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500 mb-2">
                                                {{ $product->category->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($product->description, 80) }}</p>
                                            
                                            <div class="flex justify-between items-center">
                                                <div class="text-sm">
                                                    <span class="font-medium">Batch:</span> {{ $product->batch_number }}
                                                </div>
                                                <a href="{{ route('products.show', $product->slug) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                    Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                {{ $products->withQueryString()->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
                            &larr; Back to Products
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Images -->
                        <div>
                            <div class="mb-4 border rounded-lg overflow-hidden h-80">
                                @if($product->images->count() > 0)
                                    <img id="main-image" src="{{ asset('storage/' . $product->primaryImage?->path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No image available</span>
                                    </div>
                                @endif
                            </div>
                            
                            @if($product->images->count() > 1)
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach($product->images as $image)
                                        <div class="border rounded cursor-pointer h-20 overflow-hidden {{ $image->is_primary ? 'ring-2 ring-blue-500' : '' }}" 
                                             onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->path) }}'">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div>
                            <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ ucfirst($product->condition) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Category: <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-blue-600 hover:text-blue-800">{{ $product->category->name }}</a>
                                </span>
                            </div>
                            
                            <div class="prose max-w-none mb-6">
                                <p>{{ $product->description }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <h2 class="text-lg font-semibold mb-3">Product Details</h2>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                    <div class="text-gray-600">Batch Number:</div>
                                    <div class="font-medium">{{ $product->batch_number }}</div>
                                    
                                    <div class="text-gray-600">Status:</div>
                                    <div class="font-medium">{{ ucfirst($product->status) }}</div>
                                    
                                    <div class="text-gray-600">Quantity:</div>
                                    <div class="font-medium">{{ $product->quantity }}</div>
                                    
                                    <div class="text-gray-600">Minimum Order:</div>
                                    <div class="font-medium">{{ $product->min_order_quantity }}</div>
                                    
                                    @auth
                                        @if(auth()->user()->is_approved)
                                            <div class="text-gray-600">Price:</div>
                                            <div class="font-medium">@formatPrice($product->price)</div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            
                            @if($product->specifications->count() > 0)
                                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                    <h2 class="text-lg font-semibold mb-3">Specifications</h2>
                                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                        @foreach($product->specifications as $spec)
                                            <div class="text-gray-600">{{ $spec->name }}:</div>
                                            <div class="font-medium">{{ $spec->value }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @if($product->has_product_list)
                                <div class="mb-6">
                                    <a href="{{ $product->product_list_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Download Product List
                                    </a>
                                </div>
                            @endif
                            
                            <div class="flex flex-col space-y-3">
                                @auth
                                    @if(auth()->user()->is_approved && $product->status === 'available')
                                        <form action="{{ route('products.reserve', $product) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" value="{{ $product->min_order_quantity }}" min="{{ $product->min_order_quantity }}" max="{{ $product->quantity }}" 
                                                    class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="mb-3">
                                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                                                <textarea name="notes" id="notes" rows="2"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                                            </div>
                                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Reserve This Product
                                            </button>
                                        </form>
                                    @elseif(auth()->user()->is_approved)
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                            <div class="flex">
                                                <p class="text-yellow-700">
                                                    This product is currently {{ $product->status }}. Please contact us for more information.
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                            <div class="flex">
                                                <p class="text-yellow-700">
                                                    Your account is pending approval. You will be able to place orders once approved.
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h2 class="text-lg font-semibold mb-2">Interested in this product?</h2>
                                        <p class="text-gray-600 mb-4">Please fill out the form below and we'll get back to you with more information.</p>
                                        
                                        <form action="{{ route('products.inquiry', $product) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                                <input type="text" name="name" id="name" required
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                                <input type="email" name="email" id="email" required
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="mb-3">
                                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                                                <input type="text" name="company" id="company"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                                <input type="text" name="phone" id="phone"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            </div>
                                            <div class="mb-3">
                                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                                                <textarea name="message" id="message" rows="3" required
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                                            </div>
                                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Submit Inquiry
                                            </button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    @if($relatedProducts->count() > 0)
                        <div class="mt-12">
                            <h2 class="text-xl font-semibold mb-4">Related Products</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($relatedProducts as $relatedProduct)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                        <div class="h-40 overflow-hidden">
                                            @if($relatedProduct->primaryImage)
                                                <img src="{{ asset('storage/' . $relatedProduct->primaryImage->path) }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400">No image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-semibold text-lg mb-2">{{ $relatedProduct->name }}</h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-3">
                                                {{ ucfirst($relatedProduct->condition) }}
                                            </span>
                                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium block mt-2">
                                                View Details →
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
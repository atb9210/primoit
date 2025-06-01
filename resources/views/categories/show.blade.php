<x-public-layout>
    <x-slot name="title">{{ $category->name }} - Products</x-slot>
    <x-slot name="description">Browse {{ $category->name }} products available at PrimoIT. Quality refurbished IT hardware at competitive prices.</x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('categories.index') }}" class="ml-2 hover:text-gray-700">Categories</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 font-medium text-gray-900">{{ $category->name }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="md:w-1/4 flex justify-center mb-6 md:mb-0">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="h-48 w-48 object-contain">
                            @else
                                <div class="h-48 w-48 bg-gray-100 flex items-center justify-center rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="md:w-3/4 md:pl-8">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">{{ $category->name }}</h1>
                            <div class="prose max-w-none text-gray-600 mb-6">
                                <p>{{ $category->description ?? 'Browse our selection of ' . $category->name . ' products. We offer high-quality refurbished IT hardware at competitive prices.' }}</p>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-4"><span class="font-medium">{{ count($category->products) }}</span> products available</span>
                                <a href="{{ route('contact') }}?subject=Inquiry about {{ urlencode($category->name) }} products" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Contact us about bulk orders
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Filters -->
            <div class="bg-white shadow-md rounded-lg mb-8 p-6">
                <form action="{{ route('categories.show', $category) }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sort" name="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                        <select id="brand" name="brand" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Brands</option>
                            <option value="dell" {{ request('brand') == 'dell' ? 'selected' : '' }}>Dell</option>
                            <option value="hp" {{ request('brand') == 'hp' ? 'selected' : '' }}>HP</option>
                            <option value="lenovo" {{ request('brand') == 'lenovo' ? 'selected' : '' }}>Lenovo</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex justify-center w-full py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($category->products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->producer }} {{ $product->model }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $product->description ?? 'High-quality refurbished product' }}</p>
                        <div class="space-y-2 mb-4">
                            @if($product->cpu)
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">CPU:</span> {{ $product->cpu }}
                            </div>
                            @endif
                            @if($product->ram)
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">RAM:</span> {{ $product->ram }}
                            </div>
                            @endif
                            @if($product->drive)
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Storage:</span> {{ $product->drive }}
                            </div>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold text-blue-600">
                                @if(isset($product->price))
                                    @formatPrice($product->price)
                                @else
                                    Contact for pricing
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products available</h3>
                    <p class="text-gray-500 mb-6">We don't have any {{ $category->name }} products in stock at the moment.</p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('categories.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                            Browse Other Categories
                        </a>
                        <a href="{{ route('contact') }}?subject=Product Request: {{ urlencode($category->name) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                            Request This Product
                        </a>
                    </div>
                </div>

                <!-- Placeholder products for demo purposes -->
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            @if($category->name === 'Laptops' || !isset($category->name))
                                {{ ['Dell Latitude 7420', 'HP EliteBook 840 G8', 'Lenovo ThinkPad X1 Carbon'][$i % 3] }}
                            @elseif($category->name === 'Desktops')
                                {{ ['Dell OptiPlex 7090', 'HP EliteDesk 800 G6', 'Lenovo ThinkCentre M90q'][$i % 3] }}
                            @elseif($category->name === 'Servers')
                                {{ ['Dell PowerEdge R740', 'HP ProLiant DL380 Gen10', 'Lenovo ThinkSystem SR650'][$i % 3] }}
                            @else
                                {{ ['Dell P2419H Monitor', 'HP Z27 Display', 'Lenovo ThinkVision P27h-20'][$i % 3] }}
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">Premium refurbished product with full warranty and support.</p>
                        <div class="space-y-2 mb-4">
                            @if($category->name === 'Laptops' || !isset($category->name))
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">CPU:</span> {{ ['Intel Core i7-1185G7', 'Intel Core i5-1135G7', 'AMD Ryzen 7 PRO 5850U'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">RAM:</span> {{ ['16GB DDR4', '8GB DDR4', '32GB DDR4'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Storage:</span> {{ ['512GB SSD', '256GB SSD', '1TB SSD'][$i % 3] }}
                            </div>
                            @elseif($category->name === 'Desktops')
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">CPU:</span> {{ ['Intel Core i7-10700', 'Intel Core i5-10500', 'AMD Ryzen 5 PRO 4650G'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">RAM:</span> {{ ['16GB DDR4', '8GB DDR4', '32GB DDR4'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Storage:</span> {{ ['512GB SSD + 1TB HDD', '256GB SSD', '1TB SSD'][$i % 3] }}
                            </div>
                            @elseif($category->name === 'Servers')
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">CPU:</span> {{ ['2x Intel Xeon Silver 4210', 'Intel Xeon Gold 5218', '2x AMD EPYC 7302'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">RAM:</span> {{ ['64GB DDR4', '128GB DDR4', '96GB DDR4'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Storage:</span> {{ ['4x 1.2TB SAS', '6x 900GB SAS', '4x 1.8TB SAS'][$i % 3] }}
                            </div>
                            @else
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Size:</span> {{ ['24"', '27"', '27"'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Resolution:</span> {{ ['1920x1080', '2560x1440', '2560x1440'][$i % 3] }}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="font-medium mr-2">Connections:</span> {{ ['HDMI, DisplayPort, USB', 'HDMI, DisplayPort, USB-C', 'HDMI, DisplayPort, USB-C'][$i % 3] }}
                            </div>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold text-blue-600">
                                @if($category->name === 'Laptops' || !isset($category->name))
                                    €{{ number_format(650 + ($i * 150), 2) }}
                                @elseif($category->name === 'Desktops')
                                    €{{ number_format(450 + ($i * 100), 2) }}
                                @elseif($category->name === 'Servers')
                                    €{{ number_format(1500 + ($i * 500), 2) }}
                                @else
                                    €{{ number_format(180 + ($i * 70), 2) }}
                                @endif
                            </div>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>
        </div>
    </div>
</x-public-layout> 
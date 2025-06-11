@php
    // Definizione variabili predefinite per evitare errori
    $selectedCatalog = $selectedCatalog ?? null;
    $selectedCategory = $selectedCategory ?? null;
@endphp

<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Foxway.shop Web Scraper') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.suppliers.configure', $supplier) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ __('Configure Credentials') }}
                </a>
                <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Suppliers') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 px-2 sm:px-4 lg:px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Status Messages -->
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
            
            @if (session('error') || isset($error))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') ?? $error }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Supplier Info Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                                @if($supplier->logo)
                                    <img src="{{ Storage::url($supplier->logo) }}" alt="{{ $supplier->name }}" class="h-full w-full object-contain p-1">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $supplier->name }} - Web Scraper</h3>
                                <p class="text-sm text-gray-500">Using account: zarosrls@gmail.com</p>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $supplier->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <a href="{{ $supplier->website }}" target="_blank" class="ml-2 inline-flex items-center text-xs text-indigo-600 hover:text-indigo-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Visit Website
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Supplier Summary Info -->
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col justify-center">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Info Web Scraper</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Cataloghi trovati</p>
                                    <p class="text-lg font-bold text-gray-800">{{ count($catalogs) }}</p>
                                    <p class="text-xs text-gray-600">WorkingPub Interface</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Scraper Status</p>
                                    <div class="text-lg font-semibold {{ isset($error) ? 'text-red-600' : 'text-green-600' }}">
                                        {{ isset($error) ? 'Error' : 'Ready' }}
                                    </div>
                                    <p class="text-xs text-gray-600">{{ isset($error) ? 'Check logs' : 'Ready to use' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cataloghi disponibili -->
            @if(!empty($catalogs))
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Cataloghi Disponibili</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($catalogs as $catalog)
                            <a href="{{ route('admin.foxway-scraper', ['supplier' => $supplier, 'catalog' => $catalog['id']]) }}" 
                               class="block p-4 border rounded-lg hover:bg-gray-50 transition-colors {{ $selectedCatalog == $catalog['id'] ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                <h4 class="font-medium text-gray-900">{{ $catalog['name'] }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $catalog['id'] }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        View Categories
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Categorie del catalogo selezionato -->
            @if($selectedCatalog && !empty($categories))
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Categorie del Catalogo</h3>
                        <a href="{{ route('admin.foxway-scraper', ['supplier' => $supplier]) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 border border-gray-300 rounded text-xs font-medium text-gray-700 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Torna ai Cataloghi
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                            <a href="{{ route('admin.foxway-scraper', ['supplier' => $supplier, 'catalog' => $selectedCatalog, 'category' => $category['id']]) }}" 
                               class="block p-4 border rounded-lg hover:bg-gray-50 transition-colors {{ $selectedCategory == $category['id'] ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                <h4 class="font-medium text-gray-900">{{ $category['name'] }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $category['id'] }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        View Products
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Prodotti della categoria selezionata -->
            @if($selectedCatalog && $selectedCategory && !empty($products))
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Prodotti Disponibili ({{ count($products) }})</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.foxway-scraper', ['supplier' => $supplier, 'catalog' => $selectedCatalog]) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 border border-gray-300 rounded text-xs font-medium text-gray-700 hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Torna alle Categorie
                            </a>
                            <form action="{{ route('admin.foxway-scraper.import') }}" method="POST">
                                @csrf
                                <input type="hidden" name="catalog_id" value="{{ $selectedCatalog }}">
                                <input type="hidden" name="category_id" value="{{ $selectedCategory }}">
                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded text-xs font-medium text-white hover:bg-indigo-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Import All Products
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto -mx-4 sm:-mx-6">
                        <div class="inline-block min-w-full py-2 align-middle px-4 sm:px-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3 pl-4 pr-2 sm:pl-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Price</th>
                                        <th scope="col" class="py-3 pl-2 pr-4 sm:pr-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($products as $product)
                                        <tr>
                                            <td class="py-4 pl-4 pr-2 sm:pl-6 text-sm font-medium text-gray-900">{{ $product['id'] }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-500">
                                                @if($product['image'])
                                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-12 w-12 object-cover rounded">
                                                @else
                                                    <div class="h-12 w-12 bg-gray-100 rounded flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-2 py-4 text-sm text-gray-900">{{ $product['name'] }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($product['description'], 100) }}</td>
                                            <td class="px-2 py-4 text-sm text-gray-900 font-medium">{{ $product['price'] }}</td>
                                            <td class="py-4 pl-2 pr-4 sm:pr-6 text-center">
                                                <a href="#" class="inline-flex items-center px-3 py-1.5 bg-indigo-100 border border-indigo-300 rounded text-xs font-medium text-indigo-700 hover:bg-indigo-200">
                                                    Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @elseif($selectedCatalog && $selectedCategory)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.357-1.36 3.03 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 font-medium">{{ __('Nessun prodotto disponibile') }}</p>
                            <p class="text-sm text-yellow-700 mt-1">Non sono stati trovati prodotti in questa categoria. Prova a selezionare un'altra categoria o controlla i log per eventuali errori di scraping.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($spaMessage))
            <div class="rounded-md bg-yellow-50 p-4 mb-6 border border-yellow-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Dati di esempio</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>{{ $spaMessage }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout> 
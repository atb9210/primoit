<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Foxway.shop API') }}
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

            <!-- Avviso dati di esempio -->
            @if(empty($catalogs))
            <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 8a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">Attenzione: Visualizzazione dati di esempio</p>
                        <p class="text-sm mt-1">L'API di Foxway.shop non sta rispondendo correttamente. Stiamo visualizzando dati di esempio. Possibili cause:</p>
                        <ul class="list-disc list-inside text-sm mt-1 ml-2">
                            <li>La chiave API potrebbe non essere valida o essere scaduta</li>
                            <li>L'endpoint dell'API potrebbe essere cambiato</li>
                            <li>Il formato della richiesta potrebbe essere errato</li>
                        </ul>
                        <p class="text-sm mt-1">Controlla la documentazione Swagger di Foxway.shop per ulteriori informazioni: <a href="https://foxway.shop/swagger/ui/index.html" target="_blank" class="underline">https://foxway.shop/swagger/ui/index.html</a></p>
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
                                <h3 class="text-lg font-medium text-gray-900">{{ $supplier->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $supplier->integration_type == 'api' ? 'API Integration' : ($supplier->integration_type == 'scraping' ? 'Web Scraping Integration' : 'Manual Integration') }}</p>
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
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Info Fornitore</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Unità Totali</p>
                                    <p class="text-lg font-bold text-gray-800">
                                        @php
                                            $totalUnits = 0;
                                            if(!empty($products)) {
                                                foreach($products as $product) {
                                                    $totalUnits += intval(preg_replace('/[^0-9]/', '', $product['units'] ?? 0));
                                                }
                                            }
                                        @endphp
                                        {{ number_format($totalUnits, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-600">Inventario Disponibile</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">API Status</p>
                                    <div class="text-lg font-semibold {{ isset($error) ? 'text-red-600' : 'text-green-600' }}">
                                        {{ isset($error) ? 'Error' : 'Connected' }}
                                    </div>
                                    <p class="text-xs text-gray-600">{{ isset($error) ? 'Check API Key' : 'Ready to Use' }}</p>
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
                            <a href="{{ route('admin.foxway.api', ['supplier' => $supplier, 'catalog' => $catalog['urlSlug']]) }}" 
                               class="block p-4 border rounded-lg hover:bg-gray-50 transition-colors {{ $selectedCatalog == $catalog['urlSlug'] ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                <h4 class="font-medium text-gray-900">{{ $catalog['name'] }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $catalog['urlSlug'] }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        ID: {{ $catalog['id'] }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Dettagli del catalogo selezionato -->
            @if($selectedCatalog && !empty($catalogDetails))
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Dettagli del Catalogo: {{ $selectedCatalog }}</h3>
                        <a href="{{ route('admin.foxway.api', ['supplier' => $supplier]) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 border border-gray-300 rounded text-xs font-medium text-gray-700 hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Torna ai Cataloghi
                        </a>
                    </div>

                    <!-- Dimension Groups -->
                    @if(isset($catalogDetails['dimensionGroups']) && count($catalogDetails['dimensionGroups']) > 0)
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Gruppi di Dimensioni</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($catalogDetails['dimensionGroups'] as $dimensionGroup)
                                <a href="{{ route('admin.foxway.api', ['supplier' => $supplier, 'catalog' => $selectedCatalog, 'dimensionGroup' => $dimensionGroup['id']]) }}" 
                                   class="block p-3 border rounded-lg hover:bg-gray-50 transition-colors {{ $selectedDimensionGroup == $dimensionGroup['id'] ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                    <h5 class="font-medium text-gray-900">{{ $dimensionGroup['name'] }}</h5>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            ID: {{ $dimensionGroup['id'] }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Item Groups - Mostra solo se è selezionato un dimension group -->
                    @if($selectedDimensionGroup && isset($catalogDetails['itemGroups']) && count($catalogDetails['itemGroups']) > 0)
                    <div>
                        <h4 class="text-md font-medium text-gray-700 mb-2">Gruppi di Articoli</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @php
                                $filteredItemGroups = array_filter($catalogDetails['itemGroups'], function($itemGroup) use ($selectedDimensionGroup) {
                                    return isset($itemGroup['dimensionGroupId']) && $itemGroup['dimensionGroupId'] == $selectedDimensionGroup;
                                });
                            @endphp
                            
                            @if(count($filteredItemGroups) > 0)
                                @foreach($filteredItemGroups as $itemGroup)
                                    <a href="{{ route('admin.foxway.api', ['supplier' => $supplier, 'catalog' => $selectedCatalog, 'dimensionGroup' => $selectedDimensionGroup, 'itemGroup' => $itemGroup['id']]) }}" 
                                    class="block p-3 border rounded-lg hover:bg-gray-50 transition-colors {{ $selectedItemGroup == $itemGroup['id'] ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                        <h5 class="font-medium text-gray-900">{{ $itemGroup['name'] }}</h5>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ID: {{ $itemGroup['id'] }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="col-span-3 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <p class="text-sm text-yellow-700">Nessun gruppo di articoli disponibile per questo gruppo di dimensioni.</p>
                                    <p class="text-sm text-yellow-700 mt-1">Prova a selezionare un altro gruppo di dimensioni o verifica che i gruppi di articoli siano configurati correttamente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Manufacturers -->
                    @if(!empty($manufacturers) && count($manufacturers) > 0)
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Produttori Disponibili</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <a href="{{ route('admin.foxway.api', ['supplier' => $supplier, 'catalog' => $selectedCatalog, 'dimensionGroup' => $selectedDimensionGroup, 'itemGroup' => $selectedItemGroup]) }}" 
                               class="block p-3 border rounded-lg hover:bg-gray-50 transition-colors {{ !$selectedManufacturer ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                <h5 class="font-medium text-gray-900">Tutti i produttori</h5>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Mostra tutti
                                    </span>
                                </div>
                            </a>
                            @foreach($manufacturers as $manufacturer)
                                <a href="{{ route('admin.foxway.api', ['supplier' => $supplier, 'catalog' => $selectedCatalog, 'dimensionGroup' => $selectedDimensionGroup, 'itemGroup' => $selectedItemGroup, 'manufacturer' => $manufacturer['id']]) }}" 
                                   class="block p-3 border rounded-lg hover:bg-gray-50 transition-colors {{ $selectedManufacturer == $manufacturer['id'] ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200' }}">
                                    <h5 class="font-medium text-gray-900">{{ $manufacturer['name'] }}</h5>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            ID: {{ $manufacturer['id'] }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if(empty($products) && !isset($error) && $selectedCatalog && $selectedDimensionGroup && $selectedItemGroup)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            @if(isset($noProductsMessage))
                                <p class="text-sm text-yellow-700 font-medium">{{ __('Nessun prodotto disponibile') }}</p>
                                <p class="text-sm text-yellow-700 mt-1">{!! nl2br(e($noProductsMessage)) !!}</p>
                            @else
                                <p class="text-sm text-yellow-700">Nessun prodotto disponibile per la combinazione selezionata. Prova a selezionare un altro catalogo, gruppo di dimensioni o gruppo di articoli.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif(!empty($products))
                <!-- All Available Products -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Prodotti Disponibili ({{ count($products) }})</h3>
                            
                            @if(isset($noProductsMessage))
                                <div class="w-full bg-yellow-50 border-l-4 border-yellow-400 p-3">
                                    <p class="text-sm text-yellow-700 font-medium">{{ __('Attenzione') }}</p>
                                    <p class="text-sm text-yellow-700">{!! nl2br(e($noProductsMessage)) !!}</p>
                                </div>
                            @endif
                            
                            <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-2">
                                <div class="relative w-full sm:w-auto">
                                    <input type="text" id="product-search" placeholder="Search products..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <button type="button" id="search-btn" class="w-full sm:w-auto inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto -mx-4 sm:-mx-6">
                            <div class="inline-block min-w-full py-2 align-middle px-4 sm:px-6">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3 pl-4 pr-2 sm:pl-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manufacturer</th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Units</th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Grade</th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Price</th>
                                            <th scope="col" class="py-3 pl-2 pr-4 sm:pr-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($products as $product)
                                            <tr class="product-item">
                                                <td class="py-4 pl-4 pr-2 sm:pl-6 text-sm font-medium text-gray-900">{{ $product['id'] }}</td>
                                                <td class="px-2 py-4 text-sm text-gray-900 product-name">{{ $product['name'] }}</td>
                                                <td class="px-2 py-4 text-sm text-gray-500">{{ $product['manufacturer'] ?? 'N/A' }}</td>
                                                <td class="px-2 py-4 text-sm text-gray-500">{{ $product['model'] ?? 'N/A' }}</td>
                                                <td class="px-2 py-4 text-sm text-gray-500 text-center">{{ $product['units'] }}</td>
                                                <td class="px-2 py-4 text-sm">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        {{ $product['grade'] == 'A' ? 'bg-green-100 text-green-800' : 
                                                           ($product['grade'] == 'B' ? 'bg-yellow-100 text-yellow-800' : 
                                                           'bg-red-100 text-red-800') }}">
                                                        Grade {{ $product['grade'] }}
                                                    </span>
                                                </td>
                                                <td class="px-2 py-4 text-sm text-gray-900 font-medium text-right">{{ $product['price'] }}</td>
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
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('product-search');
            const searchBtn = document.getElementById('search-btn');
            const productItems = document.querySelectorAll('.product-item');
            
            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                
                productItems.forEach(item => {
                    const productName = item.querySelector('.product-name').textContent.toLowerCase();
                    
                    if (searchTerm === '' || productName.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
            
            if(searchBtn) {
                searchBtn.addEventListener('click', filterProducts);
            }
            
            if(searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        filterProducts();
                    }
                });
            }
        });
    </script>
</x-admin-layout> 
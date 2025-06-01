<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('ITSale.pl Scraper') }}
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
                                            if(!empty($allLists)) {
                                                foreach($allLists as $list) {
                                                    $totalUnits += intval(preg_replace('/[^0-9]/', '', $list['units']));
                                                }
                                            }
                                        @endphp
                                        {{ number_format($totalUnits, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs text-gray-600">Inventario Totale</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Prezzo Totale</p>
                                    <div class="text-lg font-semibold">
                                        @php
                                            $totalPrice = 0;
                                            
                                            // Calculate total price from all lists
                                            foreach ($allLists as $list) {
                                                $price = preg_replace('/[^0-9,.]/', '', $list['price']);
                                                $price = str_replace(',', '.', $price);
                                                $totalPrice += (float) $price;
                                            }
                                        @endphp
                                        @formatPrice($totalPrice)
                                    </div>
                                    <p class="text-xs text-gray-600">Valore Inventario</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(empty($latestLists) && empty($allLists) && !isset($error))
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">No lists are available at the moment. Please try again later.</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Latest Lists -->
                @if(!empty($latestLists))
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                        <div class="p-4 sm:p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Latest Wholesale Lists</h3>
                                <a href="https://itsale.pl/list" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View on ITSale.pl
                                </a>
                            </div>
                            
                            <div class="overflow-x-auto -mx-4 sm:-mx-6">
                                <div class="inline-block min-w-full py-2 align-middle px-4 sm:px-6">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3 pl-4 pr-2 sm:pl-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Units</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Avg. Price</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Total</th>
                                                <th scope="col" class="py-3 pl-2 pr-4 sm:pr-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($latestLists as $list)
                                                <tr>
                                                    <td class="py-4 pl-4 pr-2 sm:pl-6 text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-[180px]">{{ $list['name'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 truncate max-w-[150px] sm:max-w-[250px]">{{ $list['description'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 text-center">{{ $list['units'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 text-right font-medium">{{ $list['average_price'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 text-right font-medium">{{ $list['price'] }}</td>
                                                    <td class="py-4 pl-2 pr-4 sm:pr-6 text-center">
                                                        <a href="{{ route('admin.itsale.show-list', ['supplier' => $supplier, 'listSlug' => strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $list['name']), '-'))]) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            Open
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

                <!-- All Lists -->
                @if(!empty($allLists))
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="p-4 sm:p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                                <h3 class="text-lg font-medium text-gray-900">All Available Lists</h3>
                                <div class="w-full sm:w-auto flex flex-col sm:flex-row items-center gap-2">
                                    <div class="relative w-full sm:w-auto">
                                        <input type="text" id="list-search" placeholder="Search lists..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <button class="w-full sm:w-auto inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                                <th scope="col" class="py-3 pl-4 pr-2 sm:pl-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Units</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Avg. Price</th>
                                                <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Total</th>
                                                <th scope="col" class="py-3 pl-2 pr-4 sm:pr-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($allLists as $list)
                                                <tr class="list-item">
                                                    <td class="py-4 pl-4 pr-2 sm:pl-6 text-sm font-medium text-gray-900 truncate max-w-[120px] sm:max-w-[180px] list-name">{{ $list['name'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 truncate max-w-[150px] sm:max-w-[250px]">{{ $list['description'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 text-center">{{ $list['units'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 text-right font-medium">{{ $list['average_price'] }}</td>
                                                    <td class="px-2 py-4 text-sm text-gray-500 text-right font-medium">{{ $list['price'] }}</td>
                                                    <td class="py-4 pl-2 pr-4 sm:pr-6 text-center">
                                                        <a href="{{ route('admin.itsale.show-list', ['supplier' => $supplier, 'listSlug' => strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $list['name']), '-'))]) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                            Open
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
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('list-search');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const listItems = document.querySelectorAll('.list-item');
                    
                    listItems.forEach(item => {
                        const name = item.querySelector('.list-name').textContent.toLowerCase();
                        if (name.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</x-admin-layout> 
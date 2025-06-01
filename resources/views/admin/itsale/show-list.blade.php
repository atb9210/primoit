<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $listDetails['name'] }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.itsale.index', $supplier) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Lists') }}
                </a>
                <a href="https://itsale.pl/list/asus-samsung-clevo-laptops-" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    {{ __('View on ITSale.pl') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
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

            <!-- List Overview -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">List Overview</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">ID:</span>
                                    <span class="font-medium">{{ $listDetails['id'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Description:</span>
                                    <span class="font-medium">{{ $listDetails['description'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Total Price:</span>
                                    <span class="font-medium">{{ $listDetails['total_price'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Average Price:</span>
                                    <span class="font-medium">{{ $listDetails['avg_price'] }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Units:</span>
                                    <span class="font-medium">{{ $listDetails['units'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Visual Grade</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($listDetails['visual_grade'] as $grade => $percentage)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">{{ $grade }}:</span>
                                            <span class="font-medium">{{ $percentage }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tech Grade</h3>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($listDetails['tech_grade'] as $grade => $percentage)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">{{ $grade }}:</span>
                                            <span class="font-medium">{{ $percentage }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-between">
                            <button class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Import All Products
                            </button>
                            <div class="flex space-x-2">
                                <button class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-indigo-300 rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Make Offer
                                </button>
                                <button class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Export to Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Products ({{ count($listDetails['items']) }})</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producer/Model</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPU/RAM</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Storage</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Screen</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">COA</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Problems</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($listDetails['items'] as $index => $item)
                                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                                                <img src="{{ $item['photo_url'] }}" alt="{{ $item['producer'] }} {{ $item['model'] }}" class="h-full w-full object-cover">
                                            </div>
                                        </td>
                                        <td class="px-3 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item['producer'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $item['model'] }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ $item['type'] }}</div>
                                        </td>
                                        <td class="px-3 py-4">
                                            <div class="text-sm text-gray-900">{{ $item['cpu'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $item['ram'] }}</div>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $item['drive'] }}
                                        </td>
                                        <td class="px-3 py-4">
                                            <div class="text-sm text-gray-900">{{ $item['screen_size'] }}</div>
                                            <div class="text-sm text-gray-500">{{ $item['resolution'] }}</div>
                                            <div class="text-xs text-gray-500 mt-1">LCD: {{ $item['lcd_quality'] }}</div>
                                        </td>
                                        <td class="px-3 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item['visual_grade'] == 'A' ? 'bg-green-100 text-green-800' : ($item['visual_grade'] == 'B' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $item['visual_grade'] }}
                                            </span>
                                            <div class="text-xs text-gray-500 mt-1">{{ $item['functionality'] }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Battery: {{ $item['battery'] }}</div>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            {{ $item['coa'] }}
                                            <div class="text-xs text-gray-500 mt-1">Keyboard: {{ $item['keyboard'] }}</div>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500">
                                            <div class="text-sm text-red-500">{{ $item['problems'] }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ $item['info'] }}</div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <button class="text-indigo-600 hover:text-indigo-900 block mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                                </svg>
                                                Import
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Add to Cart
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
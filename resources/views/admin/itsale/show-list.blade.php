<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $listDetails['name'] }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.itsale.scraper', $supplier) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Lists') }}
                </a>
                @php
                    $itsaleUrl = "https://itsale.pl/list/{$listSlug}";
                @endphp
                <a href="{{ $itsaleUrl }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
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

            <!-- Import Summary (if available) -->
            @if (session('import_summary'))
                <div class="mb-6 bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Import Summary</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <!-- Batch Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-base font-semibold text-gray-900 mb-2">Batch Information</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Name:</dt>
                                        <dd class="text-sm text-gray-900">{{ session('import_summary')['batch_info']['name'] }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Reference:</dt>
                                        <dd class="text-sm text-gray-900">{{ session('import_summary')['batch_info']['reference'] }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                        <dd class="text-sm text-gray-900">{{ session('import_summary')['batch_info']['status'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <!-- Source Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-base font-semibold text-gray-900 mb-2">Source Information</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Type:</dt>
                                        <dd class="text-sm text-gray-900">{{ session('import_summary')['source_info']['type'] }}</dd>
                                    </div>
                                    @if(session('import_summary')['source_info']['supplier'])
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Supplier:</dt>
                                        <dd class="text-sm text-gray-900">{{ session('import_summary')['source_info']['supplier'] }}</dd>
                                    </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Reference:</dt>
                                        <dd class="text-sm text-gray-900 truncate">{{ session('import_summary')['source_info']['external_reference'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <!-- Cost Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-base font-semibold text-gray-900 mb-2">Costs</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Batch Cost:</dt>
                                        <dd class="text-sm text-gray-900">€{{ number_format(session('import_summary')['costs']['batch_cost'], 2) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Shipping:</dt>
                                        <dd class="text-sm text-gray-900">€{{ number_format(session('import_summary')['costs']['shipping_cost'], 2) }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Tax:</dt>
                                        <dd class="text-sm text-gray-900">€{{ number_format(session('import_summary')['costs']['tax_amount'], 2) }}</dd>
                                    </div>
                                    <div class="flex justify-between font-bold">
                                        <dt class="text-sm text-gray-700">Total:</dt>
                                        <dd class="text-sm text-gray-900">€{{ number_format(session('import_summary')['costs']['total_cost'], 2) }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Field Mapping -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-base font-semibold text-gray-900 mb-2">Field Mapping</h4>
                                @if(count(session('import_summary')['field_mapping']) > 0)
                                    <div class="overflow-hidden shadow-sm border border-gray-200 rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ITSale Field</th>
                                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">System Parameter</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach(session('import_summary')['field_mapping'] as $field => $param)
                                                    <tr>
                                                        <td class="px-3 py-2 whitespace-nowrap text-xs font-medium text-gray-900">{{ $field }}</td>
                                                        <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">{{ $param }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No fields mapped.</p>
                                @endif
                            </div>
                            
                            <!-- Grade Information & Additional Parameters -->
                            <div class="grid grid-rows-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-base font-semibold text-gray-900 mb-2">Grade Information</h4>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <p class="text-xs font-medium text-gray-700">Visual Grade</p>
                                            <p class="text-sm text-gray-900">{{ session('import_summary')['grading_info']['visual_grade'] ?: 'Not detected' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-700">Tech Grade</p>
                                            <p class="text-sm text-gray-900">{{ session('import_summary')['grading_info']['tech_grade'] ?: 'Not detected' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-700">Problems</p>
                                            <p class="text-sm text-gray-900">{{ session('import_summary')['grading_info']['problems'] ?: 'None' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-base font-semibold text-gray-900 mb-2">Additional Parameters</h4>
                                    @if(count(session('import_summary')['additional_params']) > 0)
                                        <div class="overflow-hidden shadow-sm border border-gray-200 rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parameter</th>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach(session('import_summary')['additional_params'] as $param => $value)
                                                        <tr>
                                                            <td class="px-3 py-2 whitespace-nowrap text-xs font-medium text-gray-900">{{ $param }}</td>
                                                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">{{ $value }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500">No additional parameters.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button onclick="document.getElementById('import-summary').classList.add('hidden')" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                Hide Summary
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- List Overview and Tabs -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $listDetails['name'] }}</h3>
                            <p class="text-gray-500">{{ $listDetails['description'] }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-gray-900">{{ $listDetails['total_price'] }}</div>
                            <div class="text-sm text-gray-500">Total</div>
                            <div class="text-md font-medium text-gray-700 mt-1">~{{ $listDetails['avg_price'] }} Avg/unit</div>
                            <div class="text-md font-medium text-gray-700 mt-1">{{ $listDetails['units'] }} units</div>
                        </div>
                    </div>

                    <!-- Summary info in top section (not tabs) -->
                    <div class="mb-6">
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                            <!-- Cost -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Cost</h4>
                                <div class="flex items-center">
                                    @if(isset($listDetails['discounted_price']) && !empty($listDetails['discounted_price']))
                                        <div class="text-sm text-gray-500 line-through">{{ $listDetails['discounted_price'] }}</div>
                                    @endif
                                    <div class="ml-2 text-xl font-bold text-gray-900">{{ $listDetails['total_price'] }}</div>
                                    <div class="text-sm text-gray-500 ml-2">Total</div>
                                </div>
                                <div class="text-md font-medium text-gray-700 mt-1">~{{ $listDetails['avg_price'] }} Avg/unit</div>
                            </div>

                            <!-- Quantity -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Quantity</h4>
                                <div class="text-xl font-bold text-gray-900">{{ $listDetails['units'] }}<span class="text-sm text-gray-500 ml-1">units</span></div>
                            </div>

                            <!-- Visual Grade -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Visual grade</h4>
                                @if(isset($listDetails['visual_grade']) && is_array($listDetails['visual_grade']))
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(['A', 'B', 'C', 'D'] as $grade)
                                            @if(isset($listDetails['visual_grade'][$grade]) && !str_starts_with($listDetails['visual_grade'][$grade], '0%'))
                                                <div class="flex-shrink-0">
                                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-md {{ $grade == 'A' ? 'bg-green-100 text-green-800' : ($grade == 'B' ? 'bg-yellow-100 text-yellow-800' : ($grade == 'C' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                                        {{ $grade }}
                                                        <span class="ml-1 whitespace-nowrap">
                                                            @php
                                                                // Estrai solo la percentuale dal testo
                                                                $percentText = $listDetails['visual_grade'][$grade];
                                                                if (preg_match('/(\d+(?:\.\d+)?)%/', $percentText, $matches)) {
                                                                    echo $matches[0];
                                                                } else {
                                                                    echo $percentText;
                                                                }
                                                            @endphp
                                                        </span>
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No data</p>
                                @endif
                            </div>

                            <!-- Tech Grade -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Tech grade</h4>
                                @if(isset($listDetails['tech_grade']) && is_array($listDetails['tech_grade']))
                                    <div class="flex flex-wrap gap-2">
                                        @php
                                            $techGrades = [
                                                'Working' => ['bg-green-100', 'text-green-800'],
                                                'Working*' => ['bg-yellow-100', 'text-yellow-800'],
                                                'Not working' => ['bg-red-100', 'text-red-800']
                                            ];
                                            
                                            // Versioni abbreviate dei nomi
                                            $shortNames = [
                                                'Working' => 'Work',
                                                'Working*' => 'Work*',
                                                'Not working' => 'Not work'
                                            ];
                                        @endphp

                                        @foreach($techGrades as $grade => $classes)
                                            @if(isset($listDetails['tech_grade'][$grade]) && !str_starts_with($listDetails['tech_grade'][$grade], '0%'))
                                                <div class="flex-shrink-0">
                                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-md {{ $classes[0] }} {{ $classes[1] }}">
                                                        {{ $shortNames[$grade] }}
                                                        <span class="ml-1 whitespace-nowrap">
                                                            @php
                                                                // Estrai solo la percentuale dal testo
                                                                $percentText = $listDetails['tech_grade'][$grade];
                                                                if (preg_match('/(\d+(?:\.\d+)?)%/', $percentText, $matches)) {
                                                                    echo $matches[0];
                                                                } else {
                                                                    echo $percentText;
                                                                }
                                                            @endphp
                                                        </span>
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No data</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-4 mb-6">
                        <button class="inline-flex justify-center items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Make Offer
                        </button>
                        <a href="{{ route('admin.itsale.scraper.show-import-form', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" class="inline-flex justify-center items-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Import As Batch
                        </a>
                        <button class="inline-flex justify-center items-center px-6 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export to Excel
                        </button>
                        @if(!isset($loadImages) || !$loadImages)
                        <a href="{{ route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug, 'loadImages' => 'true']) }}" class="inline-flex justify-center items-center px-6 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Load Images
                        </a>
                        @else
                        <a href="{{ route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" class="inline-flex justify-center items-center px-6 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Hide Images
                        </a>
                        @endif
                    </div>

                    <!-- Tabs Navigation (only for products now) -->
                    <div class="border-b border-gray-200 mb-6">
                        <ul class="flex -mb-px" id="tabs" role="tablist">
                            <li class="mr-1" role="presentation">
                                <button class="py-2 px-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600 active" id="products-tab" data-tab="products" type="button" role="tab" aria-controls="products" aria-selected="true">
                                    Products ({{ count($listDetails['items']) }})
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div id="tabContent">
                        <!-- Products Tab (now always visible) -->
                        <div class="block" id="products" role="tabpanel" aria-labelledby="products-tab">
                            <div class="overflow-x-auto">
                                @if(count($listDetails['items']) > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type/Producer/Model</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPU/RAM/Drive</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Screen</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Battery</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info/Problems</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($listDetails['items'] as $index => $item)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-indigo-50">
                                                <td class="px-3 py-4 whitespace-nowrap">
                                                    <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden cursor-pointer" onclick="openImageModal(this, {{ $index }})">
                                                        @if(isset($item['image']) && !empty($item['image']))
                                                            <img src="{{ $item['image'] }}" alt="{{ $item['producer'] ?? '' }} {{ $item['model'] ?? '' }}" class="h-full w-full object-contain" loading="lazy" data-full-img="{{ str_replace('product_thumbnails', 'product_imgs', $item['image']) }}" @if(isset($item['alternative_image'])) data-alt-img="{{ str_replace('product_thumbnails', 'product_imgs', $item['alternative_image']) }}" @endif @if(isset($item['product_id'])) data-product-id="{{ $item['product_id'] }}" @endif onerror="this.onerror=null; @if(isset($item['alternative_image'])) this.src='{{ $item['alternative_image'] }}'; @else this.parentNode.innerHTML='<div class=\'h-full w-full flex items-center justify-center bg-gray-200 text-gray-500\'>No Image</div>'; @endif">
                                                        @elseif(isset($item['photo_url']) && !empty($item['photo_url']))
                                                            <img src="{{ $item['photo_url'] }}" alt="{{ $item['producer'] ?? '' }} {{ $item['model'] ?? '' }}" class="h-full w-full object-contain" loading="lazy" data-full-img="{{ str_replace(['/t_', '_thumbnail', '_small', '_medium'], ['/', '', '', ''], $item['photo_url']) }}" onerror="this.onerror=null;this.parentNode.innerHTML='<div class=\'h-full w-full flex items-center justify-center bg-gray-200 text-gray-500\'>No Image</div>';">
                                                        @elseif(isset($item['img_url']) && !empty($item['img_url']))
                                                            <img src="{{ $item['img_url'] }}" alt="{{ $item['producer'] ?? '' }} {{ $item['model'] ?? '' }}" class="h-full w-full object-contain" loading="lazy" data-full-img="{{ str_replace(['/t_', '_thumbnail', '_small', '_medium'], ['/', '', '', ''], $item['img_url']) }}" onerror="this.onerror=null;this.parentNode.innerHTML='<div class=\'h-full w-full flex items-center justify-center bg-gray-200 text-gray-500\'>No Image</div>';">
                                                        @else
                                                            <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500">No Image</div>
                                                        @endif
                                                        
                                                        @if(isset($item['additional_images']) && count($item['additional_images']) > 0)
                                                            <div class="absolute bottom-0 right-0 bg-blue-500 text-white text-xs font-bold px-1 rounded-tl">+{{ count($item['additional_images']) }}</div>
                                                            <div class="hidden">
                                                                @foreach($item['additional_images'] as $idx => $addImg)
                                                                    <span 
                                                                        data-idx="{{ $idx + 1 }}" 
                                                                        data-thumbnail="{{ $addImg['thumbnail'] }}" 
                                                                        data-fullsize="{{ $addImg['fullsize'] }}" 
                                                                        data-alternate="{{ $addImg['alternate'] }}">
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item['producer'] ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $item['model'] ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $item['type'] ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-3 py-4">
                                                    <div class="text-sm text-gray-900">{{ $item['cpu'] ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $item['ram'] ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $item['drive'] ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-3 py-4">
                                                    <div class="text-sm text-gray-900">{{ $item['screen_size'] ?? 'N/A' }}</div>
                                                    <div class="text-sm text-gray-500">{{ $item['resolution'] ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">LCD: {{ $item['lcd_quality'] ?? 'N/A' }}</div>
                                                </td>
                                                <td class="px-3 py-4">
                                                    @php
                                                        $visualGrade = '';
                                                        $functionality = '';
                                                        $securityMark = '';
                                                        $problems = '';
                                                        
                                                        // Estrai visual grade
                                                        if (isset($item['visual_grade'])) {
                                                            // Estrae solo la lettera del grade se il valore contiene altri dettagli
                                                            if (preg_match('/([A-C])[^A-C]*$/i', $item['visual_grade'], $gradeMatches)) {
                                                                $visualGrade = strtoupper($gradeMatches[1]);
                                                            } else {
                                                                $visualGrade = $item['visual_grade'];
                                                            }
                                                        } elseif (isset($item['grade'])) {
                                                            if (preg_match('/Visual\s+grade:\s*([A-Z])/i', $item['grade'], $matches)) {
                                                                $visualGrade = strtoupper($matches[1]);
                                                            } elseif (preg_match('/Grade\s+([A-Z])/i', $item['grade'], $matches)) {
                                                                $visualGrade = strtoupper($matches[1]);
                                                            }
                                                        }
                                                        
                                                        // Estrai functionality
                                                        if (isset($item['functionality'])) {
                                                            $functionality = $item['functionality'];
                                                        } elseif (isset($item['grade'])) {
                                                            if (preg_match('/Functionality:\s+([^\n]+)/i', $item['grade'], $matches)) {
                                                                $functionality = trim($matches[1]);
                                                            }
                                                        }
                                                        
                                                        // Estrai security mark
                                                        if (isset($item['security_mark'])) {
                                                            $securityMark = $item['security_mark'];
                                                        } elseif (isset($item['grade']) && preg_match('/Security\s+mark:\s+([^\n]*)/i', $item['grade'], $matches)) {
                                                            $securityMark = trim($matches[1]);
                                                        }
                                                        
                                                        // Estrai problems
                                                        if (isset($item['problems'])) {
                                                            $problems = $item['problems'];
                                                        } elseif (isset($item['grade']) && preg_match('/Problems:\s+([^\n]*)/i', $item['grade'], $matches)) {
                                                            $problems = trim($matches[1]);
                                                        }
                                                        
                                                        // Determina il colore in base alla functionality
                                                        $badgeColor = '';
                                                        if (stripos($functionality, 'Working') !== false && stripos($functionality, 'Working*') === false) {
                                                            $badgeColor = 'bg-green-100 text-green-800';
                                                        } elseif (stripos($functionality, 'Working*') !== false) {
                                                            $badgeColor = 'bg-yellow-100 text-yellow-800';
                                                        } elseif (stripos($functionality, 'Not working') !== false) {
                                                            $badgeColor = 'bg-red-100 text-red-800';
                                                        } else {
                                                            $badgeColor = 'bg-gray-100 text-gray-800';
                                                        }
                                                    @endphp
                                                    
                                                    <!-- Badge con Grade X e tooltip con dettagli -->
                                                    <div class="relative" id="grade-badge-{{ $index }}">
                                                        @if(!empty($visualGrade))
                                                            <div class="inline-block rounded-full px-3 py-1 text-xs font-bold {{ $badgeColor }} cursor-pointer">
                                                                Grade {{ $visualGrade }}
                                                            </div>
                                                        @else
                                                            <div class="inline-block rounded-full px-3 py-1 text-xs font-bold bg-gray-100 text-gray-800 cursor-pointer">
                                                                N/A
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Tooltip con dettagli completi, inizialmente nascosto -->
                                                        <div id="tooltip-{{ $index }}" style="display: none;" class="absolute z-50 w-60 p-3 mt-1 text-sm bg-white rounded-md shadow-lg border border-gray-200">
                                                            <div class="text-xs text-gray-700 space-y-1">
                                                                <div class="mb-2"><span class="font-semibold">Visual grade:</span> {{ $visualGrade ?: 'N/A' }}</div>
                                                                <div class="mb-2"><span class="font-semibold">Functionality:</span> {{ $functionality ?: 'N/A' }}</div>
                                                                @if(!empty($securityMark))
                                                                    <div class="mb-2"><span class="font-semibold">Security mark:</span> {{ $securityMark }}</div>
                                                                @endif
                                                                @if(!empty($problems))
                                                                    <div><span class="font-semibold">Problems:</span> {{ $problems }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            const badge = document.getElementById('grade-badge-{{ $index }}');
                                                            const tooltip = document.getElementById('tooltip-{{ $index }}');
                                                            
                                                            badge.addEventListener('mouseenter', function() {
                                                                tooltip.style.display = 'block';
                                                            });
                                                            
                                                            badge.addEventListener('mouseleave', function() {
                                                                tooltip.style.display = 'none';
                                                            });
                                                        });
                                                    </script>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    {{ $item['battery'] ?? 'N/A' }}
                                                </td>
                                                <td class="px-3 py-4 text-sm">
                                                    @if(isset($item['problems']) && !empty($item['problems']))
                                                        <div class="text-sm text-red-500">{{ $item['problems'] }}</div>
                                                    @endif
                                                    @if(isset($item['info']) && !empty($item['info']))
                                                        <div class="text-xs text-gray-500 mt-1">{{ $item['info'] }}</div>
                                                    @endif
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        @if(isset($item['keyboard']) && !empty($item['keyboard']))
                                                            Keyboard: {{ $item['keyboard'] }}<br>
                                                        @endif
                                                        @if(isset($item['coa']) && !empty($item['coa']))
                                                            COA: {{ $item['coa'] }}
                                                        @endif
                                                    </div>
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
                                @else
                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Products Available</h3>
                                        <p class="text-gray-600 mb-4">
                                            ITSale.pl reports this list has 0 products or we couldn't extract product data from the page.
                                        </p>
                                        <p class="text-sm text-gray-500 mb-4">
                                            This can happen if the products have already been sold or if the product list uses a different format than expected.
                                            Try visiting the list directly on ITSale.pl to see if products are available.
                                        </p>
                                        <div class="flex space-x-4">
                                            <a href="{{ route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug, 'refresh' => true]) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                                Refresh Data
                                            </a>
                                            <a href="{{ $itsaleUrl }}" target="_blank" 
                                               class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                View on ITSale.pl
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#tabs button');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    
                    // Update active tab
                    tabs.forEach(t => {
                        t.classList.remove('text-indigo-600', 'border-indigo-600');
                        t.classList.add('text-gray-500', 'border-transparent');
                        t.setAttribute('aria-selected', 'false');
                    });
                    
                    this.classList.remove('text-gray-500', 'border-transparent');
                    this.classList.add('text-indigo-600', 'border-indigo-600');
                    this.setAttribute('aria-selected', 'true');
                    
                    // Show the selected tab content
                    document.querySelectorAll('#tabContent > div').forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="background-color: rgba(0,0,0,0.8);">
        <div class="relative w-full max-w-4xl mx-auto">
            <!-- Close button -->
            <button id="closeImageModal" class="absolute top-4 right-4 text-white z-20 hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Previous button -->
            <button id="prevImage" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white z-20 hover:text-gray-300 bg-black bg-opacity-30 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <!-- Next button -->
            <button id="nextImage" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white z-20 hover:text-gray-300 bg-black bg-opacity-30 rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <!-- Image container -->
            <div class="bg-white p-2 rounded-lg">
                <div id="modalImageContainer" class="flex items-center justify-center h-[80vh] w-full relative">
                    <!-- Loading indicator -->
                    <div id="modalImageLoading" class="absolute inset-0 flex items-center justify-center bg-gray-200 bg-opacity-50 z-10">
                        <svg class="animate-spin h-12 w-12 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <img id="modalImage" src="" alt="Product Image" class="max-h-full max-w-full object-contain">
                </div>
                
                <!-- Thumbnails navigation -->
                <div id="imageThumbnails" class="flex overflow-x-auto p-2 gap-2 bg-gray-100 max-w-full">
                    <!-- Thumbnails will be added here dynamically -->
                </div>
                
                <div class="p-4 bg-gray-100">
                    <div id="imageCaption" class="text-center text-gray-700 font-medium"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Array per memorizzare le immagini disponibili
        let productImages = [];
        let currentImageIndex = 0;
        let currentProductId = null;

        // Funzione per ottenere l'URL dell'immagine a piena risoluzione
        function getFullSizeImageUrl(thumbnailUrl) {
            if (!thumbnailUrl) return '';
            
            // Verifica se l'URL contiene un ID prodotto di ITSale
            const itsaleProductMatch = thumbnailUrl.match(/product[_-](?:thumbnails|imgs)[\/\\\\](\d+)_(\d+)\.(jpg|png|webp)/i);
            if (itsaleProductMatch) {
                const productId = itsaleProductMatch[1];
                const imageIndex = itsaleProductMatch[2];
                // Preferisci WebP ma offri anche JPG come alternativa
                return `https://itsale.pl/product_imgs/${productId}_${imageIndex}.webp`;
            }
            
            // Altrimenti procedi con le sostituzioni standard
            let fullUrl = thumbnailUrl
                // Rimuovi parametri di dimensione comuni
                .replace(/(\?|&)(width|height|size|w|h|resize)=[^&]+/gi, '')
                // Rimuovi suffissi comuni per thumbnail
                .replace(/(_|\-)(thumbnail|thumb|small|medium|preview|t_|s_|m_)\./gi, '.')
                // Rimuovi cartelle thumbnail
                .replace(/(\/|\\)(thumbnails|thumbs|small|t_|preview)(\/|\\)/gi, '/')
                // Prova a sostituire le cartelle specifiche di ITSale
                .replace('/product_thumbnails/', '/product_imgs/')
                .replace('/thumbs/', '/full/')
                .replace('/small/', '/large/');
            
            // Rimuovi eventuali parametri di query
            const queryIndex = fullUrl.indexOf('?');
            if (queryIndex !== -1) {
                fullUrl = fullUrl.substring(0, queryIndex);
            }
            
            return fullUrl;
        }

        // Funzione per raccogliere le immagini aggiuntive per un prodotto
        function collectAdditionalImages(element, productId) {
            const additionalImages = [];
            
            // Cerca eventuali elementi nascosti con dati sulle immagini aggiuntive
            const hiddenImgContainer = element.querySelector('.hidden');
            if (hiddenImgContainer) {
                const imgDataElements = hiddenImgContainer.querySelectorAll('span[data-idx]');
                imgDataElements.forEach(el => {
                    additionalImages.push({
                        index: parseInt(el.getAttribute('data-idx')),
                        thumbnailSrc: el.getAttribute('data-thumbnail'),
                        src: el.getAttribute('data-fullsize'),
                        altSrc: el.getAttribute('data-alternate'),
                        alt: `Additional image ${el.getAttribute('data-idx')}`,
                        productId: productId
                    });
                });
            }
            
            // Se non ci sono immagini aggiuntive specificate negli elementi span,
            // proviamo a generare i possibili URL in base al productId
            if (additionalImages.length === 0 && productId) {
                for (let i = 2; i <= 5; i++) { // Verifica immagini 2-5
                    additionalImages.push({
                        index: i,
                        thumbnailSrc: `https://itsale.pl/product_thumbnails/${productId}_${i}.webp`,
                        src: `https://itsale.pl/product_imgs/${productId}_${i}.webp`,
                        altSrc: `https://itsale.pl/product_imgs/${productId}_${i}.jpg`,
                        alt: `Additional image ${i}`,
                        productId: productId
                    });
                }
            }
            
            return additionalImages;
        }

        // Funzione per aprire il modal
        function openImageModal(element, productIndex) {
            // Verifica se l'elemento contiene un'immagine
            const imgElement = element.querySelector('img');
            if (!imgElement) return;

            // Ottieni il product ID se disponibile
            currentProductId = imgElement.getAttribute('data-product-id');
            
            // Raccogli tutte le immagini disponibili nella tabella
            productImages = [];
            
            // Immagine principale
            const thumbnailSrc = imgElement.getAttribute('src');
            const fullSrc = imgElement.getAttribute('data-full-img');
            const altSrc = imgElement.getAttribute('data-alt-img');
            
            // Utilizza l'URL data-full-img se disponibile, altrimenti prova a generare l'URL per l'immagine originale
            const originalSrc = fullSrc || getFullSizeImageUrl(thumbnailSrc);
            
            productImages.push({
                src: originalSrc,
                thumbnailSrc: thumbnailSrc, // Salva anche l'URL della miniatura come fallback
                altSrc: altSrc, // URL alternativo se l'immagine principale non si carica
                alt: imgElement.getAttribute('alt'),
                index: 0,
                productId: currentProductId
            });
            
            // Aggiungi le immagini aggiuntive se disponibili
            if (currentProductId) {
                const additionalImages = collectAdditionalImages(element, currentProductId);
                productImages = productImages.concat(additionalImages);
            }

            // Se non ci sono immagini, esci
            if (productImages.length === 0) return;

            // Imposta l'indice corrente alla prima immagine
            currentImageIndex = 0;

            // Aggiorna l'immagine nel modal
            updateModalImage();
            
            // Aggiorna le thumbnail nel modal
            updateThumbnailsNavigation();

            // Mostra il modal
            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Disabilita lo scroll della pagina quando il modal è aperto
            document.body.style.overflow = 'hidden';
        }

        // Funzione per chiudere il modal
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Funzione per aggiornare l'immagine nel modal
        function updateModalImage() {
            const modalImage = document.getElementById('modalImage');
            const imageCaption = document.getElementById('imageCaption');
            const loadingIndicator = document.getElementById('modalImageLoading');
            
            if (productImages.length > 0 && currentImageIndex >= 0 && currentImageIndex < productImages.length) {
                const currentImage = productImages[currentImageIndex];
                
                // Mostra l'indicatore di caricamento
                if (loadingIndicator) loadingIndicator.classList.remove('hidden');
                
                // Imposta l'URL della miniatura come src temporaneo per un caricamento più veloce
                modalImage.src = currentImage.thumbnailSrc || '';
                
                // Crea un nuovo oggetto Image per precaricare l'immagine a piena risoluzione
                const fullImg = new Image();
                fullImg.onload = function() {
                    // Quando l'immagine è caricata, sostituisci con l'immagine a piena risoluzione
                    modalImage.src = currentImage.src;
                    // Nascondi l'indicatore di caricamento
                    if (loadingIndicator) loadingIndicator.classList.add('hidden');
                };
                
                fullImg.onerror = function() {
                    console.log('Errore nel caricamento dell\'immagine principale, tentativo con alternativa');
                    
                    // Se abbiamo un URL alternativo, proviamo quello
                    if (currentImage.altSrc) {
                        const altImg = new Image();
                        altImg.onload = function() {
                            modalImage.src = currentImage.altSrc;
                            if (loadingIndicator) loadingIndicator.classList.add('hidden');
                        };
                        
                        altImg.onerror = function() {
                            // Se anche l'immagine alternativa fallisce, usa la miniatura
                            console.log('Anche l\'immagine alternativa ha fallito, usando la miniatura');
                            modalImage.src = currentImage.thumbnailSrc || '';
                            if (loadingIndicator) loadingIndicator.classList.add('hidden');
                        };
                        
                        altImg.src = currentImage.altSrc;
                    } else {
                        // Se non abbiamo un'alternativa, usa la miniatura
                        modalImage.src = currentImage.thumbnailSrc || '';
                        if (loadingIndicator) loadingIndicator.classList.add('hidden');
                    }
                };
                
                // Inizia il caricamento dell'immagine a piena risoluzione
                fullImg.src = currentImage.src;
                
                modalImage.alt = currentImage.alt;
                imageCaption.textContent = currentImage.alt || `Image ${currentImageIndex + 1} of ${productImages.length}`;
                
                // Aggiorna le thumbnail attiva
                const thumbnails = document.querySelectorAll('#imageThumbnails .thumbnail');
                thumbnails.forEach((thumb, idx) => {
                    if (idx === currentImageIndex) {
                        thumb.classList.add('border-blue-500', 'border-2');
                    } else {
                        thumb.classList.remove('border-blue-500', 'border-2');
                    }
                });
            }

            // Mostra/nascondi i pulsanti di navigazione in base al numero di immagini
            const prevButton = document.getElementById('prevImage');
            const nextButton = document.getElementById('nextImage');
            
            if (productImages.length <= 1) {
                prevButton.classList.add('hidden');
                nextButton.classList.add('hidden');
            } else {
                prevButton.classList.remove('hidden');
                nextButton.classList.remove('hidden');
            }
        }

        // Funzione per aggiornare la navigazione delle thumbnail
        function updateThumbnailsNavigation() {
            const thumbnailsContainer = document.getElementById('imageThumbnails');
            
            // Svuota il container
            thumbnailsContainer.innerHTML = '';
            
            // Se c'è solo un'immagine, nascondi il container
            if (productImages.length <= 1) {
                thumbnailsContainer.classList.add('hidden');
                return;
            }
            
            // Mostra il container
            thumbnailsContainer.classList.remove('hidden');
            
            // Aggiungi thumbnail per ogni immagine
            productImages.forEach((image, index) => {
                const thumbnail = document.createElement('div');
                thumbnail.className = 'thumbnail h-16 w-16 flex-shrink-0 cursor-pointer border border-gray-300 rounded overflow-hidden';
                if (index === currentImageIndex) {
                    thumbnail.classList.add('border-blue-500', 'border-2');
                }
                
                // Crea elemento immagine
                const img = document.createElement('img');
                img.src = image.thumbnailSrc;
                img.alt = `Thumbnail ${index + 1}`;
                img.className = 'h-full w-full object-contain';
                
                // Gestisci errore se l'immagine non può essere caricata
                img.onerror = function() {
                    this.onerror = null;
                    this.parentNode.innerHTML = `<div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500 text-xs">${index + 1}</div>`;
                };
                
                // Aggiungi evento click
                thumbnail.addEventListener('click', function() {
                    currentImageIndex = index;
                    updateModalImage();
                });
                
                // Aggiungi immagine al thumbnail
                thumbnail.appendChild(img);
                
                // Aggiungi thumbnail al container
                thumbnailsContainer.appendChild(thumbnail);
            });
        }

        // Funzione per passare all'immagine precedente
        function showPreviousImage() {
            if (productImages.length <= 1) return;
            currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
            updateModalImage();
        }

        // Funzione per passare all'immagine successiva
        function showNextImage() {
            if (productImages.length <= 1) return;
            currentImageIndex = (currentImageIndex + 1) % productImages.length;
            updateModalImage();
        }

        // Aggiungi event listener quando il DOM è caricato
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener per chiudere il modal
            document.getElementById('closeImageModal').addEventListener('click', closeImageModal);
            
            // Event listener per passare all'immagine precedente
            document.getElementById('prevImage').addEventListener('click', showPreviousImage);
            
            // Event listener per passare all'immagine successiva
            document.getElementById('nextImage').addEventListener('click', showNextImage);
            
            // Event listener per chiudere il modal quando si clicca fuori dall'immagine
            document.getElementById('imageModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeImageModal();
                }
            });
            
            // Event listener per la navigazione con i tasti della tastiera
            document.addEventListener('keydown', function(event) {
                if (document.getElementById('imageModal').classList.contains('hidden')) return;
                
                if (event.key === 'Escape') {
                    closeImageModal();
                } else if (event.key === 'ArrowLeft') {
                    showPreviousImage();
                } else if (event.key === 'ArrowRight') {
                    showNextImage();
                }
            });
        });
    </script>
</x-admin-layout> 
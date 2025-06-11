<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Batches Management') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Status Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
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
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
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

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white border-l-4 border-red-600 rounded-lg shadow-sm p-4 flex items-center">
                        <div class="flex-shrink-0 bg-red-50 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Valore Stock</p>
                            <p class="text-lg font-bold text-gray-800">@formatPrice($batches->where('status', 'active')->sum('total_price'))</p>
                        </div>
                    </div>
                    
                    <div class="bg-white border-l-4 border-green-600 rounded-lg shadow-sm p-4 flex items-center">
                        <div class="flex-shrink-0 bg-green-50 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Valore Venduto</p>
                            <p class="text-lg font-bold text-gray-800">@formatPrice($batches->where('status', 'sold')->sum('total_price'))</p>
                        </div>
                    </div>
                    
                    <div class="bg-white border-l-4 border-blue-600 rounded-lg shadow-sm p-4 flex items-center">
                        <div class="flex-shrink-0 bg-blue-50 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Profit Totale</p>
                            <p class="text-lg font-bold text-gray-800">@formatPrice(0)</p>
                        </div>
                    </div>
                    
                    <div class="bg-white border-l-4 border-purple-600 rounded-lg shadow-sm p-4 flex items-center">
                        <div class="flex-shrink-0 bg-purple-50 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                        <div>
                            @php
                                $totalCost = $batches->sum('total_cost');
                                $marginPercent = $totalCost > 0 ? round((($batches->sum('sale_price') - $totalCost) / $totalCost) * 100, 1) : 0;
                            @endphp
                            <p class="text-sm font-medium text-gray-500">Margin Medio</p>
                            <p class="text-lg font-bold text-gray-800">{{ $marginPercent }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Top Section with Create Button and Stats -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                    <a href="{{ route('admin.batches.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-sm text-white tracking-wider hover:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-4 md:mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Create New Batch') }}
                    </a>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-50 text-blue-800">
                                Total: {{ $batches->total() }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-green-50 text-green-800">
                                Active: {{ $batches->where('status', 'active')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-amber-50 text-amber-800">
                                Reserved: {{ $batches->where('status', 'reserved')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-50 text-blue-800">
                                Value: @formatPrice($batches->sum('total_price'))
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <form method="GET" action="{{ route('admin.batches.index') }}" class="flex flex-wrap gap-3 items-center">
                        <div class="flex items-center">
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <select name="category_id" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">All Categories</option>
                                @foreach (\App\Models\Category::orderBy('name')->get() as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <select name="source_type" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">All Sources</option>
                                <option value="internal" {{ request('source_type') == 'internal' ? 'selected' : '' }}>Internal</option>
                                <option value="external" {{ request('source_type') == 'external' ? 'selected' : '' }}>External</option>
                                <option value="imported" {{ request('source_type') == 'imported' ? 'selected' : '' }}>Imported</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="search" name="search" value="{{ request('search') }}" class="pl-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Search name, model, ref...">
                            </div>
                        </div>
                        
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Filter
                        </button>
                        
                        @if(request()->anyFilled(['status', 'category_id', 'source_type', 'search']))
                            <a href="{{ route('admin.batches.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Batches Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Batch
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Manufacturer/Model
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Qty
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($batches as $batch)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            @if(isset($batch->images) && is_array($batch->images) && count($batch->images) > 0)
                                                @php
                                                    $imagePath = null;
                                                    if (isset($batch->images['default'])) {
                                                        $imagePath = $batch->images['default'];
                                                    } elseif (isset($batch->images[0])) {
                                                        $imagePath = $batch->images[0];
                                                    }
                                                @endphp
                                                @if($imagePath)
                                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $batch->name }}" 
                                                        class="h-10 w-10 object-cover rounded-md mr-3">
                                                @endif
                                            @endif
                                            <div>
                                                <div class="text-base font-normal text-gray-800">{{ $batch->name }}</div>
                                                <div class="text-xs text-gray-600">ID: {{ $batch->id }} | Ref: {{ $batch->reference_code }}</div>
                                                @if($batch->category)
                                                <div class="text-xs text-red-600">{{ $batch->category->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $batch->product_manufacturer }}</div>
                                        <div class="text-sm text-gray-700">{{ $batch->product_model }}</div>
                                        @if($batch->supplier)
                                            <div class="flex items-center text-xs text-gray-700 mt-1">
                                                @php
                                                    $supplier = \App\Models\ThirdPartySupplier::where('name', $batch->supplier)->first();
                                                @endphp
                                                @if($supplier && $supplier->logo)
                                                    <img src="{{ asset('storage/' . $supplier->logo) }}" alt="{{ $batch->supplier }}" class="h-4 w-4 mr-1 object-contain">
                                                @endif
                                                <span>{{ $batch->supplier }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium 
                                            @if($batch->status === 'active') bg-green-50 text-green-700
                                            @elseif($batch->status === 'reserved') bg-amber-50 text-amber-700
                                            @elseif($batch->status === 'sold') bg-blue-50 text-blue-700
                                            @else bg-gray-50 text-gray-700 @endif">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 
                                                @if($batch->status === 'active') text-green-700
                                                @elseif($batch->status === 'reserved') text-amber-700
                                                @elseif($batch->status === 'sold') text-blue-700
                                                @else text-gray-700 @endif" viewBox="0 0 20 20" fill="currentColor">
                                                @if($batch->status === 'active')
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                @elseif($batch->status === 'reserved')
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                @elseif($batch->status === 'sold')
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                                @else
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                @endif
                                            </svg>
                                            {{ ucfirst($batch->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                            @if($batch->source_type === 'external') bg-purple-50 text-purple-700
                                            @elseif($batch->source_type === 'imported') bg-cyan-50 text-cyan-700
                                            @else bg-gray-50 text-gray-700 @endif">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1
                                                @if($batch->source_type === 'external') text-purple-700
                                                @elseif($batch->source_type === 'imported') text-cyan-700
                                                @else text-gray-700 @endif" viewBox="0 0 20 20" fill="currentColor">
                                                @if($batch->source_type === 'external')
                                                <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
                                                @elseif($batch->source_type === 'imported')
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                @else
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                                @endif
                                            </svg>
                                            {{ ucfirst($batch->source_type ?? 'internal') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="inline-flex items-center justify-center px-3 py-1 bg-blue-50 text-blue-700 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-blue-700" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                                            </svg>
                                            <span class="font-bold">{{ $batch->total_quantity }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        @if($batch->sale_price)
                                            <div class="text-base font-bold text-blue-700">@formatPrice($batch->sale_price)</div>
                                        @else
                                            <div class="text-base font-bold text-blue-700">@formatPrice($batch->total_price)</div>
                                        @endif
                                        @if($batch->total_cost)
                                            <div class="text-xs text-red-600">Cost: @formatPrice($batch->total_cost)</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center space-x-1">
                                            <a href="{{ route('admin.batches.show', $batch) }}" class="inline-flex items-center p-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-md" title="View">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            
                                            <a href="{{ route('admin.batches.edit', $batch) }}" class="inline-flex items-center p-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-md" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <a href="{{ route('admin.batches.manage-products', $batch) }}" class="inline-flex items-center p-1.5 bg-green-50 text-green-700 hover:bg-green-100 rounded-md" title="Products">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </a>
                                            
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" class="inline-flex items-center p-1.5 bg-gray-50 text-gray-700 hover:bg-gray-100 rounded-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                    </svg>
                                                </button>
                                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                                    <div class="py-1">
                                                        <a href="{{ route('admin.batches.print-label', $batch) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                            Print Label
                                                        </a>
                                                        <a href="{{ route('admin.batches.print-product-labels', $batch) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                            Print Product Labels
                                                        </a>
                                                        <a href="{{ route('admin.batches.generate-pdf', $batch) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                            Generate PDF
                                                        </a>
                                                        <form action="{{ route('admin.batches.destroy', $batch) }}" method="POST" class="block" onsubmit="return confirm('Are you sure you want to delete this batch?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                                                Delete Batch
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <h3 class="mt-2 text-base font-medium text-gray-900">No batches found</h3>
                                        <p class="mt-1 text-sm text-gray-600">Get started by creating a new batch.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.batches.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                New Batch
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-5">
                    {{ $batches->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
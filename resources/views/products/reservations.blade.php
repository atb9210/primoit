<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">My Reservations</h1>
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($orders->isEmpty())
                        <div class="bg-gray-50 p-8 rounded-lg text-center">
                            <p class="text-gray-500 mb-4">You don't have any reservations yet.</p>
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">Browse available products</a>
                        </div>
                    @else
                        <div class="space-y-8">
                            @foreach($orders as $order)
                                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                                    <div class="bg-gray-100 px-6 py-4 border-b">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="text-lg font-semibold">Order #{{ $order->id }}</h3>
                                                <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="px-6 py-4">
                                        @foreach($order->items as $item)
                                            <div class="flex flex-col md:flex-row md:items-center py-4 border-b">
                                                <div class="md:w-24 h-24 flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                                                    @if($item->product && $item->product->primaryImage)
                                                        <img src="{{ asset('storage/' . $item->product->primaryImage->path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain">
                                                    @else
                                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                            <span class="text-gray-400">No image</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow">
                                                    <h4 class="font-semibold">
                                                        @if($item->product)
                                                            <a href="{{ route('products.show', $item->product->slug) }}" class="text-blue-600 hover:text-blue-800">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        @else
                                                            Product no longer available
                                                        @endif
                                                    </h4>
                                                    @if($item->product)
                                                        <p class="text-sm text-gray-500">{{ Str::limit($item->product->description, 100) }}</p>
                                                    @endif
                                                </div>
                                                <div class="mt-4 md:mt-0 md:ml-6 text-right">
                                                    <p class="font-medium">€{{ number_format($item->price, 2) }}</p>
                                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        <div class="mt-6 flex justify-between items-center">
                                            <div>
                                                @if($order->notes)
                                                    <p class="text-sm text-gray-600"><span class="font-medium">Notes:</span> {{ $order->notes }}</p>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Total Amount</p>
                                                <p class="text-xl font-bold">€{{ number_format($order->total_amount, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
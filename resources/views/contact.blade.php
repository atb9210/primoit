<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Contact PrimoIT</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Send Us a Message</h2>
                            
                            @if (session('success'))
                                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <form action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('name')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('email')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('company')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @error('phone')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                                    <textarea name="message" id="message" rows="5" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
                                    @error('message')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mt-6">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Our Information</h2>
                            
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-900 mb-2">Address</h3>
                                    <p class="text-gray-600">
                                        PrimoIT B.V.<br>
                                        123 Business Avenue<br>
                                        1234 AB Amsterdam<br>
                                        The Netherlands
                                    </p>
                                </div>
                                
                                <div class="mb-6">
                                    <h3 class="font-medium text-gray-900 mb-2">Contact Details</h3>
                                    <p class="text-gray-600 mb-1">
                                        <span class="font-medium">Phone:</span> +31 20 123 4567
                                    </p>
                                    <p class="text-gray-600 mb-1">
                                        <span class="font-medium">Email:</span> info@primoit.com
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Business Hours:</span> Monday-Friday, 9am-5pm CET
                                    </p>
                                </div>
                                
                                <div>
                                    <h3 class="font-medium text-gray-900 mb-2">Business Information</h3>
                                    <p class="text-gray-600 mb-1">
                                        <span class="font-medium">VAT Number:</span> NL123456789B01
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-medium">Chamber of Commerce:</span> 12345678
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
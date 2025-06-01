<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Configure') }} {{ $supplier->name }}
            </h2>
            <div class="flex space-x-2">
                @if($supplier->name == 'ITSale.pl')
                <a href="{{ route('admin.suppliers.itsale-scraper', $supplier) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    {{ __('Open ITSale Scraper') }}
                </a>
                @endif
                <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Suppliers') }}
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

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center space-x-4 mb-6">
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
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <form method="POST" action="{{ route('admin.suppliers.update-credentials', $supplier) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Authentication Credentials</h3>
                                
                                <!-- Logo Upload Section -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Logo</h3>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden mr-4">
                                            @if($supplier->logo)
                                                <img src="{{ Storage::url($supplier->logo) }}" alt="{{ $supplier->name }}" class="h-full w-full object-contain p-1">
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <label for="logo" class="block text-sm font-medium text-gray-700">Update Logo</label>
                                            <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-indigo-50 file:text-indigo-700
                                                hover:file:bg-indigo-100">
                                            <p class="text-xs text-gray-500 mt-1">Upload a square logo image (max 2MB).</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($supplier->name == 'ITSale.pl')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="credentials[username]" class="block text-sm font-medium text-gray-700">Username</label>
                                            <input type="text" name="credentials[username]" id="credentials[username]" 
                                                value="{{ old('credentials.username', $supplier->credentials['username'] ?? '') }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        
                                        <div>
                                            <label for="credentials[password]" class="block text-sm font-medium text-gray-700">Password</label>
                                            <div class="relative">
                                                <input type="password" name="credentials[password]" id="credentials[password]" 
                                                    value="{{ old('credentials.password', $supplier->credentials['password'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <div id="passwordFeedback" class="hidden absolute top-1/2 right-2 transform -translate-y-1/2 text-green-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">Inserisci la password dell'account ITSale.pl</p>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    You need to have a valid ITSale.pl account to use this integration. The credentials are stored securely and are only used to access their platform.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($supplier->name == 'Foxway.shop')
                                    <div>
                                        <label for="credentials[api_key]" class="block text-sm font-medium text-gray-700">API Key</label>
                                        <div class="relative">
                                            <input type="text" name="credentials[api_key]" id="credentials[api_key]" 
                                                value="{{ old('credentials.api_key', $supplier->credentials['api_key'] ?? '') }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <div id="apiKeyFeedback" class="hidden absolute top-1/2 right-2 transform -translate-y-1/2 text-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Inserisci la API Key fornita da Foxway.shop</p>
                                    </div>
                                    
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    You need to request an API key from Foxway.shop to use this integration. Contact their support team to get your API credentials.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 gap-6">
                                        @if($supplier->integration_type == 'api')
                                            <div>
                                                <label for="credentials[api_key]" class="block text-sm font-medium text-gray-700">API Key</label>
                                                <input type="text" name="credentials[api_key]" id="credentials[api_key]" 
                                                    value="{{ old('credentials.api_key', $supplier->credentials['api_key'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            
                                            <div>
                                                <label for="credentials[api_secret]" class="block text-sm font-medium text-gray-700">API Secret (optional)</label>
                                                <input type="password" name="credentials[api_secret]" id="credentials[api_secret]" 
                                                    value="{{ old('credentials.api_secret', $supplier->credentials['api_secret'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            
                                            <div>
                                                <label for="credentials[api_url]" class="block text-sm font-medium text-gray-700">API URL</label>
                                                <input type="url" name="credentials[api_url]" id="credentials[api_url]" 
                                                    value="{{ old('credentials.api_url', $supplier->credentials['api_url'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        @elseif($supplier->integration_type == 'scraping')
                                            <div>
                                                <label for="credentials[username]" class="block text-sm font-medium text-gray-700">Username</label>
                                                <input type="text" name="credentials[username]" id="credentials[username]" 
                                                    value="{{ old('credentials.username', $supplier->credentials['username'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            
                                            <div>
                                                <label for="credentials[password]" class="block text-sm font-medium text-gray-700">Password</label>
                                                <input type="password" name="credentials[password]" id="credentials[password]" 
                                                    value="{{ old('credentials.password', $supplier->credentials['password'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            
                                            <div>
                                                <label for="credentials[login_url]" class="block text-sm font-medium text-gray-700">Login URL</label>
                                                <input type="url" name="credentials[login_url]" id="credentials[login_url]" 
                                                    value="{{ old('credentials.login_url', $supplier->credentials['login_url'] ?? '') }}" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        @else
                                            <div>
                                                <label for="credentials[notes]" class="block text-sm font-medium text-gray-700">Integration Notes</label>
                                                <textarea name="credentials[notes]" id="credentials[notes]" rows="3" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('credentials.notes', $supplier->credentials['notes'] ?? '') }}</textarea>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="pt-6">
                                    <h3 class="text-lg font-medium text-gray-900">Sync Settings</h3>
                                    <p class="text-sm text-gray-500 mt-1">These settings control how products are imported from this supplier.</p>
                                    
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="credentials[sync_frequency]" class="block text-sm font-medium text-gray-700">Sync Frequency</label>
                                            <select name="credentials[sync_frequency]" id="credentials[sync_frequency]"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="daily" {{ old('credentials.sync_frequency', $supplier->credentials['sync_frequency'] ?? '') == 'daily' ? 'selected' : '' }}>Daily</option>
                                                <option value="weekly" {{ old('credentials.sync_frequency', $supplier->credentials['sync_frequency'] ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                <option value="manual" {{ old('credentials.sync_frequency', $supplier->credentials['sync_frequency'] ?? 'manual') == 'manual' ? 'selected' : '' }}>Manual Only</option>
                                            </select>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <input type="checkbox" name="credentials[auto_publish]" id="credentials[auto_publish]" 
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                                {{ old('credentials.auto_publish', $supplier->credentials['auto_publish'] ?? false) ? 'checked' : '' }}>
                                            <label for="credentials[auto_publish]" class="ml-2 block text-sm text-gray-700">
                                                Auto-publish imported products
                                            </label>
                                            <p class="ml-2 text-xs text-gray-500">(If unchecked, imported products will need manual approval)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Save Configuration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password input per ITSale.pl
            const passwordInput = document.getElementById('credentials[password]');
            const passwordFeedback = document.getElementById('passwordFeedback');
            
            if (passwordInput && passwordFeedback) {
                passwordInput.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        passwordFeedback.classList.remove('hidden');
                    } else {
                        passwordFeedback.classList.add('hidden');
                    }
                });
                
                // Check initial state
                if (passwordInput.value.length > 0) {
                    passwordFeedback.classList.remove('hidden');
                }
            }
            
            // API Key input per Foxway.shop
            const apiKeyInput = document.getElementById('credentials[api_key]');
            const apiKeyFeedback = document.getElementById('apiKeyFeedback');
            
            if (apiKeyInput && apiKeyFeedback) {
                apiKeyInput.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        apiKeyFeedback.classList.remove('hidden');
                    } else {
                        apiKeyFeedback.classList.add('hidden');
                    }
                });
                
                // Check initial state
                if (apiKeyInput.value.length > 0) {
                    apiKeyFeedback.classList.remove('hidden');
                }
            }
        });
    </script>
</x-admin-layout> 
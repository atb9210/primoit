<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(isset($configureParams) && $configureParams)
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Configure Parameters for "{{ $category->name }}"</h2>
                                <p class="text-sm text-gray-600 mb-4">Define the parameters that will be suggested when creating batches for this category.</p>
                                
                                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                                    <h4 class="text-sm font-semibold text-blue-700 mb-2">Suggested Parameters</h4>
                                    
                                    <div id="parameters-container" class="space-y-3">
                                        @php
                                            $parameters = isset($category->attributes['parameters']) ? $category->attributes['parameters'] : [];
                                        @endphp
                                        
                                        @if(count($parameters) > 0)
                                            @foreach($parameters as $index => $parameter)
                                                <div class="parameter-row flex items-center space-x-2">
                                                    <input type="text" name="parameters[]" value="{{ $parameter }}" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <button type="button" class="remove-parameter inline-flex items-center p-1.5 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="parameter-row flex items-center space-x-2">
                                                <input type="text" name="parameters[]" placeholder="Enter parameter name" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <button type="button" class="remove-parameter inline-flex items-center p-1.5 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="button" id="add-parameter" class="inline-flex items-center px-3 py-1.5 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Add Parameter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between">
                                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Back to List
                                </a>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Save Parameters
                                </button>
                            </div>
                        </form>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const container = document.getElementById('parameters-container');
                                const addButton = document.getElementById('add-parameter');
                                
                                // Add new parameter row
                                addButton.addEventListener('click', function() {
                                    const row = document.createElement('div');
                                    row.className = 'parameter-row flex items-center space-x-2';
                                    row.innerHTML = `
                                        <input type="text" name="parameters[]" placeholder="Enter parameter name" class="flex-grow rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="button" class="remove-parameter inline-flex items-center p-1.5 border border-transparent rounded-full text-red-600 hover:bg-red-100 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    `;
                                    container.appendChild(row);
                                    
                                    // Focus on the new input
                                    row.querySelector('input').focus();
                                    
                                    // Add event listener to remove button
                                    const removeButton = row.querySelector('.remove-parameter');
                                    removeButton.addEventListener('click', function() {
                                        row.remove();
                                    });
                                });
                                
                                // Add event listeners to existing remove buttons
                                document.querySelectorAll('.remove-parameter').forEach(button => {
                                    button.addEventListener('click', function() {
                                        this.closest('.parameter-row').remove();
                                    });
                                });
                            });
                        </script>
                    @else
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description (optional)</label>
                            <textarea name="description" id="description" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">Cancel</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Update Category</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
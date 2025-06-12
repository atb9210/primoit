<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Impostazioni') }}: {{ $groupName }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Torna alle Impostazioni') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.settings.update', $group) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @foreach($settings as $setting)
                            <div class="mb-8 pb-6 border-b border-gray-200">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 md:w-1/4 mb-2 md:mb-0">
                                        {{ $setting->name }}
                                    </label>
                                    
                                    <div class="md:w-3/4">
                                        @switch($setting->type)
                                            @case('text')
                                                <input type="text" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    {{ $setting->is_system ? 'readonly' : '' }}>
                                                @break
                                                
                                            @case('textarea')
                                                <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="3"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    {{ $setting->is_system ? 'readonly' : '' }}>{{ old($setting->key, $setting->value) }}</textarea>
                                                @break
                                                
                                            @case('json')
                                                <textarea id="{{ $setting->key }}" name="{{ $setting->key }}" rows="5"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm"
                                                    {{ $setting->is_system ? 'readonly' : '' }}>{{ old($setting->key, $setting->value) }}</textarea>
                                                <p class="mt-1 text-xs text-gray-500">Formato JSON valido richiesto</p>
                                                @break
                                                
                                            @case('boolean')
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="{{ $setting->key }}" name="{{ $setting->key }}" value="1"
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                        {{ old($setting->key, $setting->value) ? 'checked' : '' }}
                                                        {{ $setting->is_system ? 'disabled' : '' }}>
                                                    <label for="{{ $setting->key }}" class="ml-2 text-sm text-gray-600">Attiva</label>
                                                </div>
                                                @break
                                                
                                            @case('image')
                                                <div class="flex flex-col space-y-2">
                                                    @if($setting->value)
                                                        <div class="mb-2">
                                                            <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->name }}" class="max-h-32 max-w-full rounded-md border border-gray-200">
                                                            <div class="mt-1 flex items-center">
                                                                <input type="checkbox" id="remove_{{ $setting->key }}" name="remove_{{ $setting->key }}" class="rounded border-gray-300 text-red-600">
                                                                <label for="remove_{{ $setting->key }}" class="ml-2 text-sm text-red-600">Rimuovi immagine esistente</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <input type="file" id="{{ $setting->key }}" name="{{ $setting->key }}" accept="image/*"
                                                        class="block w-full text-sm text-gray-500
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-full file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-indigo-50 file:text-indigo-700
                                                        hover:file:bg-indigo-100"
                                                        {{ $setting->is_system ? 'disabled' : '' }}>
                                                </div>
                                                @break
                                                
                                            @case('file')
                                                <div class="flex flex-col space-y-2">
                                                    @if($setting->value)
                                                        <div class="mb-2">
                                                            <div class="p-2 bg-gray-50 border border-gray-200 rounded-md flex items-center">
                                                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                <span class="text-sm text-gray-600">{{ basename($setting->value) }}</span>
                                                                <a href="{{ Storage::url($setting->value) }}" target="_blank" class="ml-2 text-xs text-indigo-600 hover:text-indigo-500">
                                                                    Visualizza
                                                                </a>
                                                            </div>
                                                            <div class="mt-1 flex items-center">
                                                                <input type="checkbox" id="remove_{{ $setting->key }}" name="remove_{{ $setting->key }}" class="rounded border-gray-300 text-red-600">
                                                                <label for="remove_{{ $setting->key }}" class="ml-2 text-sm text-red-600">Rimuovi file esistente</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    <input type="file" id="{{ $setting->key }}" name="{{ $setting->key }}"
                                                        class="block w-full text-sm text-gray-500
                                                        file:mr-4 file:py-2 file:px-4
                                                        file:rounded-full file:border-0
                                                        file:text-sm file:font-semibold
                                                        file:bg-indigo-50 file:text-indigo-700
                                                        hover:file:bg-indigo-100"
                                                        {{ $setting->is_system ? 'disabled' : '' }}>
                                                </div>
                                                @break
                                                
                                            @default
                                                <input type="text" id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                    {{ $setting->is_system ? 'readonly' : '' }}>
                                        @endswitch
                                        
                                        @if($setting->description)
                                            <p class="mt-1 text-sm text-gray-500">{{ $setting->description }}</p>
                                        @endif
                                        
                                        @error($setting->key)
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                Annulla
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                Salva Impostazioni
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
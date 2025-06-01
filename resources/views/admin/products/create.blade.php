<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Product') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Back to Products') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.products.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Type')" />
                                <x-text-input id="type" class="block mt-1 w-full" type="text" name="type" :value="old('type')" required />
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Producer -->
                            <div>
                                <x-input-label for="producer" :value="__('Producer')" />
                                <x-text-input id="producer" class="block mt-1 w-full" type="text" name="producer" :value="old('producer')" required />
                                <x-input-error :messages="$errors->get('producer')" class="mt-2" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" required />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>

                            <!-- CPU -->
                            <div>
                                <x-input-label for="cpu" :value="__('CPU')" />
                                <x-text-input id="cpu" class="block mt-1 w-full" type="text" name="cpu" :value="old('cpu')" />
                                <x-input-error :messages="$errors->get('cpu')" class="mt-2" />
                            </div>

                            <!-- RAM -->
                            <div>
                                <x-input-label for="ram" :value="__('RAM')" />
                                <x-text-input id="ram" class="block mt-1 w-full" type="text" name="ram" :value="old('ram')" />
                                <x-input-error :messages="$errors->get('ram')" class="mt-2" />
                            </div>

                            <!-- Drive -->
                            <div>
                                <x-input-label for="drive" :value="__('Drive')" />
                                <x-text-input id="drive" class="block mt-1 w-full" type="text" name="drive" :value="old('drive')" />
                                <x-input-error :messages="$errors->get('drive')" class="mt-2" />
                            </div>

                            <!-- Operating System -->
                            <div>
                                <x-input-label for="operating_system" :value="__('Operating System (COA)')" />
                                <x-text-input id="operating_system" class="block mt-1 w-full" type="text" name="operating_system" :value="old('operating_system')" />
                                <x-input-error :messages="$errors->get('operating_system')" class="mt-2" />
                            </div>

                            <!-- GPU -->
                            <div>
                                <x-input-label for="gpu" :value="__('GPU')" />
                                <x-text-input id="gpu" class="block mt-1 w-full" type="text" name="gpu" :value="old('gpu')" />
                                <x-input-error :messages="$errors->get('gpu')" class="mt-2" />
                            </div>

                            <!-- Has Box -->
                            <div>
                                <div class="flex items-center mt-4">
                                    <input id="has_box" type="checkbox" name="has_box" value="1" @checked(old('has_box')) class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="has_box" class="ml-2 text-sm font-medium text-gray-900">{{ __('With Box') }}</label>
                                </div>
                                <x-input-error :messages="$errors->get('has_box')" class="mt-2" />
                            </div>

                            <!-- Color -->
                            <div>
                                <x-input-label for="color" :value="__('Color')" />
                                <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color')" />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <!-- Screen Size -->
                            <div>
                                <x-input-label for="screen_size" :value="__('Screen Size')" />
                                <x-text-input id="screen_size" class="block mt-1 w-full" type="text" name="screen_size" :value="old('screen_size')" />
                                <x-input-error :messages="$errors->get('screen_size')" class="mt-2" />
                            </div>

                            <!-- LCD Quality -->
                            <div>
                                <x-input-label for="lcd_quality" :value="__('LCD Quality')" />
                                <x-text-input id="lcd_quality" class="block mt-1 w-full" type="text" name="lcd_quality" :value="old('lcd_quality')" />
                                <x-input-error :messages="$errors->get('lcd_quality')" class="mt-2" />
                            </div>

                            <!-- Battery -->
                            <div>
                                <x-input-label for="battery" :value="__('Battery')" />
                                <x-text-input id="battery" class="block mt-1 w-full" type="text" name="battery" :value="old('battery')" />
                                <x-input-error :messages="$errors->get('battery')" class="mt-2" />
                            </div>

                            <!-- Visual Grade -->
                            <div>
                                <x-input-label for="visual_grade" :value="__('Visual Grade')" />
                                <x-text-input id="visual_grade" class="block mt-1 w-full" type="text" name="visual_grade" :value="old('visual_grade')" />
                                <x-input-error :messages="$errors->get('visual_grade')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" step="0.01" min="0" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" :value="old('quantity', 1)" min="0" required />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="mt-6">
                            <x-input-label for="info" :value="__('Additional Information')" />
                            <textarea id="info" name="info" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('info') }}</textarea>
                            <x-input-error :messages="$errors->get('info')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
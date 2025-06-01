<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Category') }}
        </h2>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Categories') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                                </div>
                                
                                <div>
                                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                                    <select name="parent_id" id="parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">None (Top Level Category)</option>
                                        @foreach(\App\Models\Category::where('parent_id', null)->orderBy('name')->get() as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Visual Elements -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Visual Elements</h3>
                                
                                <div>
                                    <label for="icon_svg" class="block text-sm font-medium text-gray-700">SVG Icon</label>
                                    <div class="mt-1">
                                        <textarea name="icon_svg" id="icon_svg" rows="4" 
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm"
                                            placeholder='<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">...</svg>'>{{ old('icon_svg') }}</textarea>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Paste SVG code here. Example: &lt;svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"...&gt;</p>
                                    @error('icon_svg')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="icon_image" class="block text-sm font-medium text-gray-700">Icon Image</label>
                                    <div class="mt-1 flex items-center">
                                        <input type="file" name="icon_image" id="icon_image" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-md file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-indigo-50 file:text-indigo-700
                                            hover:file:bg-indigo-100">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Upload a PNG, JPG or GIF image (max 2MB)</p>
                                    @error('icon_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Attributes -->
                        <div class="mt-8 space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Category Attributes</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="attr_type" class="block text-sm font-medium text-gray-700">Type</label>
                                    <select name="attributes[type]" id="attr_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Type</option>
                                        <option value="computer" {{ old('attributes.type') == 'computer' ? 'selected' : '' }}>Computer</option>
                                        <option value="mobile" {{ old('attributes.type') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                                        <option value="tablet" {{ old('attributes.type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                        <option value="peripheral" {{ old('attributes.type') == 'peripheral' ? 'selected' : '' }}>Peripheral</option>
                                        <option value="accessory" {{ old('attributes.type') == 'accessory' ? 'selected' : '' }}>Accessory</option>
                                        <option value="other" {{ old('attributes.type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="attr_brand" class="block text-sm font-medium text-gray-700">Brand</label>
                                    <select name="attributes[brand]" id="attr_brand" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Brand</option>
                                        <option value="apple" {{ old('attributes.brand') == 'apple' ? 'selected' : '' }}>Apple</option>
                                        <option value="microsoft" {{ old('attributes.brand') == 'microsoft' ? 'selected' : '' }}>Microsoft</option>
                                        <option value="dell" {{ old('attributes.brand') == 'dell' ? 'selected' : '' }}>Dell</option>
                                        <option value="hp" {{ old('attributes.brand') == 'hp' ? 'selected' : '' }}>HP</option>
                                        <option value="lenovo" {{ old('attributes.brand') == 'lenovo' ? 'selected' : '' }}>Lenovo</option>
                                        <option value="samsung" {{ old('attributes.brand') == 'samsung' ? 'selected' : '' }}>Samsung</option>
                                        <option value="other" {{ old('attributes.brand') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="attr_portable" class="block text-sm font-medium text-gray-700">Portable</label>
                                    <select name="attributes[portable]" id="attr_portable" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Option</option>
                                        <option value="1" {{ old('attributes.portable') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('attributes.portable') == '0' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                                
                                <div id="peripheral_type_container" class="hidden">
                                    <label for="attr_peripheral_type" class="block text-sm font-medium text-gray-700">Peripheral Type</label>
                                    <select name="attributes[peripheral_type]" id="attr_peripheral_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Peripheral Type</option>
                                        <option value="display" {{ old('attributes.peripheral_type') == 'display' ? 'selected' : '' }}>Display</option>
                                        <option value="printer" {{ old('attributes.peripheral_type') == 'printer' ? 'selected' : '' }}>Printer</option>
                                        <option value="network" {{ old('attributes.peripheral_type') == 'network' ? 'selected' : '' }}>Network</option>
                                        <option value="docking" {{ old('attributes.peripheral_type') == 'docking' ? 'selected' : '' }}>Docking Station</option>
                                        <option value="projector" {{ old('attributes.peripheral_type') == 'projector' ? 'selected' : '' }}>Projector</option>
                                        <option value="other" {{ old('attributes.peripheral_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                
                                <div id="accessory_type_container" class="hidden">
                                    <label for="attr_accessory_type" class="block text-sm font-medium text-gray-700">Accessory Type</label>
                                    <select name="attributes[accessory_type]" id="attr_accessory_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Accessory Type</option>
                                        <option value="power" {{ old('attributes.accessory_type') == 'power' ? 'selected' : '' }}>Power/Cables</option>
                                        <option value="case" {{ old('attributes.accessory_type') == 'case' ? 'selected' : '' }}>Case/Bag</option>
                                        <option value="keyboard" {{ old('attributes.accessory_type') == 'keyboard' ? 'selected' : '' }}>Keyboard</option>
                                        <option value="mouse" {{ old('attributes.accessory_type') == 'mouse' ? 'selected' : '' }}>Mouse</option>
                                        <option value="general" {{ old('attributes.accessory_type') == 'general' ? 'selected' : '' }}>General</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label for="attributes_json" class="block text-sm font-medium text-gray-700">Additional Attributes (JSON)</label>
                                <textarea name="attributes_json" id="attributes_json" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm"
                                    placeholder='{"key": "value"}'></textarea>
                                <p class="mt-1 text-xs text-gray-500">Optional: Add any additional attributes in JSON format</p>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-8 flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('attr_type');
            const peripheralTypeContainer = document.getElementById('peripheral_type_container');
            const accessoryTypeContainer = document.getElementById('accessory_type_container');
            
            function updateDependentFields() {
                if (typeSelect.value === 'peripheral') {
                    peripheralTypeContainer.classList.remove('hidden');
                } else {
                    peripheralTypeContainer.classList.add('hidden');
                }
                
                if (typeSelect.value === 'accessory') {
                    accessoryTypeContainer.classList.remove('hidden');
                } else {
                    accessoryTypeContainer.classList.add('hidden');
                }
            }
            
            typeSelect.addEventListener('change', updateDependentFields);
            
            // Initial state
            updateDependentFields();
        });
    </script>
</x-admin-layout> 
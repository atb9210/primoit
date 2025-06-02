<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Import Batch: {{ $listDetails['name'] }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to List Details') }}
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

            <!-- Import Form -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Import List as Batch</h3>
                        <p class="text-gray-600">
                            You are about to import <span class="font-semibold">{{ $listDetails['name'] }}</span> with {{ count($products) }} products and {{ $listDetails['units'] }} units.
                            Please configure how the data should be imported into your system by mapping the fields below.
                        </p>
                    </div>

                    <!-- Batch Settings Form -->
                    <form action="{{ route('admin.itsale.scraper.import-batch', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" method="POST" class="space-y-8">
                        @csrf
                        <input type="hidden" name="confirm_import" value="1">
                        
                        <!-- Batch Information -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200">Batch Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="batch_name" class="block text-sm font-medium text-gray-700 mb-1">Batch Name</label>
                                    <input type="text" name="batch_name" id="batch_name" value="{{ $listDetails['name'] }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="batch_reference" class="block text-sm font-medium text-gray-700 mb-1">Reference Code</label>
                                    <input type="text" name="batch_reference" id="batch_reference" value="ITSALE-{{ strtoupper($listSlug) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="batch_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select name="batch_status" id="batch_status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="active" selected>Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="sold">Sold</option>
                                        <option value="reserved">Reserved</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="col-span-1 md:col-span-2">
                                    <label for="batch_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="batch_description" id="batch_description" rows="2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $listDetails['description'] }}</textarea>
                                </div>
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category_id" id="category_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Batch Source -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200">Batch Source</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="source_type" class="block text-sm font-medium text-gray-700 mb-1">Source Type</label>
                                    <select name="source_type" id="source_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="internal">Internal</option>
                                        <option value="external" selected>External</option>
                                    </select>
                                </div>
                                <div id="supplier_container">
                                    <label for="supplier" class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                                    <select name="supplier" id="supplier" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="ITSale" selected>ITSale</option>
                                        <option value="Foxway">Foxway</option>
                                        <option value="Ecorefurb">Ecorefurb</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="external_reference" class="block text-sm font-medium text-gray-700 mb-1">External Reference</label>
                                    <input type="text" name="external_reference" id="external_reference" value="https://itsale.pl/list/{{ $listSlug }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label for="batch_cost" class="block text-sm font-medium text-gray-700 mb-1">Batch Cost (€)</label>
                                    <input type="number" step="0.01" name="batch_cost" id="batch_cost" value="{{ (float)preg_replace('/[^0-9.,]/', '', $listDetails['total_price']) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md cost-input">
                                </div>
                                <div>
                                    <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost (€)</label>
                                    <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" value="0.00" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md cost-input">
                                </div>
                                <div>
                                    <label for="tax_amount" class="block text-sm font-medium text-gray-700 mb-1">Tax Amount (€)</label>
                                    <input type="number" step="0.01" name="tax_amount" id="tax_amount" value="0.00" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md cost-input">
                                </div>
                                <div>
                                    <label for="total_cost" class="block text-sm font-medium text-gray-700 mb-1">Total Cost (€)</label>
                                    <input type="number" step="0.01" name="total_cost" id="total_cost" readonly class="bg-gray-50 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- Field Mapping -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200">Field Mapping</h4>
                            <p class="text-sm text-gray-600 mb-3">Map the specifications from ITSale.pl to your system's fields. We'll automatically extract grading information from the Visual grade field.</p>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h5 class="text-sm font-semibold text-gray-700 mb-2">Preview of first product:</h5>
                                @if($sampleProduct && isset($sampleProduct['specs']) && is_array($sampleProduct['specs']))
                                    <div class="grid grid-cols-1 gap-4 text-xs">
                                        <div>
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spec</th>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($sampleProduct['specs'] as $key => $value)
                                                        <tr>
                                                            <td class="px-3 py-2 whitespace-nowrap text-xs font-medium text-gray-900">{{ $key }}</td>
                                                            <td class="px-3 py-2 whitespace-nowrap text-xs text-gray-500">{{ $value }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    @if(isset($sampleProduct['specs']['Visual grade']) || isset($sampleProduct['specs']['Grade']))
                                        @php
                                            // Cerca in tutti i campi possibili che potrebbero contenere info sul grade
                                            $gradeText = '';
                                            $possibleGradeFields = ['Visual grade', 'Grade', 'Condition', 'Quality', 'Status'];
                                            foreach ($possibleGradeFields as $field) {
                                                if (isset($sampleProduct['specs'][$field])) {
                                                    $gradeText .= $sampleProduct['specs'][$field] . ' ';
                                                }
                                            }
                                            
                                            // Cerca in tutti i campi dell'oggetto per valori che contengono le parole chiave
                                            foreach ($sampleProduct['specs'] as $key => $value) {
                                                if (stripos($key, 'grade') !== false || 
                                                    stripos($key, 'condition') !== false || 
                                                    stripos($key, 'functionality') !== false ||
                                                    stripos($key, 'working') !== false ||
                                                    stripos($key, 'problem') !== false) {
                                                    $gradeText .= $value . ' ';
                                                }
                                            }
                                            
                                            // Ricerca anche in campi non-spec che potrebbero contenere info di grading
                                            if (isset($sampleProduct['visual_grade'])) $gradeText .= $sampleProduct['visual_grade'] . ' ';
                                            if (isset($sampleProduct['tech_grade'])) $gradeText .= $sampleProduct['tech_grade'] . ' ';
                                            if (isset($sampleProduct['functionality'])) $gradeText .= $sampleProduct['functionality'] . ' ';
                                            if (isset($sampleProduct['problems'])) $gradeText .= $sampleProduct['problems'] . ' ';
                                            
                                            // Pattern riconoscimento per formato specifico ITSale "Grade A Visual grade: A Functionality: Working Security mark: Problems: [problemi]"
                                            $standardPattern = '/Grade\s+([A-D])(?:\s+Visual\s+grade:\s+([A-D]))?(?:\s+Functionality:\s+([^.,:;]+))?(?:\s+Security\s+mark:([^:]*))?\s+Problems:\s*(.*?)(?:\s*$|(?:\s+[A-Z][a-z]+:))/s';
                                            if (preg_match($standardPattern, $gradeText, $fullMatches)) {
                                                // Se abbiamo un match completo, estrai tutti i componenti
                                                $visualGrade = !empty($fullMatches[2]) ? $fullMatches[2] : $fullMatches[1]; // Usa Visual grade: se presente, altrimenti Grade
                                                $functionality = !empty($fullMatches[3]) ? trim($fullMatches[3]) : '';
                                                $problems = !empty($fullMatches[5]) ? trim($fullMatches[5]) : '';
                                            } else {
                                                // Altrimenti usa il metodo precedente
                                                // Extract Visual Grade
                                                $visualGrade = '';
                                                if (preg_match('/Grade\s+([A-D])/i', $gradeText, $matches)) {
                                                    $visualGrade = $matches[1];
                                                } elseif (preg_match('/Visual\s+grade:\s*([A-D])/i', $gradeText, $matches)) {
                                                    $visualGrade = $matches[1];
                                                } elseif (preg_match('/[^a-zA-Z]([A-D])(?:\s+Grade|\s+Quality|\s+Condition)/i', $gradeText, $matches)) {
                                                    $visualGrade = $matches[1];
                                                }
                                                
                                                // Extract Functionality (Tech Grade)
                                                $functionality = '';
                                                if (preg_match('/Functionality:\s+([^\n,:;]+)/', $gradeText, $matches)) {
                                                    $functionality = trim($matches[1]);
                                                } elseif (preg_match('/Working(?:\*)?/i', $gradeText)) {
                                                    if (stripos($gradeText, 'Not working') !== false) {
                                                        $functionality = 'Not working';
                                                    } elseif (stripos($gradeText, 'Working*') !== false) {
                                                        $functionality = 'Working*';
                                                    } else {
                                                        $functionality = 'Working';
                                                    }
                                                }
                                                
                                                // Extract Problems - cerca solo il testo dopo "Problems:"
                                                $problems = '';
                                                if (preg_match('/Problems:\s+([^\n.,:;]+)/', $gradeText, $matches)) {
                                                    $problems = trim($matches[1]);
                                                } elseif (preg_match('/(?:Issue|Problem)s?(?:\s+with|\s*:)?\s+([^\n.,:;]+)/i', $gradeText, $matches)) {
                                                    $problems = trim($matches[1]);
                                                }
                                            }
                                        @endphp

                                        <div class="mt-4 p-3 border border-indigo-200 rounded-md bg-indigo-50">
                                            <h5 class="text-sm font-semibold text-indigo-700 mb-2">Grading Information:</h5>
                                            <div class="grid grid-cols-1 gap-4">
                                                <div class="grid grid-cols-3 gap-4">
                                                    <div>
                                                        <p class="text-xs font-medium text-gray-700">Visual Grade (Auto-detected)</p>
                                                        <p class="text-xs text-gray-900">{{ $visualGrade ?: 'Not detected' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-gray-700">Tech Grade (Auto-detected)</p>
                                                        <p class="text-xs text-gray-900">{{ $functionality ?: 'Not detected' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-gray-700">Problems (Auto-detected)</p>
                                                        <p class="text-xs text-gray-900">{{ $problems ?: 'Not detected' }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-2 p-3 border border-indigo-300 rounded-md bg-indigo-100">
                                                    <h6 class="text-xs font-semibold text-indigo-700 mb-2">Manual Override (Optional):</h6>
                                                    <p class="text-xs text-gray-600 mb-2">If the automatic detection didn't work correctly, you can manually specify the grading values:</p>
                                                    
                                                    <div class="grid grid-cols-3 gap-4">
                                                        <div>
                                                            <label for="manual_visual_grade" class="block text-xs font-medium text-gray-700 mb-1">Visual Grade:</label>
                                                            <select id="manual_visual_grade" name="manual_visual_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                                <option value="">-- Use auto-detected --</option>
                                                                <option value="A" {{ $visualGrade == 'A' ? 'selected' : '' }}>A</option>
                                                                <option value="B" {{ $visualGrade == 'B' ? 'selected' : '' }}>B</option>
                                                                <option value="C" {{ $visualGrade == 'C' ? 'selected' : '' }}>C</option>
                                                                <option value="D" {{ $visualGrade == 'D' ? 'selected' : '' }}>D</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="manual_tech_grade" class="block text-xs font-medium text-gray-700 mb-1">Tech Grade:</label>
                                                            <select id="manual_tech_grade" name="manual_tech_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                                <option value="">-- Use auto-detected --</option>
                                                                <option value="Working" {{ $functionality == 'Working' ? 'selected' : '' }}>Working</option>
                                                                <option value="Working*" {{ $functionality == 'Working*' ? 'selected' : '' }}>Working*</option>
                                                                <option value="Not working" {{ $functionality == 'Not working' ? 'selected' : '' }}>Not working</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="manual_problems" class="block text-xs font-medium text-gray-700 mb-1">Problems:</label>
                                                            <input type="text" id="manual_problems" name="manual_problems" value="{{ $problems }}" placeholder="Enter problems if any" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-4 p-3 border border-indigo-200 rounded-md bg-indigo-50">
                                            <h5 class="text-sm font-semibold text-indigo-700 mb-2">No Grading Information Found</h5>
                                            <p class="text-xs text-gray-600 mb-2">No grade fields detected in the product specifications. You can manually specify the grading:</p>
                                            
                                            <div class="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label for="manual_visual_grade" class="block text-xs font-medium text-gray-700 mb-1">Visual Grade:</label>
                                                    <select id="manual_visual_grade" name="manual_visual_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                        <option value="">-- Not specified --</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="manual_tech_grade" class="block text-xs font-medium text-gray-700 mb-1">Tech Grade:</label>
                                                    <select id="manual_tech_grade" name="manual_tech_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                        <option value="">-- Not specified --</option>
                                                        <option value="Working">Working</option>
                                                        <option value="Working*">Working*</option>
                                                        <option value="Not working">Not working</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="manual_problems" class="block text-xs font-medium text-gray-700 mb-1">Problems:</label>
                                                    <input type="text" id="manual_problems" name="manual_problems" placeholder="Enter problems if any" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-500">No sample product specifications available for preview.</p>
                                @endif
                            </div>

                            <!-- Field Mapping Table -->
                            <div class="overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">ITSale Specification</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">System Parameter</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Sample Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="field-mapping-body" class="bg-white divide-y divide-gray-200">
                                        @if($sampleProduct && isset($sampleProduct['specs']))
                                            @foreach($sampleProduct['specs'] as $specKey => $specValue)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $specKey }}
                                                        <input type="hidden" name="spec_fields[]" value="{{ $specKey }}">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <select name="spec_params[]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                            <option value="">-- Not mapped --</option>
                                                            
                                                            <!-- Common mappings -->
                                                            <option value="model" {{ stripos($specKey, 'model') !== false ? 'selected' : '' }}>Model</option>
                                                            <option value="manufacturer" {{ stripos($specKey, 'brand') !== false || stripos($specKey, 'producer') !== false ? 'selected' : '' }}>Manufacturer</option>
                                                            <option value="cpu" {{ stripos($specKey, 'cpu') !== false || stripos($specKey, 'processor') !== false ? 'selected' : '' }}>CPU</option>
                                                            <option value="ram" {{ stripos($specKey, 'ram') !== false || stripos($specKey, 'memory') !== false ? 'selected' : '' }}>RAM</option>
                                                            <option value="storage" {{ stripos($specKey, 'hdd') !== false || stripos($specKey, 'ssd') !== false || stripos($specKey, 'drive') !== false || stripos($specKey, 'storage') !== false ? 'selected' : '' }}>Storage</option>
                                                            <option value="screen_size" {{ stripos($specKey, 'screen') !== false || stripos($specKey, 'display') !== false ? 'selected' : '' }}>Screen Size</option>
                                                            <option value="os" {{ stripos($specKey, 'os') !== false || stripos($specKey, 'operating') !== false ? 'selected' : '' }}>Operating System</option>
                                                            <option value="battery" {{ stripos($specKey, 'battery') !== false ? 'selected' : '' }}>Battery</option>
                                                            <option value="color" {{ stripos($specKey, 'color') !== false ? 'selected' : '' }}>Color</option>
                                                            <option value="quantity" {{ stripos($specKey, 'quantity') !== false || stripos($specKey, 'qty') !== false ? 'selected' : '' }}>Quantity</option>
                                                            <option value="visual_grade" {{ stripos($specKey, 'visual') !== false && stripos($specKey, 'grade') !== false ? 'selected' : '' }}>Visual Grade</option>
                                                            <option value="tech_grade" {{ (stripos($specKey, 'tech') !== false && stripos($specKey, 'grade') !== false) || stripos($specKey, 'functionality') !== false ? 'selected' : '' }}>Tech Grade/Functionality</option>
                                                            <option value="problems" {{ stripos($specKey, 'problem') !== false || stripos($specKey, 'issue') !== false ? 'selected' : '' }}>Problems</option>
                                                            <option value="keyboard" {{ stripos($specKey, 'keyboard') !== false ? 'selected' : '' }}>Keyboard</option>
                                                            <option value="coa" {{ stripos($specKey, 'coa') !== false || stripos($specKey, 'certificate') !== false || stripos($specKey, 'license') !== false ? 'selected' : '' }}>COA</option>
                                                            <option value="webcam" {{ stripos($specKey, 'camera') !== false || stripos($specKey, 'webcam') !== false || stripos($specKey, 'cam') !== false ? 'selected' : '' }}>Webcam/Camera</option>
                                                            
                                                            <!-- Special case for Visual grade -->
                                                            @if(stripos($specKey, 'grade') !== false)
                                                                <option value="_grade_special" selected>Process as Grade Information</option>
                                                            @endif
                                                            
                                                            <!-- Custom Parameter Option -->
                                                            <option value="custom">Custom Parameter...</option>
                                                        </select>
                                                        <input type="text" name="spec_custom_params[]" placeholder="Enter custom parameter name" class="hidden mt-2 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $specValue }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Custom Parameters -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200">Additional Parameters</h4>
                            <p class="text-sm text-gray-600 mb-3">Add any additional parameters that should be included in all products in this batch.</p>
                            
                            <div id="custom-parameters" class="space-y-3">
                                <div class="flex items-center space-x-4">
                                    <div class="w-1/3">
                                        <input type="text" name="additional_param_names[]" placeholder="Parameter Name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="w-1/3">
                                        <input type="text" name="additional_param_values[]" placeholder="Parameter Value" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <button type="button" class="add-param-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add Parameter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end pt-5 border-t border-gray-200">
                            <a href="{{ route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Import Batch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestione dei parametri personalizzati per ogni campo mappato
            document.querySelectorAll('select[name="spec_params[]"]').forEach(select => {
                select.addEventListener('change', function() {
                    const customInput = this.nextElementSibling;
                    if (this.value === 'custom') {
                        customInput.classList.remove('hidden');
                    } else {
                        customInput.classList.add('hidden');
                        customInput.value = '';
                    }
                });
            });
            
            // Aggiunta di nuovi parametri personalizzati
            document.querySelector('.add-param-btn').addEventListener('click', function() {
                const container = document.getElementById('custom-parameters');
                const newRow = document.createElement('div');
                newRow.className = 'flex items-center space-x-4';
                newRow.innerHTML = `
                    <div class="w-1/3">
                        <input type="text" name="additional_param_names[]" placeholder="Parameter Name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="w-1/3">
                        <input type="text" name="additional_param_values[]" placeholder="Parameter Value" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <button type="button" class="remove-param-btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Remove
                        </button>
                    </div>
                `;
                container.appendChild(newRow);
                
                // Aggiungi event listener al nuovo pulsante di rimozione
                newRow.querySelector('.remove-param-btn').addEventListener('click', function() {
                    container.removeChild(newRow);
                });
            });
            
            // Gestione del tipo di sorgente (interno/esterno)
            document.getElementById('source_type').addEventListener('change', function() {
                const supplierContainer = document.getElementById('supplier_container');
                if (this.value === 'internal') {
                    supplierContainer.classList.add('hidden');
                } else {
                    supplierContainer.classList.remove('hidden');
                }
            });
            
            // Calcolo del costo totale
            const costInputs = document.querySelectorAll('.cost-input');
            const totalCostInput = document.getElementById('total_cost');
            
            function calculateTotalCost() {
                let total = 0;
                costInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                totalCostInput.value = total.toFixed(2);
            }
            
            // Calcola il costo totale iniziale
            calculateTotalCost();
            
            // Aggiorna il costo totale quando un input cambia
            costInputs.forEach(input => {
                input.addEventListener('input', calculateTotalCost);
            });
            
            // Popolamento dinamico dei parametri in base alla categoria selezionata
            const categorySelect = document.getElementById('category_id');
            const categoryParameters = @json($categoryParameters);
            
            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
                const parameters = categoryParameters[categoryId] || [];
                
                // Qui potresti implementare la logica per aggiornare i parametri disponibili
                // nel selettore di mappatura in base alla categoria selezionata
                console.log('Category parameters:', parameters);
            });
            
            // Funzione di estrazione dei valori di grade dal testo
            function parseGradeInfo(gradeText) {
                // Mostriamo l'analisi del testo di grading nella console per debug
                console.log('Parsing grade text:', gradeText);
                
                // Pattern riconoscimento per formato specifico ITSale "Grade A Visual grade: A Functionality: Working Security mark: Problems: [problemi]"
                const standardPattern = /Grade\s+([A-D])(?:\s+Visual\s+grade:\s+([A-D]))?(?:\s+Functionality:\s+([^.,:;]+))?(?:\s+Security\s+mark:([^:]*))?\s+Problems:\s*(.*?)(?:\s*$|(?:\s+[A-Z][a-z]+:))/s;
                const standardMatch = gradeText.match(standardPattern);
                
                let visualGrade = '';
                let functionality = '';
                let problems = '';
                
                if (standardMatch) {
                    // Se abbiamo un match completo, estrai tutti i componenti
                    visualGrade = standardMatch[2] ? standardMatch[2] : standardMatch[1]; // Usa Visual grade: se presente, altrimenti Grade
                    functionality = standardMatch[3] ? standardMatch[3].trim() : '';
                    problems = standardMatch[5] ? standardMatch[5].trim() : '';
                    
                    console.log('Standard pattern match:', {visualGrade, functionality, problems});
                } else {
                    // Altrimenti usa il metodo precedente
                    // Estrai Visual Grade
                    if (gradeText.match(/Grade\s+([A-D])/i)) {
                        visualGrade = gradeText.match(/Grade\s+([A-D])/i)[1];
                    } else if (gradeText.match(/Visual\s+grade:\s*([A-D])/i)) {
                        visualGrade = gradeText.match(/Visual\s+grade:\s*([A-D])/i)[1];
                    } else if (gradeText.match(/[^a-zA-Z]([A-D])(?:\s+Grade|\s+Quality|\s+Condition)/i)) {
                        visualGrade = gradeText.match(/[^a-zA-Z]([A-D])(?:\s+Grade|\s+Quality|\s+Condition)/i)[1];
                    }
                    
                    // Estrai Functionality (Tech Grade)
                    if (gradeText.match(/Functionality:\s+([^\n,:;]+)/)) {
                        functionality = gradeText.match(/Functionality:\s+([^\n,:;]+)/)[1].trim();
                    } else if (gradeText.match(/Working(?:\*)?/i)) {
                        if (gradeText.match(/Not\s+working/i)) {
                            functionality = 'Not working';
                        } else if (gradeText.match(/Working\*/i)) {
                            functionality = 'Working*';
                        } else {
                            functionality = 'Working';
                        }
                    }
                    
                    // Estrai Problems - solo il testo dopo "Problems:"
                    if (gradeText.match(/Problems:\s+([^\n.,:;]+)/)) {
                        problems = gradeText.match(/Problems:\s+([^\n.,:;]+)/)[1].trim();
                    } else if (gradeText.match(/(?:Issue|Problem)s?(?:\s+with|\s*:)?\s+([^\n.,:;]+)/i)) {
                        problems = gradeText.match(/(?:Issue|Problem)s?(?:\s+with|\s*:)?\s+([^\n.,:;]+)/i)[1].trim();
                    }
                }
                
                // Verifica speciale per rimuovere il testo di grading dal campo problems
                if (problems && (problems.includes('Grade') || problems.includes('Visual grade'))) {
                    // Se problems contiene l'intera stringa di grading, estraiamo solo la parte dopo "Problems:"
                    const problemsMatch = problems.match(/Problems:\s+([^\n.,:;]+)/i);
                    if (problemsMatch) {
                        problems = problemsMatch[1].trim();
                    } else {
                        // Se non troviamo "Problems:" nel testo, probabilmente non ci sono problemi
                        problems = '';
                    }
                }
                
                // Aggiorna i campi nascosti per il form di importazione
                document.getElementById('extracted_visual_grade').value = visualGrade;
                document.getElementById('extracted_tech_grade').value = functionality;
                document.getElementById('extracted_problems').value = problems;
                
                // Aggiorna anche i campi di visualizzazione
                const visualGradeDisplay = document.getElementById('visual_grade_display');
                const techGradeDisplay = document.getElementById('tech_grade_display');
                const problemsDisplay = document.getElementById('problems_display');
                
                if (visualGradeDisplay) visualGradeDisplay.textContent = visualGrade || 'Not detected';
                if (techGradeDisplay) techGradeDisplay.textContent = functionality || 'Not detected';
                if (problemsDisplay) problemsDisplay.textContent = problems || 'Not detected';
                
                // Aggiorna i campi di override se esistono
                const manualVisualGrade = document.getElementById('manual_visual_grade');
                const manualTechGrade = document.getElementById('manual_tech_grade');
                const manualProblems = document.getElementById('manual_problems');
                
                if (manualVisualGrade && visualGrade && !manualVisualGrade.value) {
                    // Trova l'opzione corrispondente e selezionala
                    for (let i = 0; i < manualVisualGrade.options.length; i++) {
                        if (manualVisualGrade.options[i].value === visualGrade) {
                            manualVisualGrade.selectedIndex = i;
                            break;
                        }
                    }
                }
                
                if (manualTechGrade && functionality && !manualTechGrade.value) {
                    // Trova l'opzione corrispondente e selezionala
                    for (let i = 0; i < manualTechGrade.options.length; i++) {
                        if (manualTechGrade.options[i].value === functionality) {
                            manualTechGrade.selectedIndex = i;
                            break;
                        }
                    }
                }
                
                if (manualProblems && problems && !manualProblems.value) {
                    manualProblems.value = problems;
                }
            }
            
            // Aggiungi campi nascosti per i valori estratti
            const form = document.querySelector('form');
            const hiddenFields = document.createElement('div');
            hiddenFields.style.display = 'none';
            hiddenFields.innerHTML = `
                <input type="hidden" id="extracted_visual_grade" name="extracted_visual_grade" value="">
                <input type="hidden" id="extracted_tech_grade" name="extracted_tech_grade" value="">
                <input type="hidden" id="extracted_problems" name="extracted_problems" value="">
            `;
            form.appendChild(hiddenFields);
            
            // Trova il campo Visual grade e analizzalo all'avvio
            document.querySelectorAll('select[name="spec_params[]"]').forEach((select, index) => {
                if (select.value === '_grade_special') {
                    const specField = select.closest('tr').querySelector('td:first-child').textContent.trim();
                    const specValue = select.closest('tr').querySelector('td:last-child').textContent.trim();
                    
                    if (specValue) {
                        parseGradeInfo(specValue);
                    }
                }
            });
            
            // Gestisci i campi di override manuali
            document.querySelectorAll('[name="manual_visual_grade"], [name="manual_tech_grade"], [name="manual_problems"]').forEach(field => {
                field.addEventListener('change', function() {
                    // Se viene selezionato un valore manuale, sovrascrive quello auto-detected
                    if (this.name === 'manual_visual_grade' && this.value) {
                        document.getElementById('extracted_visual_grade').value = this.value;
                    }
                    if (this.name === 'manual_tech_grade' && this.value) {
                        document.getElementById('extracted_tech_grade').value = this.value;
                    }
                    if (this.name === 'manual_problems') {
                        document.getElementById('extracted_problems').value = this.value;
                    }
                });
            });
            
            // Elabora automaticamente i campi "Not mapped" prima del submit
            form.addEventListener('submit', function(e) {
                // Per ogni select con valore vuoto, imposta automaticamente come parametro custom con lo stesso nome
                document.querySelectorAll('select[name="spec_params[]"]').forEach((select, index) => {
                    if (select.value === '') {
                        const row = select.closest('tr');
                        const specName = row.querySelector('td:first-child').textContent.trim();
                        const specValue = row.querySelector('td:last-child').textContent.trim();
                        
                        // Se il valore della specifica non è vuoto, crea un parametro custom automatico
                        if (specValue && specValue !== 'N/A') {
                            select.value = 'custom';
                            const customInput = select.nextElementSibling;
                            customInput.value = specName;
                            customInput.classList.remove('hidden');
                        }
                    }
                });
                
                // Assicurati che sia impostato almeno quantity=1 se non è già mappato
                let hasQuantity = false;
                document.querySelectorAll('select[name="spec_params[]"]').forEach(select => {
                    if (select.value === 'quantity') {
                        hasQuantity = true;
                    }
                });
                
                if (!hasQuantity) {
                    // Aggiungi un parametro aggiuntivo per quantity=1
                    const additionalParamNames = document.querySelectorAll('input[name="additional_param_names[]"]');
                    const additionalParamValues = document.querySelectorAll('input[name="additional_param_values[]"]');
                    
                    // Controlla se esiste già un campo vuoto per aggiungere il parametro
                    let quantityAdded = false;
                    for (let i = 0; i < additionalParamNames.length; i++) {
                        if (additionalParamNames[i].value === '') {
                            additionalParamNames[i].value = 'quantity';
                            additionalParamValues[i].value = '1';
                            quantityAdded = true;
                            break;
                        }
                    }
                    
                    // Se non c'è un campo vuoto, aggiungi un nuovo parametro cliccando sul pulsante
                    if (!quantityAdded && additionalParamNames.length > 0) {
                        // Clicca sul pulsante per aggiungere un nuovo parametro
                        document.querySelector('.add-param-btn').click();
                        
                        // Ora prendi l'ultimo parametro aggiunto
                        const newParamNames = document.querySelectorAll('input[name="additional_param_names[]"]');
                        const newParamValues = document.querySelectorAll('input[name="additional_param_values[]"]');
                        
                        // Imposta i valori
                        newParamNames[newParamNames.length - 1].value = 'quantity';
                        newParamValues[newParamValues.length - 1].value = '1';
                    }
                }
            });
        });
    </script>
</x-admin-layout> 
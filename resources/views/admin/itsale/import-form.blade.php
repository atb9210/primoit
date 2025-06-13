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

    <div class="py-4 px-2 sm:px-4 lg:px-6">
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
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-4">
                <div class="p-4">
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900">Import List as Batch</h3>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                                {{ count($products) }} products | {{ $listDetails['units'] }} units
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">
                            Configure how <span class="font-semibold">{{ $listDetails['name'] }}</span> should be imported into your system.
                        </p>
                    </div>

                    <!-- Batch Settings Form -->
                    <form id="import-batch-form" action="{{ route('admin.itsale.scraper.import-batch', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="confirm_import" value="1">
                        
                        <!-- Batch Information -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2 pb-1 border-b border-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Batch Information
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div>
                                    <label for="batch_name" class="block text-xs font-medium text-gray-700 mb-1">Batch Name</label>
                                    <input type="text" name="batch_name" id="batch_name" value="{{ $listDetails['name'] }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="batch_reference" class="block text-xs font-medium text-gray-700 mb-1">Reference Code <span class="text-gray-400 font-normal">(optional)</span></label>
                                    <div class="flex">
                                        <input type="text" name="batch_reference" id="batch_reference" value="ITSALE-{{ strtoupper($listSlug) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <button type="button" onclick="document.getElementById('batch_reference').value = ''" class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Clear
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Leave empty to generate automatically</p>
                                </div>
                                <div>
                                    <label for="batch_status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                    <select name="batch_status" id="batch_status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="active" selected>Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="sold">Sold</option>
                                        <option value="reserved">Reserved</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="category_id" class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                                    <select name="category_id" id="category_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <label for="batch_description" class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="batch_description" id="batch_description" rows="2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $listDetails['description'] }}</textarea>
                            </div>
                        </div>

                        <!-- Batch Source -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2 pb-1 border-b border-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Source & Costs
                            </h4>
                            
                            <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
                                <div class="md:col-span-1">
                                    <label for="source_type" class="block text-xs font-medium text-gray-700 mb-1">Source Type</label>
                                    <select name="source_type" id="source_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="internal">Internal</option>
                                        <option value="external" selected>External</option>
                                    </select>
                                </div>
                                <div id="supplier_container" class="md:col-span-1">
                                    <label for="supplier" class="block text-xs font-medium text-gray-700 mb-1">Supplier</label>
                                    <select name="supplier" id="supplier" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="ITSale" selected>ITSale</option>
                                        <option value="Foxway">Foxway</option>
                                        <option value="Ecorefurb">Ecorefurb</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="external_reference" class="block text-xs font-medium text-gray-700 mb-1">External Reference</label>
                                    <input type="text" name="external_reference" id="external_reference" value="https://itsale.pl/list/{{ $listSlug }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                                <div class="md:col-span-1">
                                    <label for="batch_cost" class="block text-xs font-medium text-gray-700 mb-1">Batch Cost (€)</label>
                                    <input type="number" step="0.01" name="batch_cost" id="batch_cost" value="{{ (float)preg_replace('/[^0-9.,]/', '', $listDetails['total_price']) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md cost-input">
                                </div>
                                <div class="md:col-span-1">
                                    <label for="total_cost" class="block text-xs font-medium text-gray-700 mb-1">Total Cost (€)</label>
                                    <input type="number" step="0.01" name="total_cost" id="total_cost" readonly class="bg-gray-50 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md font-medium text-indigo-600">
                                </div>
                            </div>
                            
                            <div class="mt-3 grid grid-cols-3 gap-3">
                                <div>
                                    <label for="shipping_cost" class="block text-xs font-medium text-gray-700 mb-1">Shipping Cost (€)</label>
                                    <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" value="0.00" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md cost-input">
                                </div>
                                <div>
                                    <label for="tax_amount" class="block text-xs font-medium text-gray-700 mb-1">Tax Amount (€)</label>
                                    <input type="number" step="0.01" name="tax_amount" id="tax_amount" value="0.00" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md cost-input">
                                </div>
                                <div class="flex items-end">
                                    <button type="button" id="calculate-cost" class="mt-5 inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        Calculate Total
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Sales Data -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2 pb-1 border-b border-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Sales Data
                            </h4>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <div>
                                    <label for="profit_margin" class="block text-xs font-medium text-gray-700 mb-1">Profit Margin (%)</label>
                                    <input type="number" step="1" min="0" name="profit_margin" id="profit_margin" value="16" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="sale_price" class="block text-xs font-medium text-gray-700 mb-1">Sale Price (€)</label>
                                    <input type="number" step="0.01" name="sale_price" id="sale_price" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="flex items-end">
                                    <button type="button" id="calculate-sale-price" class="mt-5 inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        Calculate Sale Price
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Field Mapping -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2 pb-1 border-b border-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                Field Mapping
                            </h4>
                            
                            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                <!-- Preview Panel (Left) -->
                                <div class="w-full md:w-1/3 bg-gray-50 p-3 rounded-lg">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Product Preview
                                    </h5>
                                    
                                @if($sampleProduct && isset($sampleProduct['specs']) && is_array($sampleProduct['specs']))
                                        <div class="text-xs max-h-64 overflow-y-auto pr-2">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-100">
                                                    <tr>
                                                        <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spec</th>
                                                        <th scope="col" class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($sampleProduct['specs'] as $key => $value)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-2 py-1 whitespace-nowrap text-xs font-medium text-gray-900">{{ $key }}</td>
                                                            <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-500">{{ $value }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                    <!-- Grading Information -->
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
                                                if (preg_match('/Functionality:\s+([^\n]+)/i', $gradeText, $matches)) {
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
                                                if (preg_match('/Problems:\s+([^\n.,:;]+)/i', $gradeText, $matches)) {
                                                    $problems = trim($matches[1]);
                                                } elseif (preg_match('/(?:Issue|Problem)s?(?:\s+with|\s*:)?\s+([^\n.,:;]+)/i', $gradeText, $matches)) {
                                                    $problems = trim($matches[1]);
                                                }
                                            }
                                        @endphp

                                        <div class="mt-4 p-3 border border-indigo-200 rounded-md bg-indigo-50">
                                            <h5 class="text-xs font-semibold text-indigo-700 mb-2">Auto-detected Grading:</h5>
                                            <div class="grid grid-cols-3 gap-2 text-xs">
                                                    <div>
                                                    <p class="font-medium text-gray-700">Visual Grade</p>
                                                    <p class="text-gray-900">{{ $visualGrade ?: 'Not detected' }}</p>
                                                    </div>
                                                    <div>
                                                    <p class="font-medium text-gray-700">Tech Grade</p>
                                                    <p class="text-gray-900">{{ $functionality ?: 'Not detected' }}</p>
                                                    </div>
                                                    <div>
                                                    <p class="font-medium text-gray-700">Problems</p>
                                                    <p class="text-gray-900">{{ $problems ?: 'None' }}</p>
                                                </div>
                                                    </div>
                                            
                                            <div class="mt-2 p-2 border border-indigo-300 rounded-md bg-indigo-100">
                                                <div class="flex items-center justify-between mb-1">
                                                    <h6 class="text-xs font-semibold text-indigo-700">Manual Override:</h6>
                                                    <span class="text-xs text-gray-500">(Optional)</span>
                                                </div>
                                                
                                                <div class="grid grid-cols-3 gap-2">
                                                        <div>
                                                            <select id="manual_visual_grade" name="manual_visual_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                            <option value="">-- Auto --</option>
                                                                <option value="A" {{ $visualGrade == 'A' ? 'selected' : '' }}>A</option>
                                                                <option value="B" {{ $visualGrade == 'B' ? 'selected' : '' }}>B</option>
                                                                <option value="C" {{ $visualGrade == 'C' ? 'selected' : '' }}>C</option>
                                                                <option value="D" {{ $visualGrade == 'D' ? 'selected' : '' }}>D</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <select id="manual_tech_grade" name="manual_tech_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                            <option value="">-- Auto --</option>
                                                                <option value="Working" {{ $functionality == 'Working' ? 'selected' : '' }}>Working</option>
                                                                <option value="Working*" {{ $functionality == 'Working*' ? 'selected' : '' }}>Working*</option>
                                                                <option value="Not working" {{ $functionality == 'Not working' ? 'selected' : '' }}>Not working</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                        <input type="text" id="manual_problems" name="manual_problems" value="{{ $problems }}" placeholder="Problems" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-4 p-3 border border-indigo-200 rounded-md bg-indigo-50">
                                            <h5 class="text-xs font-semibold text-indigo-700 mb-1">No Grade Information Found</h5>
                                            <p class="text-xs text-gray-600 mb-2">Specify manually if needed:</p>
                                            
                                            <div class="grid grid-cols-3 gap-2">
                                                <div>
                                                    <select id="manual_visual_grade" name="manual_visual_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                        <option value="">-- Not specified --</option>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <select id="manual_tech_grade" name="manual_tech_grade" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                        <option value="">-- Not specified --</option>
                                                        <option value="Working">Working</option>
                                                        <option value="Working*">Working*</option>
                                                        <option value="Not working">Not working</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <input type="text" id="manual_problems" name="manual_problems" placeholder="Problems" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                @endif
                            </div>

                                <!-- Field Mapping Table (Right) -->
                                <div class="w-full md:w-2/3">
                                    <div class="shadow-sm sm:rounded-lg border border-gray-200">
                                        <div class="max-h-96 overflow-y-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50 sticky top-0 z-10">
                                                    <tr>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">ITSale Specification</th>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/5">System Parameter</th>
                                                        <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/5">Sample Value</th>
                                        </tr>
                                    </thead>
                                    <tbody id="field-mapping-body" class="bg-white divide-y divide-gray-200">
                                        @if($sampleProduct && isset($sampleProduct['specs']))
                                            @foreach($sampleProduct['specs'] as $specKey => $specValue)
                                                            <tr class="hover:bg-gray-50 field-mapping-row" 
                                                                style="{{ stripos($specKey, 'model') !== false || 
                                                                          stripos($specKey, 'brand') !== false || 
                                                                          stripos($specKey, 'producer') !== false || 
                                                                          stripos($specKey, 'cpu') !== false || 
                                                                          stripos($specKey, 'processor') !== false || 
                                                                          stripos($specKey, 'ram') !== false || 
                                                                          stripos($specKey, 'memory') !== false || 
                                                                          stripos($specKey, 'hdd') !== false || 
                                                                          stripos($specKey, 'ssd') !== false || 
                                                                          stripos($specKey, 'drive') !== false || 
                                                                          stripos($specKey, 'storage') !== false || 
                                                                          stripos($specKey, 'screen') !== false || 
                                                                          stripos($specKey, 'display') !== false || 
                                                                          stripos($specKey, 'os') !== false || 
                                                                          stripos($specKey, 'operating') !== false || 
                                                                          stripos($specKey, 'battery') !== false || 
                                                                          stripos($specKey, 'color') !== false || 
                                                                          stripos($specKey, 'quantity') !== false || 
                                                                          stripos($specKey, 'qty') !== false || 
                                                                          (stripos($specKey, 'visual') !== false && stripos($specKey, 'grade') !== false) || 
                                                                          (stripos($specKey, 'tech') !== false && stripos($specKey, 'grade') !== false) || 
                                                                          stripos($specKey, 'functionality') !== false || 
                                                                          stripos($specKey, 'problem') !== false || 
                                                                          stripos($specKey, 'issue') !== false || 
                                                                          stripos($specKey, 'keyboard') !== false || 
                                                                          stripos($specKey, 'coa') !== false || 
                                                                          stripos($specKey, 'certificate') !== false || 
                                                                          stripos($specKey, 'license') !== false || 
                                                                          stripos($specKey, 'camera') !== false || 
                                                                          stripos($specKey, 'webcam') !== false || 
                                                                          stripos($specKey, 'cam') !== false || 
                                                                          stripos($specKey, 'grade') !== false 
                                                                          ? 'background-color: #ecfdf5; border-left: 3px solid #10b981;' 
                                                                          : 'background-color: #f9fafb; border-left: 3px solid #d1d5db;' }}">
                                                                <td class="px-3 py-2 text-sm font-medium text-gray-900 truncate" style="max-width: 150px;">
                                                        {{ $specKey }}
                                                        <input type="hidden" name="spec_fields[]" value="{{ $specKey }}">
                                                    </td>
                                                                <td class="px-3 py-2 text-sm text-gray-500">
                                                                    <select name="spec_params[]" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md mapping-select" style="min-width: 200px; {{ stripos($specKey, 'model') !== false || 
                                                                          stripos($specKey, 'brand') !== false || 
                                                                          stripos($specKey, 'producer') !== false || 
                                                                          stripos($specKey, 'cpu') !== false || 
                                                                          stripos($specKey, 'processor') !== false || 
                                                                          stripos($specKey, 'ram') !== false || 
                                                                          stripos($specKey, 'memory') !== false || 
                                                                          stripos($specKey, 'hdd') !== false || 
                                                                          stripos($specKey, 'ssd') !== false || 
                                                                          stripos($specKey, 'drive') !== false || 
                                                                          stripos($specKey, 'storage') !== false || 
                                                                          stripos($specKey, 'screen') !== false || 
                                                                          stripos($specKey, 'display') !== false || 
                                                                          stripos($specKey, 'os') !== false || 
                                                                          stripos($specKey, 'operating') !== false || 
                                                                          stripos($specKey, 'battery') !== false || 
                                                                          stripos($specKey, 'color') !== false || 
                                                                          stripos($specKey, 'quantity') !== false || 
                                                                          stripos($specKey, 'qty') !== false || 
                                                                          (stripos($specKey, 'visual') !== false && stripos($specKey, 'grade') !== false) || 
                                                                          (stripos($specKey, 'tech') !== false && stripos($specKey, 'grade') !== false) || 
                                                                          stripos($specKey, 'functionality') !== false || 
                                                                          stripos($specKey, 'problem') !== false || 
                                                                          stripos($specKey, 'issue') !== false || 
                                                                          stripos($specKey, 'keyboard') !== false || 
                                                                          stripos($specKey, 'coa') !== false || 
                                                                          stripos($specKey, 'certificate') !== false || 
                                                                          stripos($specKey, 'license') !== false || 
                                                                          stripos($specKey, 'camera') !== false || 
                                                                          stripos($specKey, 'webcam') !== false || 
                                                                          stripos($specKey, 'cam') !== false || 
                                                                          stripos($specKey, 'grade') !== false 
                                                                          ? 'border-color: #10b981; background-color: #f8fffc;' 
                                                                          : '' }}">
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
                                                                <td class="px-3 py-2 text-sm text-gray-500 truncate" style="max-width: 150px;">
                                                        {{ $specValue }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-2 flex justify-between items-center text-xs text-gray-600">
                                        <div class="flex items-center">
                                            <span class="inline-block w-3 h-3 bg-green-100 border border-green-300 rounded-full mr-1"></span>
                                            <span>Mapped</span>
                                            <span class="inline-block w-3 h-3 bg-gray-100 border border-gray-300 rounded-full ml-4 mr-1"></span>
                                            <span>Not mapped</span>
                                        </div>
                                        <div>
                                            <span id="mapped-count" class="font-medium text-indigo-600">0</span> of <span id="total-count" class="font-medium">0</span> fields mapped
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Parameters -->
                        <div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2 pb-1 border-b border-gray-200 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Additional Parameters
                            </h4>
                            <p class="text-xs text-gray-600 mb-2">Add any extra parameters that should be included in all products in this batch.</p>
                            
                            <div id="custom-parameters" class="space-y-2 mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-1/3">
                                        <input type="text" name="additional_param_names[]" placeholder="Parameter Name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="w-1/3">
                                        <input type="text" name="additional_param_values[]" placeholder="Parameter Value" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <button type="button" class="add-param-btn inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.itsale.scraper.show-list', ['supplier' => $supplier, 'listSlug' => $listSlug]) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                Cancel
                            </a>
                                <button type="submit" id="import-batch-button" class="inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                Import Batch
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Debug form submission
            const form = document.getElementById('import-batch-form');
            const submitButton = document.getElementById('import-batch-button');
            
            if (form && submitButton) {
                submitButton.addEventListener('click', function(e) {
                    e.preventDefault(); // Preveniamo l'azione di default
                    console.log('Import button clicked');
                    
                    // Assicuriamoci che il campo confirm_import sia impostato
                    let confirmImportField = form.querySelector('input[name="confirm_import"]');
                    if (!confirmImportField) {
                        confirmImportField = document.createElement('input');
                        confirmImportField.type = 'hidden';
                        confirmImportField.name = 'confirm_import';
                        confirmImportField.value = '1';
                        form.appendChild(confirmImportField);
                    } else {
                        confirmImportField.value = '1';
                    }
                    
                    // Verifichiamo che il token CSRF sia presente
                    if (!form.querySelector('input[name="_token"]')) {
                        console.error('CSRF token missing!');
                        alert('CSRF token is missing. Cannot submit the form.');
                        return;
                    }
                    
                    console.log('Submitting form to:', form.action);
                    console.log('With method:', form.method);
                    
                    // Inviamo il form
                    form.submit();
                });
            }
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    console.log('Form is being submitted to:', form.action);
                    console.log('With method:', form.method);
                    // Non blocchiamo la sottomissione, ma loghiamo l'evento
                });
            }
            
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
                    updateMappingStyles();
                });
            });
            
            // Aggiunta di nuovi parametri personalizzati
            document.querySelector('.add-param-btn').addEventListener('click', function() {
                const container = document.getElementById('custom-parameters');
                const newRow = document.createElement('div');
                newRow.className = 'flex items-center space-x-3';
                newRow.innerHTML = `
                    <div class="w-1/3">
                        <input type="text" name="additional_param_names[]" placeholder="Parameter Name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="w-1/3">
                        <input type="text" name="additional_param_values[]" placeholder="Parameter Value" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <button type="button" class="remove-param-btn inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
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
                
                // Aggiorniamo automaticamente anche il sale price quando cambia il total cost
                calculateSalePrice();
            }
            
            // Calcola il costo totale iniziale
            calculateTotalCost();
            
            // Aggiorna il costo totale quando un input cambia
            costInputs.forEach(input => {
                input.addEventListener('input', calculateTotalCost);
            });
            
            // Pulsante per calcolare il costo totale
            document.getElementById('calculate-cost').addEventListener('click', calculateTotalCost);
            
            // Calcolo del prezzo di vendita
            const profitMarginInput = document.getElementById('profit_margin');
            const salePriceInput = document.getElementById('sale_price');
            
            function calculateSalePrice() {
                const totalCost = parseFloat(totalCostInput.value) || 0;
                const profitMargin = parseFloat(profitMarginInput.value) || 0;
                
                if (totalCost > 0 && profitMargin > 0) {
                    const salePrice = totalCost * (1 + (profitMargin / 100));
                    salePriceInput.value = salePrice.toFixed(2);
                }
            }
            
            // Calcola il prezzo di vendita iniziale
            calculateSalePrice();
            
            // Aggiorna il prezzo di vendita quando cambia il margine di profitto
            profitMarginInput.addEventListener('input', calculateSalePrice);
            
            // Pulsante per calcolare il prezzo di vendita
            document.getElementById('calculate-sale-price').addEventListener('click', calculateSalePrice);
            
            // Permetti l'inserimento manuale del prezzo di vendita
            salePriceInput.addEventListener('input', function() {
                // Se viene inserito manualmente un prezzo di vendita, calcoliamo il margine corrispondente
                const totalCost = parseFloat(totalCostInput.value) || 0;
                const salePrice = parseFloat(this.value) || 0;
                
                if (totalCost > 0 && salePrice > 0) {
                    const margin = ((salePrice / totalCost) - 1) * 100;
                    profitMarginInput.value = margin.toFixed(0);
                }
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
                    } elseif (gradeText.match(/Visual\s+grade:\s*([A-D])/i)) {
                        visualGrade = gradeText.match(/Visual\s+grade:\s*([A-D])/i)[1];
                    } elseif (gradeText.match(/[^a-zA-Z]([A-D])(?:\s+Grade|\s+Quality|\s+Condition)/i)) {
                        visualGrade = gradeText.match(/[^a-zA-Z]([A-D])(?:\s+Grade|\s+Quality|\s+Condition)/i)[1];
                    }
                    
                    // Estrai Functionality (Tech Grade)
                    if (gradeText.match(/Functionality:\s+([^\n]+)/i)) {
                        functionality = gradeText.match(/Functionality:\s+([^\n]+)/i)[1].trim();
                    } elseif (gradeText.match(/Working(?:\*)?/i)) {
                        if (gradeText.match(/Not\s+working/i)) {
                            functionality = 'Not working';
                        } elseif (gradeText.match(/Working\*/i)) {
                            functionality = 'Working*';
                        } else {
                            functionality = 'Working';
                        }
                    }
                    
                    // Estrai Problems - solo il testo dopo "Problems:"
                    if (gradeText.match(/Problems:\s+([^\n.,:;]+)/i)) {
                        problems = gradeText.match(/Problems:\s+([^\n.,:;]+)/i)[1].trim();
                    } elseif (gradeText.match(/(?:Issue|Problem)s?(?:\s+with|\s*:)?\s+([^\n.,:;]+)/i)) {
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

            // Funzione per aggiornare gli stili in base allo stato di mapping
            function updateMappingStyles() {
                const selects = document.querySelectorAll('.mapping-select');
                const rows = document.querySelectorAll('.field-mapping-row');
                let mappedCount = 0;
                
                selects.forEach((select, index) => {
                    const row = rows[index];
                    if (select.value && select.value !== '') {
                        row.classList.add('bg-green-50');
                        row.classList.remove('bg-gray-50');
                        mappedCount++;
                    } else {
                        row.classList.remove('bg-green-50');
                        row.classList.add('bg-gray-50');
                    }
                });
                
                // Aggiorna il conteggio visualizzato
                document.getElementById('mapped-count').textContent = mappedCount;
                document.getElementById('total-count').textContent = selects.length;
            }
            
            // Esegui l'aggiornamento degli stili all'avvio
            updateMappingStyles();
            
            // Aggiungi listener per aggiornare gli stili quando un select cambia
            document.querySelectorAll('.mapping-select').forEach(select => {
                select.addEventListener('change', updateMappingStyles);
            });
        });
    </script>
</x-admin-layout> 

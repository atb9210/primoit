<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $supplier->name }} - Catalogo Prodotti</title>
    <meta name="description" content="Catalogo prodotti di {{ $supplier->name }} - Trova i migliori prodotti tecnologici a prezzi competitivi.">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('img/logo.png') }}" alt="PrimoIT Logo" class="h-8 mr-2">
                <span class="text-xl font-bold text-gray-800">PrimoIT</span>
            </a>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                <a href="{{ route('batches.index') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Stock disponibile</a>
                <a href="{{ route('contact') }}" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">Contattaci</a>
            </div>
        </div>
    </nav>

    <!-- Header with Supplier Info -->
    <div class="bg-blue-800 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ $supplier->name }} - Catalogo Prodotti</h1>
                    <p class="mt-2 opacity-80">Offerte speciali sui migliori prodotti tecnologici</p>
                </div>
                @if($supplier->logo)
                <div class="mt-4 md:mt-0 bg-white p-2 rounded-lg">
                    <img src="{{ Storage::url($supplier->logo) }}" alt="{{ $supplier->name }}" class="h-16 object-contain">
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Back Navigation -->
        @if($listSlug)
        <div class="mb-4">
            <a href="{{ route('catalog.show', $supplier) }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Torna all'elenco principale
            </a>
        </div>
        @endif
        
        @if(isset($lists) && count($lists) > 0)
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Liste disponibili</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($lists as $list)
                <a href="{{ route('catalog.show.list', ['supplier' => $supplier->id, 'listSlug' => $list['slug']]) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $list['name'] }}</h3>
                        <div class="mt-2 text-gray-600">
                            <div class="flex justify-between">
                                <span>Prodotti: {{ $list['products_count'] }}</span>
                                <span class="text-blue-600 font-medium">{{ $list['total_price'] }}</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $list['description'] }}</p>
                        </div>
                        <div class="mt-3 flex justify-end">
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                Visualizza prodotti
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        @elseif(count($products) > 0)
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $list['name'] ?? 'Prodotti' }}</h2>
                <p class="text-gray-600 mt-1">{{ $list['description'] ?? '' }}</p>
            </div>
            
            <!-- Filter & Sort (Optional) -->
            <div class="mb-6 p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="flex flex-col md:flex-row md:justify-between items-center gap-4">
                    <div class="relative w-full md:w-auto">
                        <input id="searchInput" type="text" placeholder="Cerca prodotti..." class="w-full p-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="sortSelect" class="text-gray-600 text-sm">Ordina per:</label>
                        <select id="sortSelect" class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="name">Nome</option>
                            <option value="price-asc">Prezzo (crescente)</option>
                            <option value="price-desc">Prezzo (decrescente)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Products Table (come in ITSale) -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-sm mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type/Producer/Model</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPU/RAM/Drive</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Screen</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $index => $product)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 product-row" 
                                data-name="{{ $product['name'] ?? '' }}"
                                data-price="{{ isset($product['price']) ? (float) str_replace(['€', ','], ['', '.'], $product['price']) : 0 }}">
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                                        @if(isset($product['image']))
                                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] ?? 'Product' }}" class="h-full w-full object-contain">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500">No Image</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $product['producer'] ?? ($product['specs']['manufacturer'] ?? 'N/A') }}</div>
                                    <div class="text-sm text-gray-500">{{ $product['model'] ?? $product['name'] ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $product['type'] ?? ($product['specs']['type'] ?? 'N/A') }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">{{ $product['cpu'] ?? ($product['specs']['CPU'] ?? 'N/A') }}</div>
                                    <div class="text-sm text-gray-500">{{ $product['ram'] ?? ($product['specs']['RAM'] ?? 'N/A') }}</div>
                                    <div class="text-sm text-gray-500">{{ $product['drive'] ?? ($product['specs']['Storage'] ?? 'N/A') }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-sm text-gray-900">{{ $product['screen_size'] ?? ($product['specs']['Screen size'] ?? 'N/A') }}</div>
                                    <div class="text-sm text-gray-500">{{ $product['resolution'] ?? ($product['specs']['Resolution'] ?? 'N/A') }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    @php
                                        $visualGrade = '';
                                        $techGrade = '';
                                        
                                        // Estrai visual grade
                                        if (isset($product['visual_grade'])) {
                                            $visualGrade = $product['visual_grade'];
                                        } elseif (isset($product['specs']['Visual Grade'])) {
                                            $visualGrade = $product['specs']['Visual Grade'];
                                        }
                                        
                                        // Estrai tech grade
                                        if (isset($product['tech_grade'])) {
                                            $techGrade = $product['tech_grade'];
                                        } elseif (isset($product['specs']['Tech Grade'])) {
                                            $techGrade = $product['specs']['Tech Grade'];
                                        }
                                        
                                        // Determina il colore in base alla functionality
                                        $badgeColor = '';
                                        if (stripos($techGrade, 'Working') !== false && stripos($techGrade, 'Working*') === false) {
                                            $badgeColor = 'bg-green-100 text-green-800';
                                        } elseif (stripos($techGrade, 'Working*') !== false) {
                                            $badgeColor = 'bg-yellow-100 text-yellow-800';
                                        } elseif (stripos($techGrade, 'Not working') !== false) {
                                            $badgeColor = 'bg-red-100 text-red-800';
                                        } else {
                                            $badgeColor = 'bg-gray-100 text-gray-800';
                                        }
                                    @endphp
                                    
                                    <div class="inline-block rounded-full px-3 py-1 text-xs font-bold {{ $badgeColor }}">
                                        {{ $visualGrade ?: 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $techGrade }}</div>
                                </td>
                                <td class="px-3 py-4">
                                    <div class="text-blue-700 font-bold text-lg">{{ $product['price'] ?? '' }}</div>
                                    @if(isset($product['original_price']))
                                        <div class="text-xs text-gray-500">Originale: {{ $product['original_price'] }}</div>
                                    @endif
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <button type="button" 
                                            class="whatsapp-btn inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            data-index="{{ $index }}"
                                            data-name="{{ $product['name'] ?? 'Prodotto' }}"
                                            data-price="{{ $product['price'] ?? '' }}"
                                            {{ $whatsapp ? '' : 'disabled' }}>
                                        <i class="fab fa-whatsapp mr-2"></i>
                                        Info
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(count($products) === 0)
                <div class="text-center py-10">
                    <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-800">Nessun prodotto trovato</h3>
                    <p class="text-gray-600 mt-2">Prova a selezionare un'altra lista o contattaci per verificare la disponibilità.</p>
                </div>
            @endif
        @else
            <div class="text-center py-10">
                <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-800">Nessun prodotto disponibile</h3>
                <p class="text-gray-600 mt-2">Al momento non ci sono prodotti disponibili in questo catalogo.</p>
                <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                    Contattaci per informazioni
                </a>
            </div>
        @endif
    </div>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-10">
        <div class="container mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">PrimoIT</h3>
                    <p class="text-gray-300">Specialisti nella fornitura di prodotti tecnologici per il mercato B2B.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contatti</h3>
                    <ul class="text-gray-300 space-y-2">
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Via Roma 123, Milano</li>
                        <li><i class="fas fa-phone mr-2"></i> +39 02 123 456</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@primoit.com</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Collegamenti</h3>
                    <ul class="text-gray-300 space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                        <li><a href="{{ route('batches.index') }}" class="hover:text-white">Stock disponibile</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white">Chi siamo</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">Contatti</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-10 pt-6 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} PrimoIT. Tutti i diritti riservati.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Modal -->
    <div id="whatsappModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Richiedi informazioni</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="mb-4">Stai per inviare una richiesta di informazioni via WhatsApp per:</p>
                <div class="p-4 bg-gray-50 rounded-md mb-4">
                    <p id="modalProductName" class="font-medium"></p>
                    <p id="modalProductPrice" class="text-blue-700 font-medium mt-1"></p>
                </div>
                <div class="mt-5 flex justify-end">
                    <button id="cancelButton" class="mr-3 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Annulla
                    </button>
                    <a id="whatsappLink" href="#" target="_blank" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Apri WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // WhatsApp functionality
            const whatsappButtons = document.querySelectorAll('.whatsapp-btn');
            const modal = document.getElementById('whatsappModal');
            const closeModal = document.getElementById('closeModal');
            const cancelButton = document.getElementById('cancelButton');
            const whatsappLink = document.getElementById('whatsappLink');
            const modalProductName = document.getElementById('modalProductName');
            const modalProductPrice = document.getElementById('modalProductPrice');
            
            const whatsappNumber = '{{ $whatsapp }}';
            const products = @json($products);
            
            whatsappButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    const product = products[index];
                    
                    modalProductName.textContent = product.name || 'Prodotto';
                    modalProductPrice.textContent = product.price || '';
                    
                    // Format the WhatsApp message
                    const message = `Salve, sono interessato al prodotto: ${product.name || 'Prodotto'} (${product.price || ''}). Potreste fornirmi maggiori informazioni? Grazie.`;
                    const encodedMessage = encodeURIComponent(message);
                    whatsappLink.href = `https://wa.me/${whatsappNumber.replace(/[^0-9]/g, '')}?text=${encodedMessage}`;
                    
                    modal.classList.remove('hidden');
                });
            });
            
            // Close the modal
            [closeModal, cancelButton].forEach(element => {
                element.addEventListener('click', function() {
                    modal.classList.add('hidden');
                });
            });
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
            
            // Search and sort functionality
            const searchInput = document.getElementById('searchInput');
            const sortSelect = document.getElementById('sortSelect');
            const productRows = document.querySelectorAll('.product-row');
            
            // Search function
            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                
                productRows.forEach(row => {
                    const productName = row.getAttribute('data-name').toLowerCase();
                    
                    if (productName.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            // Sort function
            function sortProducts() {
                const sortBy = sortSelect.value;
                const tbody = document.querySelector('tbody');
                const rows = Array.from(productRows);
                
                rows.sort((a, b) => {
                    if (sortBy === 'name') {
                        const nameA = a.getAttribute('data-name').toLowerCase();
                        const nameB = b.getAttribute('data-name').toLowerCase();
                        return nameA.localeCompare(nameB);
                    } else if (sortBy === 'price-asc') {
                        const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                        const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                        return priceA - priceB;
                    } else if (sortBy === 'price-desc') {
                        const priceA = parseFloat(a.getAttribute('data-price')) || 0;
                        const priceB = parseFloat(b.getAttribute('data-price')) || 0;
                        return priceB - priceA;
                    }
                    return 0;
                });
                
                // Remove all rows
                productRows.forEach(row => row.remove());
                
                // Add sorted rows
                rows.forEach(row => {
                    tbody.appendChild(row);
                });
            }
            
            // Event listeners
            if (searchInput) {
                searchInput.addEventListener('input', filterProducts);
            }
            
            if (sortSelect) {
                sortSelect.addEventListener('change', sortProducts);
            }
        });
    </script>
</body>
</html> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Labels - {{ $batch->reference_code }}</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            size: 4in 5.95in;
            margin: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f5f5f5;
        }
        
        /* Main container */
        .main-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Page layout */
        .page {
            width: 4in;
            height: 5.95in;
            margin: 0 auto 40px;
            background: white;
            position: relative;
            page-break-after: always;
            page-break-inside: avoid;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 0.1in;
            clear: both;
        }
        
        .page-break {
            page-break-after: always;
            break-after: page;
            display: block;
            clear: both;
            height: 0;
            margin: 0;
            padding: 0;
            border: none;
        }
        
        /* Grid for labels */
        .label-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(5, 1fr);
            gap: 0.03in;
            height: 100%;
        }
        
        /* Individual label */
        .product-label {
            border: 1px dashed #ccc;
            padding: 0.08in;
            height: 1.10in;
            width: 1.86in;
            overflow: hidden;
            position: relative;
        }
        
        /* Label components */
        .label-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #000;
            padding-bottom: 0.03in;
            margin-bottom: 0.03in;
            font-size: 6px;
        }
        
        .company-name {
            font-weight: bold;
        }
        
        .ref-code {
            font-weight: bold;
            font-size: 7px;
        }
        
        .product-info {
            display: grid;
            grid-template-columns: 65% 35%;
            gap: 0.03in;
            margin-top: 0.02in;
            height: calc(100% - 0.38in);
        }
        
        .product-details {
            font-size: 6px;
            overflow: hidden;
        }
        
        .info-line {
            margin-bottom: 0.01in;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .qr-container {
            text-align: center;
        }
        
        .qr-code {
            width: 0.45in;
            height: 0.45in;
            margin: 0 auto;
        }
        
        .qr-text {
            font-size: 5px;
            margin-top: 0.01in;
        }
        
        .product-name {
            font-weight: bold;
            font-size: 7px;
            margin: 0.02in 0;
            max-height: 0.12in;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .label-footer {
            position: absolute;
            bottom: 0.03in;
            left: 0.08in;
            right: 0.08in;
            text-align: center;
            font-size: 5px;
            border-top: 1px solid #000;
            padding-top: 0.02in;
        }
        
        /* Print specific styles */
        @media print {
            @page {
                size: 4in 5.95in;
                margin: 0;
            }
            
            body {
                background: white;
                width: 4in;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            
            .main-container {
                padding: 0;
                max-width: 100%;
            }
            
            .page {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0.1in;
                break-after: page;
                break-before: page;
                page-break-after: always;
                page-break-before: always;
                width: 4in;
                height: 5.95in;
                overflow: hidden;
            }
            
            .page:first-child {
                break-before: auto;
                page-break-before: auto;
            }
            
            .controls {
                display: none;
            }
            
            .page-info {
                display: none;
            }
            
            .hidden {
                display: block !important;
            }
        }
        
        /* Utility classes */
        .hidden {
            display: none;
        }
        
        /* Controls styling */
        .controls {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .controls h2 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }
        
        .btn-primary {
            background-color: #4CAF50;
        }
        
        .btn-secondary {
            background-color: #2196F3;
        }
        
        .btn-warning {
            background-color: #FF9800;
        }
        
        .btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        
        .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .pagination {
            margin: 15px 0;
        }
        
        .print-tips {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-top: 15px;
        }
        
        .print-tips h3 {
            margin-top: 0;
            font-size: 14px;
            color: #333;
        }
        
        .print-tips ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .print-tips li {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .batch-info {
            text-align: center;
            margin-bottom: 0.04in;
            font-weight: bold;
            font-size: 7px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="controls">
            <h2>Product Labels - {{ $batch->reference_code }}</h2>
            
            <button onclick="printLabels()" class="btn btn-primary">Print All Labels</button>
            <button onclick="togglePages()" class="btn btn-warning" id="toggleBtn">Show All Pages</button>
            <a href="{{ route('admin.batches.download-product-labels', $batch) }}" class="btn btn-secondary">Download PDF</a>
            
            <div class="pagination flex">
                <button onclick="prevPage()" class="btn btn-secondary" id="prevBtn" disabled>Previous Page</button>
                <span id="pageInfo">Page 1 of {{ ceil(count($batch->products) / 10) }}</span>
                <button onclick="nextPage()" class="btn btn-secondary" id="nextBtn" {{ ceil(count($batch->products) / 10) <= 1 ? 'disabled' : '' }}>Next Page</button>
            </div>
            
            <div class="print-tips">
                <h3>Printing Tips:</h3>
                <ul>
                    <li>Select "4 × 6 in" in your printer settings</li>
                    <li>Choose "Actual size" or "No scaling" in print options</li>
                    <li>Disable headers and footers in browser print settings</li>
                    <li>Each page will print on a separate sheet</li>
                    <li>For best results, use the "Download PDF" button and print from PDF</li>
                </ul>
            </div>
        </div>
        
        @php
            $productsPerPage = 10;
            $productCount = count($batch->products);
            $pageCount = ceil($productCount / $productsPerPage);
        @endphp
        
        @for ($page = 0; $page < $pageCount; $page++)
            <div class="page {{ $page === 0 ? '' : 'hidden' }}" data-page="{{ $page + 1 }}">
                <div class="batch-info">
                    Page {{ $page + 1 }} of {{ $pageCount }}
                </div>
                
                <div class="label-grid">
                    @for ($i = 0; $i < $productsPerPage; $i++)
                        @php
                            $index = $page * $productsPerPage + $i;
                            if ($index >= $productCount) break;
                            $product = $batch->products[$index];
                        @endphp
                        
                        <div class="product-label">
                            <div class="label-header">
                                <div class="company-name">PRIMO IT</div>
                                <div class="date">{{ now()->format('d/m/Y') }}</div>
                            </div>
                            
                            <div class="ref-code">
                                REF: {{ $batch->reference_code }}-{{ $index + 1 }}
                            </div>
                            
                            <div class="product-name">
                                {{ $product['name'] ?? ($batch->name . ' - Unit ' . ($index + 1)) }}
                            </div>
                            
                            <div class="product-info">
                                <div class="product-details">
                                    @if(!empty($product['model']))
                                    <div class="info-line">
                                        <span class="info-label">Model:</span> {{ $product['model'] }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['cpu']) || !empty($batch->cpu))
                                    <div class="info-line">
                                        <span class="info-label">CPU:</span> {{ $product['cpu'] ?? $batch->cpu }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['ram']) || !empty($batch->ram))
                                    <div class="info-line">
                                        <span class="info-label">RAM:</span> {{ $product['ram'] ?? $batch->ram }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['storage']) || !empty($batch->storage))
                                    <div class="info-line">
                                        <span class="info-label">Storage:</span> {{ $product['storage'] ?? $batch->storage }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['grade']) || !empty($batch->grade))
                                    <div class="info-line">
                                        <span class="info-label">Grade:</span> {{ $product['grade'] ?? $batch->grade }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['tech_grade']))
                                    <div class="info-line">
                                        <span class="info-label">Tech:</span> {{ $product['tech_grade'] }}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="qr-container">
                                    <div class="qr-code">
                                        {!! QrCode::size(45)->generate(route('admin.batches.show', $batch) . '#product-' . ($index + 1)) !!}
                                    </div>
                                    <div class="qr-text">Scan for details</div>
                                </div>
                            </div>
                            
                            <div class="label-footer">
                                <div></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>
    
    <script>
        let currentPage = 1;
        const totalPages = {{ $pageCount }};
        let showAllPages = false;
        
        function updatePageDisplay() {
            // Update page info text
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            
            // Enable/disable navigation buttons
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;
            
            if (!showAllPages) {
                // Hide all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.add('hidden');
                });
                
                // Show only current page
                const currentPageElement = document.querySelector(`.page[data-page="${currentPage}"]`);
                if (currentPageElement) {
                    currentPageElement.classList.remove('hidden');
                }
            }
        }
        
        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                updatePageDisplay();
            }
        }
        
        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePageDisplay();
            }
        }
        
        function togglePages() {
            showAllPages = !showAllPages;
            const toggleBtn = document.getElementById('toggleBtn');
            
            if (showAllPages) {
                // Show all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('hidden');
                });
                toggleBtn.textContent = 'Show Single Page';
            } else {
                toggleBtn.textContent = 'Show All Pages';
                updatePageDisplay();
            }
        }
        
        function printLabels() {
            // Show all pages before printing
            const wasShowingAll = showAllPages;
            
            if (!wasShowingAll) {
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('hidden');
                });
            }
            
            // Add a slight delay to ensure all pages are rendered
            setTimeout(() => {
                window.print();
                
                // After printing, restore previous view
                setTimeout(() => {
                    if (!wasShowingAll) {
                        showAllPages = false;
                        updatePageDisplay();
                    }
                }, 500);
            }, 300);
        }
    </script>
</body>
</html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Labels - {{ $batch->reference_code }}</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            size: 4in 5.95in;
            margin: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f5f5f5;
        }
        
        /* Main container */
        .main-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Page layout */
        .page {
            width: 4in;
            height: 5.95in;
            margin: 0 auto 40px;
            background: white;
            position: relative;
            page-break-after: always;
            page-break-inside: avoid;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 0.1in;
            clear: both;
        }
        
        .page-break {
            page-break-after: always;
            break-after: page;
            display: block;
            clear: both;
            height: 0;
            margin: 0;
            padding: 0;
            border: none;
        }
        
        /* Grid for labels */
        .label-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(5, 1fr);
            gap: 0.03in;
            height: 100%;
        }
        
        /* Individual label */
        .product-label {
            border: 1px dashed #ccc;
            padding: 0.08in;
            height: 1.10in;
            width: 1.86in;
            overflow: hidden;
            position: relative;
        }
        
        /* Label components */
        .label-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #000;
            padding-bottom: 0.03in;
            margin-bottom: 0.03in;
            font-size: 6px;
        }
        
        .company-name {
            font-weight: bold;
        }
        
        .ref-code {
            font-weight: bold;
            font-size: 7px;
        }
        
        .product-info {
            display: grid;
            grid-template-columns: 65% 35%;
            gap: 0.03in;
            margin-top: 0.02in;
            height: calc(100% - 0.38in);
        }
        
        .product-details {
            font-size: 6px;
            overflow: hidden;
        }
        
        .info-line {
            margin-bottom: 0.01in;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .qr-container {
            text-align: center;
        }
        
        .qr-code {
            width: 0.45in;
            height: 0.45in;
            margin: 0 auto;
        }
        
        .qr-text {
            font-size: 5px;
            margin-top: 0.01in;
        }
        
        .product-name {
            font-weight: bold;
            font-size: 7px;
            margin: 0.02in 0;
            max-height: 0.12in;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .label-footer {
            position: absolute;
            bottom: 0.03in;
            left: 0.08in;
            right: 0.08in;
            text-align: center;
            font-size: 5px;
            border-top: 1px solid #000;
            padding-top: 0.02in;
        }
        
        /* Print specific styles */
        @media print {
            @page {
                size: 4in 5.95in;
                margin: 0;
            }
            
            body {
                background: white;
                width: 4in;
                height: 100%;
                margin: 0;
                padding: 0;
            }
            
            .main-container {
                padding: 0;
                max-width: 100%;
            }
            
            .page {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0.1in;
                break-after: page;
                break-before: page;
                page-break-after: always;
                page-break-before: always;
                width: 4in;
                height: 5.95in;
                overflow: hidden;
            }
            
            .page:first-child {
                break-before: auto;
                page-break-before: auto;
            }
            
            .controls {
                display: none;
            }
            
            .page-info {
                display: none;
            }
            
            .hidden {
                display: block !important;
            }
        }
        
        /* Utility classes */
        .hidden {
            display: none;
        }
        
        /* Controls styling */
        .controls {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .controls h2 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }
        
        .btn-primary {
            background-color: #4CAF50;
        }
        
        .btn-secondary {
            background-color: #2196F3;
        }
        
        .btn-warning {
            background-color: #FF9800;
        }
        
        .btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        
        .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .pagination {
            margin: 15px 0;
        }
        
        .print-tips {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-top: 15px;
        }
        
        .print-tips h3 {
            margin-top: 0;
            font-size: 14px;
            color: #333;
        }
        
        .print-tips ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .print-tips li {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .batch-info {
            text-align: center;
            margin-bottom: 0.04in;
            font-weight: bold;
            font-size: 7px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="controls">
            <h2>Product Labels - {{ $batch->reference_code }}</h2>
            
            <button onclick="printLabels()" class="btn btn-primary">Print All Labels</button>
            <button onclick="togglePages()" class="btn btn-warning" id="toggleBtn">Show All Pages</button>
            <a href="{{ route('admin.batches.download-product-labels', $batch) }}" class="btn btn-secondary">Download PDF</a>
            
            <div class="pagination flex">
                <button onclick="prevPage()" class="btn btn-secondary" id="prevBtn" disabled>Previous Page</button>
                <span id="pageInfo">Page 1 of {{ ceil(count($batch->products) / 10) }}</span>
                <button onclick="nextPage()" class="btn btn-secondary" id="nextBtn" {{ ceil(count($batch->products) / 10) <= 1 ? 'disabled' : '' }}>Next Page</button>
            </div>
            
            <div class="print-tips">
                <h3>Printing Tips:</h3>
                <ul>
                    <li>Select "4 × 6 in" in your printer settings</li>
                    <li>Choose "Actual size" or "No scaling" in print options</li>
                    <li>Disable headers and footers in browser print settings</li>
                    <li>Each page will print on a separate sheet</li>
                    <li>For best results, use the "Download PDF" button and print from PDF</li>
                </ul>
            </div>
        </div>
        
        @php
            $productsPerPage = 10;
            $productCount = count($batch->products);
            $pageCount = ceil($productCount / $productsPerPage);
        @endphp
        
        @for ($page = 0; $page < $pageCount; $page++)
            <div class="page {{ $page === 0 ? '' : 'hidden' }}" data-page="{{ $page + 1 }}">
                <div class="batch-info">
                    Page {{ $page + 1 }} of {{ $pageCount }}
                </div>
                
                <div class="label-grid">
                    @for ($i = 0; $i < $productsPerPage; $i++)
                        @php
                            $index = $page * $productsPerPage + $i;
                            if ($index >= $productCount) break;
                            $product = $batch->products[$index];
                        @endphp
                        
                        <div class="product-label">
                            <div class="label-header">
                                <div class="company-name">PRIMO IT</div>
                                <div class="date">{{ now()->format('d/m/Y') }}</div>
                            </div>
                            
                            <div class="ref-code">
                                REF: {{ $batch->reference_code }}-{{ $index + 1 }}
                            </div>
                            
                            <div class="product-name">
                                {{ $product['name'] ?? ($batch->name . ' - Unit ' . ($index + 1)) }}
                            </div>
                            
                            <div class="product-info">
                                <div class="product-details">
                                    @if(!empty($product['model']))
                                    <div class="info-line">
                                        <span class="info-label">Model:</span> {{ $product['model'] }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['cpu']) || !empty($batch->cpu))
                                    <div class="info-line">
                                        <span class="info-label">CPU:</span> {{ $product['cpu'] ?? $batch->cpu }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['ram']) || !empty($batch->ram))
                                    <div class="info-line">
                                        <span class="info-label">RAM:</span> {{ $product['ram'] ?? $batch->ram }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['storage']) || !empty($batch->storage))
                                    <div class="info-line">
                                        <span class="info-label">Storage:</span> {{ $product['storage'] ?? $batch->storage }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['grade']) || !empty($batch->grade))
                                    <div class="info-line">
                                        <span class="info-label">Grade:</span> {{ $product['grade'] ?? $batch->grade }}
                                    </div>
                                    @endif
                                    
                                    @if(!empty($product['tech_grade']))
                                    <div class="info-line">
                                        <span class="info-label">Tech:</span> {{ $product['tech_grade'] }}
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="qr-container">
                                    <div class="qr-code">
                                        {!! QrCode::size(45)->generate(route('admin.batches.show', $batch) . '#product-' . ($index + 1)) !!}
                                    </div>
                                    <div class="qr-text">Scan for details</div>
                                </div>
                            </div>
                            
                            <div class="label-footer">
                                <div></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>
    
    <script>
        let currentPage = 1;
        const totalPages = {{ $pageCount }};
        let showAllPages = false;
        
        function updatePageDisplay() {
            // Update page info text
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            
            // Enable/disable navigation buttons
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;
            
            if (!showAllPages) {
                // Hide all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.add('hidden');
                });
                
                // Show only current page
                const currentPageElement = document.querySelector(`.page[data-page="${currentPage}"]`);
                if (currentPageElement) {
                    currentPageElement.classList.remove('hidden');
                }
            }
        }
        
        function nextPage() {
            if (currentPage < totalPages) {
                currentPage++;
                updatePageDisplay();
            }
        }
        
        function prevPage() {
            if (currentPage > 1) {
                currentPage--;
                updatePageDisplay();
            }
        }
        
        function togglePages() {
            showAllPages = !showAllPages;
            const toggleBtn = document.getElementById('toggleBtn');
            
            if (showAllPages) {
                // Show all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('hidden');
                });
                toggleBtn.textContent = 'Show Single Page';
            } else {
                toggleBtn.textContent = 'Show All Pages';
                updatePageDisplay();
            }
        }
        
        function printLabels() {
            // Show all pages before printing
            const wasShowingAll = showAllPages;
            
            if (!wasShowingAll) {
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('hidden');
                });
            }
            
            // Add a slight delay to ensure all pages are rendered
            setTimeout(() => {
                window.print();
                
                // After printing, restore previous view
                setTimeout(() => {
                    if (!wasShowingAll) {
                        showAllPages = false;
                        updatePageDisplay();
                    }
                }, 500);
            }, 300);
        }
    </script>
</body>
</html> 
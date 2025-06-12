<?php
// Leggi il file originale
$content = file_get_contents('resources/views/admin/batches/edit.blade.php');

// Modifica il campo profit_margin rimuovendo x-model
$content = str_replace(
    '<input type="number" name="profit_margin" id="profit_margin" x-model="profitMargin" min="0" step="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">',
    '<input type="number" name="profit_margin" id="profit_margin" value="{{ old(\'profit_margin\', $batch->profit_margin ?? 16) }}" min="0" step="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">',
    $content
);

// Modifica il campo sale_price rimuovendo x-model
$content = str_replace(
    '<input type="number" name="sale_price" id="sale_price" x-model="salePrice" min="0" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" readonly>',
    '<input type="number" name="sale_price" id="sale_price" value="{{ old(\'sale_price\', $batch->sale_price ?? 0) }}" min="0" step="0.01" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-100" readonly>',
    $content
);

// Trova l'inizio del div x-data
$startPos = strpos($content, '<div x-data');
if ($startPos !== false) {
    // Trova il tag di chiusura del div x-data
    $depth = 1;
    $endPos = $startPos;
    $inString = false;
    $stringDelimiter = '';
    
    for ($i = $startPos + 10; $i < strlen($content); $i++) {
        $char = $content[$i];
        
        // Gestione delle stringhe
        if (($char === '"' || $char === "'") && ($i === 0 || $content[$i-1] !== '\\')) {
            if (!$inString) {
                $inString = true;
                $stringDelimiter = $char;
            } elseif ($char === $stringDelimiter) {
                $inString = false;
            }
        }
        
        if (!$inString) {
            if ($char === '<' && substr($content, $i, 4) === '<div') {
                $depth++;
            } elseif ($char === '<' && substr($content, $i, 6) === '</div>') {
                $depth--;
                if ($depth === 0) {
                    $endPos = $i + 6;
                    break;
                }
            }
        }
    }
    
    if ($endPos > $startPos) {
        // Estrai il contenuto interno del div x-data
        $innerContent = substr($content, $startPos, $endPos - $startPos);
        
        // Crea il nuovo div semplice per profit_margin
        $newProfitMarginDiv = '
                                <div>
                                    <label for="profit_margin" class="block text-sm font-medium text-gray-700 mb-1">Profit Margin (%)</label>
                                    <input type="number" name="profit_margin" id="profit_margin" value="{{ old(\'profit_margin\', $batch->profit_margin ?? 16) }}" min="0" step="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error(\'profit_margin\')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>';
        
        // Sostituisci il div x-data con il nuovo div
        $content = substr_replace($content, $newProfitMarginDiv, $startPos, $endPos - $startPos);
    }
}

// Aggiungi il codice JavaScript per il calcolo del sale_price
$jsCode = '
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const totalCostInput = document.getElementById("total_cost");
            const profitMarginInput = document.getElementById("profit_margin");
            const salePriceInput = document.getElementById("sale_price");
            
            // Function to calculate sale price
            function calculateSalePrice() {
                const totalCost = parseFloat(totalCostInput.value) || 0;
                const profitMargin = parseFloat(profitMarginInput.value) || 0;
                
                if (totalCost > 0 && profitMargin > 0) {
                    const salePrice = (totalCost * (1 + (profitMargin / 100))).toFixed(2);
                    salePriceInput.value = salePrice;
                }
            }
            
            // Add event listeners
            if (profitMarginInput) {
                profitMarginInput.addEventListener("input", calculateSalePrice);
            }
            
            if (totalCostInput) {
                totalCostInput.addEventListener("change", calculateSalePrice);
                // Triggerare l\'evento change quando cambia batch_cost, shipping_cost e tax_amount
                document.getElementById("batch_cost").addEventListener("input", function() {
                    calculateTotalCost();
                    setTimeout(calculateSalePrice, 50);
                });
                document.getElementById("shipping_cost").addEventListener("input", function() {
                    calculateTotalCost();
                    setTimeout(calculateSalePrice, 50);
                });
                document.getElementById("tax_amount").addEventListener("input", function() {
                    calculateTotalCost();
                    setTimeout(calculateSalePrice, 50);
                });
            }
            
            // Initialize on page load
            calculateSalePrice();
        });
    </script>
';

// Trova la posizione di </x-admin-layout> per inserire il codice JavaScript
$jsInsertPos = strrpos($content, '</x-admin-layout>');
if ($jsInsertPos !== false) {
    $content = substr_replace($content, $jsCode, $jsInsertPos, 0);
}

// Scrivi il contenuto modificato nel file
file_put_contents('resources/views/admin/batches/edit.blade.php', $content);

echo "File updated successfully!\n"; 
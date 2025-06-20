document.addEventListener("DOMContentLoaded", function() {
    // Ottieni i riferimenti agli input
    const unitQuantityInput = document.getElementById("unit_quantity");
    const unitPriceInput = document.getElementById("unit_price");
    const salePriceInput = document.getElementById("sale_price");
    
    // Funzione per calcolare unit_price
    function calculateUnitPrice() {
        const salePrice = parseFloat(salePriceInput.value) || 0;
        const quantity = parseFloat(unitQuantityInput.value) || 1; // Usa 1 come fallback per evitare divisioni per zero
        
        if (salePrice > 0 && quantity > 0) {
            const unitPrice = (salePrice / quantity).toFixed(2);
            unitPriceInput.value = unitPrice;
        }
    }
    
    // Aggiungi event listeners
    if (unitQuantityInput) {
        unitQuantityInput.addEventListener("input", calculateUnitPrice);
    }
    
    if (salePriceInput) {
        // Event listener per quando sale_price cambia direttamente
        salePriceInput.addEventListener("change", calculateUnitPrice);
        
        // Monitora anche le altre variabili che influenzano sale_price
        const profitMarginInput = document.getElementById("profit_margin");
        if (profitMarginInput) {
            profitMarginInput.addEventListener("input", function() {
                // Attendiamo che sale_price sia aggiornato prima di calcolare unit_price
                setTimeout(calculateUnitPrice, 50);
            });
        }
        
        // Monitora le variabili che influenzano total_cost, che a sua volta influenza sale_price
        const batchCostInput = document.getElementById("batch_cost");
        const shippingCostInput = document.getElementById("shipping_cost");
        const taxAmountInput = document.getElementById("tax_amount");
        
        if (batchCostInput) {
            batchCostInput.addEventListener("input", function() {
                // Attendiamo che total_cost e sale_price siano aggiornati
                setTimeout(calculateUnitPrice, 100);
            });
        }
        
        if (shippingCostInput) {
            shippingCostInput.addEventListener("input", function() {
                setTimeout(calculateUnitPrice, 100);
            });
        }
        
        if (taxAmountInput) {
            taxAmountInput.addEventListener("input", function() {
                setTimeout(calculateUnitPrice, 100);
            });
        }
    }
    
    // Calcola il prezzo unitario all'avvio
    calculateUnitPrice();
}); 
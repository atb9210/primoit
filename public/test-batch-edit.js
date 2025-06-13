/**
 * Script di test per il form di modifica batch
 * Questo script deve essere inserito nella console del browser per diagnosticare i problemi
 */

console.log("=== BATCH EDIT FORM TEST SCRIPT ===");

// 1. Verifica se il form esiste
const batchForm = document.querySelector('form[action*="batches"]');
console.log("Form trovato:", !!batchForm);
if (batchForm) {
    console.log("Form action:", batchForm.action);
    console.log("Form method:", batchForm.method);
}

// 2. Verifica tutti gli input hidden required che potrebbero causare problemi
const hiddenRequiredInputs = Array.from(document.querySelectorAll('input[type="hidden"][required]'));
console.log("Input hidden required trovati:", hiddenRequiredInputs.length);
hiddenRequiredInputs.forEach(input => {
    console.log(`Input hidden required: name=${input.name}, value=${input.value || 'VUOTO'}, valid=${input.validity.valid}`);
});

// 3. Verifica specificamente l'input quantity che causa l'errore
const quantityInput = document.querySelector('input[name="quantity"]');
console.log("Input quantity trovato:", !!quantityInput);
if (quantityInput) {
    console.log("Quantity input:", {
        type: quantityInput.type,
        name: quantityInput.name,
        value: quantityInput.value,
        required: quantityInput.required,
        min: quantityInput.min,
        hidden: quantityInput.hidden,
        disabled: quantityInput.disabled,
        readOnly: quantityInput.readOnly,
        parentVisible: quantityInput.parentElement ? window.getComputedStyle(quantityInput.parentElement).display !== 'none' : false,
        valid: quantityInput.validity.valid,
        validationMessage: quantityInput.validationMessage
    });
}

// 4. Verifica il bottone di submit
const submitButton = document.querySelector('button[type="submit"]');
console.log("Submit button trovato:", !!submitButton);
if (submitButton) {
    console.log("Submit button text:", submitButton.textContent.trim());
    console.log("Submit button disabled:", submitButton.disabled);
}

// 5. Verifica i campi manufacturer e model
const manufacturerInput = document.getElementById('product_manufacturer');
const modelInput = document.getElementById('product_model');
console.log("Manufacturer input trovato:", !!manufacturerInput);
console.log("Model input trovato:", !!modelInput);
if (manufacturerInput) {
    console.log("Manufacturer value:", manufacturerInput.value);
    console.log("Manufacturer valid:", manufacturerInput.validity.valid);
}
if (modelInput) {
    console.log("Model value:", modelInput.value);
    console.log("Model valid:", modelInput.validity.valid);
}

// 6. Verifica tutti gli input required nel form
const allRequiredInputs = Array.from(document.querySelectorAll('input[required], select[required], textarea[required]'));
console.log("Tutti gli input required trovati:", allRequiredInputs.length);
const invalidInputs = allRequiredInputs.filter(input => !input.validity.valid);
console.log("Input required non validi:", invalidInputs.length);
invalidInputs.forEach(input => {
    console.log(`Input non valido: name=${input.name}, type=${input.type}, value=${input.value || 'VUOTO'}, validationMessage=${input.validationMessage}`);
});

// 7. Testa il submit del form manualmente
console.log("=== TEST SUBMIT FORM ===");
console.log("Per testare il submit del form, esegui questa funzione:");
console.log("testSubmitForm()");

function testSubmitForm() {
    console.log("Tentativo di submit del form...");
    
    // Correggi eventuali problemi con l'input quantity
    const quantityInput = document.querySelector('input[name="quantity"]');
    if (quantityInput && !quantityInput.validity.valid) {
        console.log("Correzione input quantity...");
        // Rimuovi il requisito min se è il problema
        quantityInput.removeAttribute('min');
        // Assicurati che abbia un valore valido
        if (!quantityInput.value) {
            quantityInput.value = "0";
        }
        console.log("Quantity input dopo correzione:", quantityInput.value, "valid:", quantityInput.validity.valid);
    }
    
    // Verifica che tutti i campi required abbiano un valore
    const allRequiredInputs = Array.from(document.querySelectorAll('input[required], select[required], textarea[required]'));
    allRequiredInputs.forEach(input => {
        if (!input.validity.valid) {
            console.log(`Correzione input ${input.name}...`);
            if (input.type === "text" && !input.value) {
                input.value = "Test value";
            } else if (input.type === "number" && !input.value) {
                input.value = "0";
            } else if (input.tagName === "SELECT" && !input.value) {
                if (input.options.length > 0) {
                    input.selectedIndex = 1; // Seleziona la prima opzione non vuota
                }
            }
            console.log(`Input ${input.name} dopo correzione:`, input.value, "valid:", input.validity.valid);
        }
    });
    
    // Prova a inviare il form
    try {
        // Crea un evento submit
        const event = new Event('submit', {
            'bubbles': true,
            'cancelable': true
        });
        
        // Dispatch dell'evento
        const submitted = batchForm.dispatchEvent(event);
        console.log("Form submit event dispatched, cancelled:", !submitted);
        
        // Se l'evento non è stato cancellato, prova a inviare il form manualmente
        if (submitted) {
            batchForm.submit();
            console.log("Form submitted manually");
        }
    } catch (error) {
        console.error("Errore durante il submit del form:", error);
    }
}

// 8. Funzione per correggere automaticamente i problemi
console.log("=== CORREZIONE AUTOMATICA ===");
console.log("Per tentare una correzione automatica, esegui questa funzione:");
console.log("fixFormIssues()");

function fixFormIssues() {
    console.log("Tentativo di correzione dei problemi del form...");
    
    // 1. Correggi l'input quantity
    const quantityInput = document.querySelector('input[name="quantity"]');
    if (quantityInput) {
        console.log("Correzione input quantity...");
        // Rimuovi l'attributo required se è nascosto
        if (quantityInput.parentElement && window.getComputedStyle(quantityInput.parentElement).display === 'none') {
            quantityInput.removeAttribute('required');
        }
        // Rimuovi min se è un problema
        quantityInput.removeAttribute('min');
        // Assicurati che abbia un valore
        if (!quantityInput.value) {
            quantityInput.value = "0";
        }
    }
    
    // 2. Assicurati che manufacturer e model abbiano valori
    const manufacturerInput = document.getElementById('product_manufacturer');
    const modelInput = document.getElementById('product_model');
    
    if (manufacturerInput && !manufacturerInput.value) {
        console.log("Impostazione valore manufacturer...");
        manufacturerInput.value = "Lenovo";
    }
    
    if (modelInput && !modelInput.value) {
        console.log("Impostazione valore model...");
        modelInput.value = "ThinkPad T470";
    }
    
    // 3. Verifica tutti gli input required
    const allRequiredInputs = Array.from(document.querySelectorAll('input[required], select[required], textarea[required]'));
    allRequiredInputs.forEach(input => {
        if (!input.validity.valid) {
            console.log(`Correzione input ${input.name}...`);
            if (input.type === "text" && !input.value) {
                input.value = "Test value";
            } else if (input.type === "number" && !input.value) {
                input.value = "0";
            } else if (input.tagName === "SELECT" && !input.value) {
                if (input.options.length > 0) {
                    input.selectedIndex = 1; // Seleziona la prima opzione non vuota
                }
            }
        }
    });
    
    console.log("Correzione completata. Ora puoi provare a inviare il form.");
}

console.log("=== FINE SCRIPT DI TEST ==="); 
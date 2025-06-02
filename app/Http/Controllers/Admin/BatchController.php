<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BatchController extends Controller
{
    /**
     * Display a listing of the batches.
     */
    public function index()
    {
        $batches = Batch::paginate(15);
        
        // Aggiorna total_quantity per ogni batch
        foreach ($batches as $batch) {
            // Verifica se ci sono prodotti e aggiorna total_quantity
            if (is_array($batch->products) && count($batch->products) > 0) {
                $totalQuantity = 0;
                foreach ($batch->products as $product) {
                    $totalQuantity += (int)($product['quantity'] ?? 0);
                }
                
                // Aggiorna solo se ci sono differenze
                if ($batch->total_quantity != $totalQuantity) {
                    $batch->total_quantity = $totalQuantity;
                    $batch->save();
                }
            }
        }
        
        return view('admin.batches.index', compact('batches'));
    }

    /**
     * Show the form for creating a new batch.
     */
    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.batches.create', compact('categories'));
    }

    /**
     * Store a newly created batch in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'product_manufacturer' => 'required|string|max:100',
            'product_model' => 'required|string|max:100',
            'unit_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,active,reserved,sold',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date',
            'condition_grade' => 'nullable|string|max:50',
            'visual_grade' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'param_keys' => 'nullable|array',
            'param_keys.*' => 'string|max:100',
            'param_values' => 'nullable|array',
            'param_values.*' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:2048', // Validazione per il caricamento di immagini
            'default_image_index' => 'nullable|integer',
            'source_type' => 'nullable|string|in:internal,external,imported',
            'supplier' => 'nullable|string|max:255',
            'source_reference' => 'nullable|string|max:255',
            'batch_cost' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ]);

        // Nella creazione iniziale, tipicamente non ci sono prodotti,
        // quindi useremo i valori di input
        $totalQuantity = $validated['unit_quantity'];
        $totalPrice = $validated['unit_price'] * $validated['unit_quantity'];
        
        // Gestione upload immagini se presenti
        $imagesPaths = [];
        $defaultImageIndex = $request->input('default_image_index', 0);
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('batches', 'public');
                
                // Se questa è l'immagine default, salva le informazioni
                if ((int)$defaultImageIndex === $index) {
                    $imagesPaths['default'] = $path;
                }
                
                $imagesPaths[] = $path;
            }
        }

        // Prepara le specifiche dinamiche
        $specifications = [];
        if ($request->has('param_keys') && $request->has('param_values')) {
            $keys = $request->param_keys;
            $values = $request->param_values;
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index])) {
                    $specifications[$key] = $values[$index];
                }
            }
        }

        // Crea il batch con tutti i campi
        $batch = Batch::create([
            'name' => $validated['name'],
            'reference_code' => $validated['reference_code'] ?? Batch::generateReferenceCode($validated['source_type'] ?? 'internal', $validated['category_id']),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'product_manufacturer' => $validated['product_manufacturer'],
            'product_model' => $validated['product_model'],
            'unit_quantity' => $validated['unit_quantity'],
            'unit_price' => $validated['unit_price'],
            'total_price' => $totalPrice,
            'total_quantity' => $totalQuantity,
            'condition_grade' => $validated['condition_grade'] ?? null,
            'visual_grade' => $validated['visual_grade'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'specifications' => $specifications,
            'images' => $imagesPaths,
            'status' => $validated['status'],
            'available_from' => $validated['available_from'],
            'available_until' => $validated['available_until'],
            'source_type' => $validated['source_type'],
            'supplier' => $validated['supplier'],
            'source_reference' => $validated['source_reference'],
            'batch_cost' => $validated['batch_cost'],
            'shipping_cost' => $validated['shipping_cost'],
            'tax_amount' => $validated['tax_amount'],
            'total_cost' => $validated['total_cost'],
        ]);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch created successfully.');
    }

    /**
     * Display the specified batch.
     */
    public function show(Batch $batch)
    {
        return view('admin.batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified batch.
     */
    public function edit(Batch $batch)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        return view('admin.batches.edit', compact('batch', 'categories'));
    }

    /**
     * Update the specified batch in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'reference_code' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'product_manufacturer' => 'required|string|max:100',
            'product_model' => 'required|string|max:100',
            'unit_quantity' => 'required|integer|min:0',  // Cambiato min:1 a min:0 per consentire batch vuoti
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,active,reserved,sold',
            'available_from' => 'nullable|date',
            'available_until' => 'nullable|date',
            'condition_grade' => 'nullable|string|max:50',
            'visual_grade' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
            'param_keys' => 'nullable|array',
            'param_keys.*' => 'string|max:100',
            'param_values' => 'nullable|array',
            'param_values.*' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|max:2048', // Validazione per il caricamento di immagini
            'remove_images' => 'nullable|array', // Array di indici di immagini da rimuovere
            'default_image_index' => 'nullable|integer',
            'source_type' => 'nullable|string|in:internal,external,imported',
            'supplier' => 'nullable|string|max:255',
            'source_reference' => 'nullable|string|max:255',
            'batch_cost' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ]);

        // Calcola la quantità totale dai prodotti se presenti
        $totalQuantity = 0;
        $totalPrice = 0;
        
        if (is_array($batch->products) && count($batch->products) > 0) {
            foreach ($batch->products as $product) {
                $totalQuantity += (int)($product['quantity'] ?? 0);
                $totalPrice += (float)($product['price'] ?? 0) * (int)($product['quantity'] ?? 0);
            }
        } else {
            // Se non ci sono prodotti, usa i valori di input come fallback
            $totalQuantity = $validated['unit_quantity'];
            $totalPrice = $validated['unit_price'] * $validated['unit_quantity'];
        }
        
        // Gestione immagini
        $imagesPaths = $batch->images ?? [];
        $hasDefaultKey = isset($imagesPaths['default']);
        $defaultPath = $hasDefaultKey ? $imagesPaths['default'] : null;
        
        // Se abbiamo un campo default, rimuoviamolo per lavorare sull'array numerico
        if ($hasDefaultKey) {
            unset($imagesPaths['default']);
        }
        
        // Rimuovi immagini selezionate
        if (isset($validated['remove_images'])) {
            foreach ($validated['remove_images'] as $index) {
                if (isset($imagesPaths[$index])) {
                    // Rimuovi il file fisico se esiste
                    $filePath = storage_path('app/public/' . $imagesPaths[$index]);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    
                    // Se questa è l'immagine default, rimuovi il riferimento
                    if ($defaultPath === $imagesPaths[$index]) {
                        $defaultPath = null;
                    }
                    
                    // Rimuovi dal array
                    unset($imagesPaths[$index]);
                }
            }
            // Reindex array
            $imagesPaths = array_values($imagesPaths);
        }
        
        // Aggiungi nuove immagini
        $newImagesCount = 0;
        $defaultImageIndex = $request->input('default_image_index');
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('batches', 'public');
                
                // Se questa è l'immagine default, salva le informazioni
                if ((string)$defaultImageIndex === "new_$index") {
                    $defaultPath = $path;
                }
                
                $imagesPaths[] = $path;
                $newImagesCount++;
            }
        }
        
        // Aggiorna l'immagine default basata sull'indice selezionato
        if (is_numeric($defaultImageIndex) && isset($imagesPaths[$defaultImageIndex])) {
            $defaultPath = $imagesPaths[$defaultImageIndex];
        }
        
        // Aggiungi l'immagine default se presente
        if ($defaultPath) {
            $imagesPaths['default'] = $defaultPath;
        }

        // Prepara le specifiche dinamiche
        $specifications = [];
        if ($request->has('param_keys') && $request->has('param_values')) {
            $keys = $request->param_keys;
            $values = $request->param_values;
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index])) {
                    $specifications[$key] = $values[$index];
                }
            }
        }

        // Aggiorna il batch
        $batch->update([
            'name' => $validated['name'],
            'reference_code' => $validated['reference_code'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'product_manufacturer' => $validated['product_manufacturer'],
            'product_model' => $validated['product_model'],
            'unit_quantity' => $totalQuantity, // Usa la quantità calcolata dai prodotti
            'unit_price' => $validated['unit_price'],
            'total_price' => $totalPrice,
            'total_quantity' => $totalQuantity, // Aggiornato per usare la quantità calcolata
            'condition_grade' => $validated['condition_grade'] ?? null,
            'visual_grade' => $validated['visual_grade'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'specifications' => $specifications,
            'images' => $imagesPaths,
            'status' => $validated['status'],
            'available_from' => $validated['available_from'],
            'available_until' => $validated['available_until'],
            'source_type' => $validated['source_type'],
            'supplier' => $validated['supplier'],
            'source_reference' => $validated['source_reference'],
            'batch_cost' => $validated['batch_cost'],
            'shipping_cost' => $validated['shipping_cost'],
            'tax_amount' => $validated['tax_amount'],
            'total_cost' => $validated['total_cost'],
        ]);

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch updated successfully.');
    }

    /**
     * Remove the specified batch from storage.
     */
    public function destroy(Batch $batch)
    {
        // Rimuovi immagini fisiche se presenti
        if (is_array($batch->images) && count($batch->images) > 0) {
            foreach ($batch->images as $imagePath) {
                $filePath = storage_path('app/public/' . $imagePath);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        
        $batch->delete();

        return redirect()->route('admin.batches.index')
            ->with('success', 'Batch deleted successfully.');
    }
    
    /**
     * Manage products in a batch
     */
    public function manageProducts(Batch $batch)
    {
        return view('admin.batches.manage-products', compact('batch'));
    }
    
    /**
     * Add a product to a batch
     */
    public function addProduct(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'manufacturer' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'grade' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'tech_grade' => 'nullable|string|max:50',
            'problems' => 'nullable|string|max:500',
            'param_keys' => 'nullable|array',
            'param_keys.*' => 'string|max:100',
            'param_values' => 'nullable|array',
            'param_values.*' => 'nullable|string|max:255',
            'product_images.*' => 'nullable|image|max:2048', // Validazione per le immagini del prodotto
            'product_default_image' => 'nullable|integer', // Indice dell'immagine predefinita
        ]);
        
        // Prepara i parametri del prodotto
        $productParams = [];
        if ($request->has('param_keys') && $request->has('param_values')) {
            $keys = $request->param_keys;
            $values = $request->param_values;
            
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index])) {
                    $productParams[$key] = $values[$index];
                }
            }
        }
        
        // Gestione delle immagini del prodotto
        $productImages = [];
        $defaultImageIndex = (int)$request->input('product_default_image', 0);
        
        if ($request->hasFile('product_images')) {
            $files = $request->file('product_images');
            
            // Limitiamo il numero di immagini a 4
            $filesToProcess = array_slice($files, 0, 4);
            
            foreach ($filesToProcess as $index => $image) {
                $path = $image->store('products', 'public');
                
                // Imposta l'immagine predefinita in base all'indice selezionato
                if ($index === $defaultImageIndex) {
                    $productImages['default'] = $path;
                }
                
                $productImages[] = $path;
            }
            
            // Se non è stato selezionato un indice valido, usa la prima immagine come predefinita
            if (!isset($productImages['default']) && count($productImages) > 0) {
                $productImages['default'] = $productImages[0];
            }
        }
        
        // Crea un array che rappresenta il prodotto (in un formato JSON)
        $product = [
            'manufacturer' => $validated['manufacturer'],
            'model' => $validated['model'],
            'grade' => $validated['grade'],
            'price' => (float)$validated['price'],
            'quantity' => (int)$validated['quantity'],
            'tech_grade' => $validated['tech_grade'],
            'parameters' => $productParams,
            'images' => $productImages,
            'created_at' => now()->toDateTimeString()
        ];
        
        // Aggiungi il campo problems solo se tech_grade è Working* o Not Working
        if (in_array($validated['tech_grade'], ['Working*', 'Not Working']) && isset($request->problems)) {
            $product['problems'] = $request->problems;
        }
        
        // Recupera i prodotti esistenti o inizializza un array vuoto
        $products = $batch->products ?? [];
        
        // Aggiungi il nuovo prodotto
        $products[] = $product;
        
        // Aggiorna il batch con i nuovi prodotti
        $batch->products = $products;
        
        // Aggiorna anche il prezzo totale e la quantità
        $totalQuantity = 0;
        $totalPrice = 0;
        
        foreach ($products as $product) {
            $totalQuantity += $product['quantity'];
            $totalPrice += $product['price'] * $product['quantity'];
        }
        
        $batch->total_quantity = $totalQuantity;
        $batch->total_price = $totalPrice;
        
        $batch->save();
        
        return redirect()->route('admin.batches.manage-products', $batch)
            ->with('success', 'Product added to batch successfully.');
    }
    
    /**
     * Remove a product from a batch
     */
    public function removeProduct(Request $request, Batch $batch, $index)
    {
        // Recupera i prodotti del batch
        $products = $batch->products ?? [];
        
        // Verifica che l'indice esista
        if (!isset($products[$index])) {
            return redirect()->route('admin.batches.manage-products', $batch)
                ->with('error', 'Product not found.');
        }
        
        // Rimuovi le immagini fisiche del prodotto se presenti
        if (isset($products[$index]['images']) && is_array($products[$index]['images'])) {
            foreach ($products[$index]['images'] as $imagePath) {
                // Salta la chiave 'default' che non è un percorso
                if ($imagePath === $products[$index]['images']['default'] ?? null) {
                    continue;
                }
                
                $filePath = storage_path('app/public/' . $imagePath);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        
        // Rimuovi il prodotto dall'array
        array_splice($products, $index, 1);
        
        // Aggiorna il batch con i prodotti rimanenti
        $batch->products = $products;
        
        // Aggiorna anche il prezzo totale e la quantità
        $totalQuantity = 0;
        $totalPrice = 0;
        
        foreach ($products as $product) {
            $totalQuantity += $product['quantity'];
            $totalPrice += $product['price'] * $product['quantity'];
        }
        
        $batch->total_quantity = $totalQuantity;
        $batch->total_price = $totalPrice;
        
        $batch->save();
        
        return redirect()->route('admin.batches.manage-products', $batch)
            ->with('success', 'Product removed from batch successfully.');
    }
}

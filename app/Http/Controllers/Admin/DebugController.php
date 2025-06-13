<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    public function testBatchUpdate(Request $request, $id)
    {
        try {
            $batch = Batch::findOrFail($id);
            
            Log::debug('DebugController - testBatchUpdate');
            Log::debug('Batch ID: ' . $id);
            Log::debug('Batch name: ' . $batch->name);
            Log::debug('Batch manufacturer: ' . $batch->product_manufacturer);
            Log::debug('Batch model: ' . $batch->product_model);
            
            // Aggiorna solo il nome per testare
            $batch->name = "Lenovo ThinkPad T470 - Test Update";
            $batch->product_manufacturer = "Lenovo";
            $batch->product_model = "ThinkPad T470";
            $batch->save();
            
            Log::debug('Batch aggiornato con successo');
            
            return redirect()->route('admin.batches.index')
                ->with('success', 'Batch updated successfully via debug controller.');
        } catch (\Exception $e) {
            Log::error('Errore nel debug controller: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->route('admin.batches.index')
                ->with('error', 'Error updating batch: ' . $e->getMessage());
        }
    }
} 
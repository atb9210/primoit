<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Mostra la pagina delle impostazioni
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Raggruppa le impostazioni per gruppo
        $settingGroups = Setting::orderBy('group')->orderBy('name')->get()->groupBy('group');
        
        return view('admin.settings.index', compact('settingGroups'));
    }
    
    /**
     * Mostra la pagina per modificare le impostazioni di un gruppo specifico
     *
     * @param string $group
     * @return \Illuminate\View\View
     */
    public function edit($group)
    {
        // Verifica che il gruppo esista
        $settings = Setting::where('group', $group)->orderBy('name')->get();
        
        if ($settings->isEmpty()) {
            return redirect()->route('admin.settings.index')
                ->with('error', "Il gruppo di impostazioni '$group' non esiste.");
        }
        
        $groupName = $this->getGroupDisplayName($group);
        
        return view('admin.settings.edit', compact('settings', 'group', 'groupName'));
    }
    
    /**
     * Aggiorna le impostazioni di un gruppo specifico
     *
     * @param Request $request
     * @param string $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $group)
    {
        // Verifica che il gruppo esista
        $settings = Setting::where('group', $group)->get();
        
        if ($settings->isEmpty()) {
            return redirect()->route('admin.settings.index')
                ->with('error', "Il gruppo di impostazioni '$group' non esiste.");
        }
        
        // Per ogni impostazione nel gruppo
        foreach ($settings as $setting) {
            // Se l'impostazione è di sistema, non la modifichiamo
            if ($setting->is_system) {
                continue;
            }
            
            $key = $setting->key;
            
            // Gestione diversa in base al tipo di impostazione
            switch ($setting->type) {
                case 'image':
                    // Gestione del caricamento immagine
                    if ($request->hasFile($key)) {
                        $file = $request->file($key);
                        
                        // Valida il file
                        $validator = Validator::make(
                            [$key => $file],
                            [$key => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']
                        );
                        
                        if ($validator->fails()) {
                            return redirect()->back()
                                ->with('error', 'Il file per ' . $setting->name . ' non è valido: ' . $validator->errors()->first($key))
                                ->withInput();
                        }
                        
                        // Rimuovi il vecchio file se esiste
                        if ($setting->value) {
                            Storage::disk('public')->delete($setting->value);
                        }
                        
                        // Salva il nuovo file
                        $path = $file->store('settings', 'public');
                        $setting->value = $path;
                    }
                    break;
                    
                default:
                    // Per tutti gli altri tipi, ottieni il valore dal request
                    if ($request->has($key)) {
                        $setting->value = $request->input($key);
                    }
                    break;
            }
            
            $setting->save();
            
            // Aggiorna la cache
            Cache::forget("setting_{$key}");
        }
        
        // Ottieni il nome visualizzabile del gruppo
        $groupName = $this->getGroupDisplayName($group);
        
        return redirect()->route('admin.settings.edit', $group)
            ->with('success', "Le impostazioni del gruppo '$groupName' sono state aggiornate con successo.");
    }
    
    /**
     * Restituisce il nome visualizzabile del gruppo
     *
     * @param string $group
     * @return string
     */
    private function getGroupDisplayName($group)
    {
        $groupNames = [
            'company' => 'Azienda',
            'contact' => 'Contatti',
            'social' => 'Social Media',
            'document' => 'Documenti e PDF',
            'seo' => 'SEO e Analytics',
            'general' => 'Generali',
        ];
        
        return $groupNames[$group] ?? ucfirst($group);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'name',
        'description',
        'is_public',
        'is_system',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_system' => 'boolean',
    ];

    /**
     * Recupera un'impostazione dal database o dalla cache
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        // Prova a recuperare dalla cache
        $cacheKey = "setting_{$key}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Recupera dal database
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Gestisci i diversi tipi di dati
        $value = $setting->value;
        
        switch ($setting->type) {
            case 'json':
                $value = json_decode($value, true);
                break;
            case 'boolean':
                $value = (bool)$value;
                break;
            case 'integer':
                $value = (int)$value;
                break;
            case 'float':
                $value = (float)$value;
                break;
            case 'file':
            case 'image':
                $value = $value ? Storage::url($value) : null;
                break;
        }

        // Salva in cache
        Cache::put($cacheKey, $value, now()->addDay());

        return $value;
    }

    /**
     * Aggiorna o crea un'impostazione
     *
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Setting
     */
    public static function set(string $key, $value, array $attributes = [])
    {
        $setting = self::firstOrNew(['key' => $key]);
        
        // Gestisci i diversi tipi di dati
        if (isset($attributes['type'])) {
            $setting->type = $attributes['type'];
            
            // Converti i valori in base al tipo
            if ($attributes['type'] === 'json' && !is_string($value)) {
                $value = json_encode($value);
            }
            
            // Per immagini e file, il valore dovrebbe essere il percorso di storage
            if (in_array($attributes['type'], ['file', 'image']) && $value) {
                // Assumi che $value contenga il percorso dopo l'upload
                // Se è una nuova immagine, l'upload è gestito dal controller
            }
        }
        
        $setting->value = $value;
        
        // Imposta gli altri attributi
        foreach ($attributes as $attr => $val) {
            if (in_array($attr, $setting->fillable) && $attr !== 'key' && $attr !== 'value') {
                $setting->$attr = $val;
            }
        }
        
        $setting->save();
        
        // Aggiorna la cache
        Cache::put("setting_{$key}", $value, now()->addDay());
        
        return $setting;
    }

    /**
     * Elimina la cache per tutte le impostazioni
     */
    public static function clearCache()
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
    }
}

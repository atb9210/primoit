<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Batch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'reference_code',
        'description',
        'category_id',
        'product_type',
        'product_manufacturer',
        'product_model',
        'total_price',
        'total_quantity',
        'unit_quantity',
        'unit_price',
        'specifications',
        'cpu',
        'ram',
        'storage',
        'gpu',
        'os',
        'screen_size',
        'screen_resolution',
        'internal_memory',
        'camera',
        'battery_capacity',
        'hdd_capacity',
        'hdd_type',
        'hdd_interface',
        'condition_grade',
        'visual_grade',
        'notes',
        'images',
        'status',
        'available_from',
        'available_until',
        'products',
        'source_type',
        'supplier',
        'source_reference',
        'batch_cost',
        'shipping_cost',
        'tax_amount',
        'total_cost',
        'sale_price',
        'profit_margin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'total_quantity' => 'integer',
        'unit_quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'specifications' => 'array',
        'images' => 'array',
        'products' => 'array',
        'available_from' => 'date',
        'available_until' => 'date',
        'batch_cost' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'profit_margin' => 'integer',
    ];

    /**
     * Get the products in this batch.
     * 
     * @deprecated Will be removed after migrating to the new architecture
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }

    /**
     * Get the category this batch belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get specific attributes based on product type
     */
    public function getTypeSpecificAttributes(): array
    {
        $attributes = [];
        
        switch ($this->product_type) {
            case 'laptop':
            case 'desktop':
            case 'workstation':
                $attributes = [
                    'cpu' => $this->cpu,
                    'ram' => $this->ram,
                    'storage' => $this->storage,
                    'gpu' => $this->gpu,
                    'os' => $this->os,
                    'screen_size' => $this->screen_size,
                    'screen_resolution' => $this->screen_resolution,
                ];
                break;
                
            case 'smartphone':
            case 'tablet':
                $attributes = [
                    'internal_memory' => $this->internal_memory,
                    'ram' => $this->ram,
                    'camera' => $this->camera,
                    'screen_size' => $this->screen_size,
                    'battery_capacity' => $this->battery_capacity,
                    'os' => $this->os,
                ];
                break;
                
            case 'hdd':
            case 'ssd':
            case 'storage':
                $attributes = [
                    'hdd_capacity' => $this->hdd_capacity,
                    'hdd_type' => $this->hdd_type,
                    'hdd_interface' => $this->hdd_interface,
                ];
                break;
        }
        
        // Filtra attributi nulli
        return array_filter($attributes, function ($value) {
            return !is_null($value);
        });
    }

    /**
     * Calcola il prezzo totale dal prezzo unitario e dalla quantità
     */
    public function calculateTotalPrice()
    {
        if ($this->unit_price && $this->unit_quantity) {
            $this->total_price = $this->unit_price * $this->unit_quantity;
        }
        return $this->total_price;
    }

    /**
     * Calcola il prezzo di vendita in base al margine di profitto
     */
    public function calculateSalePrice()
    {
        if ($this->total_cost && $this->profit_margin) {
            $this->sale_price = $this->total_cost * (1 + ($this->profit_margin / 100));
        }
        return $this->sale_price;
    }

    /**
     * Get an array of common product types
     */
    public static function getProductTypes(): array
    {
        return [
            'laptop' => 'Laptop',
            'desktop' => 'Desktop',
            'workstation' => 'Workstation',
            'server' => 'Server',
            'smartphone' => 'Smartphone',
            'tablet' => 'Tablet',
            'monitor' => 'Monitor',
            'printer' => 'Stampante',
            'hdd' => 'Hard Disk',
            'ssd' => 'SSD',
            'ram' => 'Memoria RAM',
            'gpu' => 'Scheda Video',
            'cpu' => 'Processore',
            'network' => 'Dispositivo di Rete',
            'accessory' => 'Accessorio',
            'other' => 'Altro',
        ];
    }

    /**
     * Scope a query to only include active batches.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include available batches.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('available_until')
                    ->orWhere('available_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('available_from')
                    ->orWhere('available_from', '<=', now());
            });
    }

    /**
     * Filter batches by product type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    /**
     * Filter batches by manufacturer
     */
    public function scopeByManufacturer($query, $manufacturer)
    {
        return $query->where('product_manufacturer', $manufacturer);
    }
}

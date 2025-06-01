<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'message',
        'product_id',
        'status',
    ];

    /**
     * Get the product that the inquiry is about.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

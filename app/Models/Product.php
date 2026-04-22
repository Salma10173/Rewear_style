<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description',
        'price', 'sale_price', 'stock', 'image',
        'sizes', 'colors', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'sale_price'  => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getSizesArrayAttribute(): array
    {
        return $this->sizes ? explode(',', $this->sizes) : [];
    }

    public function getColorsArrayAttribute(): array
    {
        return $this->colors ? explode(',', $this->colors) : [];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

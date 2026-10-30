<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'badge_label',
        'description',
        'location',
        'subdistrict',
        'address_full',
        'price',
        'rating',
        'reviews_count',
        'image',
        'gallery',
        'facilities',
        'highlights',
        'type',
        'price_label',
        'price_type_title',
        'button_label',
        'button_class',
        'is_featured',
        'open_hours',
        'temperature',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'gallery' => 'array',
        'facilities' => 'array',
        'highlights' => 'array',
        'is_featured' => 'boolean',
        'price' => 'integer',
        'rating' => 'float',
        'reviews_count' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Helper accessor for category_name
     */
    public function getCategoryNameAttribute(): string
    {
        return $this->category ? $this->category->name : 'Wisata Banyumas';
    }

    /**
     * Helper accessor for category_slug
     */
    public function getCategorySlugAttribute(): string
    {
        return $this->category ? $this->category->slug : 'wisata';
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->image ?? '';
    }

    public function getRatingAvgAttribute(): float
    {
        return (float) $this->rating;
    }

    public function getAddressAttribute(): string
    {
        return $this->address_full ?? $this->location;
    }

    public function getOpeningHoursAttribute(): string
    {
        return $this->open_hours ?? '07:00 - 17:00 WIB';
    }

    public function getIsPopularAttribute(): bool
    {
        return (bool) $this->is_featured;
    }
}

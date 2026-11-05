<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }

    public function getCountAttribute(): int
    {
        return $this->destinations_count ?? $this->destinations()->count();
    }
}

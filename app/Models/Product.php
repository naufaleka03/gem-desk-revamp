<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    public function asset(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    protected $fillable = [
        'name',
        'organization_name',
        'product_type',
        'manufacturer',
        'cost',
        'description',
        'image',
        'acquisition_date'
    ];

    // One-to-many relationship
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
    
    // Many-to-many relationship (if needed later)
    public function serviceConnections(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_product');
    }
}

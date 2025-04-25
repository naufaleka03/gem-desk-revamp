<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class ProductType extends Model
{
    use HasFactory;

    public function asset(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    protected $fillable = [
        'name',
        'organization_name',
        'asset_type',
        'asset_category',
        'description',
        'image'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    public $table = 'services';

    protected $fillable = [
        'name',
        'service_categories',
        'description',
        'cost',
        'quantity',
        'availability',
        'hours',
        'organization_id',
        'product_id',
        'files',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * The additional products that belong to the service.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'service_product');
    }
}

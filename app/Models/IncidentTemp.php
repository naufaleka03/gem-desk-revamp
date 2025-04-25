<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident',
        'probability',
        'risk_impact',
        'priority',
        'incident_desc',
        'service',
        'asset',
    ];

//    public function service() : BelongsTo
//    {
//        return $this->belongsTo(Service::class);
//    }
}

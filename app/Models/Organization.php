<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model 
{
    use HasFactory;

    protected $fillable =[
        'organization_name',
        'description',
        'industry_category',
        'address',
        'city',
        'postal_code',
        'state',
        'country',
        'email',
        'phone_no',
        'fax_no',
        'web_url',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'id_organization'); // Foreign key: id_product
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}

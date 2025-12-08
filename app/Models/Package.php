<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'product_id',
    ];

    /**
     * Get the product associated with this package
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the services associated with this package
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_service');
    }
}

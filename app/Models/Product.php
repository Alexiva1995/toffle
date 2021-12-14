<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gr',
        'units_reposition_alert',
    ];

    public function inventories()
    {
        return $this->belongsToMany('App\Models\Inventory', 'product_inventory')
                        ->withPivot('qty_package', 'unit_package', 'price');
    }
}

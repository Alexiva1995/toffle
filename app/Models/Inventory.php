<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;
use App\Models\Product;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total',
        'deposit',
        'local',
        'public',
        'cost',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_inventory')
                        ->withPivot('id', 'product_id', 'inventory_id', 'qty_package', 'unit_package', 'price', 'created_at', 'updated_at');
    }
}

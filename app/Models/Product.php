<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mark',
        'gr',
        'quantity',
        'it_has_flavors',
        'units_reposition_alert',
    ];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'id', 'product_id');
    }
}

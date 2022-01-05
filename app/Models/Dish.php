<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'cost_price',
        'suggested_price',
        'designated_price',
        'percentage_profit',
        'category_id',
        'status',
    ];

    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Inventory', 'dish_ingredient')
                ->withPivot('id', 'dish_id', 'inventory_id', 'portion', 'created_at', 'updated_at');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

}
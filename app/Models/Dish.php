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
                ->withPivot('id', 'dish_id', 'inventory_id', 'portion', 'designated_cost', 'created_at', 'updated_at');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function collectionDishes($category_id)
    {
        $dishes = Dish::where('category_id', $category_id)->whereIn('status', ['1', '2'])->get();
        return $dishes;
    }
    
    public function status()
    {
        if($this->status == '0'){
            return "Inactivo";
        }else if($this->status == '1'){
            return "Activo";
        }else if($this->status == '2'){
            return "En Revisión";
        }
    }

    public function statusColor()
    {
        if($this->status == '0'){
            return "danger";
        }else if($this->status == '1'){
            return "success";
        }else if($this->status == '2'){
            return "info";
        }
    }
}
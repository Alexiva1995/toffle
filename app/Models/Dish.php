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
        $dishes = Dish::where('category_id', $category_id)->where('status', '1')->get();
        return $dishes;
    }

    public function countDish($dish_id)
    {
        $dish = Dish::
            selectRaw('COUNT(b.dish_id) * SUM(b.unit) as count')
            ->leftJoin('order_dish as b', 'dishes.id', '=', 'b.dish_id')
            ->leftJoin('orders as c', 'b.order_id', '=', 'c.id')
            ->where('dishes.id', $dish_id)
            ->groupBy('dishes.name')
            ->first();

        return $dish->count;
    }

    public function dishProfit($dish_id)
    {
        $dish = Dish::
            selectRaw('SUM((dishes.designated_price - dishes.cost_price) * b.unit) as gain')
            ->leftJoin('order_dish as b', 'dishes.id', '=', 'b.dish_id')
            ->leftJoin('orders as c', 'b.order_id', '=', 'c.id')
            ->where('dishes.id', $dish_id)
            ->groupBy('dishes.name')
            ->first();

        return $dish->gain;
    }

    public function dishDate()
    {
        $orders = Order::selectRaw('DATE(orders.updated_at) as date')
        ->selectRaw('sum(orders.total_amount) as total_amount')
        ->selectRaw('sum((c.designated_price - c.cost_price) * b.unit) as gain')
        ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
        ->leftJoin('dishes as c', 'b.dish_id', '=', 'c.id')
        ->where('orders.status', '2')
        ->orderBy('date', 'ASC')
        ->groupBy('date')
        ->get();

        return $orders->date;

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
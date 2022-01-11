<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'table',
        'total_amount',
        'status',
    ];

    public function dishes()
    {
        return $this->belongsToMany('App\Models\Dish', 'order_dish')
                ->withPivot('id', 'order_id', 'dish_id', 'unit', 'price', 'created_at', 'updated_at');
    }

    public function estado()
    {
        if($this->status == '0'){
            return "Pendiente";
        }else if($this->status == '1'){
            return "En Espera";
        }else if($this->status == '2'){
            return "Finalizado";
        }else if($this->status == '3'){
            return "Cancelado";
        }
    }
    
    public function getOrderIds($table)
    {
        $order_ids = Order::where('table', $table)->orderBy('id','ASC')->get();

        return $order_ids;
    }
}

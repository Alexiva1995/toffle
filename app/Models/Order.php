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
            return "pendiente";
        }else if($this->status == '1'){
            return "En espera";
        }else if($this->status == '2'){
            return "Finalizados";
        }else if($this->status == '3'){
            return "Cancelados";
        }
    }
}

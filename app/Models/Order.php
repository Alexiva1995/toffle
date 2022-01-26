<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
                ->withPivot('id', 'order_id', 'dish_id', 'unit', 'price', 'cost', 'created_at', 'updated_at');
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

    public function colorStatus()
    {
        if($this->status == '0'){
            return "warning";
        }else if($this->status == '1'){
            return "info";
        }else if($this->status == '2'){
            return "success";
        }else if($this->status == '3'){
            return "danger";
        }
    }

    public function getOrderIds($table)
    {
        $order_ids = Order::where('table', $table)->orderBy('id','ASC')->get();

        return $order_ids;
    }

    public function getcategory($category)
    {
        $category = Category::where('id', $category)->first();

        return $category;
    }

    public function getUpdatedAtTimezoneAttribute()
    {
        if ($this->updated_at != null) {
            return (new Carbon( $this->updated_at ))->format('Y-m-d');
        }
    
        return null;
    }

    public function getDay($date)
    {
        $days = array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
        return $days[date('N', strtotime($date)) - 1 ];
    }

    public function getProfitPerOrder($order_id)
    {
        $order = Order::selectRaw(
                'SUM( ROUND( (b.price - b.cost) * b.unit, 2 ) ) as profit'
            )
            ->leftJoin('order_dish as b', 'orders.id', '=', 'b.order_id')
            ->where('orders.id', $order_id)
            ->groupBy('b.order_id')
            ->first();

        return $order->profit;
    }
}

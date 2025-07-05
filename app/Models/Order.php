<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
       
        'table',
        'total_amount',
        'status',
    ];
    
    public function hoy() {
         $datehoy = Carbon::now();
         $orderdates = whereBetween('created_at', ['2023-01-01', '2024-01-31']);
         
        return $datehoy;
        
    }

    public function dishes()
    {
        return $this->belongsToMany(\App\Models\Dish::class, 'order_dish')
                ->withPivot('id', 'order_id', 'dish_id', 'code_operation', 'unit', 'price', 'cost', 'is_for_carry', 'created_at', 'updated_at');
    }

    public function ingredients()
    {
        return $this->belongsToMany(\App\Models\Inventory::class, 'order_ingredient')
                ->withPivot('id', 'order_id', 'inventory_id', 'code_operation', 'dish_id', 'portion', 'designated_cost', 'it_has_flavors', 'flavor_name', 'created_at', 'updated_at');
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
        $order_ids = Order::where('table', $table)->whereIn('status', ['0', '1'])->orderBy('id','ASC')->get();

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

    public function productRequiresFlavor($order_id, $code_operation)
    {
        $order = Order::find($order_id);
        $it_has_flavors = false;

        foreach ($order->ingredients()->wherePivot('code_operation', $code_operation)->get() as $key => $item) {
            if ($item->pivot->it_has_flavors == true && $item->pivot->flavor_name == null) {
                $it_has_flavors = true;
            }
        }

        return $it_has_flavors;
    }

    public function calculatePriceDish($order, $code_operation, $dish)
    {
        $ingredients = $order->ingredients()->wherePivot('code_operation', $code_operation)->get();

        $total_cost = 0;

        foreach ($ingredients as $key => $value) {
            $total_cost = number_format($total_cost + $value->pivot->designated_cost, 2, '.', '');
        }

        $total_amount = $total_cost * $dish->percentage_profit;

        $order->dishes()->wherePivot('code_operation', $code_operation)->update(
            [
                'price' => $total_amount,
                'cost' => $total_cost
            ]
        );

        $order_total_amount = 0;

        foreach ($order->dishes()->get() as $key => $item) {
            $order_total_amount += $item->pivot->price;
        }

        $order->update([
            'total_amount' => number_format($order_total_amount, 2, '.', '')
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'flavor_name',
        'qty_package',
        'unit_package',
        'price',
        'cost',
        'total',
        'deposit',
        'local',
        'public',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    //Calcula el promedio para el nuevo precio del inventario
    public function promedialPrice($old_price, $new_price, $stock, $add_to_stock)
    {
       if($stock <=0 ){
            return $new_price;
        } else{
            $a = $stock * $old_price;
            $b = $add_to_stock * $new_price;
            $c = $stock + $add_to_stock;
            $x = ($a + $b) / $c;
            return $x;
        }
    }

    public function qtyProductsNeeded($inventory_id)
    {
        $start_of_month = date("Y-m-01");
        $end_of_month = date("Y-m-t");

        $orders = Order::whereHas('ingredients', function($q) use($inventory_id) {
            $q->where('inventory_id', $inventory_id);
        })->whereBetween('created_at', [$start_of_month, $end_of_month])->get();

        $units = 0;
        if ($orders != '[]') {
            foreach ($orders as $key => $order) {
        
                $order_ingredients = $order->ingredients()->wherePivot('inventory_id', $inventory_id)->get();
            
                foreach ($order_ingredients as $key => $item) {
                    $inventory = Inventory::where('id', $inventory_id)->first();
                    $grams_used = $item->pivot->portion;
                    $units = $units + ($grams_used / $inventory->product->gr);
                }
            }
        }
        return number_format($units, 2, '.', '');
    }
}

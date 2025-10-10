<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\CustomClass\Ingredient;


class Dish extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'cost_price',
        'cpv',
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

    public function getDishIngredients($baseName)
    {
        $ingredients = collect();
        switch($baseName){

            case 'waffle':
                $dish = Dish::with('ingredients')->whereName('Sencillo')->first();
                foreach($dish->ingredients as $key => $item)
                {
                    $ingredient = new Ingredient;
                    //Obtener nombre del producto
                    $product = Product::whereId($item->product_id)->first();
                    //Llenar objeto ingredient
                    $ingredient->id = $item->id;
                    $ingredient->name = $product->name;
                    $ingredient->amount = $item->pivot->portion;
                    $ingredient->quantity = $product->gr != null ? $product->gr : $product->quantity;
                    $ingredient->cost = $item->cost;
                    $ingredients->push($ingredient);
                }
                return $ingredients;
                break;

            case 'half_waffle';
                $dish = Dish::whereName('Sencillo')->first();
                foreach($dish->ingredients as $item)
                {
                    $ingredient = new Ingredient;
                    //Obtener nombre del producto
                    $product = Product::whereId($item->product_id)->first();
                    //Llenar objeto ingredient
                    $ingredient->id = $item->id;
                    $ingredient->name = $product->name;
                    $ingredient->amount = ( floatval($item->pivot->portion) / 2 );
                    $ingredient->quantity = $product->gr != null ? $product->gr : $product->quantity;
                    $ingredient->cost = $item->cost;
                    $ingredients->push($ingredient);
                }
                return $ingredients;
                break;

            case 'quarter_waffle';
                $dish = Dish::whereName('Sencillo')->first();
                foreach($dish->ingredients as $item)
                {
                    $ingredient = new Ingredient;
                    //Obtener nombre del producto
                    $product = Product::whereId($item->product_id)->first();
                    //Llenar objeto ingredient
                    $ingredient->id = $item->id;
                    $ingredient->name = $product->name;
                    $ingredient->amount = ( floatval($item->pivot->portion) / 4 );
                    $ingredient->quantity = $product->gr != null ? $product->gr : $product->quantity;
                    $ingredient->cost = $item->cost;
                    $ingredients->push($ingredient);
                }
                return $ingredients;
                break;

            case 'bubble';
                $dish = Dish::whereName('Bubble')->first();
                foreach($dish->ingredients as $item)
                {
                    $ingredient = new Ingredient;
                    //Obtener nombre del producto
                    $product = Product::whereId($item->product_id)->first();
                    //Llenar objeto ingredient
                    $ingredient->id = $item->id;
                    $ingredient->name = $product->name;
                    $ingredient->amount = $item->pivot->portion;
                    $ingredient->quantity = $product->gr != null ? $product->gr : $product->quantity;
                    $ingredient->cost = $item->cost;
                    $ingredients->push($ingredient);
                }
                return $ingredients;
                break;

            case 'palito';
                $dish = Dish::whereName('Toffle palito base')->first();
                foreach($dish->ingredients as $item)
                {
                    $ingredient = new Ingredient;
                    //Obtener nombre del producto
                    $product = Product::whereId($item->product_id)->first();
                    //Llenar objeto ingredient
                    $ingredient->id = $item->id;
                    $ingredient->name = $product->name;
                    $ingredient->amount = $item->pivot->portion;
                    $ingredient->quantity = $product->gr != null ? $product->gr : $product->quantity;
                    $ingredient->cost = $item->cost;
                    $ingredients->push($ingredient);
                }
                return $ingredients;
                break;

        }

    }
}

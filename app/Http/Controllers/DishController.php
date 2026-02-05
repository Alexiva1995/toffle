<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Product;
use App\CustomClass\Ingredient;

class DishController extends Controller
{
    public function index(): View
    {
        $dishes = Dish::with('category')->orderBy('id', 'DESC')->get();
        $ingredients = Inventory::orderBy('id', 'DESC')->get();
        $category = Category::where('type', 1)->orderBy('id', 'DESC')->get();

        return view('admin.dishes.list', compact('dishes', 'ingredients', 'category'));
    }

    public function create(): View
    {
        $dishes = Dish::orderBy('id', 'DESC')->get();
        $ingredients = Inventory::with('product')->orderBy('id', 'DESC')->get();
        $category = Category::where('type', 1)->orderBy('id', 'DESC')->get();
        $dish = new Dish;

        return view('admin.dishes.create', compact('dishes','ingredients','category','dish'));
    }

    public function store(Request $request): RedirectResponse
    {
        $fields = [
            'name' => ['required', 'min:2'],
            'category_id' => ['required'],
            'percentage_profit' => ['required'],
            'cost_price' => ['required'],
            'suggested_price' => ['required'],
            'designated_price' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'category_id.required' => 'La categoria es requerida.',
            'percentage_profit.required' => 'El porcentage es requerido.',
            'cost_price.required' => 'El costo es requerido.',
            'suggested_price.required' => 'El precio sugerido es requerido.',
            'designated_price.required' => 'El precio designado es requerido.',
            'status.required' => 'El estado del plato es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        if ($request->ingredient_ids == null || $request->portion == null || $request->price == null) {
            return redirect()->back()->withInput()->with('danger', 'Debes Agregar Ingredientes en el Plato');
        }

        $cost_price = (float)$request->cost_price;
        $cpv_deduction = 0.0;

        foreach ($request->ingredient_ids as $index => $id) {
            $clean_id = (int)str_replace("ingredient_", "", $id);
            if ($clean_id === 88 || $clean_id === 97) {
                $designated_cost = (float)$request->price[$index];
                $cpv_deduction += $designated_cost;
            }
        }

        $cpv_final = $cost_price - $cpv_deduction;
        $dishData = $request->all();
        $dishData['cpv'] = $cpv_final;

        $dish = Dish::create($dishData);

        $portions = array_combine($request->ingredient_ids, $request->portion);
        $costs = array_combine($request->ingredient_ids, $request->price);
        $dish_ingredient = array_merge_recursive($portions, $costs);
        $array_dish = [];

        foreach ($dish_ingredient as $key => $dishe) {
            $ingredient_ = array([
                'ingredient_id' => str_replace("ingredient_", "", $key),
                'portion' => $dishe[0],
                'designated_cost' => $dishe[1],
            ]);
            $array_dish = array_merge($array_dish, $ingredient_);
        }

        foreach ($array_dish as $key => $item) {
            $dish->ingredients()->attach([ $dish->id =>
                [
                    'dish_id' => $dish->id,
                    'inventory_id' => $item['ingredient_id'],
                    'portion' => $item['portion'],
                    'designated_cost' => $item['designated_cost'],
                ]
            ]);
        }

        return redirect()->route('dishes.index')->with('success', 'Plato Añadido');
    }

    public function show(Dish $dish): void
    {
        //
    }

    public function edit(int $id): View
    {
        $dish = Dish::find($id);
        $ingredients = Inventory::orderBy('id', 'DESC')->with('product')->get();
        $category = Category::orderBy('id', 'DESC')->get();

        return view('admin.dishes.edit', compact('dish', 'ingredients', 'category'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $fields = [
            'name' => ['required', 'min:2'],
            'category_id' => ['required'],
            'percentage_profit' => ['required'],
            'cost_price' => ['required'],
            'suggested_price' => ['required'],
            'designated_price' => ['required'],
            'status' => ['required'],
        ];

        $msj = [
            'name.required' => 'El nombre es requerido.',
            'category_id.required' => 'La categoria es requerida.',
            'percentage_profit.required' => 'El porcentage es requerido.',
            'cost_price.required' => 'El costo es requerido.',
            'suggested_price.required' => 'El precio sugerido es requerido.',
            'designated_price.required' => 'El precio designado es requerido.',
            'status.required' => 'El estado del plato es requerido.',
        ];

        $this->validate($request, $fields, $msj);

        $dish = Dish::find($id);

        $cost_price_total = (float)$request->cost_price;
        $cpv_deduction = 0.0;

        foreach ($request->ingredient_ids as $index => $id) {
            $clean_id = (int)str_replace("ingredient_", "", $id);
            if ($clean_id === 88 || $clean_id === 97) {
                $designated_cost = (float)$request->price[$index];
                $cpv_deduction += $designated_cost;
            }
        }

        $cpv_final = $cost_price_total - $cpv_deduction;

        $dish->update([
            'name' => $request->name,
            'cost_price' => $request->cost_price,
            'cpv' => $cpv_final,
            'suggested_price' => $request->suggested_price,
            'designated_price' => $request->designated_price,
            'percentage_profit' => $request->percentage_profit,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        $portions = array_combine($request->ingredient_ids, $request->portion);
        $costs = array_combine($request->ingredient_ids, $request->price);
        $dish_ingredient = array_merge_recursive($portions, $costs);
        $array_dish = [];

        foreach ($dish_ingredient as $key => $dishe) {
            $ingredient_ = array([
                'ingredient_id' => str_replace("ingredient_", "", $key),
                'portion' => $dishe[0],
                'designated_cost' => $dishe[1],
            ]);
            $array_dish = array_merge($array_dish, $ingredient_);
        }

        foreach ($array_dish as $key => $item) {
            if ($dish->ingredients()->wherePivot('inventory_id', $item['ingredient_id'])->first() == null) {
                $dish->ingredients()->attach([ $dish->id =>
                    [
                        'dish_id' => $dish->id,
                        'inventory_id' => $item['ingredient_id'],
                        'portion' => $item['portion'],
                        'designated_cost' => $item['designated_cost'],
                    ]
                ]);
            }
        }

        return redirect()->route('dishes.index')->with('success', 'Plato editado');
    }

    public function destroy(int $id): RedirectResponse
    {
        $dish = Dish::find($id);

        $orders = Order::whereHas('dishes', function($q) use($dish) {
            $q->where('dish_id', $dish->id);
        })->get();

        if ($orders != '[]') {
            return redirect()->route('dishes.index')->with('danger', 'Este Plato no puede ser eliminado, porque está añadido en '.count($orders).' órdenes.');
        }

        $dish->ingredients()->detach();
        $dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Plato Eliminado');
    }

    public function removeIngredient(Request $request, int $id): string
    {
        $dish = Dish::find($request->dish_id);

        $dish->ingredients()->wherePivot('id', $id)->detach();

        $cost_price = 0;
        $cpv_deduction = 0.0;

        if ($dish->ingredients()->get()->isNotEmpty()) {
            foreach ($dish->ingredients()->get() as $item) {
                $costo_ingrediente = (float)$item->pivot->designated_cost;
                $cost_price += $costo_ingrediente;
                if ($item->id === 1 || $item->id === 2) {
                    $cpv_deduction += $costo_ingrediente;
                }
            }
        }

        $cpv_final = $cost_price - $cpv_deduction;
        $price_dish = number_format($cost_price * $dish->percentage_profit, 2, '.', '');

        $dish->update([
            'cost_price' => $cost_price,
            'cpv' => $cpv_final,
            'suggested_price' => $price_dish,
            'designated_price' => $price_dish,
        ]);

        return 'Ingrediente Eliminado del Plato';
    }
}

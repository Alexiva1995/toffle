<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{

    protected $guarded = ['id'];
    use HasFactory;

    public function dishes()
    {
        return $this->belongsToMany('App\Models\Dish', 'dishes_ingredients')
            ->withPivot('dish_id', 'ingredient_id');
    }
}

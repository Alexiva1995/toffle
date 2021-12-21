<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient', 'dishes_ingredients');
    }
}

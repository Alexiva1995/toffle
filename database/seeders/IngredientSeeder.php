<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ingredient::create([
            'name'=> 'Cebolla'
        ]);
        Ingredient::create([
            'name'=> 'Tomate'
        ]);
        Ingredient::create([
            'name'=> 'Pimentón'
        ]);
        Ingredient::create([
            'name'=> 'Ají'
        ]);
        Ingredient::create([
            'name'=> 'Papa'
        ]);
        Ingredient::create([
            'name'=> 'Zanahoria'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Dish::factory(10)->create();
        $this->call(IngredientSeeder::class);
        $ingredients = Ingredient::all();
        Dish::All()->each(function ($dish) use ($ingredients){
            $dish->ingredients()->saveMany($ingredients);
        });
        $this->call(UserSeeder::class);
    }
}

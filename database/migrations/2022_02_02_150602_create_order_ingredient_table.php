<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_ingredient', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('inventory_id');
            $table->integer('code_operation');
            $table->integer('dish_id');
            $table->integer('portion');
            $table->double('designated_cost');
            $table->boolean('it_has_flavors')->default(0);
            $table->string('flavor_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_ingredient');
    }
}

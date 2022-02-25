<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_dish', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('dish_id');
            $table->integer('code_operation');
            $table->integer('unit');
            $table->double('price');
            $table->double('cost');
            $table->boolean('is_for_carry')->default(0)->comment('0 - false, 1 - true');
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
        Schema::dropIfExists('order_dish');
    }
}

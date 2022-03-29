<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('cost_price');
            $table->double('suggested_price');
            $table->double('designated_price');
            $table->string('percentage_profit');
            $table->string('category_id');
            $table->enum('status', [0, 1, 2])->default(1)->comment('0 - Inactivo, 1 - Activo, 2 - En Revisión');
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
        Schema::dropIfExists('dishes');
    }
}

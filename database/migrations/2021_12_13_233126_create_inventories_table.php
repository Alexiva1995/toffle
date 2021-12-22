<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('qty_package');
            $table->integer('unit_package');
            $table->double('price');
            $table->double('cost')->default(0);
            $table->integer('total')->default(0);
            $table->integer('deposit')->default(0);
            $table->integer('local')->default(0);
            $table->integer('public')->default(0);
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
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('product_inventory');
    }
}

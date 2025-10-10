<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpvValueToOrderDishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_dish', function (Blueprint $table) {
            // Se asume que cpv es un valor decimal (dinero)
            $table->decimal('cpv_value', 8, 2)->nullable()->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_dish', function (Blueprint $table) {
            $table->dropColumn('cpv_value');
        });
    }
}

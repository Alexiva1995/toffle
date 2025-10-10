<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCpvToDishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('dishes', function (Blueprint $table) {
        // CPV: Costo de Venta, permite decimales y puede ser nulo inicialmente
        $table->decimal('cpv', 10, 2)->nullable()->after('cost_price');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('dishes', function (Blueprint $table) {
        $table->dropColumn('cpv');
    });
    }
}

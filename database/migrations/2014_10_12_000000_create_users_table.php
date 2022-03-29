<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('dni')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token_crypt')->nullable();
            $table->double('salary');
            $table->enum('role', [0, 1])->comment('0 - Empleado, 1 - Administrador');
            $table->boolean('status')->default(0)->comment('0 - Inactivo, 1 - Activo');
            $table->string('phone');
            $table->date('date_birth');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

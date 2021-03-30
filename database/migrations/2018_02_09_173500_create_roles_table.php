<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('desc')->nullable();
        });

        DB::table('roles')->insert([
            'id' => 1,
            'nombre' => 'Admin',
            'desc' => NULL
        ]);


        DB::table('roles')->insert([
            'id' => 2,
            'nombre' => 'Cliente',
            'desc' => NULL
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

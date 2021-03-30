<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodoPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //CC= Credit Card
        Schema::create('metodo_pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 10)->index();
            $table->string('desc');
        });

        DB::table('metodo_pagos')->insert([
                'codigo' => 'credito',
                'desc' => ''
            ]);

        DB::table('metodo_pagos')->insert([
                'codigo' => 'debito',
                'desc' => ''
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metodo_pagos');
    }
}

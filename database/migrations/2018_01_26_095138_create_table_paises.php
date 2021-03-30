<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePaises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('desc')->nullable();
            $table->timestamps();
        });

        DB::table('paises')->insert([
                'nombre' => 'Perú'
        ]);
        DB::table('paises')->insert([
            'nombre' => 'Brasil'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paises');
    }
}

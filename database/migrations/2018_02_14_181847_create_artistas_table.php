<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artistas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('img')->nullable();
            $table->string('pais');
            $table->string('ciudad')->nullable();
            $table->string('telefono')->nullable();
            /*$table->integer('categoria_id')->unsigned()->index()->nullable();*/
            $table->text('bio');
            $table->text('estudios')->nullable();
            $table->text('muestras')->nullable();
            $table->text('premios')->nullable();
            $table->string('slug')->unique();
            $table->string('img_portada')->nullable();
            $table->boolean('publicado');
            $table->boolean('destacado');
            $table->timestamps();

            /*$table->foreign('categoria_id')->references('id')->on('categorias');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artistas');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('publicado');
            $table->integer('categoria_id')->unsigned()->index()->nullable();
            $table->text('desc')->nullable();
            $table->text('desc_corta');
            $table->string('slug')->unique();
            $table->string('img')->nullable();
            $table->text('galeria_img')->nullable();
            $table->integer('artista_id')->unsigned()->index()->nullable();
            $table->string('tamano')->nullable();
            $table->decimal('peso', 10, 2)->nullable();
            $table->integer('anio')->nullable();

            $table->string('disponible_tienda');
            
            $table->timestamps();

            $table->foreign('artista_id')->references('id')->on('artistas');
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obras');
    }
}

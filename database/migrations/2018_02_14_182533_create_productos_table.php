<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('publicado');
            $table->integer('categoria_id')->unsigned()->index()->nullable();
            $table->integer("stock");
            $table->string('sku')->nullable();
            $table->text('desc');
            $table->text('desc_corta')->nullable();
            $table->string('slug')->unique();
            $table->string('img')->nullable();
            $table->text('galeria_img')->nullable();
            $table->string('tamano')->nullable();
            $table->decimal('peso', 10, 2)->nullable();
            $table->decimal('precio', 10, 2);
            $table->text('color');
            $table->string('otros_detalles')->nullable();

            $table->decimal('dsct_lista_regalo', 10, 2);

            $table->foreign('categoria_id')->references('id')->on('categorias');

            $table->integer('artista_id')->unsigned()->index()->nullable();
            $table->foreign('artista_id')->references('id')->on('artistas');

            $table->integer('tipo_id')->unsigned()->index()->nullable();
            $table->foreign('tipo_id')->references('id')->on('tipos');

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
        Schema::dropIfExists('productos');
    }
}

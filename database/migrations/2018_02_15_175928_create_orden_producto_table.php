<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_producto', function (Blueprint $table) {
            $table->increments('orden_producto_id');
            $table->integer('orden_id')->unsigned();
            $table->integer('producto_id')->unsigned();


            $table->string('color')->nullable();
            $table->integer('lista_regalo_id')->nullable();

            $table->decimal('producto_precio', 10, 2);
            $table->integer("cantidad");

            $table->decimal('producto_dsct', 10, 2);
            $table->decimal('recargo', 10, 2);

            $table->decimal('total', 10, 2);


            $table->softDeletes();

            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_producto');
    }
}

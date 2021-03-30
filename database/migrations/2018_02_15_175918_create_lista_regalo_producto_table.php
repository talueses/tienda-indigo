<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaRegaloProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_regalo_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lista_regalos_id')->unsigned()->index();
            //$table->integer('orden_id')->unsigned()->nullable();
            $table->integer('producto_id')->unsigned();

            $table->integer('solicitados');
            $table->integer('recibidos');
            $table->string('color')->nullable();

            $table->decimal('recargo', 10, 2)->nullable();

            $table->timestamps();

            $table->foreign('lista_regalos_id')->references('id')->on('lista_regalo')->onDelete('cascade');
            //$table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
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
        Schema::dropIfExists('lista_regalo_producto');
    }
}

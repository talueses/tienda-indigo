<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->string('estado', '40');
            $table->string('entrega');

            $table->integer('pais_id')->unsigned()->nullable();

            $table->string('departamento');
            $table->string('distrito')->nullable();

            $table->string('direccion');
            $table->decimal('costo_envio', 10, 2)->nullable();
            $table->decimal('monto_devolucion', 10, 2)->nullable();

            $table->string('id_orden_culqi')->nullable();

            $table->boolean('factura')->nullable();
            $table->string('ruc')->nullable();
            $table->string('razon_social')->nullable();

            $table->text('notas')->nullable();

            $table->softDeletes();
            $table->timestamp('payed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pais_id')->references('id')->on('paises');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes');
    }
}

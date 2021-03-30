<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaRegaloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_regalo', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo')->unique()->index();
            $table->integer('cuenta_regalos_id')->unsigned();

            $table->string('img')->nullable();

            $table->string('titulo');
            $table->text('desc')->nullable();
            $table->text('organizador_uno')->nullable();
            $table->text('organizador_dos')->nullable();
            $table->timestamp('fecha')->nullable();


            $table->string('entrega')->nullable();
            $table->string('departamento')->nullable();
            $table->string('distrito')->nullable();
            $table->string('direccion')->nullable();


            $table->decimal('costo_envio', 10, 2)->nullable();
            $table->boolean('edicion_finalizada')->default(false);

            $table->timestamps();

            $table->foreign('cuenta_regalos_id')->references('id')->on('cuenta_regalos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_regalo');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExposicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exposiciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img')->nullable();
            $table->text('desc')->nullable();
            $table->text('titulo')->nullable();
            $table->string('artista')->nullable();
            $table->boolean('publicado');
            $table->string('hora')->nullable();
            $table->string('lugar')->nullable();
            $table->string('distrito')->nullable();
            $table->string('direccion')->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->string('slug')->unique();
            $table->string('tags')->nullable();
            $table->text('galeria_img')->nullable();
            $table->string('tipo');
            $table->string('fuente')->nullable();
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
        Schema::dropIfExists('exposicions');
    }
}

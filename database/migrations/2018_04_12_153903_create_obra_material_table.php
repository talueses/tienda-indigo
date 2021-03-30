<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObraMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obra_material', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('obra_id')->unsigned();
            $table->integer('material_id')->unsigned();

            $table->foreign('obra_id')->references('id')->on('obras')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materiales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obra_material');
    }
}

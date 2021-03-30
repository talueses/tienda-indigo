<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaRegalosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_regalos', function (Blueprint $table) {
            $table->increments('id');

            $table->string('email')->index();
            $table->string('password');
            //$table->string('img')->nullable();

            $table->string('token')->nullable();
            $table->rememberToken();

            $table->timestamp('activated_at')->nullable();
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
        Schema::dropIfExists('cuenta_regalos');
    }
}

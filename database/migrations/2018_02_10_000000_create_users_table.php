<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->string('apellidos')->nullable();
            $table->string('telefono1')->nullable();
            $table->string('telefono2')->nullable();
            $table->text('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('pais')->nullable();
            $table->string('token', 60)->unique()->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Soporte',
            'email' => 'soporte@ilustraconsultores.com',
            'password' => '$2y$10$TcDPC5p2xAiyH.zNI6DW8uJoHMSBP5Cymqbz1NUdNjCPPtZEYnrwK',
            'role_id' => 1,
            'apellidos' => 'Ilustra',
            'telefono1' => '',
            'telefono2' => '',
            'direccion' => '',
            'ciudad' => NULL,
            'pais' => NULL,
            'token' => 'Sp2aaqFNpfv3Bu0YmH7GqZzdmsvzr6cUPTfjTM1OmzzG0RTbXqJMmZSDzria',
            'remember_token' => 'WKcse1Ehr1Vrkoc30BNY2MyYy4n6bMiPmwipEZEhtO5XVgaVVx9i3tSmQav1',
            'created_at' => '2018-09-27 20:00:42',
            'updated_at' => '2019-04-01 09:52:09'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

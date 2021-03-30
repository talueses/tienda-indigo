<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('active')->default(true);
            $table->integer('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('departamentos')->insert([
            'nombre' => 'Lima',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Amazonas',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Ancash',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Apurimac',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Arequipa',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Ayacucho',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Cajamarca',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Callao',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Cusco',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Huancavelica',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Huanuco',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Ica',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Junin',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'La Libertad',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Lambayeque',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Loreto',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Madre De Dios',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Moquegua',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Pasco',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Piura',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Puno',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'San Martin',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Tacna',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Tumbes',
            'pais_id'=> 1
        ]);
        DB::table('departamentos')->insert([
            'nombre' => 'Ucayali',
            'pais_id'=> 1
        ]);

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}

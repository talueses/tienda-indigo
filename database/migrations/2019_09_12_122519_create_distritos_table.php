<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distritos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('active')->default(true);
            $table->boolean('is_free')->default(false);
            $table->integer('departamento_id')->unsigned();
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('distritos')->insert([
            'nombre' => 'Barranco',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Miraflores',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Surco',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'San Borja',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Surquillo',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'San Isidro',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Chorrillos',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Cercado',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'San Luis',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Breña',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'La Victoria',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Rimac',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Lince',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'San Miguel',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Jesús María',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Magdalena',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Pblo. Libre',
            'departamento_id'=> 1,
            'is_free'=> 1
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Ancon',
            'departamento_id'=> 1,
            'is_free'=> 0
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Ate',
            'departamento_id'=> 1,
            'is_free'=> 0
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Carabayllo',
            'departamento_id'=> 1,
            'is_free'=> 0
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Chaclacayo',
            'departamento_id'=> 1,
            'is_free'=> 0
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Cieneguilla',
            'departamento_id'=> 1,
            'is_free'=> 0
        ]);
        DB::table('distritos')->insert([
            'nombre' => 'Comas',
            'departamento_id'=> 1,
            'is_free'=> 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distritos');
    }
}

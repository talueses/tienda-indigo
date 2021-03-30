<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\CuentaNovios;
use App\Producto;
use App\ListaRegaloProducto;

Class CuentaNoviosTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('cuenta_novios')->delete();

        $faker = Faker::create();

        $matrimonio1 = 'Matrimonio de Pamela y Ruben';

        CuentaNovios::create(array(
            'codigo' => md5(uniqid($matrimonio1, true)),
            'password' => '',
            'titulo' => $matrimonio1,
            'desc' => $faker->text,
            'novio' => 'Ruben M.',
            'novia' => 'Pamela P.'
        ));

        $matrimonio2 = 'Matrimonio de Jose y Pamela';

        CuentaNovios::create(array(
            'codigo' => md5(uniqid($matrimonio2, true)),
            'password' => '',
            'titulo' => $matrimonio2,
            'desc' => $faker->text,
            'novio' => 'Jose M.',
            'novia' => 'Pamela P.'
        ));

        $listas = CuentaNovios::all();
        $productos = Producto::all();

        for ($i=0; $i < rand(1, 10); $i++) {
            
            ListaRegaloProducto::create(array(
                'cuenta_novios_id' => $listas[0]->id,
                'producto_id' => $productos[$i]->id
            ));
        }

    }
 
}
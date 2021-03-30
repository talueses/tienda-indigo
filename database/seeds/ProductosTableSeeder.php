<?php

use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Producto::class, 163)->create()->each(function($producto)
        {
            $producto->materiales()->save(App\Material::all()->random())->make();
        });
    }
}

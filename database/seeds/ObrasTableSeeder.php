<?php

use Illuminate\Database\Seeder;

class ObrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Obras
      factory(App\Obra::class, 75)->create()->each(function($obra)
      {
          $obra->materiales()->save(App\Material::all()->random())->make();
      });
    }
}

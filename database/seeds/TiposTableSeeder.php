<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Tipo;

Class TiposTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('tipos')->delete();

        $faker = Faker::create();
          
        Tipo::create(array(
            'nombre' => 'Madera'
        ));
                
        Tipo::create(array(
            'nombre' => 'Canvas'
        ));

        Tipo::create(array(
            'nombre' => 'Poster'
        ));

        Tipo::create(array(
            'nombre' => 'Collage'
        ));

    }
 
}
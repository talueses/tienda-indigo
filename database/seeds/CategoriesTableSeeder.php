<?php
use Illuminate\Database\Seeder;
use App\Categoria;

Class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('categorias')->delete();

		Categoria::create(array(
            'nombre' => 'Antigüedades'
        ));

		Categoria::create(array(
            'nombre' => 'Arte contemporáneo'
        ));

        Categoria::create(array(
            'nombre' => 'Arte asiático'
        ));

        Categoria::create(array(
            'nombre' => 'Arte impresionista y moderno'
        ));

	}
}
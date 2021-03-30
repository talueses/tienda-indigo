<?php
use Faker\Factory as Faker;
use Illuminate\Support\Str as Str;
use Illuminate\Database\Seeder;
use App\Artista;

Class ArtistsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('artistas')->delete();
		DB::table('obras')->delete();
		DB::table('productos')->delete();


		factory(App\Artista::class, 15)->create();

	}
}

<?php
use Faker\Factory as Faker;
use Illuminate\Support\Str as Str;
use Illuminate\Database\Seeder;
use App\Artista;

Class EventsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('exposiciones')->delete();
		
		factory(App\Exposicion::class, 16)->create();

	}
}
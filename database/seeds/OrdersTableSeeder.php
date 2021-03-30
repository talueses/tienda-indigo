<?php
use Illuminate\Database\Seeder;
use App\User;
use App\Orden;

Class OrdersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('ordenes')->delete();

		$users = User::all();

	    foreach ($users as $user)
	    {
	      for ($i = 0; $i < rand(1, 6); $i++)
	      {
	        Orden::create([
	          "user_id" => $user->id,
	          "estado" => 'Completado'
	        ]);
	      }
	    }

	}
}
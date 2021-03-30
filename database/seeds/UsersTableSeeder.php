<?php
use Illuminate\Database\Seeder;
use App\User;

Class UsersTableSeeder extends Seeder {
  
    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email' => 'soporte@ilustraconsultores.com',
            'password' => Hash::make('indigo2018'),
            'name' => 'Soporte',
            'role_id' => 1
        ));
          
        /*User::create(array(
            'email' => 'member@email.com',
            'password' => Hash::make('123'),
            'name' => 'John Doe',
            'role_id' => 2
        ));*/

    }
 
}
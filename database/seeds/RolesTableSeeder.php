<?php
use Illuminate\Database\Seeder;
use App\Role;

Class RolesTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->delete();
        DB::table('roles')->delete();
          
        Role::create(array(
            'nombre' => 'Admin'
        ));
                
        Role::create(array(
            'nombre' => 'Cliente'
        ));

    }
 
}
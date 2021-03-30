<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        $this->call('RolesTableSeeder');
        $this->command->info('Roles table seeded');

        /*$this->call('MaterialTableSeeder');
        $this->command->info('Materiales table seeded');*/

        $this->call('UsersTableSeeder');
        $this->command->info('Users table seeded');

        /*$this->call('TiposTableSeeder');
        $this->command->info('Tipos table seeded');
        $this->call('CategoriesTableSeeder');
        $this->command->info('Category table seeded');

	    $this->call('ArtistsTableSeeder');
		$this->command->info('Artists table seeded');
	    $this->call('ObrasTableSeeder');
		$this->command->info('Obras table seeded');
	    $this->call('ProductosTableSeeder');
		$this->command->info('Products table seeded');


		$this->call('OrdersTableSeeder');
        $this->command->info('Orders table seeded');

        $this->call('OrderProductsTableSeeder');
        $this->command->info('Order Items table seeded');

        $this->call('MetodoPagoTableSeeder');
        $this->command->info('Metodo Pago table seeded');

        $this->call('PagosTableSeeder');
        $this->command->info('Pagos table seeded');

        $this->call('CuentaNoviosTableSeeder');
        $this->command->info('Cuenta Novios table seeded');

        $this->call('EventsTableSeeder');
	    $this->command->info('Eventos table seeded');*/

        Model::reguard();
    }
}

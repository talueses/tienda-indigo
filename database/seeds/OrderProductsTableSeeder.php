<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Orden;
use App\OrdenProducto;
use App\Producto;

Class OrderProductsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('orden_producto')->delete();

		$faker = Faker::create();

		$ordenes = Orden::all();
		$productos = Producto::all()->toArray();

	    foreach ($ordenes as $orden)
	    {

	    	$used = [];
	    	$producto = $faker->randomElement($productos);

	    	if (!in_array($producto['id'], $used)) {

	    		$id = $producto['id'];
	    		$precio = $producto['precio'];
	    		$cantidad = $faker->numberBetween(1, 3);
	    		$total = $precio *  $cantidad;

	    		OrdenProducto::create([
					"orden_id" => $orden->id,
	            	"producto_id" => $id,
	            	"producto_precio" => $precio,
	            	"cantidad" => $cantidad,
	            	"total" => $total
				]);

	    		$used[] = $producto['id'];
	    	}
	    }

	}
}
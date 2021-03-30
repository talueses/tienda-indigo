<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Pago;
use App\Orden;
use App\MetodoPago;

Class PagosTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('pagos')->delete();
        
        $faker = Faker::create();

        $ordenes = Orden::all();

        $metodos_pago = MetodoPago::all();

        foreach ($ordenes as $orden) {

            $metodo = MetodoPago::find(1);

            Pago::create(array(
                'orden_id' => $orden->id,
                'metodo_pago_id' => $metodo->id
            ));

        }

    }
 
}
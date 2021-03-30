<?php
use Illuminate\Database\Seeder;
use App\MetodoPago;

Class MetodoPagoTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('metodo_pagos')->delete();

        MetodoPago::create(array(
            'codigo' => 'TC',
            'desc' => 'Tarjeta Credito'
        ));

        MetodoPago::create(array(
            'codigo' => 'TB',
            'desc' => 'Tarjeta Debito'
        ));

    }
 
}
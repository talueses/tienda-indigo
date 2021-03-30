<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpDetalleOrden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::unprepared('DROP PROCEDURE IF EXISTS sp_detalleOrden;
        CREATE PROCEDURE sp_detalleOrden(IN ordenId int, IN userId int)
          BEGIN
          select `productos`.`nombre` as `producto_nombre`, `productos`.`precio` as `precio_unidad`,
            `orden_producto`.`cantidad`, `orden_producto`.`color`, `lista_regalo_id`, `lista_regalo`.`codigo`, `recargo` ,`orden_producto`.`total`
            from `orden_producto`
            inner join `productos` on `orden_producto`.`producto_id` = `productos`.`id`
            inner join `ordenes` on `orden_producto`.`orden_id` = `ordenes`.`id`
            left join `lista_regalo` on `orden_producto`.`lista_regalo_id` = `lista_regalo`.`id`
          where `orden_id` = ordenId and `user_id` = userId;
          END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_detalleOrden');
    }
}

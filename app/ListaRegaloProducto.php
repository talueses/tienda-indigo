<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaRegaloProducto extends Model
{
    protected $table = 'lista_regalo_producto';

    protected $fillable = [ 'lista_regalos_id', 'producto_id', 'solicitados', 'recibidos', 'color', 'recargo' ];

    public function lista_regalos()
    {
      return $this->hasOne(ListaRegalo::class, 'id', 'lista_regalos_id');
    }

    public function productos()
    {
    	return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function ordenes()
    {
      return $this->belongsToMany(Orden::class, 'regalo_orden', 'regalo_id', 'orden_id');
    }
}

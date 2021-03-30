<?php

namespace App\Exports;

use App\ListaRegalo;
use App\ListaRegaloProducto;
use Maatwebsite\Excel\Concerns\FromCollection;

class GiftListExport implements FromCollection
{

    protected $codigo;

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

      $lista = ListaRegalo::where('codigo', $this->codigo)->get()->first();

      //Traer lista regalo producto - where('publicado', 1)
      $regalos = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
                ->select(
                    'productos.nombre',
                    'lista_regalo_producto.color',
                    'lista_regalo_producto.solicitados',
                    'lista_regalo_producto.recibidos',
                    'productos.precio',
                    'productos.dsct_lista_regalo as descuento',
                    'lista_regalo_producto.recargo'
                  )
                ->where('lista_regalos_id', '=', $lista->id)
                ->getQuery()
                ->get();

        return $regalos;
    }
}

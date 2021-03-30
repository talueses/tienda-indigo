<?php
namespace App\Services;

use App\Producto;
use App\Orden;
use App\OrdenProducto;
use App\ListaRegaloProducto;
use App\Pago;
use App\MetodoPago;
use App\Http\Controllers\Traits\ProductStock;

class Store
{
  use ProductStock;

  public function getInfo($list)
  {

    $items = [];
    $items_w = [];
    $subtotal = 0;

    try {

      if (empty($list)) { return []; }

      //Por cada producto del carrito (id, cantidad, color)
      foreach ($list as $product) {
          $dbproduct = Producto::select('productos.id', 'productos.nombre',
                          'productos.slug', 'productos.img', 'productos.precio',
                          'productos.stock', 'productos.color', 'productos.dsct_lista_regalo')
              ->where('id', $product['id'])->first();

          $app = app();
          $item = $app->make('stdClass');
          $item->error = false;

          if(!$dbproduct) {
            $item->id = $product['id'];
            $item->nombre = "Producto eliminado";
            $item->quantity = $product['quantity'];
            $item->precio = 0;
            $item->error = true;
            $item->error_msg = "Producto no existe.";
          }else{
            $chosen_color = isset($product['color']) ? $product['color'] : "";

            $item->id = $product['id'];
            $item->quantity = $product['quantity'];
            $item->precio = $dbproduct->precio;
            $item->dsct = $dbproduct->dsct_lista_regalo;
            $item->img = $dbproduct->img;
            $item->nombre = $dbproduct->nombre;
            $item->slug = $dbproduct->slug;

            $item->wedding_list_id = isset($product['wedding_list_id']) ? $product['wedding_list_id'] : null;

            if ($chosen_color) {
                $item->stock = $this->getColorStock($chosen_color, $dbproduct->color);
                $item->color = $chosen_color;
            }else{
                $item->stock = $dbproduct->stock;
            }

            if($item->quantity > $item->stock || $item->stock == 0){
                $item->error = true;
            }

            $subtotal += floatval($item->precio)  * floatval($item->quantity);
          }

          $items[] = $item;
      }


    } catch (\Exception $e) {
      //dd([$e->getMessage(), $e->getLine()]);
    }

    return $items;
  }


}

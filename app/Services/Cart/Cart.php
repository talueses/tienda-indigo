<?php
namespace App\Services\Cart;
use App\Producto;
use App\ListaRegaloProducto;
use App\Http\Controllers\Traits\ProductStock;

class Cart implements Contracts\CartContract  {

	use ProductStock;

	protected $stock_virtual = [];
  protected $info = [];

  public function getContents($list) {

  	$this->stock_virtual = $this->getStockDatabase($list);
  	$this->updateVirtualStock($list);

  	return ["products" => $this->info];

  }

  public function getCartTotal($list) {
		$response = true;
		$total = 0;

		$items = $this->getContents($list);  

		foreach ($items['products'] as $item) {

			if ($item->error) {
			  $response = false;
			} else {
			  $total += ($item->price - $item->dsct) * $item->quantity;
			}

		}

		return ["success" => $response, "data" => $total];
	}

  public function getStockDatabase($cart_items) {

		$data = array();

		if (!empty($cart_items)) {
			foreach ($cart_items as $product) {
				$data[] = $product['id'];
			}
		}

		$items_prod = Producto::select('productos.id', 'productos.nombre as name',
											'productos.img', 'productos.precio', 'productos.stock',
											 'productos.color', 'productos.slug',
												'productos.dsct_lista_regalo as dsct')
						->whereIn('id', $data)
						->getQuery()
						->get();

		return $items_prod->toArray();

  }

  protected function updateVirtualStock($list) {

  	if (!empty($list)) {
			
		foreach ($list as $i) {

			$id = intval($i["id"]);
			$cant = $i["quantity"];

			foreach ($this->stock_virtual as $key => $item) {
				$item = (object) $item;

				if ($item->id == $id) {

					$chosen_color = isset($i["color"]) ? $i["color"] : "";

					$app = app();
					$new_item = $app->make('stdClass');
					$new_item->id = isset($item->id) ? $item->id : "";
					$new_item->img = isset($item->img) ? $item->img : "";
					$new_item->name = isset($item->name) ? $item->name : "";
					$new_item->price = isset($item->precio) ? $item->precio : "";
					$new_item->dsct = isset($item->dsct) ? $item->dsct : "";
					$new_item->slug = isset($item->slug) ? $item->slug : "";
					$new_item->quantity = $cant;
					$new_item->error = false;	

					if ( isset($i["wedding_list_id"]) ) {
								$gift = ListaRegaloProducto::find($i["wedding_product_id"]);

								$new_item->wedding_list_id = $i["wedding_list_id"];
								$new_item->dsct = isset($item->dsct) ? $item->dsct : "";
								$new_item->old_price = isset($item->precio) ? $item->precio : "";
								$dsct = isset($item->dsct) ? $item->dsct : "";
								$old_price = isset($item->precio) ? $item->precio : "";
								$recargo = $gift->recargo / $gift->solicitados;
								$new_item->price = ( $old_price - $dsct ) + $recargo;
								$new_item->recargo = $gift->recargo;

								$quantityAsked = $i['quantity'];
								$quantityGift = $gift->solicitados;

								if($quantityAsked > $quantityGift) {
									$new_item->error = true;
									$new_item->error_msg = sprintf("La cantidad solicitada por esta lista fue %u items", $quantityGift);
								}
							
					}

					if ($chosen_color) {
							$color_stock = $this->getColorStock($chosen_color, $item->color);
							$new_item->stock = $color_stock;
							$new_item->color = $chosen_color;
					}else{
							$new_item->stock = isset($item->stock) ? $item->stock : "";
					}

						$new_quantity_stock = ($chosen_color) ? $color_stock - $cant : $item->stock - $cant;

						if ($new_quantity_stock < 0) {
							$new_item->error = true;

							if ($item->stock == 0) {
									$new_item->error_msg = "Ya no hay más items en stock";
							} else {
									$new_item->error_msg = "* La cantidad solicitada no esta disponible";
							}

							$new_quantity_stock = 0;
						}

						$this->info[] = $new_item;

						if ($chosen_color) {
							$new_colors = $this->updateColorStock($this->stock_virtual[$key]->color, $cant, $chosen_color);
							$this->stock_virtual[$key]->color = $new_colors;
						} else {
							$this->stock_virtual[$key]->stock = $new_quantity_stock;
						}

				}

			}

	    }
	}
  }

  protected function updateColorStock($product_colors, $cant, $chosen_color) {
      $product_colors = json_decode($product_colors);

      //dd($product_colors);

      if ($product_colors) {

        foreach ($product_colors as $key => $c) {

           if($chosen_color == $c->color) {
              $c->stock = intval($c->stock) - $cant;
              //$product_colors[$key]->stock = $cant - $c->stock;
           }

        }

      }
      //dd($product_colors);
      return json_encode($product_colors);

  }

  /*protected function getListaRegaloItem($item) {
  	$item = ListaRegaloProducto::where('lista_regalo_producto.id', $item['wedding_product_id'])
                  ->where('lista_regalo_producto.color', $item['color'])
                  ->where('lista_regalo_producto.producto_id', $item['id'])
                  ->join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
                  ->select(
                  	'lista_regalo_producto.id as id_real',
                  	'producto_id as id',
                  	'lista_regalo_producto.cuenta_novios_id',
                  	'productos.stock',
                  	'productos.nombre',
                  	'productos.img',
                  	'lista_regalo_producto.solicitados',
                  	'lista_regalo_producto.recibidos',
                  	'productos.precio',
                  	'productos.slug',
                  	'lista_regalo_producto.color',
                  	'productos.color as db_color',
                  	'productos.dsct_lista_regalo',
                  	'lista_regalo_producto.recargo')
                  ->get()
									->first();

		return ($item) ? $item->toArray() : null;
  }

  protected function getProductoItem($item) {
  	$item = Producto::where('productos.id', $item['id'])
                    ->select(
                    	'productos.id',
                    	'productos.nombre',
                        'productos.img',
                        'productos.precio',
                        'productos.stock',
                        'productos.color as db_color',
                        'productos.slug',
                        'productos.dsct_lista_regalo as dsct')
                    ->get()
                    ->first();

     return ($item) ? $item->toArray() : null;
  }*/

}

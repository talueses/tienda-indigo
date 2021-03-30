<?php
namespace App\Http\Controllers\Traits;
use Carbon\Carbon;
use App\Producto;

trait ProductStock {

	public function getStock($req_product) {
        $product = Producto::find($req_product['id']);

        $product_colors = ($product->color) ? json_decode($product->color) : null;

        if ( !is_null($product_colors) && !empty($product_colors) ) {
            $stock = $product_colors;//$productColor[0]->stock;
        } else {
            $stock = [[ "stock" => $product->stock ]];
        }
           
        return $stock;
    }

    public function getColorStock($chosen_color, $colors) {
        $colors = !empty($colors) ? (array) json_decode($colors) : [];
        $stock = 0;

        foreach ($colors as $c) {
           if($chosen_color == $c->color) {
                $stock = $c->stock;
            }
        }

        return $stock;
    }

	public function disminuirStock($id_producto, $cantidad, $color)
	{

			$producto = Producto::find($id_producto);

			if (!is_null($color)) {

					$colors = json_decode($producto->color);

					foreach ($colors as $c) {
							//dd($color);
							if ($c->color == $color) {
								$c->stock = $c->stock - $cantidad;
							}
					}

					$producto->color = json_encode($colors);
			}

          $producto->stock = $producto->stock - $cantidad;
          $producto->save();
	}

}

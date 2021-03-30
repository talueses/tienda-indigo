<?php
namespace App\Services\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Pais;
use App\Orden;
use App\MetodoPago;
use App\Pago;
use App\OrdenProducto;
use App\CuentaNovios;
use App\ListaRegalo;
use App\ListaRegaloProducto;
use Carbon\Carbon;
use App\Http\Controllers\Traits\ProductStock;

class Order implements Contracts\OrderContract  {

		use ProductStock;

		public function all() {
			
			return Orden::join('users', 'users.id', '=', 'ordenes.user_id')
	            ->join('orden_producto', 'orden_producto.orden_id', '=', 'ordenes.id')
	            ->join('productos', 'productos.id', '=', 'orden_producto.producto_id')
	            ->select('ordenes.id as orden_id',  'ordenes.estado',
	              DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
	              'ordenes.created_at', 'orden_producto.cantidad as productos',
	              'orden_producto.lista_regalo_id',
	              DB::raw('sum(((orden_producto.producto_precio - orden_producto.producto_dsct )+ orden_producto.recargo) * orden_producto.cantidad) + ifnull(ordenes.costo_envio,0)  as total'))
	            ->groupBy('orden_id')
	            ->orderBy('orden_id', 'DESC')
							->get();
		}

		public function pending() {
			
			return Orden::join('users', 'users.id', '=', 'ordenes.user_id')
	            ->join('orden_producto', 'orden_producto.orden_id', '=', 'ordenes.id')
	            ->join('productos', 'productos.id', '=', 'orden_producto.producto_id')
	            ->select('ordenes.id as orden_id',  'ordenes.estado',
	              DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
	              'ordenes.created_at', 'orden_producto.cantidad as productos',
	              'orden_producto.lista_regalo_id',
								DB::raw('sum((productos.precio + orden_producto.recargo) * orden_producto.cantidad) as total'))
							->where('ordenes.estado','Pendiente')
	            ->groupBy('orden_id')
	            ->orderBy('orden_id', 'DESC')
							->get();
		}

		public function calculating() {
			
			return Orden::join('users', 'users.id', '=', 'ordenes.user_id')
	            ->join('orden_producto', 'orden_producto.orden_id', '=', 'ordenes.id')
	            ->join('productos', 'productos.id', '=', 'orden_producto.producto_id')
	            ->select('ordenes.id as orden_id',  'ordenes.estado',
	              DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
	              'ordenes.created_at', 'orden_producto.cantidad as productos',
	              'orden_producto.lista_regalo_id',
								DB::raw('sum((productos.precio + orden_producto.recargo) * orden_producto.cantidad) as total'))
							->where('ordenes.estado','Calculando')
	            ->groupBy('orden_id')
	            ->orderBy('orden_id', 'DESC')
							->get();
		}
		public function tracking() {
			
			return Orden::join('users', 'users.id', '=', 'ordenes.user_id')
	            ->join('orden_producto', 'orden_producto.orden_id', '=', 'ordenes.id')
	            ->join('productos', 'productos.id', '=', 'orden_producto.producto_id')
	            ->select('ordenes.id as orden_id',  'ordenes.estado',
	              DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
	              'ordenes.created_at', 'orden_producto.cantidad as productos',
	              'orden_producto.lista_regalo_id',
								DB::raw('sum((productos.precio + orden_producto.recargo) * orden_producto.cantidad) as total'))
							// ->where('ordenes.tracking','<>', null)->orWhere('ordenes.estado','=','Enviado')
							->where('ordenes.estado','=','Enviado')
	            ->groupBy('orden_id')
	            ->orderBy('orden_id', 'DESC')
							->get();
		}

		public function paid() {
			
			return Orden::join('users', 'users.id', '=', 'ordenes.user_id')
	            ->join('orden_producto', 'orden_producto.orden_id', '=', 'ordenes.id')
	            ->join('productos', 'productos.id', '=', 'orden_producto.producto_id')
	            ->select('ordenes.id as orden_id',  'ordenes.estado',
	              DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
	              'ordenes.created_at', 'orden_producto.cantidad as productos',
	              'orden_producto.lista_regalo_id',
								DB::raw('sum((productos.precio + orden_producto.recargo) * orden_producto.cantidad) as total'))
						  ->where('ordenes.estado','Pagado')
	            ->groupBy('orden_id')
	            ->orderBy('orden_id', 'DESC')
							->get();
		}
		// TODO: Ordenes del cliente verificar
		public function getByUserId($id) {

			return Orden::join('users', 'users.id', '=', 'ordenes.user_id')
							->join('orden_producto', 'orden_producto.orden_id', '=', 'ordenes.id')
							->join('productos', 'productos.id', '=', 'orden_producto.producto_id')
							->where('ordenes.user_id', '=', $id)
							->select('ordenes.id as orden_id',  'ordenes.estado',
								DB::raw('CONCAT(users.name, " ", users.apellidos) as usuario'),
								'ordenes.created_at', 'orden_producto.cantidad as productos',
								'orden_producto.lista_regalo_id',
								DB::raw('sum(((orden_producto.producto_precio - orden_producto.producto_dsct) + orden_producto.recargo) * orden_producto.cantidad) + IFNULL(ordenes.costo_envio,0) as total'))
							->groupBy('orden_id')
							->orderBy('orden_id', 'DESC')
							->get();

		}

    public function generateOrder(Request $request, $user, $items) {

        $order = new Orden;
        $order->user_id = $user->id;
        $order->estado = 'Calculando';
        $order->entrega = $request->get('modoEntrega');
        $order->factura = $request->get('modoFactura');
        $order->distrito = $request->get('distrito');;
        $order->direccion = ($request->get('modoEntrega') == 'recojo_tienda') ? "" : $request->get('direccion');
        $order->departamento = ($request->get('modoEntrega') == 'recojo_tienda') ? "" : formatDepartamento($request->get('departamento'));

        $order->ruc = ($request->get('ruc') != null) ? $request->get('ruc') : null;
        $order->razon_social = ($request->get('razonSocial') != null) ? $request->get('razonSocial') : null;

				//Pais
				$pais = Pais::find($request->get('paisId'));
				
				if (!is_null($pais)) {
					$order->pais_id = $pais->id;
				}
        $order->save();

        //update
        foreach ($items as $item) {

              $color = isset($item->color) ? $item->color : null;

              if ($item->error) {
                continue;
              }

              //Si producto pertenece a lista de regalos
              if (isset( $item->wedding_list_id ) ){
                    //$novios_id = $item->wedding_list_id;
                    $lista_regalo = ListaRegalo::where('codigo', '=', $item->wedding_list_id)->first();


										$gift = ListaRegaloProducto::where('lista_regalos_id', $lista_regalo->id)
																->where('producto_id', $item->id)
																->where('color', $color)
																->get()
																->first();

										$recargo = 0.00;// null;
										if(!is_null($gift)) {
											$recargo = is_null($gift->recargo) ? 0.00 : $gift->recargo;
										}

                    //Si producto tiene descuento por lista de regalos
                    if (isset($item->dsct) && ($item->dsct > 0) ) {
                        $new_price = $item->precio - $item->dsct;

                        $order->productos()->attach($item->id, [
                          'producto_precio' => $new_price,
                          'cantidad' => $item->quantity,
                          'total' => ($new_price - $item->dsct) * $item->quantity,
                          'color' => $color,
													'recargo' => $recargo,
                          'producto_dsct' => $item->dsct,
                          'lista_regalo_id' => $lista_regalo->id
                        ]);

                    } else {

                        $order->productos()->attach($item->id, [
                          'producto_precio' => $item->precio,
                          'cantidad' => $item->quantity,
                          'total' => ($item->precio - $item->dsct) * $item->quantity,
                          'color' => $color,
													'recargo' => $recargo,
                          'producto_dsct' => $item->dsct,
                          'lista_regalo_id' => $lista_regalo->id
                        ]);
                    }

              } else {

                    $order->productos()->attach($item->id, [
                      'producto_precio' => $item->precio,
                      'cantidad' => $item->quantity,
                      'total' => ($item->precio - $item->dsct) * $item->quantity,
                      'color' => $color,
                      'producto_dsct' => $item->dsct,
                      'lista_regalo_id' => null
                    ]);

              }

              $this->disminuirStock($item->id, $item->quantity, $color);
        }

        return $order;
    }

    public function getOrderInfo($orderId) {
    	$subtotal = 0;
	    $items = [];
			
    	$dbproductos = OrdenProducto::join('productos', 'orden_producto.producto_id', '=', 'productos.id')
                  ->select(
                  		'productos.id','productos.dsct_lista_regalo',
											'productos.nombre',
											'productos.img',
                  		'orden_producto.color',
                      'orden_producto.cantidad as quantity',
                      'orden_producto.producto_precio as precio',
                      'orden_producto.total',
					  'orden_producto.recargo',
					  'orden_producto.producto_dsct as dsct',
                      'orden_producto.lista_regalo_id')
                  ->where('orden_producto.orden_id', $orderId)
                  ->getQuery()
                  ->get();

	    foreach ($dbproductos as $producto) {

				if($producto->lista_regalo_id) {

					$gift = ListaRegaloProducto::where('lista_regalos_id', $producto->lista_regalo_id)
											->where('producto_id', $producto->id)
											->where('color', $producto->color)
											->first();

					$new_price = calcTotalGiftItemOrder($producto, $gift->recargo, $gift->solicitados);
					$subtotal += floatval($new_price)  * floatval($producto->quantity);

				} else {
					// $subtotal += (floatval($producto->precio)-floatval($producto->descuento))  * floatval($producto->quantity);
					$subtotal += floatval($producto->precio-$producto->dsct)  * floatval($producto->quantity);
				}

			  $items[] = $producto;
	    }

	    return ['products' => $items, 'subtotal' => $subtotal];

    }

    public function cancelOrder(Request $request, $orderId) {

    }

		public function createPayment($paymentMethod, $orderId, $billingOrderId, $card) 
		{
			$metodo = MetodoPago::where('codigo', '=', $paymentMethod)->getQuery()->first();

			//Crear Pago
			$pago = new Pago;
			$pago->orden_id = $orderId;
			$pago->metodo_pago_id = $metodo->id;
			$pago->save();

			//Actualizar Orden a Pagado
			$orden = Orden::where('id', $orderId)->first();
			$orden->estado = "Pagado";

			//Id Orden Culqi
			$orden->id_orden_culqi = $billingOrderId;
			$orden->card= $card;
			$orden->payed_at = $pago->created_at;
			$orden->save();

			$pago['metodo'] = $paymentMethod;

			return [
				'orden' => $orden,
				'pago' => $pago
			];

		}

    public function refund(Request $request) {
        dd($request->all());
        $data = $request->get('data');

        $pago = Pago::where('culqi_id', $data->id)->first();

        $orden = Orden::find($pago->orden_id);
        $orden->estado = 'Cancelado';
        //$orden->cancelled_at = ''; //$data->creationDate;
        $orden->monto_devolucion = $data->refundedAmount;
        $orden->save();
    }

}

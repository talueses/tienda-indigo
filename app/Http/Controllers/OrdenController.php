<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Orden;
use App\MetodoPago;
use App\Pago;
use App\Pais;
use App\OrdenProducto;
use App\Departamentos;
use Carbon\Carbon;
use App\Services\Email as EmailService;
use App\Services\Order\Contracts\OrderContract;
use App\Services\Exports\Orders\OrdersMultiSheetsByStatus;


class OrdenController extends Controller
{
    private $email, $cart;
    protected $order;
    protected $print;
    protected $html;

    public function __construct(EmailService $email, OrderContract $order)
    {
      $this->mail = $email;
      $this->order = $order;
      $this->print= false;
      $this->html;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordenes = $this->order->all();
        return view('admin.tienda.ordenes.index')->withOrdenes($ordenes);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        $ordenes = $this->order->pending();
        
        return view('admin.tienda.ordenes.index')->withOrdenes($ordenes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculating()
    {
        $ordenes = $this->order->calculating();
        
        return view('admin.tienda.ordenes.index')->withOrdenes($ordenes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tracking()
    {
        $ordenes = $this->order->tracking();
        
        return view('admin.tienda.ordenes.index')->withOrdenes($ordenes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paid()
    {
        $ordenes = $this->order->paid();
        
        return view('admin.tienda.ordenes.index')->withOrdenes($ordenes);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Request $request, $id)
    // TODO: Vista de admin/orders/detail
    public function show($id)
    {
        $total = 0;
        // $novios = $request->get('novios');
        $detalle_envio = Orden::getDetail($id);
        if($detalle_envio) {
              $usuario = User::find($detalle_envio->usuario);
              $name_pais=Pais::find($detalle_envio->pais_id); 
              $ordenes = OrdenProducto::join('productos', 'orden_producto.producto_id', '=', 'productos.id')
                      ->join('ordenes', 'orden_producto.orden_id', '=', 'ordenes.id')
                      ->leftJoin('lista_regalo', 'orden_producto.lista_regalo_id', '=', 'lista_regalo.id')
                      ->select(
                          'productos.nombre as producto_nombre',
                          // 'productos.dsct_lista_regalo as dsct',
                          'orden_producto.producto_dsct as dsct',
                          'productos.img',
                          'productos.sku',
                          'ordenes.card',
                          'ordenes.ruc as ruc',
                          'ordenes.razon_social as social_name',
                          'productos.precio as precio_unidad',
                          'orden_producto.cantidad',
                          'orden_producto.color',
                          'lista_regalo_id',
                          'lista_regalo.codigo',
                          'recargo',
                          'orden_producto.total'
                        )
                      ->where('orden_id', $id)
                      ->where('user_id', $usuario->id)
                      ->getQuery()
                      ->get();

              foreach ($ordenes as $producto) {
                // $total += ($producto->total - $producto->dsct)+ $producto->recargo;
                $total += ($producto->total)+ $producto->recargo;
              }
              $subtotal = $total;

              $historial = [];
              $historial['pendiente'] = $detalle_envio->created_at;
              $historial['pagado'] = !is_null($detalle_envio->payed_at) ? new Carbon($detalle_envio->payed_at) : null;
              $historial['entregado'] = !is_null($detalle_envio->payed_at) ? new Carbon($detalle_envio->delivery_at) : null;
              $historial['cancelado'] = !is_null($detalle_envio->cancelled_at) ? new Carbon($detalle_envio->cancelled_at) : null;
              $historial['devuelto'] = !is_null($detalle_envio->refunded_at) ? new Carbon($detalle_envio->refunded_at) : null;

              $subtotal = $total;

              $costo_envio = ($detalle_envio->costo_envio) ? $detalle_envio->costo_envio : 0.00;

              if($costo_envio) {
                $total = $total + $costo_envio;
              }

              $usuario = User::find($detalle_envio->usuario);
              // dd($detalle_envio);
              $name_depto=(is_numeric($detalle_envio->departamento))? Departamentos::find($detalle_envio->departamento)->nombre : $detalle_envio->departamento;          
              // var_dump($name_depto); exit;
              $metodo_pago = '';
              if($detalle_envio->estado == "Pagado") 
              {
                $pago = Pago::where('orden_id', $id)->first();
                $metodo_pago = MetodoPago::find($pago->metodo_pago_id)->first();
                $metodo_pago = $metodo_pago->codigo;
              }
              return view('admin.tienda.ordenes.show', compact('ordenes', 'detalle_envio', 'usuario', 'subtotal', 'costo_envio', 'total', 'historial', 'metodo_pago','name_pais','name_depto'));
        }

        return redirect()->route('admin.orders');
    }

    /***
     *
     *Imprimir
     *
    ****/
    public function imprimir(Request $request)
    { 
      // $html=$request->get('data');
      // $pdf = \App::make('dompdf.wrapper');
      // $pdf->loadHTML($html);
      // return $pdf->download('demo.pdf');      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orden = Orden::findOrFail($id);
        $orden->update($request->all());
    }

    public function getOrderPaymDetails(Request $request)
    {
        if (!Auth::check()) { return response()->json(['error' => 'Unauthenticated'], 401); }

        try{
            $id = $request->get('orden_id');

            $user = Auth::guard()->user();
            $orden = Orden::findOrFail($id);

            if($orden->user_id == $user->id) {
                $items = $this->order->getOrderInfo($id);
                $subtotal = $items['subtotal'];
                $total = $subtotal + $orden->costo_envio;
                $total = $total;
            }

        } catch(Exception $e) {
            return response()->json(['success' => false, 'data' => $e->getMessage() ]);
        }

        return response()->json(['success' => true, 'data' => $total ]);
    }

    public function updateShipCost(Request $request, $id)
    {
        $costo_envio = $request->get('costo_envio');

        $orden = Orden::findOrFail($id);
        $orden->costo_envio = $costo_envio;
        $orden->estado = 'Pendiente';
        $orden->save();
        $orden_id = $orden->id;
        $items = $this->order->getOrderInfo($id);
        $cart_products = $items['products']; 
        $wedding_items = [];

        $subtotal = number_format($items['subtotal'], 2);
        // $total = floatval($subtotal) + $costo_envio;
        $total = floatval($subtotal);
        $total = number_format($total+$costo_envio, 2);
        $customer = setUser(User::find($orden->user_id));
        $route = route('cuenta.orden.detalle', $orden->id);

        //Enviar Email
        $html = view('mails.shipcostupdate', compact('cart_products', 'wedding_items', 'subtotal', 'costo_envio', 'total', 'customer', 'orden_id', 'route'))->render();

        $this->mail->send($html, $customer->email, 'Se ha calculado el costo de envío para su orden');

        session()->flash('message', ['type' => 'success', 'message' => 'Se ha actualizado el costo de envío y se ha enviado una confirmación al correo del cliente.']);

        return redirect()->route('admin.order.show', $id);
    }

    public function updateTracking(Request $request, $id)
    {
        $tracking = $request->get('tracking');

        $orden = Orden::findOrFail($id);
        $orden->tracking = $tracking;
        $orden->save();

        $orden_id = $orden->id;
        $items = $this->order->getOrderInfo($id);
        $cart_products = $items['products'];

        $subtotal = number_format($items['subtotal'], 2);
        $costo_envio = number_format($orden->costo_envio, 2);
        $total = floatval($subtotal) + $costo_envio;
        $total = number_format($total, 2);
        $customer = setUser(User::find($orden->user_id));
        $route = route('cuenta.orden.detalle', $orden->id);

        //Enviar Email
        $html = view('mails.trackingupdate', compact('cart_products', 'subtotal', 'costo_envio', 'total', 'customer', 'orden_id', 'route'))->render();

        $this->mail->send($html, $customer->email, 'Su orden ya cuenta con codigo de seguimiento');

        session()->flash('message', ['type' => 'success', 'message' => 'Se ha actualizado el costo de envío y se ha enviado una confirmación al correo del cliente.']);

        return redirect()->route('admin.order.show', $id);
    }

    public function cancelOrder(Request $request, $orderId)
    {
      if (!Auth::check()) { return response()->json(['error' => 'Unauthenticated'], 401); }

      $user = Auth::guard()->user();
      $orden = Orden::find($orderId);
      $costo_envio = $orden->costo_envio;


      if ( ($orden->user_id == $user->id) || $user->hasRole('Admin') ) {

        if ($request->get('accion') == 'cancelar' && $orden->estado = 'Pendiente' || $request->get('accion') == 'cancelar' && $orden->estado = 'Calculando') {
          $orden->estado = 'Cancelado';
           $orden->cancelled_at = Carbon::now();
          $orden->save();

          $orden_id = $orden->id;

          Carbon::setLocale('es');
          Carbon::setUtf8(true);
          $cancelled_at = $orden->cancelled_at->toFormattedDateString();

          $items = $this->order->getOrderInfo($orderId);
          $cart_products = $items['products'];
          $wedding_items = [];

          if (!empty($cart_products)) {
            foreach ($cart_products as $item) {
              $data = [];
              (isset($item->color))? $data=['color'=> $item->color,"stock"=> $item->quantity] : $data=null ;
              ProductoController::devolverStock($item->id, $item->quantity,$data);
            }
          }

          $subtotal = number_format($items['subtotal'], 2);
          $total = floatval($subtotal) + $costo_envio;
          $total = number_format($total, 2);
          $customer = setUser(User::find($orden->user_id));
          $route = route('cuenta.orden.detalle', $orden->id);

          //Enviar Email
          $html = view('mails.cancelledorder', compact('cart_products', 'subtotal', 'costo_envio', 'total', 'customer', 'route', 'cancelled_at', 'orden_id'))->render();

          session()->flash('message', ['type' => 'success', 'message' => 'La orden ha sido cancelada.']);
        }
      }

      return redirect()->route('admin.order.show', $orderId);

    } ///**********

    public function markDelivered(Request $request, $orderId)
    {
      if (!Auth::check()) { return response()->json(['error' => 'Unauthenticated'], 401); }

      $orden = Orden::find($orderId);
      $orden->delivery_at = Carbon::now();
      $orden->estado='Enviado';
      $orden->save();
      session()->flash('message', ['type' => 'success', 'message' => 'La orden ha sido marcada como Enviada.']);
      return redirect()->route('admin.order.show', $orderId);

    }

    public function export()
    {
        $names = [];
				$headers = [  'ID', 'Cliente', 'Total', 'Fecha', 'Estado' ];
        $orders = $this->order->all();
        $results = [];
				foreach ($orders as $k => $order) {
					$results[$order->estado][$k]['id'] = $order->orden_id;
					$results[$order->estado][$k]['cliente'] = $order->usuario;
					$results[$order->estado][$k]['total'] = $order->total;
					$results[$order->estado][$k]['fecha'] = $order->created_at;
          $results[$order->estado][$k]['estado'] = $order->estado;
          array_push($names, $order->estado);
        }
        // echo '<pre>'; var_dump($results); //var_dump($orders);var_dump($headers); exit;
        // exit;
        $names = array_unique($names);
				$download_name = 'ORDENES_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';
				return (new OrdersMultiSheetsByStatus($names, $headers, $results))->download($download_name);
    }

    public function exportPending()
    {
  
        $names = [];
				$headers = [  'ID','Cliente', 'Total', 'Fecha', 'Estado' ];

        $orders = $this->order->pending();

        $results = [];
    
				foreach ($orders as $k => $order) {
					$results[$order->estado][$k]['id'] = $order->orden_id;
					$results[$order->estado][$k]['cliente'] = $order->usuario;
					$results[$order->estado][$k]['total'] = $order->total;
					$results[$order->estado][$k]['fecha'] = $order->created_at;
          $results[$order->estado][$k]['estado'] = $order->estado;
          array_push($names, $order->estado);
        }
        $names = array_unique($names);
        
				$download_name = 'ORDENES_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';
			
				return (new OrdersMultiSheetsByStatus($names, $headers, $results))->download($download_name);

    }
    public function exportCalculating()
    {
  
        $names = [];
				$headers = [  'ID', 'Cliente', 'Total', 'Fecha', 'Estado' ];

        $orders = $this->order->calculating();

        $results = [];
    
				foreach ($orders as $k => $order) {
					$results[$order->estado][$k]['id'] = $order->orden_id;
					$results[$order->estado][$k]['cliente'] = $order->usuario;
					$results[$order->estado][$k]['total'] = $order->total;
					$results[$order->estado][$k]['fecha'] = $order->created_at;
          $results[$order->estado][$k]['estado'] = $order->estado;
          array_push($names, $order->estado);
        }
        $names = array_unique($names);
        
				$download_name = 'ORDENES_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';
			
				return (new OrdersMultiSheetsByStatus($names, $headers, $results))->download($download_name);

    }
    public function exportTracking()
    {
  
        $names = [];
				$headers = [  'ID','Cliente', 'Total', 'Fecha', 'Estado' ];

        $orders = $this->order->tracking();

        $results = [];
    
				foreach ($orders as $k => $order) {
					$results[$order->estado][$k]['id'] = $order->orden_id;
					$results[$order->estado][$k]['cliente'] = $order->usuario;
					$results[$order->estado][$k]['total'] = $order->total;
					$results[$order->estado][$k]['fecha'] = $order->created_at;
          $results[$order->estado][$k]['estado'] = $order->estado;
          array_push($names, $order->estado);
        }
        $names = array_unique($names);
        
				$download_name = 'ORDENES_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';
			
				return (new OrdersMultiSheetsByStatus($names, $headers, $results))->download($download_name);

    }


    public function exportPaid()
    {
  
        $names = [];
				$headers = [  'ID','Cliente', 'Total', 'Fecha', 'Estado' ];

        $orders = $this->order->paid();

        $results = [];
    
				foreach ($orders as $k => $order) {
					$results[$order->estado][$k]['id'] = $order->orden_id;
					$results[$order->estado][$k]['cliente'] = $order->usuario;
					$results[$order->estado][$k]['total'] = $order->total;
					$results[$order->estado][$k]['fecha'] = $order->created_at;
          $results[$order->estado][$k]['estado'] = $order->estado;
          array_push($names, $order->estado);
        }
        $names = array_unique($names);
        
				$download_name = 'ORDENES_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';
			
				return (new OrdersMultiSheetsByStatus($names, $headers, $results))->download($download_name);

    }

}

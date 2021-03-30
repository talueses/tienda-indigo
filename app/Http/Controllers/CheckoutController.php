<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\User;
use App\Orden;
use App\Pago;
use App\Pais;
use App\General;
use App\MetodoPago;
use App\CuentaNovios;
use App\Departamentos;
use App\ListaRegaloProducto;
use App\Http\Controllers\Traits\ProductStock;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\CartController;
use App\Services\Email as EmailService;
use App\Services\Store;
use App\Services\Billing\Contracts\BillingContract;
use App\Services\Order\Contracts\OrderContract;
use App\Services\Cart\Contracts\CartContract;
//use \Culqi\Culqi;

class CheckoutController extends Controller
{
    use ProductStock;

    private $mail;
    protected $cart;
    protected $store;
    protected $billing;
    protected $order;

    public function __construct(
      EmailService $email,
      Store $store,
      BillingContract $billing,
      OrderContract $order,
      CartContract $cart
      )
    {
        $this->mail = $email;
        $this->store = $store;
        $this->billing = $billing;
        $this->order = $order;
        $this->cart = $cart;
    }

    public function store(Request $request)
    {
      if (!Auth::check()) { return response()->json(['error' => 'Unauthenticated'], 401); }

        $orden_id = null;
        
        $req_orden_id = $request->get('orden_id') ? $request->get('orden_id') : null;
        $card_email = is_null($request->get('email')) ? '':$request->get('email');

        DB::beginTransaction();
        /**
        * Existe la orden o es pago
        * Si es pago, generar la orden.
        *
        */

        $orden_id = !is_null($req_orden_id) ? intval($req_orden_id) : json_decode($this->generateOrder($request, true)->getContent())->data;

        $items = $this->order->getOrderInfo($orden_id);

        $user = Auth::guard()->user();
        $user->card_email = $card_email;

        try {
            $token_object_id = $request->get('id'); //culqi id response
            $items['source_id'] = $token_object_id;

            $charge = $this->billing->charge($user, $items, $orden_id);

            if ($charge->outcome->type == "venta_exitosa") 
            {
              $paym = $this->order->createPayment($request->get('metodoPago'), $orden_id, $charge->id , $charge->source->last_four);

              $weddinglist = [];

              if (!empty($items['products'])) {
                  $weddinglist = $this->updateListaRegalo($items['products']);
              }
              $generales = General::where('nombre', 'free_delivery')->first();
              $free_delivery = $request->get('freeDelivery') ? $generales->valor : $request->get('freeDelivery');
              $this->mail->send(
                  $this->sendPaymentEmail($items, $paym['orden'], $paym['pago'], $free_delivery),
                  $user->email,
                  'Se ha completado su orden exitosamente'
              );

            }

        } catch (\Exception $e) {
            DB::rollback();
            $msg = $e->getMessage();
            Log::error($msg);
            return response()->json(['error' => $msg], 400);
        }

        DB::commit();

        return response()->json($charge->outcome, 200);

    }

    public function storeOrder(Request $request, $id)
    {
      if (!Auth::check()) { return response()->json(['error' => 'Unauthenticated'], 401); }

        $orden_id = $id;
        $card_email = is_null($request->get('email')) ? '':$request->get('email');

        DB::beginTransaction();

        $items = $this->order->getOrderInfo($orden_id);
        $user = Auth::guard()->user();
        $user->card_email = $card_email;

        try {
            $token_object_id = $request->get('culqiId');
            $items['source_id'] = $token_object_id;

            $charge = $this->billing->charge($user, $items, $orden_id);

            if ($charge->outcome->type == 'venta_exitosa') 
            {
              $paym = $this->order->createPayment($request->get('metodoPago'), $orden_id, $charge->id, $charge->source->last_four);

              //Enviar Email
              $this->mail->send(
                  $this->sendPaymentEmail($items, $paym['orden'], $paym['pago']),
                  $user->email,
                  'Se ha completado su orden exitosamente'
              );

            }

        } catch (\Exception $e) {
            DB::rollback();
            $msg = $e->getMessage();
            Log::error($msg);
            return response()->json(['error' => $msg], 400);
        }

        DB::commit();

        return response()->json($charge->outcome, 200);

    }

    public function sendPaymentEmail($items, $orden, $pago, $free_delivery = false)
    {
      $orden_id = $orden->id;
      $detalle_envio =  Orden::getDetail($orden_id);   
      $costo_envio = isset($detalle_envio->costo_envio) ? $detalle_envio->costo_envio : 0;
      // $costo_envio = isset($items['costo_envio']) ? $items['costo_envio'] : 0;
      $subtotal = (float) $items['subtotal'];
      $total = $subtotal + $costo_envio;
      $total = (float) $total;
      $free_delivery = $free_delivery;
      $cart_products = isset($items['products']) ? $items['products'] : [];
    
      // $name_pais=Pais::find($detalle_envio->pais_id); 

      $customer = setUser(User::find($orden->user_id));

      $route = route('cuenta.orden.detalle', $orden_id);
      return view('mails.payment', compact('detalle_envio','cart_products', 'subtotal', 'costo_envio', 'total', 'customer', 'route', 'orden_id', 'pago', 'free_delivery'))->render();
      
    }

    public function updateListaRegalo($weddinglist)
    {
        $arr = [];

        foreach ($weddinglist as $item) {

          if (isset($item->lista_regalo_id)) {

            $regalo = ListaRegaloProducto::where('lista_regalos_id', '=', $item->lista_regalo_id)
                  ->where('producto_id', '=', $item->id)
                  ->where('color', '=', $item->color)
                  ->first();

            // Cambiar el numero de recibidos en la tabla lista_regalo_producto
            $regalo->recibidos += $item->quantity;
            $regalo->save();

            $arr[] = $regalo;
            //$item->cuenta_novios_codigo = $cuenta_novios->codigo;
          }
        }

        return $arr;

    }


    public function generateOrder(Request $request, $from_store = false)
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $list = $request->get('list')['products'];
        $response = $this->cart->getCartTotal($list);

        if ($response['success']) {
          $user = Auth::guard()->user();
          $customer = setUser($user);

          $items = $this->store->getInfo($list);  
          $order = $this->order->generateOrder($request, $user, $items);
        
          $info = $this->order->getOrderInfo($order->id);
          $total = $info['subtotal'];

          $order_id = $order->id;

          $detalle_envio =  Orden::getDetail($order_id);   
          $name_pais=Pais::find($detalle_envio->pais_id); 
          (is_numeric($detalle_envio->departamento))? $name_depto=Departamentos::find($detalle_envio->departamento) : $name_depto = $detalle_envio->departamento;          

          //Enviar mail
          if($request->get('modoEntrega') == 'delivery' && !$from_store) {
 
            $html = view('mails.order', compact('customer', 'total', 'items', 'order_id','detalle_envio','name_pais','name_depto'))->render();
            $this->mail->send($html, $user->email, 'Se ha generado su orden');
          }

          return response()->json(['success' => true, 'data' => $order->id]);
        }

        return response()->json(['error' => 'stock']);

    }


    public function refund(Request $request)
    {
        $this->order->refund($request);
    }

}

<?php

namespace App\Http\Controllers;

use App\Services\Email as EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Orden;
use App\Producto;
use App\Services\Order\Contracts\OrderContract;
use App\Services\Order\Order;
use App\Services\Store;
use App\Http\Controllers\CheckoutController;

class TestController extends Controller
{

    private $stock_contable = array();
    private $info = array();
    protected $store;
    protected $order;
    protected $check;
    protected $email;

    public function __construct( Store $store , Order $order, CheckoutController $check,EmailService $email)
    {
        //code
        $this->order=$order;
        $this->check;
        $this->email=$email;
        $this->store = $store;
        $this->stock_contable = $this->getStockDatabase();
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cart_items = [   [   "id" => 1,          "quantity" => 4        ],
        [          "id" => 2,          "quantity" => 2        ],
        [          "id" => 3,          "quantity" => 2        ],
        [          "id" => 5,          "quantity" => 4        ]      ];

      // $items = $this->store->getInfo($cart_items);
      $cart_products = $this->order->getOrderInfo(36);
      $customer=null;
      $total=null;
      $order_id=123;
      $detalle_envio= Orden::getDetail($order_id); 
      $name_pais='demo';
      $subtotal=1999;
      $costo_envio=111;
      $route='rutadede';
      $orden_id=11112;
      $pago=133;
      $free_delivery='free';

      
      // $this->check->sendPaymentEmail($cart_products, 44,222);

      $html = view('mails.order', compact('customer', 'total', 'items', 'order_id','detalle_envio','name_pais'))->render();
      // return view('mails.payment', compact('detalle_envio','cart_products', 'subtotal', 'costo_envio', 'total', 'customer', 'route', 'orden_id', 'pago', 'free_delivery'))->render();
      // dd($items);
      // return $html;
    }

    private function updateStockContable($i)
    {

        $id = $i["id"];
        $cant = $i["quantity"];

        foreach ($this->stock_contable as $key => $item) {

          if ($item["id"] == $id) {

              //$this->stock_contable[$key]["_r"] = true;

              //requested
              //$this->stock_contable[$key]["_r"] = true;
              /*$this->stock_contable[$key]["quantity"] = $cant;
              $this->stock_contable[$key]["error"] = false;*/
              $app = app();
              $new_item = $app->make('stdClass');
              $new_item->id = $item["id"];
              $new_item->img = $item["img"];
              $new_item->name = $item["name"];
              $new_item->price = $item["precio"];
              $new_item->slug = $item["slug"];
              $new_item->quantity = $cant;
              $new_item->stock = $item["stock"];
              $new_item->error = false;

              if ( isset($i["wedding_list_id"]) ) {
                $new_item->wedding_list_id = $i["wedding_list_id"];
              }

              ///
               $new_quantity_stock = $item["stock"] - $cant;

               if ($new_quantity_stock < 0) {

                  //throw new \Exception("Sólo hay {$item["stock"]} para {$item["name"]}, ha solicitado {$cant}", 1);

                  $new_item->error = true;

                  if ($item["stock"] == 0) {
                      $new_item->error_msg = "Ya no hay más items en stock";
                  } else {
                      $new_item->error_msg = "Sólo hay {$item["stock"]} items en stock para {$item["name"]}, ha solicitado {$cant}";
                  }


                  /*$this->stock_contable[$key]["error"] = true;
                  $this->stock_contable[$key]["msg"] = "Sólo hay {$item["stock"]} para {$item["name"]}, ha solicitado {$cant}";*/

                  $new_quantity_stock = 0;
               }
               ///

               $this->info[] = $new_item;
               $this->stock_contable[$key]["stock"] = $new_quantity_stock;
          }


        }

    }

    /*local*/
    private function getStockContable($item_id)
    {
        foreach ($this->stock_contable as $item) {
          if ($item["id"] == $item_id) {
               return $item["stock"];
          }
        }
    }

    /*db*/
    private function getStockDatabase()
    {

      //$lista = $request->get('products');
      $lista = isset($lista) ? $lista : [];
      $data = array();

      if (!empty($lista)) {
        foreach ($lista as $product) {
          $data[] = $product['id'];
        }
      }

      $items_prod = Producto::select('productos.id', 'productos.nombre', 'productos.img', 'productos.precio', 'productos.stock', 'productos.color')
              ->whereIn('id', $data)
              ->getQuery()
              ->get();

      //return $items_prod->toArray();

      return [
        [
          "id" => 19,
          "img" => '1a3fdbbaa0c19da86d533d494e5786e8.jpg',
          "name" => 'Ángel de Almeria',
          "precio" => "250.00",
          "stock"=> 4,
          "slug" => 'angel-de-almeria'
        ],
        [
          "id" => 20,
          "img" => '333b4678212bca6416348999916a0b7e.jpg',
          "name" => "Yute Tocuyo Flying Goldfish",
          "precio" => "250.00",
          "stock" => 8,
          "slug" => 'yute-tocuyo-flying-goldfish'
        ]
      ];


    }

    public function test()
    {
      $this->email->send('texto','joze1402@gmail.com','demo');
    }

}

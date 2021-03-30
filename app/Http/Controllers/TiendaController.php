<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Producto;
use App\Material;
use App\Categoria;
use App\ListaRegaloProducto;
use App\Orden;
use App\General;
use App\CuentaRegalos;
use App\ListaRegalo;
use Carbon\Carbon;
use App\Services\Cart\Contracts\CartContract;
use App\Http\Controllers\Traits\ProductStock;

class TiendaController extends Controller
{
    use ProductStock;

    protected $cart;

    public function __construct(CartContract $cart)
    {
      $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Pronto
        //return view('en-construccion');

        $productsql = Producto::leftjoin('descuentos','descuentos.id','productos.descuento_id')
                            ->select('productos.*','productos.dsct_lista_regalo as dsct', 'descuentos.descuento','descuentos.fecha_fin','descuentos.aplicado')
                            ->where('publicado', 1)
                            ->where('stock', '>=', 1)
                            ->where('precio', '>', 0);
        $maxprice = round(floatval($productsql->get()->max('precio')));
        $minprice = round(floatval($productsql->get()->min('precio')));
        $bymaterials = Material::with('productos')->select('id', 'nombre')->get();
        $byartists = $productsql->get()->sortBy('artista.nombres')->groupBy('artista.nombres');
        $bycategories = $productsql->get()->sortBy('categoria.nombre')->groupBy('categoria.nombre');
        $productsql = $productsql->order(request('orderby'),request('orden'));

        if (request('filterby') == 'material_id') {
          $productsql = $productsql->filterMaterial(request('filterby'), request('value'));
        }

        if (request('rule')) {
          $productsql = $productsql->filter(request('filterby'), request('value'), request('rule'));
        } else {
          $productsql = $productsql->filter(request('filterby'), request('value'));
        }

        $products = $productsql->orderBy('created_at','desc')->get();
        foreach ($products as $product) {
          $differencia = Carbon::now()->diffInDays($product->created_at);
          $product->recently = $differencia < 14;
        }
        $products = $products->paginate(12);
        $products->maxprice = $maxprice;
        $products->currentprice = request('rule') ? request('value') : $maxprice;
        $products->minprice = $minprice;


        $weddingproducts = array();
        $costo_envio = '';

        if (\Auth::guard('boda')->check()) {
          $bodaid = \Auth::guard('boda')->user()->id;

          $cuenta = CuentaRegalos::find($bodaid);


          return view('tienda', compact('products','bycategories','byartists','bymaterials', 'weddingproducts', 'costo_envio', 'cuenta'));

        }
        //  echo '<pre>';         var_dump($products);
        return view('tienda', compact('products','bycategories','byartists','bymaterials', 'weddingproducts', 'costo_envio'));
    }

    public function getStockProducto(Request $request)
    {
      $stock = 0;
      $producto_id = $request->get('productId');
      $producto_color = $request->get('color');

      $product = array(
        'id' => $producto_id,
        'color' => $producto_color,
      );

      $stock = $this->getStock($product);

      return response()->json(['success' => true, 'data' => $stock]);
    }

    public function getStockProductoCart(Request $request)
    {
      /*$stock = 0;
      $producto_id = $request->get('productId');
      $producto_color = $request->get('color');
    
      $product = array(
        'id' => $producto_id,
        'color' => $producto_color,
      );

      $stock = $this->getStock($product);*/
      $colors = !empty($request) ? (array) json_decode($request) : [];
      $producto_id = $request->get('productId');
      //$product = Producto::find($request['id']);


      return response()->json(['success' => true, 'data' => $producto_id]);
    }


    public function getStockProductoAPI(Request $request)
    {

        $producto_id = $request->get('productId');
        $stock = [];

        $dbproduct = Producto::find($producto_id);
        $title = $dbproduct->nombre;
        $img = $dbproduct->img;
        $price = $dbproduct->precio;
        $lista_colores = $dbproduct->color ? json_decode($dbproduct->color) : [];

        if (!empty($lista_colores)) {
            $stock = $lista_colores;
        } else {
            $stock[] = ["stock"=>$dbproduct->stock];
        }

        return response()->json([
          "title" => $title,
          "img" => $img,
          "price" => $price,
          "stock" => $stock
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function producto($slug)
    {
        //Pronto
        //return view('en-construccion');

        $product = Producto::where('slug',$slug)->where('publicado', 1)->first();

        if (is_null($product)) {
            return redirect()->route('home.tienda');
        }

        $listas = [];

        if (\Auth::guard('boda')->check()) {
            $gift_account = \Auth::guard('boda');
            $cuenta = CuentaRegalos::find($gift_account->user()->id);

            $listas = ListaRegalo::where('cuenta_regalos_id', $gift_account->user()->id)
                      ->where('edicion_finalizada', false)
                      ->get();

        }
        $generales = General::where('nombre', 'free_delivery')->first();


        $free_delivery = $generales->valor;

        if (!is_null($product)) {

            if (!is_null($product->galeria_img)) {

                $galeria_img[] = '/uploads/products/'.$product->img;
                $imgs = json_decode($product->galeria_img);
                foreach ($imgs as $img) {
                    $galeria_img[] = '/uploads/products/shop/'.$img;
                }
                $product->galeria_img = $galeria_img;
            }

            if (isset($product->tipo))
            {
              // $products_like = Producto::where('categoria_id', $product->categoria->id)
              //               ->orWhere('tipo_id', $product->tipo->id)
              //               ->where('id','!=',$product->id)
              //               ->inRandomOrder()->take(5)->get();
              $products_like = Producto::where('slug','!=',$slug)->orWhere('stock','>',0)
                            ->inRandomOrder()->take(5)->get();
                foreach ($products_like as $key => $producto) {
                if ($product->id == $producto->id || $producto->stock == 0) {
                  unset($products_like[$key]);
                }

                $differencia = Carbon::now()->diffInDays($producto->created_at);
                $producto->recently = $differencia < 14;
              }
            } else {
               $products_like = [];
            }

            $product->color = ($product->color) ? json_decode($product->color) : [];

            $costo_envio = '';

            return view('producto', compact('product','products_like', 'costo_envio', 'listas', 'free_delivery'));
        }

        return redirect()->route('home.tienda');
    }

    public function cart()
    {

        //Pronto
        //return view('en-construccion');

        $role = null;

        $generales = General::where('nombre', 'free_delivery')->first();
        $free_delivery = $generales->valor;

        if (\Auth::guard('boda')->check()) {
            $role = 'boda';
        }

        $user = Auth::user();
        if ($user != null && $user->hasRole('Admin')) {
          $role = 'admin';
        }

        return view('cart', compact('role','free_delivery'));

    }


    /**
     * Verify auth and product stock
     *
     * @return 
     */
    public function verifyAuthAndStock(Request $request)
    {
      if (!Auth::check()) {
          return response()->json(['error' => 'Unauthenticated'], 401);
      }

      $items = $this->cart->getCartTotal($request->get('products'));

      if ($items['success']) {
        return response()->json(['success' => 'success', 'data'=> $items['data'] ]);
      }
      return response()->json(['error' => 'stock']);

    }


}

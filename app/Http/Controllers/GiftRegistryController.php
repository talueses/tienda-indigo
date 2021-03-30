<?php

namespace App\Http\Controllers;

use Session;
use DateTime;
use App\Pagina;
use App\General;
use App\Producto;
use Carbon\Carbon;
use App\CuentaRegalos;
use App\ListaRegalo;
use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Traits\Item;
use App\Http\Controllers\Traits\ProductStock;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\ListaRegaloProducto;
use Illuminate\Support\Facades\Password;

class GiftRegistryController extends Controller
{
    use RegistersUsers,AuthenticatesUsers,Item,ProductStock;

    /**
     * guard
     */
    public function guard()
    {
        return Auth::guard('boda');
    }

    /**
     * username to authentication
     */
    public function username()
    {
        return 'codigo';
    }

    /**
     * redirect when authenticate success
     */
    public function redirectPath()
    {
        return '/programa-de-regalos';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regalos = [];

        //Pronto
        //return view('en-construccion');

        if ($this->guard()->check()) {
          $cuenta = CuentaRegalos::findOrFail($this->guard()->user()->id);

          return view('listaregalo.dashboard', compact('cuenta'));
        }

        $programa_novios_description = Pagina::where('titulo', '=', 'programa_novios')->first() ? Pagina::where('titulo', '=', 'programa_novios')->first()->contenido : '';


        /**
         * save the previous page in the session
         */
        $previous_url = Session::get('_previous.url');
        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $ref = rtrim($ref, '/');
        $last = explode('/', $previous_url, 7);

        //dd($previous_url != url('programa-de-regalos') && $ref == '', $previous_url, $ref, isset($last[5]) && $last[5] == 'detalle');

        if ($previous_url != url('programa-de-regalos') && isset($last[5]) && $last[5] == 'detalle')
        {
            Session::put('referrer', $previous_url);
            Session::put('url.intended', $previous_url);
        }

        return view('novios', compact('programa_novios_description'));
    }


    public function listas()
    {
        if (is_null($this->guard()->user())) {
          return redirect()->route('home.giftregistry');
        }

        $cuenta = CuentaRegalos::findOrFail($this->guard()->user()->id);

        if (is_null($cuenta->activated_at)) {
          $email = $cuenta->email;
          $user_token = Password::getRepository()->create($cuenta);

          return view('listaregalo.restricted', compact('user_token', 'email'));
        }

        $listas = ListaRegalo::where('cuenta_regalos_id', $cuenta->id)->get();

        return view('listaregalo.listas', compact('listas'));
    }


    public function createList(Request $request)
    {
        $this->validate(request(), [
            'titulo_evento' => 'required',
            'modo_entrega' => 'required',
            'fecha_evento' => 'required'
        ]);


        try {
            $lista = new ListaRegalo;

            //cuenta regalos
            $lista->cuenta_regalos_id = Auth::guard('boda')->user()->id;

            $lista->titulo = $request->get('titulo_evento');
            $lista->desc = $request->get('desc_evento');
            $lista->organizador_uno = $request->get('organizador_uno');
            $lista->organizador_dos = $request->get('organizador_dos');
            $lista->fecha = \Carbon\Carbon::parse($request->get('fecha_evento'));

            $slug = Str::slug($request->get('titulo_evento'));

            $lista->img = ($request->hasFile('img')) ?
                        $this->uploadCover($request->file('img'), $slug, 'giftregistry') : null;

            $lista->entrega = $request->get('modo_entrega');

            if ($request->get('modo_entrega') == 'delivery') {
                $lista->departamento = $request->get('envio_departamento');
                $lista->distrito = $request->get('envio_lima_metropolitana');
                $lista->direccion = $request->get('direccion');
            }

            if ($request->get('modo_entrega') == 'recojo_tienda')
            {
                $lista->departamento = null;
                $lista->distrito = null;
                $lista->direccion = null;
            }

            $lista->codigo = $lista->generateCode();

            $lista->save();

            session()->flash('message', ['type' => 'success', 'message' => 'Lista creada.']);

        } catch (\Exception $e) {

            session()->flash('message', ['type' => 'danger', 'message' => 'Error al crear la lista.'.$e->getMessage()]);
            return redirect()->route('giftregistry.newlist');
        }

        return redirect()->route('giftregistry.showList', $lista->codigo);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateList(Request $request, $codigo)
    {
        if ($this->guard()->check()) {

            $lista = ListaRegalo::where('codigo', $codigo)->first();
            $estado = $lista->getState();

            if ($estado == 'edicion') {
                $this->validate($request, [
                  'titulo_evento' => 'required',
                  'modo_entrega' => 'required',
                  'fecha_evento' => 'required|date'
                ]);

                $lista->titulo = $request->get('titulo_evento');
                $lista->desc = $request->get('desc_evento');

                $slug = Str::slug($request->get('titulo_evento'));
                $lista->img = ($request->hasFile('img')) ?
                            $this->uploadCover($request->file('img'), $slug, 'giftregistry') : $lista->img;

                $fecha = \Carbon\Carbon::parse($request->get('fecha_evento'));
                $lista->fecha = $fecha->toDateTimeString();
                $lista->organizador_uno = $request->get('organizador_uno');
                $lista->organizador_dos = $request->get('organizador_dos');

                if ( $request->get('modo_entrega') && ($request->get('modo_entrega') == 'delivery' )) {
                    $lista->departamento = $request->get('envio_departamento');
                    $lista->distrito = $request->get('envio_lima_metropolitana');
                    $lista->direccion = $request->get('direccion');
                }

                if ( $request->get('modo_entrega') && ($request->get('modo_entrega') == 'recojo_tienda' )) {
                    $lista->departamento = null;
                    $lista->distrito = null;
                    $lista->direccion = null;
                }

                $lista->entrega = $request->get('modo_entrega');
                $lista->save();
            } else {
                $this->validate($request, [
                  'titulo_evento' => 'required',
                  'desc_evento' => 'required|min:3',
                  'organizador_uno' => 'required',
                  'organizador_dos' => 'required',
                  'fecha_evento' => 'required|date'
                ]);

                $lista->titulo = $request->get('titulo_evento');
                $lista->desc = $request->get('desc_evento');
                $slug = Str::slug($request->get('nombre'));

                $lista->img = ($request->hasFile('img')) ?
                            $this->uploadCover($request->file('img'), $slug, 'giftregistry') : $lista->img;

                $fecha = \Carbon\Carbon::parse($request->get('fecha_evento'));
                $lista->fecha = $fecha->toDateTimeString();
                $lista->organizador_uno = $request->get('organizador_uno');
                $lista->organizador_dos = $request->get('organizador_dos');
                $lista->save();
            }

            session()->flash('message', ['type' => 'success', 'message' => 'Lista actualizada.']);
        }

        return redirect()->route('giftregistry.showList', $codigo);
    }

    public function updateListFromApi(Request $request)
    {
            $lista = ListaRegalo::find($request->get('id'));

            $lista->titulo = $request->get('titulo');
            $lista->desc = $request->get('desc');
            $fecha = DateTime::createFromFormat('d/m/Y', str_replace('"', '', $request->get('fecha')));
            $lista->fecha = $fecha->format('Y-m-d H:i:s');
            $lista->organizador_uno = $request->get('organizador_uno');
            $lista->organizador_dos = $request->get('organizador_dos');
            $lista->entrega = $request->get('entrega');
            $lista->departamento = $request->get('departamento');
            $lista->distrito = $request->get('distrito');
            $lista->direccion = $request->get('direccion');
            $lista->save();

            return response()->json($lista);
    }

    public function updateListPictureFromApi(Request $request) {
        $lista = ListaRegalo::find($request->get('id'));
        $slug = Str::slug($lista->id.$lista->titulo);

        $lista->img = ($request->hasFile('img')) ?
                            $this->uploadCover($request->file('img'), $slug, 'giftregistry') : $lista->img;
        $lista->save();

        return response()->json($lista);
    }

    /**
     * Mostrar lista creada.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function showList($codigo)
    {
      if ($this->guard()->check()) {
        $cuenta = CuentaRegalos::findOrFail($this->guard()->user()->id);

        //Search by codigo
        $lista = ListaRegalo::where('codigo', $codigo)->first();
        $fecha = \Carbon\Carbon::parse($lista->fecha);
        $lista->fecha = $fecha->format('m/d/Y');

        return view('listaregalo.gift-list-vue', compact('lista'));
      }

      return redirect($this->redirectPath());
    }

    public function getDetailFromApi(Request $request)
    {
        $detail = ListaRegalo::find($request->get('id'));
        $fecha = \Carbon\Carbon::parse($detail->fecha);
        $detail->fecha = $fecha->format('m/d/Y');
        $detail->state = $detail->getState();
        $detail->badge = $detail->getBadge();

        return response()->json($detail);

    }

    /**
     * Mostrar pagina para crear una nueva lista.
     *
     * @return \Illuminate\View\View
     */
    public function showNewList()
    {
      if ($this->guard()->check()) {
          $cuenta = CuentaRegalos::findOrFail($this->guard()->user()->id);

          if (is_null($cuenta->activated_at)) {
              $email = $cuenta->email;
              $user_token = Password::getRepository()->create($cuenta);
              return view('listaregalo.restricted', compact('user_token', 'email'));
          }

          $regalos = [];
          return view('listaregalo.new-list', compact('cuenta', 'regalos'));
      }

      $programa_novios_description = Pagina::where('titulo', '=', 'programa_novios')->first() ? Pagina::where('titulo', '=', 'programa_novios')->first()->contenido : '';

      return view('novios', compact('programa_novios_description'));

    }


    /**
     * Eliminar imagen de una lista.
     *
     * @return \Illuminate\View\View
     */
    public function removeImage(Request $request, $id)
    {
        $lista = ListaRegalo::find($id);

        if($lista->img)
        {
          if ($lista->deleteImage()) {

            $lista->img = null;
            $lista->save();
            session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);

          } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al eliminar la imagen.']);
          }
        } else {
            session()->flash('message', ['type' => 'warning', 'message' => 'Esta lista no tiene imagenes para eliminar.']);
        }

        return redirect()->route('giftregistry.showList', $lista->codigo);
    }


    /**
     * Agregar producto a una lista.
     *
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {
      $this->validate($request, [
        'lista_codigo' => 'required',
        'producto_id' => 'required',
        'cantidad' => 'required'
      ]);

      $data = $request->all();

      try {
        $cuenta_id = $data['cuenta_id'];
        $lista_codigo = $data['lista_codigo'];
        $producto_id = $data['producto_id'];
        $cantidad = $data['cantidad'];
        $color = isset($data['color']) ? $data['color'] : null;

        $lista_regalo = ListaRegalo::where('codigo', $lista_codigo)->first();
        $producto = Producto::find($producto_id);


        $lista_regalo_producto = ListaRegaloProducto::where('lista_regalos_id', $lista_regalo->id)
                                    ->where('producto_id', $producto->id)
                                    ->where('color', $color)
                                    ->get()
                                    ->first();

        if (!empty($lista_regalo_producto)) {
            //actualizar
            $lista_regalo_producto->solicitados = $cantidad;
            $lista_regalo_producto->update();
            return response()->json('success');
        } else {
            //crear
            if ($cantidad) {

              $lista = new ListaRegaloProducto();
              $lista->lista_regalos_id = $lista_regalo->id;
              $lista->producto_id = $producto->id;
              $lista->solicitados = $cantidad;
              $lista->color = $color;
              $lista->save();

              return response()->json('success');
            } else {
              return response()->json('error');
            }

        }


      } catch (Exception $e) {

        return response()->json('error');
      }
    }

    public function removeProduct(Request $request)
    {
        $id = $request->get('id');
        $producto = ListaRegaloProducto::find($id);

        if (!is_null($producto) && $producto->recibidos == 0) {
            $producto->delete();
            session()->flash('message', ['type' => 'success', 'message' => 'Producto eliminado.']);
        } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'No se pudo eliminar producto. Ya se ha comprado uno de los solicitados.']);
        }

        return redirect()->route('giftregistry.lists');
    }

    public function removeProductFromApi(Request $request)
    {
        $product_id = $request->get('product_id');
        $gift_list_id = $request->get('gift_list_id');
        $product = ListaRegaloProducto::where('producto_id',$product_id)->where('lista_regalos_id', $gift_list_id)->first();
        $response = false;

        if (!is_null($product) && $product->recibidos == 0) {
            $product->delete();
            $response = true;
        }
        return response()->json($response);
    }

    public function updateProductFromApi(Request $request)
    {
        $product_id = $request->get('product_id');
        $gift_list_id = $request->get('gift_list_id');
        $quantity = $request->get('quantity');
        $product = ListaRegaloProducto::where('producto_id',$product_id)->where('lista_regalos_id', $gift_list_id)->first();
        $response = false;

        if (!is_null($product)) {
            $product->solicitados = $quantity;
            $product->save();
            $response = true;
        }
        return response()->json($response);
    }

    public function getProductsFromApi(Request $request)
    {

      $list_id = $request->get('list_id');
      $response = [];

      $gifts = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
                ->select(
                    'lista_regalo_producto.id',
                    'lista_regalo_producto.lista_regalos_id',
                    'lista_regalo_producto.producto_id',
                    'lista_regalo_producto.solicitados',
                    'lista_regalo_producto.recibidos',
                    'lista_regalo_producto.recargo',
                    'lista_regalo_producto.color',
                    'productos.nombre',
                    'productos.stock',
                    'productos.categoria_id',
                    'productos.img',
                    'productos.precio',
                    'productos.dsct_lista_regalo'
                  )
                ->where('lista_regalos_id', '=', $list_id)
                ->getQuery()
                ->get();

        if (!is_null($gifts)) {
            $response = $gifts;
        }
        return response()->json($response);
    }

    public function updateProductQuantity(Request $request)
    {
      $producto_id = $request->get('productId');
      $cantidad = $request->get('cantidad');
      $cuenta_novios_id = $request->get('cuentaNovios');

      $producto = ListaRegaloProducto::where('cuenta_novios_id', '=', $cuenta_novios_id)
                      ->where('producto_id', '=', $producto_id)
                      ->get()
                      ->first();
      $producto->solicitados = $cantidad;
      $producto->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchList(Request $request)
    {
        $user = Auth::user();
        $lista_regalo_guard = Auth::guard('boda')->check();

        if($lista_regalo_guard) {
            return redirect()->route('home.giftregistry');
        }

        setlocale(LC_ALL, 'es_ES');
        $lista = ListaRegalo::where('codigo', $request->get('codigo'))->first();
        $regalos = [];

        if (!is_null($lista)) {

          if ( $lista->edicion_finalizado && $lista->entrega == 'delivery' && !$lista_costo_envio ) {
              session()->flash('message', ['type' => 'success', 'message' => 'Esta lista aun no está publicada.']);

              return redirect()->route('home.novios');
          }

          //Traer lista regalo producto - where('publicado', 1)
          $regalos = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
                    ->select(
                      'lista_regalo_producto.id as lista_regalo_id',
                      'lista_regalo_producto.lista_regalos_id',
                      'lista_regalo_producto.producto_id',
                      'lista_regalo_producto.solicitados',
                      'lista_regalo_producto.recibidos',
                      'lista_regalo_producto.recargo',
                      'lista_regalo_producto.color',
                      'productos.nombre',
                      'productos.stock',
                      'productos.categoria_id',
                      'productos.img',
                      'productos.precio',
                      'productos.id',
                      'productos.dsct_lista_regalo',
                      'productos.slug')
                    ->where('lista_regalos_id', '=', $lista->id)
                    ->getQuery()
                    ->get();

           return view('lista-regalo-search', compact('lista', 'regalos'));
        }

        session()->flash('message', ['type' => 'danger', 'message' => 'No se encontró la lista que buscaba.']);

        return view('novios');
    }

    /**
     * Mostrar previsualizacion de la lista.
     *
     * @return \Illuminate\View\View
     */
    public function preview(Request $request, $codigo)
    {

        $regalos = [];

        $cuenta = ListaRegalo::with('productos')
              ->where('codigo', $codigo)->get()->first();
        $cuenta->fecha = date('Y-m-d', strtotime($cuenta->fecha));
        $products = $cuenta->productos;

        //Traer lista regalo producto - where('publicado', 1)
        $regalos = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
                  ->select('lista_regalo_producto.lista_regalos_id', 'lista_regalo_producto.producto_id',
                  'lista_regalo_producto.solicitados', 'lista_regalo_producto.recibidos',
                  'lista_regalo_producto.color', 'productos.nombre', 'productos.stock',
                  'productos.categoria_id', 'productos.img', 'productos.slug', 'productos.precio', 'productos.id', 'productos.dsct_lista_regalo')
                  ->where('lista_regalos_id', '=', $cuenta->id)
                  ->getQuery()
                  ->get();

        return view('lista-regalo-preview', compact('cuenta', 'products', 'regalos'));
    }


    public function getQuantityNeeded(Request $request)
    {
      $list_id = $request->get('listId');
      $producto_id = $request->get('productId');
      $producto_color = $request->get('color');

      $product = array(
        'list_id' => $list_id,
        'id' => $producto_id,
        'color' => $producto_color,
      );

      $num = 0;
      $stock = 0;

      $lista = ListaRegalo::where('codigo', $list_id)->first();

      $producto = ListaRegaloProducto::where('lista_regalos_id', '=', $lista->id)
                      ->where('producto_id', '=', $producto_id)
                      ->where('color', '=', $producto_color)
                      ->first();

      //Solicitados
      $qty = $producto->solicitados - $producto->recibidos;

      //Verificar stock
      $stock = $this->getStock($product);

      if (count($stock) <= 1) {

        if( is_array($stock[0]) ) {
          $stock = $stock[0]["stock"];
        } else {
          $stock = $stock[0]->stock;
        }

      }

      if ($qty <= $stock){
        $num = $qty;
      }elseif ($stock < $qty){
        $num = $stock;
      }

      return \Response::json(array(
        'success' => true,
        'data' => array(
          'num' => $num,
          'stock' => $stock
        )
      ));
    }


    public function getMyGiftLists(Request $request)
    {
        $listas = [];

        $gift_account = Auth::guard('boda');
        $productId = $request->get('productId');

        if(is_null($gift_account)) {
            return \Response::json([
              'success'=> false,
              'data' => []
            ]);
        }

        $listas = ListaRegalo::where('cuenta_regalos_id', $gift_account->user()->id)
                  ->where('edicion_finalizada', false)
                  ->get();
        $data = $this->getItemStock($productId);

        return \Response::json([
          'success'=> true,
          'data' => [
            'title' => $data['title'],
            'img' => $data['img'],
            'price' => $data['price'],
            'lists' => $listas,
            'stock' => $data['stock']
          ]
        ]);
    }


    public function getItemStock($productId)
    {
        $stock = [];

        $dbproduct = Producto::find($productId);
        $title = $dbproduct->nombre;
        $img = $dbproduct->img;
        $price = $dbproduct->precio;
        $lista_colores = $dbproduct->color ? json_decode($dbproduct->color) : [];

        if (!empty($lista_colores)) {
            $stock = $lista_colores;
        } else {
            $stock[] = ["stock"=>$dbproduct->stock];
        }

        return [
          "title" => $title,
          "img" => $img,
          "price" => $price,
          "stock" => $stock
        ];
    }


    public function endlist(Request $request)
    {
        $codigo = $request->get('cuenta_lista_regalo');
        $lista = ListaRegalo::where('codigo', $codigo)->first();
        $regalos = ListaRegaloProducto::where('lista_regalos_id', $lista->id)->get();

        if ($regalos->isEmpty()) {
          session()->flash('message', ['type' => 'danger', 'message' => 'No es posible finalizar esta lista. Primero debe añadir algún producto.']);

        } else {
          $lista->edicion_finalizada = true;

          if ( $lista->update() ) {
              session()->flash('message', ['type' => 'success', 'message' => 'Se ha finalizado la edición de la lista. Si eligió delivery el costo de envio será confirmado.']);
          }
        }

        //return redirect()->route('giftregistry.showList', $codigo);
        return back();

    }

    public function cancelCalcList(Request $request)
    {
        $codigo = $request->get('cuenta_lista_regalo');

        $lista = ListaRegalo::where('codigo', $codigo)->first();
        $lista->edicion_finalizada = false;

        //Actualizar sólo si no hay un ningún regalo recibido
        $items = ListaRegaloProducto::where('lista_regalos_id', $lista->id)
                      ->get()
                      ->toArray();

        $recibido = false;

        foreach ($items as $item) {
          if ($item['recibidos']) {
            $recibido = true;
            break;
          }
        }

        if (!$recibido) {
            $lista->update();
            session()->flash('message', ['type' => 'success', 'message' => 'Se ha cancelado el cálculo de costo de envio para esta lista.']);
        } else {
            session()->flash('message', ['type' => 'danger', 'message' => 'No se puede actualizar esta lista, uno de los items solicitados ya fue comprado.']);
        }

        //return redirect()->route('giftregistry.showList', $codigo);
        return back();
    }
}

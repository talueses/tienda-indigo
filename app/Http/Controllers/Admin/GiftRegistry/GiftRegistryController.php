<?php
namespace App\Http\Controllers\Admin\GiftRegistry;

use App\Http\Controllers\Controller;

use App\Pagina;
use App\Producto;
use Carbon\Carbon;
use App\ListaRegalo;
use App\CuentaRegalos;
use App\Services\Excel;
use App\ListaRegaloProducto;
use Illuminate\Http\Request;
use App\Exports\GiftListExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\Item;
use App\Services\Email as EmailService;
use App\Services\Exports\GenericSingleSheet;
use App\Services\Exports\Gift\GiftMultiSheetsByUser;

class GiftRegistryController extends Controller
{

	use Item;
	
	public function __construct(EmailService $email) 
	{
		$this->mail = $email;
	}

	public function index()
	{
      	$listas = CuentaRegalos::all();

		$programa_novios_description = Pagina::where('titulo', '=', 'programa_novios')->first() ? Pagina::where('titulo', '=', 'programa_novios')->first()->contenido : '';

      return view('admin.giftregistry.index', compact('listas', 'programa_novios_description'));
	}

	public function edition()
	{
			$listas = ListaRegalo::where('edicion_finalizada', 0)->get();
			
      return view('admin.giftregistry.bystatus', compact('listas'));
	}

	public function calculating()
	{
			$listas = ListaRegalo::where('edicion_finalizada', 1)
																					->where('costo_envio', null)
																					->where('entrega', 'delivery')
																					->where('departamento', '<>','lima_metropolitana')
																					->get();
			
      return view('admin.giftregistry.bystatus', compact('listas'));
	}

	public function tracking()
	{
			$listas = ListaRegalo::where('edicion_finalizada', 1)
																					->where('tracking', '<>', null)
																					->where('tracking', '<>', '')
																					->get();
			
      return view('admin.giftregistry.bystatus', compact('listas'));
	}

	public function finished()
	{

		$listas = ListaRegalo::where('edicion_finalizada', 1)->get();

		$finished = [];

		foreach($listas as $key => $lista)
		{
			
			if ($lista->costo_envio)
			{
				$finished[] = $lista;
			}

			if ($lista->entrega == 'recojo_tienda')
			{
				$finished[] = $lista;	
			}

			if ($lista->entrega == 'delivery' &&  $lista->departamento == 'lima_metropolitana') 
			{
				$finished[] = $lista;
			}

		}

		$listas = $finished;

		return view('admin.giftregistry.bystatus', compact('listas'));
		
	}

  public function updateDescription(Request $request)
  {

      $description = $request->get('description');

      $programa_novios = Pagina::where('titulo', '=', 'programa_novios')->first();

      if ($programa_novios !== null) {

          $pagina = Pagina::find($programa_novios->id);
          $pagina->titulo = 'programa_novios';
          $pagina->contenido = $description;
          $pagina->update();

          session()->flash('message', ['type' => 'success', 'message' => 'Contenido de Programa de Regalos actualizado.']);

      } else {

          $pagina = new Pagina;
          $pagina->titulo = 'programa_novios';
          $pagina->contenido = $description;
          $pagina->save();

          session()->flash('message', ['type' => 'success', 'message' => 'Contenido de Programa d Regalos guardado.']);
      }
      return redirect()->route('admin.giftregistry');

  }

  public function listsById($id)
  {
			$cuenta = CuentaRegalos::find($id);

			$listas = ListaRegalo::where('cuenta_regalos_id', $cuenta->id)->get();
			
      return view('admin.giftregistry.lists', compact('cuenta', 'listas'));
  }

	public function showCreateList(Request $request, $id)
	{
			$cuenta = CuentaRegalos::find($id);
			if (is_null($cuenta)) {
				return redirect()->route('admin.giftregistry');
			}
			$productos = Producto::all();

			return view('admin.giftregistry.create', compact('cuenta','productos'));
	}

	public function storeList(Request $request, $id)
	{
			$this->validate($request, [
					'titulo_evento' => 'required',
					'fecha_evento' => 'required',
					'modo_entrega' => 'required'
			]);

			$cuenta = CuentaRegalos::find($id);

			try {

				$lista = new ListaRegalo;
				$lista->cuenta_regalos_id = $cuenta->id;

				$lista->titulo = $request->get('titulo_evento');
				$lista->desc = $request->get('desc_evento');
			
				$lista->organizador_uno = $request->get('organizador_uno');
				$lista->organizador_dos = $request->get('organizador_dos');

				$fecha = \Carbon\Carbon::parse($request->get('fecha_evento'));
				$lista->fecha = $fecha->toDateTimeString();

				$slug = Str::slug($request->get('titulo_evento'));
				$lista->img = ($request->hasFile('img')) ?
										$this->uploadCover($request->file('img'), $slug, 'giftregistry') : null;


				$lista->entrega = $request->get('modo_entrega');

				if ($request->get('modo_entrega') == 'delivery') {
						$lista->departamento = $request->get('envio_departamento');
						$lista->distrito = $request->get('envio_lima_metropolitana');
						$lista->direccion = $request->get('direccion');
				}

				if ($request->get('modo_entrega') == 'recojo_tienda') {
						$lista->departamento = null;
						$lista->distrito = null;
						$lista->direccion = null;
				}


				$lista->codigo = $lista->generateCode();

				$lista->save();

			} catch (\Exception $e) {
				session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al crear la lista.']);
				redirect()->back();
			}


			session()->flash('message', ['type' => 'success', 'message' => 'Lista creada.']);
			return redirect()->route('admin.giftregistry.showList', $lista->codigo);

	}

  public function updateList(Request $request, $id)
  {
      $this->validate(request(), [
          'titulo_evento' => 'required',
          'fecha_evento' => 'required'
      ]);

      $lista = ListaRegalo::find($id);

      $lista->titulo = $request->get('titulo_evento');
      $lista->desc = $request->get('desc_evento');

      $slug = Str::slug($request->get('titulo_evento'));

			$lista->img = ($request->hasFile('img')) ?
									$this->uploadCover($request->file('img'), $slug, 'giftregistry') : $lista->img;

      $fecha = \Carbon\Carbon::parse($request->get('fecha_evento'));
      $lista->fecha = $fecha->toDateTimeString();

      $lista->organizador_uno = $request->get('organizador_uno');
      $lista->organizador_dos = $request->get('organizador_dos');
      $lista->save();

      session()->flash('message', ['type' => 'success', 'message' => 'Lista actualizada.']);

      return redirect()->route('admin.giftregistry.showList', $lista->codigo);
  }

  public function showList(Request $request, $codigo)
  {
      $lista = ListaRegalo::where('codigo', $codigo)->first();

      $fecha = \Carbon\Carbon::parse($lista->fecha);
      $lista->fecha = $fecha->format('m/d/Y');

      $tienda_productos = Producto::where('publicado', 1)->orderBy('created_at','desc')->get();

      $regalos = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
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
                    'productos.dsct_lista_regalo',
                    'productos.slug'
                  )
                ->where('lista_regalos_id', '=', $lista->id)
                ->getQuery()
								->get();

        $dt = $lista->updated_at->toDateTimeString();
        Carbon::setLocale('es');
				$updated_at = Carbon::parse($dt)->diffForHumans();

        return view('admin.giftregistry.show', compact('lista', 'regalos', 'tienda_productos', 'updated_at'));
  }


  public function updatePassword(Request $request)
  {
      $this->validate($request, [
        'password' => 'required|min:8'
      ], [
        'password.required' => 'El campo password es requerido para actualizar la cuenta de regalos.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
      ]);

      $id = $request->get('id');
      $cuenta_regalos = CuentaRegalos::find($id);
      $cuenta_regalos->password = Hash::make($request['password']);
      $cuenta_regalos->save();

      session()->flash('message', ['type' => 'success', 'message' => 'Password actualizado.']);
      return redirect()->route('admin.giftregistry.lists', $id);
  }


	public function updateShipcost(Request $request)
	{
			$this->validate($request, [
				'costo_envio' => 'required|numeric'
			], [
				'costo_envio.required' => 'Debe ingresar un monto correcto para el costo de envio.',
				'costo_envio.numeric' => 'El costo de envio debe ser un número.'
			]);

			$id = $request->get('id');
			$lista = ListaRegalo::find($id);

			$lista->costo_envio = $request->get('costo_envio');

			$selected = ListaRegaloProducto::where('lista_regalos_id', $lista->id)->get();
			$total_items = 0;
			foreach ( $selected as $item ) {
				$total_items += $item->solicitados;
			}

			$price_p_item = $lista->costo_envio / $total_items;

			foreach ( $selected as $item ) {
				
				$regalo = ListaRegaloProducto::find($item->id);
				$regalo->recargo = $item->solicitados * $price_p_item;
				$regalo->save();
			}
			$route = route('giftregistry.showList', $lista->codigo);
			
			if ($lista->update()) {
				$html = view('mails.giftregistry.costupdated', compact('lista', 'route'))->render();
        $this->mail->send($html, $lista->cuentaRegalo->email, 'Costo de envio actualizado');
				session()->flash('message', ['type' => 'success', 'message' => 'El costo de envío se actualizó correctamente.']);
			} else {
				session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al actualizar el costo de envío.']);
			}

			return redirect()->route('admin.giftregistry.showList', $lista->codigo);
	}


	public function deleteShipcost(Request $request)
	{
			$id = $request->get('id');
			$lista = ListaRegalo::find($id);
			$lista->costo_envio = null;

			$selected = ListaRegaloProducto::where('lista_regalos_id', $lista->id)->get();

			foreach ( $selected as $item ) {
				$regalo = ListaRegaloProducto::find($item->id);
				$regalo->recargo = null;
				$regalo->save();
			}

			if ($lista->update()) {
				session()->flash('message', ['type' => 'success', 'message' => 'Se elimino el costo de envío correctamente.']);
			} else {
				session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al eliminar el costo de envío.']);
			}

			return redirect()->route('admin.giftregistry.showList', $lista->codigo);
	}


	public function updateTracking(Request $request)
	{
			$this->validate($request, [
				'tracking' => 'required'
			], [
				'tracking.required' => 'Debe ingresar la url correctamente de tracking.'
			]);

			$id = $request->get('id');
			$lista = ListaRegalo::find($id);

			$lista->tracking = $request->get('tracking');

			$cart_products = count($lista->productos()->get()) >= 1 ? $lista->productos()->get() : [];
			$subtotal =0; 
			$costo_envio = $lista->costo_envio;
			$total = 0; 
			$customer = $lista->cuentaRegalo()->first();
			$codigo_lista = $lista->codigo;
			$route = route('giftregistry.showList', $codigo_lista);

			if ($lista->update()) {
				//Enviar Email
        $html = view('mails.trackingupdate', compact('cart_products', 'subtotal', 'costo_envio', 'total', 'customer', 'codigo_lista', 'route'))->render();

				$this->mail->send($html, $customer->email, 'Su lista de regalo ya cuenta con codigo de seguimiento');
				
				session()->flash('message', ['type' => 'success', 'message' => 'El tracking se actualizó correctamente.']);
			} else {
				session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al actualizar el tracking.']);
			}

			return redirect()->route('admin.giftregistry.showList', $lista->codigo);
	}


	public function deleteTracking(Request $request)
	{
			$id = $request->get('id');
			$lista = ListaRegalo::find($id);
			$lista->tracking = null;

			$selected = ListaRegaloProducto::where('lista_regalos_id', $lista->id)->get();

			if ($lista->update()) {
				session()->flash('message', ['type' => 'success', 'message' => 'Se elimino el tracking correctamente.']);
			} else {
				session()->flash('message', ['type' => 'danger', 'message' => 'Hubo un error al eliminar el tracking.']);
			}

			return redirect()->route('admin.giftregistry.showList', $lista->codigo);
	}

	public function isGiftReceived($id)
	{
			$items = ListaRegaloProducto::where('lista_regalos_id', $id)->get()->first();

			$recibido = false;

			foreach ($items as $item) {
				if ($item['recibidos']) {
					$recibido = true;
					break;
				}
			}

			return $recibido;
	}

	public function removeImage(Request $request, $id)
	{
			$lista = ListaRegalo::find($id);
			$lista->deleteImage();
			$lista->img = null;
			$lista->save();

			session()->flash('message', ['type' => 'success', 'message' => 'Imagen eliminada.']);
			return redirect()->route('admin.giftregistry.showList', $lista->codigo);
	}


	/**
	 * 
	 * Method to get stock list by product id
	 */
	public function getProductStockList(Request $request)
	{
			$productId = $request->get('productId');

			$data = $this->getItemStock($productId);

			return \Response::json([
				'success'=> true,
				'data' => [
					'title' => $data['title'],
					'img' => $data['img'],
					'price' => $data['price'],
					'stock' => $data['stock']
				]
			]);
	}

	/**
	 * 
	 * Chain method of getProductStockList
	 */
	public function getItemStock($productId)
	{
			$stock = [];

			$dbproduct = Producto::find($productId);
			$title = $dbproduct->nombre;
			$img = $dbproduct->img;
			$price = $dbproduct->precio;
			$lista_colores = $dbproduct->color ? json_decode($dbproduct->color) : [];

			if (!empty($lista_colores)) 
			{
					$stock = $lista_colores;
			} else {
					$stock[] = [ "stock" => $dbproduct->stock];
			}

			return [
				"title" => $title,
				"img" => $img,
				"price" => $price,
				"stock" => $stock
			];
	}


	public function exportGiftList(Request $request, $codigo)
	{

			$headers = [ 'SKU', 'Nombre Producto', 'Color', 'Solicitados', 'Stock', 'Precio', 'Recibidos', 'Recargo', 'Descuento en Lista de Regalo' ];

			$lista = ListaRegalo::where('codigo', $codigo)->first();
			$status = $lista->getState('format');
			$delivery_mode = $lista->entrega == 'recojo_tienda' ? 'Recojo en tienda' : 'Delivery';
			$name = 'Lista Regalo: '.$lista->titulo.' - Estado: '.$status.' - Código: '.$codigo. ' - Modo entrega: '.$delivery_mode;

			$items = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
								->select(
										'productos.sku',
										'productos.nombre',
										'lista_regalo_producto.color',
										'lista_regalo_producto.solicitados',
										'productos.stock',
										'productos.precio',
										'lista_regalo_producto.recibidos',
										'lista_regalo_producto.recargo',																													
										'productos.dsct_lista_regalo'
									)
								->where('lista_regalos_id', '=', $lista->id)
								->getQuery()
								->get()->toArray();

			$downloadName = 'LISTA_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';

			return \Excel::download(new GenericSingleSheet($name, $headers, $items, 'LISTA DE REGALOS'), $downloadName);

	}

	public function exportAccountAndList(Request $request, $account_id)
	{

				$headers = [ 'SKU', 'Nombre Producto', 'Color', 'Solicitados', 'Stock', 'Precio', 'Recibidos', 'Recargo', 'Descuento en Lista de Regalo' ];

				$gift_account = CuentaRegalos::where('id', $account_id)->first();

				$gift_account_lists = $gift_account->listas()->get();

				$results = [];
				$names = [];
				$list_codes = [];

				foreach ($gift_account_lists as $k => $list) {

					$status = $list->getState('format');
					$delivery_mode = $list->entrega == 'recojo_tienda' ? 'Recojo en tienda' : 'Delivery';
					$name = 'Lista Regalo: '.$list->titulo.' - Estado: '.$status.' - Código: '.$list->codigo. ' - Modo entrega: '.$delivery_mode. ' - Cuenta: '.$gift_account->email;
	
					$items = ListaRegaloProducto::join('productos', 'lista_regalo_producto.producto_id', '=', 'productos.id')
										->select(
												'productos.sku',
												'productos.nombre',
												'lista_regalo_producto.color',
												'lista_regalo_producto.solicitados',
												'productos.stock',
												'productos.precio',
												'lista_regalo_producto.recibidos',
												'lista_regalo_producto.recargo',																													
												'productos.dsct_lista_regalo'
											)
										->where('lista_regalos_id', '=', $list->id)
										->getQuery()
										->get()->toArray();

					$results[$k] = $items;
					$names[] = $name;
					$list_codes[] = $list->codigo;

				}

				$download_name = 'LISTA_CUENTA_'.date_create('now')->format('d-m-Y_H:i:s').'.xlsx';

				return (new GiftMultiSheetsByUser($names, $headers, $results, $list_codes))->download($download_name);

	}

	/**
   *
	 * Method to create a new regalos user , activated
	 */
	public function createActivatedRegalosUser(Request $request)
  {
      $this->validate($request, [
				'password' => 'required|min:8',
				'email' => 'unique:cuenta_regalos,email,'.$request->email
      ], [
				'email.required' => 'El campo email es requerido para crear la cuenta de regalos.',
				'email.unique' => 'Ya existe una cuenta de regalos con este correo electronico.',
        'password.required' => 'El campo password es requerido para actualizar la cuenta de regalos.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
			]);
			  
			$cuenta_regalos = new CuentaRegalos();
			$cuenta_regalos->email = $request['email'];
			$cuenta_regalos->password = Hash::make($request['password']);
			$cuenta_regalos->activated_at = date_create('now')->format('Y-m-d H:i:s');
      $cuenta_regalos->save();

			session()->flash('message', ['type' => 'success', 'message' => 'Usuario creado exitosamente y ya se encuentra activado .']);
			
      return redirect()->route('admin.giftregistry.lists', $cuenta_regalos->id);
  }

}

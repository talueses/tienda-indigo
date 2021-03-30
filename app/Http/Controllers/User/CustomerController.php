<?php

namespace App\Http\Controllers\User;

use Session;
use App\Obra;
use App\User;
use App\Orden;
use App\Role;
use App\Pago;
use App\Pais;
use App\Pagina;
use App\Artista;
use App\Producto;
use App\Contacto;
use Carbon\Carbon;
use App\Exposicion;
use App\MetodoPago;
use App\OrdenProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Services\Order\Contracts\OrderContract;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Traits\AuthenticationUsers;

class CustomerController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/cuenta';
    protected $order;

    public function __construct(OrderContract $order)
    {
        $this->order = $order;
    }

    public function account()
    {
        $user = Auth::user();
        $wedding = Auth::guard('boda')->check();

        if($wedding) {
            return redirect()->route('home.giftregistry');
        }

        if ($user!=null && $user->hasRole('Cliente')) {

            $cuenta = Auth::user();

            return view('cuenta.info', compact('user', 'cuenta'));
        }
        return redirect()->route('home.login');
    }

    public function showLogin()
    {
        //Pronto
        //return view('en-construccion');

        if(Auth::guard('boda')->check()) {
            return redirect()->route('home.giftregistry');
        }

        if (Auth::guard()->check()) {
            $user = Auth::guard()->user();

            if ($user->hasRole('Cliente')) {
                return redirect()->route('customer.info');
            }
        }

        /**
         * save the previous page in the session
         */
        $previous_url = Session::get('_previous.url');
        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $ref = rtrim($ref, '/');

        if ($previous_url != url('login'))
        {
            Session::put('referrer', $ref);

            if ($previous_url == $ref)
            {
                Session::put('url.intended', $ref);
            }
        }

        return view('login');
    }

    public function login(Request $request)
    {
        if (Auth::guard()->user())
        {
            $this->guard()->logout();
            $request->session()->invalidate();
        }

        $this->validateLogin($request);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role_id' => 2])) {

            $user = Auth::guard()->user();
            $user->generateToken();

            $data = $user->toArray();

            session(['token' => $data['token']]);

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Overrides method in class 'AuthenticatesUsers'
     *
     * @param Request $request
     * @param $throttles
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles)
        {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated'))
        {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }

        return redirect()->intended(Session::pull('referrer'));

    }

    public function showRegister()
    {
        $paises=Pais::all();
        return view('cuenta.register',compact('paises'));
    }

    public function showPasswordReset()
    {
        return view('cuenta');
    }


    public function showDetalleOrden(Request $request, $id)
    {
        $subtotal = 0;
        $novios = $request->get('novios');
        $historial = []; 
        $metodo_pago = '';

        $detalle_envio = Orden::getDetail($id);

        if($detalle_envio) {

            $pais = Pais::find($detalle_envio->pais_id);
            $usuario = User::find($detalle_envio->usuario);

            $historial['pendiente'] = $detalle_envio->created_at;
            $historial['pagado'] = new Carbon($detalle_envio->payed_at);
            $historial['cancelado'] = new Carbon($detalle_envio->cancelled_at);
            $historial['devuelto'] = new Carbon($detalle_envio->refunded_at);

            $costo_envio = ($detalle_envio->costo_envio) ? $detalle_envio->costo_envio : 0.00;

            $ordenes = OrdenProducto::join('productos', 'orden_producto.producto_id', '=', 'productos.id')
                    ->join('ordenes', 'orden_producto.orden_id', '=', 'ordenes.id')
                    ->leftJoin('lista_regalo', 'orden_producto.lista_regalo_id', '=', 'lista_regalo.id')
                    ->select(
                        'productos.nombre as producto_nombre',
                        // 'productos.precio as precio_unidad',
                        // 'productos.dsct_lista_regalo as dsct',
                        'orden_producto.producto_precio as precio_unidad',
                        'orden_producto.producto_dsct as dsct',
                        'orden_producto.recargo',
                        'orden_producto.cantidad',
                        'orden_producto.color',
                        'lista_regalo_id',
                        'lista_regalo.codigo',
                        'recargo',
                        'orden_producto.producto_dsct',
                        'orden_producto.total',
                        'productos.img'
                      )
                    ->where('orden_id', $id)
                    ->where('user_id', $usuario->id)
                    ->getQuery()
                    ->get();

            foreach ($ordenes as $producto)
            {
              $subtotal += (($producto->precio_unidad - $producto->dsct ) + $producto->recargo) * $producto->cantidad;
            }

            $total = $subtotal + $costo_envio;

            if($detalle_envio->estado == "Pagado")
            {

              $pago = Pago::where('orden_id', $id)->first();
              $metodo_pago = MetodoPago::find($pago->metodo_pago_id)->first();
              $metodo_pago = $metodo_pago->codigo;

            }
 
            return view('cuenta.orden-detalle', compact('ordenes', 'pais', 'detalle_envio', 'usuario', 'subtotal', 'costo_envio', 'total', 'historial', 'metodo_pago'));

        }

        return redirect()->route('cuenta.ordenes');

    }

    public function showOrders(Request $request)
    {

      $user = Auth::user();
      $lista_regalo_guard = Auth::guard('boda')->check();

      if($lista_regalo_guard) {
          return redirect()->route('home.giftregistry');
      }

      if ($user!=null && $user->hasRole('Cliente')) {

          return view('cuenta.ordenes')->withOrdenes($this->order->getByUserId($user->id));//
      }

      return redirect()->route('home.login');

    }

    public function updateDetails(Request $request)
    {

        $this->validate($request, [
          'nombre' => 'required|min:3',
          'apellidos' => 'required|min:3',
          'telefono' => 'required',
           'dni' => 'required',
          'direccion' => 'required|min:3',
        ]);

        $user = User::find(Auth::user()->id);

        $user->name = $request->get('nombre');
        $user->apellidos = $request->get('apellidos');

        $user->telefono1 = $request->get('telefono');
        $user->telefono2 = $request->get('telefono2');
        $user->direccion = $request->get('direccion');
        $user->dni = $request->get('dni');
        $user->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Datos actualizados.']);
        return redirect()->route('customer.info');
    }

    public function showChangePassword(Request $request)
    {
        $user = Auth::user();
        $wedding = Auth::guard('boda')->check();

        if($wedding) {
            return redirect()->route('home.giftregistry');
        }

        if ($user!=null && $user->hasRole('Cliente')) {

            $cuenta = Auth::user();

            return view('cuenta.change-password', compact('user', 'cuenta'));
        }
        return redirect()->route('home.login');

    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
          'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails()) {

            return redirect('cuenta#contrasena')->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->get('password'));
        $user->save();

        session()->flash('message', ['type' => 'success', 'message' => 'Su contraseña fue actualizada.']);
        return redirect()->route('cuenta.changepw');
    }

}

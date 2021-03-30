<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Http\Controllers\Traits\Item;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Traits\AuthenticationUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Producto;
use App\User;
use App\CuentaRegalos;
use App\ListaRegaloProducto;
use App\Http\Controllers\Controller;
use App\Services\Email as EmailService;

use Carbon\Carbon;

use Illuminate\Support\Facades\Password;

class WeddingController extends Controller
{
    use RegistersUsers,AuthenticatesUsers,Item;

    protected $mail;

    public function __construct(EmailService $email)
    {
        $this->mail = $email;
    }

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
        return 'programa-de-regalos/listas/nuevo';
    }

    /**
     * login cuenta novios
     * @param Request
     * @return void
     */
    public function login(Request $request)
    {
        if (Auth::guard()->user()) {
            $this->guard()->logout();
            $request->session()->invalidate();
        }

        $validateData = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($this->guard()->attempt($request->only('email','password'))) {

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
    /**
     * Logout cuenta novios
     */
    public function logout(Request $request)
    {
      try {
          $this->guard()->logout();
          $request->session()->invalidate();
          return redirect('/programa-de-regalos');
      } catch (\Exception $e) {
        return redirect('/programa-de-regalos');
      }

    }

    public function activate(Request $request)
    {

        $token = $request->get('token');
        $email = $request->get('email');

        $cuenta = CuentaRegalos::where('email', $email)->first();

        $success = false;
        $msg = 'hubo un error, su cuenta no pudo activada';


        if (!is_null($cuenta) && !is_null($cuenta->activated_at)) {
           $success = true;
           $msg = 'Su cuenta fue activada anteriormente.';
           return view('listaregalo.activate', compact('success', 'msg', 'cuenta'));
        }

        if (!is_null($cuenta)) {

          if($request->get('token') == $cuenta->token) {

            $success = true;

            $cuenta->activated_at = Carbon::now();
            $cuenta->save();

            $msg = 'Su cuenta está activada, puede iniciar sesión ahora';

            $html = view('mails.giftregistry.registration')->with(['cuenta' => $cuenta, 'token' => $cuenta->token])->render();

            $this->mail->send($html, $cuenta->email, "Correo de bienvenida Galeria Indigo");
          }

        }

        return view('listaregalo.activate', compact('success', 'msg', 'cuenta'));

    }

    /**
     * Register a newly created wedding account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validationRules = [
            'email' => 'required|email|unique:cuenta_regalos',
            'password' => 'required|min:8|confirmed',
        ];

        $validation = Validator::make($request->all(), $validationRules);
        $errors = $validation->errors()->getMessages();

        if ($validation->fails()) {
            return response()->json([
              'success' => false,
              'errors' => $errors
            ]);
         }

        try {
          $cuenta = new CuentaRegalos;
          $cuenta->email = $request->get('email');
          $cuenta->password = Hash::make($request->get('password'));
          $cuenta->activated_at = date_create('now')->format('Y-m-d H:i:s');
          $cuenta->save();

          $this->guard()->login($cuenta);

          //token activate
          $token = Password::getRepository()->create($cuenta);

          $cuenta->token = $token;
          $cuenta->update();
          //dd($token);

          $data = [
            'cuenta' => $cuenta,
            'token' => $token
          ];

          //Enviar Email
          $html = view('mails.giftregistry.registration', $data)->render();
          $this->mail->send($html, $cuenta->email, "Correo de bienvenida Galeria Indigo");

        } catch (\Exception $e) {
            //dd($e->getMessage());
            return response()->json([
                'success' => true,
                'data' => $e->getMessage(),
                'url' => '/programa-de-regalos'
            ]);
        }

        return response()->json([
            'success' => true,
            'url' => '/programa-de-regalos'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'confirm_password' => 'required'
        ]);

        $id = $request->get('id');
        $password = $request->get('password');
        $password_confirmation = $request->get('confirm_password');

        if ($validateData['password'] == $validateData['confirm_password']) {
          $cuenta = CuentaRegalos::find($id);
          $cuenta->password = Hash::make($request->get('password'));
          $cuenta->save();

          session()->flash('message', ['type' => 'success', 'message' => 'Password actualizado.']);
        } else {
          session()->flash('message', ['type' => 'danger', 'message' => 'El password no coincide.']);
        }

        return redirect()->route('home.giftregistry');
    }
}

<?php

namespace App\Http\Controllers\ListaRegaloAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CuentaRegalos;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\ResetsPasswords;

//Auth Facade
use Illuminate\Support\Facades\Auth;

//Password Broker Facade
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Services\Email as EmailService;

class ResetPasswordController extends Controller
{
    //Seller redirect path
    protected $redirectTo = '/programa-de-regalos';

    protected $mail;

    //trait for handling reset Password
    use ResetsPasswords;

    public function __construct(EmailService $email)
    {
        $this->mail = $email;
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('listaregalo.password-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
          $this->validate(request(),[
            'token' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8'
          ]);

          $email = $request->get('email');
          $password = $request->get('password');
          $cuenta_regalos = CuentaRegalos::where('email', $request->all('email'))->first();

          if(!is_null($cuenta_regalos)) {

              $rec = DB::table('lista_regalo_password_resets')
                    ->where('email', $email)
                    ->orderBy('created_at', 'desc')->first();

              if(Hash::check($request->get('token'), $rec->token)) {

                //5min expirado
                $expire = \Carbon\Carbon::parse($rec->created_at)->addSeconds(config('auth.passwords.cuenta_novios.expire')*5)->isPast();

                if (!$expire) {

                  $cuenta_regalos->password = Hash::make($password);
                  //$cuenta_regalos->setRememberToken(Str::random(60));
                  if ($cuenta_regalos->save()) {
                    return back()->with('status', 'Se ha actualizado la contraseña.');
                  }

                } else {
                    return back()->with('error', 'El token ha expirado.');
                }

              } else {
                return back()->with('error', 'El token no es válido.');
              }

          }

          return back()->with('error', 'No se pudo actualizar la contraseña.');

    }

    /**
     * Confirmar cuenta.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmAccount(Request $request)
    {
        //dd($request->all());
        $email = $request->get('email');
        $token = $request->get('user_token');

        $cuenta = CuentaRegalos::where('email', $email)->first();
        $cuenta->token = $token;
        $cuenta->save();

        $data = [
          'email' => $email,
          'token' => $token
        ];

        //Enviar Email
        $html = view('mails.giftregistry.confirm', $data)->render();
        /*echo $html;
        exit;*/
        $this->mail->send($html, $email, "Correo de bienvenida Galeria Indigo");

        $url = '/programa-de-regalos/activate?token='.$token.'&email='.$email;

        session()->flash('message', ['type' => 'success', 'message' => 'Se envió un correo de confirmación.']);
        return redirect()->back();
    }

    //returns Password broker of cuenta_novios
    public function broker()
    {
        return Password::broker('cuenta_novios');
    }

    //returns authentication guard
    protected function guard()
    {
        return Auth::guard('boda');
    }
}

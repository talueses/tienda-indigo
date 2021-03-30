<?php

namespace App\Http\Controllers\ListaRegaloAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CuentaRegalos;
use Illuminate\Support\Facades\DB;

//Trait
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

//Password Broker Facade
use Illuminate\Support\Facades\Password;
use App\Services\Email as EmailService;

class ForgotPasswordController extends Controller
{
    //Sends Password Reset emails
    use SendsPasswordResetEmails;

    public function __construct(EmailService $email)
    {
      $this->mail = $email;
    }

    //Shows form to request password reset
    public function showLinkRequestForm()
    {
        return view('listaregalo.password-email');
    }

    public function broker()
    {
         return Password::broker('cuenta_novios');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $cuenta_novios = CuentaRegalos::where('email', $request->email)->first();

        if (!$cuenta_novios ) {
              return back()->with('status', 'La cuenta que ha ingresado no existe.');
        } else {
              $token = Password::getRepository()->create($cuenta_novios);

              DB::table('lista_regalo_password_resets')->insert(
                  ['email' => $cuenta_novios->email, 'token' => \Hash::make($token), 'created_at' => \Carbon\Carbon::now()]
              );

              $link = url('programa-de-regalos/password/reset', $token).'?email='.urlencode($cuenta_novios->email);
              
              $html = view('mails.user.password-reset', compact('link', 'token'))->render();
              $response = $this->mail->send($html, $user->email, "Restablecimiento de contraseña");

              if ($token) {
                  return back()->with('status', 'Se ha enviado un email a su cuenta.');
              }
        }
    }
}

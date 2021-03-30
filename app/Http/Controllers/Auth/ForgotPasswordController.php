<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;

use App\Services\Email as EmailService;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailService $email)
    {
        $this->mail = $email;
        $this->middleware('guest');
    }

    public function showLinkRequestFormClient()
    {
        return view('cuenta.password-email');
    }

    public function sendResetLinkEmailClient(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user ) {
            return back()->with('status', 'La cuenta que ha ingresado no existe.');
        } else {
            $token = Password::getRepository()->create($user);
            $link = url('password/reset', $token).'?email='.urlencode($user->email);
            //Enviar Email
            $html = view('mails.user.password-reset', compact('link', 'token'))->render();
            $response = $this->mail->send($html, $user->email, "Restablecimiento de contraseña");

            if ($token) {
                return back()->with('status', 'Se ha enviado un email a su cuenta.');
            }

        }
    }
}

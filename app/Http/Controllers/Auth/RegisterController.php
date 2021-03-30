<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

use App\Services\Email as EmailService;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    private $email;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function validateClient(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni'   => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

            'telefono1' => 'required',
            'direccion' => 'required|string',
            'ciudad' => 'required|string',
            'pais' => 'required|string',

            'accept_terms' => 'required',
        ];

        $messages = [
            'name.required'         => 'Este campo es requerido.',
            'apellidos.required'    => 'Este campo es requerido.',
            'dni.required'          => 'Este campo es requerido.',
            'email.required'        => 'Ingrese su email.',
            'email.email'           => 'Hay un problema con su dirección de correo electrónico.',
            'email.unique'            => 'Este correo ya se encuentra registrado.',
            'password.required'     => 'Ingrese su contraseña.',
            'password.min'          => 'Su contraseña debe ser de al menos 6 caracteres.',

            'telefono1.required'    => 'Ingrese un teléfono donde podamos contactarlo.',
            'direccion.required'    => 'Direccion es requerido.',
            'ciudad.required'       => 'Ingrese Ciudad.',
            'pais.required'         => 'Ingrese País.',

            'accept_terms.required' => 'Debe aceptar términos y condiciones antes de registrarse.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerAdmin(Request $request)

    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->createAdmin($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user);
    }

    public function registerClient(Request $request)
    {
    
        $this->validateClient($request->all())->validate();

        event(new Registered($user = $this->createUser($request->all())));

        $this->guard()->login($user);

        $user->generateToken();

        //Enviar Email
        $html = view('mails.user.registration', compact('user'))->render();
        $this->mail->send($html, $user->email, "Correo de bienvenida Galeria Indigo");

        return redirect('/cuenta');
    }

    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return redirect('/admin');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createAdmin(array $data)
    {
        $role = Role::find(1); //Admin
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $role->id
        ]);
    }

    protected function createUser(array $data)
    {
        $role = Role::find(2);
        return User::create([
            'name' => $data['name'],
            'apellidos' => $data['apellidos'],
            'dni'   =>  $data['dni'],
            'telefono1' => $data['telefono1'],
            'telefono2' => $data['telefono2'],
            'direccion' => $data['direccion'],
            'ciudad' => $data['ciudad'],
            'pais' => $data['pais'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $role->id
        ]);
    }
}

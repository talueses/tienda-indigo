@extends('layouts.admin-auth')

@section('content')
<div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-body">

        <div class="text-center mb-3">
            <img class="img-fluid center" src="{{ asset('media/indigo_logo.png') }}" alt="">
        </div>

        <form method="POST" action="{{ route('login') }}">
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">Dirección de correo electrónico</label>
            <input class="form-control" type="email" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
          </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password">Contraseña</label>
            <input class="form-control" id="password" type="password" placeholder="Password" name="password" required>

              @if ($errors->has('password'))
                  <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
          </div>

          <div class="form-group">
            <div class="form-check pl-0">
              <label class="form-check-label">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Mantener sesión activa </label>
            </div>
          </div>

          <div class="mb-3">
            <a class="d-block" href="{{ route('password.request') }}">He olvidado mi contraseña</a>
          </div>

          <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
        </form>

      </div>
    </div>
  </div>
@endsection

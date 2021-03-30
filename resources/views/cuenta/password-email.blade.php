@extends('layouts.front', ['subtitle'=>'Registro'])
@section('contenido')
@include('partials.banner')

<div class="container">

        <div class="row">

            <div class="col-md-6 offset-md-3">

                <div class="card my-4">
                    <div class="card-body">

                        <h4 class="pb-3">Restablecer contraseña</h4>

                        @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('customer.password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">Dirección de correo electrónico</label>

                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('home.login') }}">Volver a Inicio de sesión</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-outline-secondary linear float-right">Enviar</button>
                        </div>
                    </div>                    
                </div>
            </form>

                    </div>
                </div>
            </div>
        </div>

</div>
@endsection

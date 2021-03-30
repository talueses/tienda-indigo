@extends('layouts.admin-auth')

@section('content')
<div class="container">
 
    <div class="card card-login mx-auto mt-5">
        
        <div class="card-body">

            <div class="text-center mb-3">
                <img class="img-fluid center" src="{{ asset('media/indigo_logo.png') }}" alt="">
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
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
                            <a href="{{ route('login') }}">Volver a Inicio de sesión</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary float-right">Enviar</button>
                        </div>
                    </div>                    
                </div>
            </form>
        </div>
    </div>    

</div>
@endsection

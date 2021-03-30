@extends('layouts.front', ['subtitle'=>'Restablecer contraseña Lista Regalo'])
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

            <p>Ingresa el correo electrónico el cual fue registrado la lista regalo. Se enviará un link de reestablecimiento de contraseña.</p>

            <form class="form-horizontal" method="POST" action="{{ route('listaregalo.password.email') }}">
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
                            <small><a href="{{ route('giftregistry.lists') }}"><i class="fa fa-arrow-left mr-2"></i>Volver a Lista de Regalo</a></small>
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

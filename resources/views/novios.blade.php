@extends('layouts.front', ['subtitle'=>'Programa de regalos'])
@section('contenido')
@include('partials.banner')
<div class="container contenido bg-white">

  @include('listaregalo.layouts.session')

  <div class="row">
    @if(!isset($cuenta))
    <div class="col-12">
      <h2>Programa de regalos</h2>
      @if(isset($programa_novios_description))
        <p>{{ $programa_novios_description }}</p>
      @endif
    </div>
    <div class="col-12 mt-4">
      <div class="row justify-content-around">
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header bg-white">
              <ul class=" nav nav-tabs card-header-tabs">
                <li class="nav-item">
                  <h5 data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true" class="nav-link active m-0 subtitle text-secondary">Ingresar</h5>
                </li>
                <li class="nav-item">
                  <h5 data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="true" class="nav-link m-0 subtitle text-secondary">Registrarte</h5>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-home-tab">
                  <form class="form-novios" action="{{ route('home.novios.login') }}" method="post" autocomplete="off">

                    {{ csrf_field() }}
                    <p class="text-left">Si ya tienes una cuenta, ingresa con tu código para administrar tu lista de regalos.</p>
                    <div class="form-group">
                      <input type="text" class="form-control subtitle" value="{{ old('email') }}" placeholder="Email" name="email">
                      @if ($errors->has('email'))
                          <span class="help-block">
                              <small class="text-danger">{{ $errors->first('email') }}</small>
                          </span>
                      @endif
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control subtitle" placeholder="Contraseña" name="password" autocomplete="new-password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <small class="text-danger">{{ $errors->first('password') }}</small>
                          </span>
                      @endif
                    </div>
                    <div class="form-group mb-0">
                      <div class="mb-1">
                        <small><a class="d-block" href="{{ route('listaregalo.password.request') }}">He olvidado mi contraseña</a></small>
                      </div>
                      <button type="submit" class="btn btn-outline-secondary linear w-50 py-2 my-2">Ingresar</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-profile-tab">
                  <form id="form-novios-register" class="form-novios" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <p class="text-justify">Si aún no tienes una cuenta, regístrate para crear una lista de regalos.</p>

                    <div class="form-group">
                      <input type="email" class="form-control subtitle" placeholder="correo electrónico" required name="email" autocomplete="off"  value="{{ old('email') }}">
                      <span class="help-block">
                          <small class="text-danger"></small>
                      </span>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control subtitle" required placeholder="ingrese contraseña" name="password" autocomplete="off">
                      <span class="help-block">
                          <small class="text-danger"></small>
                      </span>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control subtitle" required  placeholder="ingrese contraseña nuevamente" name="password_confirmation">
                      <span class="help-block">
                          <small class="text-danger"></small>
                      </span>
                    </div>
                    <div class="form-group mb-0">
                      <button type="submit" class="btn btn-outline-secondary linear w-50 py-2 my-2"><p class="m-0 subtitle">Registrarse</p></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <h4 class="subtitle text-secondary">Buscar lista de regalos</h4>
          <div class="card mt-4">
            <div class="card-body">
              <p class="text-justify">Ingresa el código de la lista de regalos para mostrar sus productos.</p>
              <form class="" action="{{ route('home.novios.search') }}" method="get">
                <div class="input-group">
                  <input type="text" class="form-control subtitle" name="codigo" placeholder="">
                  <button class="input-group-append btn btn-inverse linear bg-dark text-white px-4" type="submit">Buscar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @elseif(auth('boda')->check())
        @include('partials.listaregalo.auth-lista-regalo')
    @endif
  </div>
</div>
@include('partials.modal-add-cart')

@include('partials.modal-add-gift')

@include('partials.modal-client-gift')

@endsection

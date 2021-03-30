@extends('layouts.front', ['subtitle'=>'Cuenta de Programa de Regalos'])
@section('contenido')
@include('partials.banner')

<div class="container contenido">

@include('listaregalo.layouts.session')

<div class="card">
  <div class="card-body">
    <div class="row no-gutters">

      <div class="col-md-3">

        @include('listaregalo.partials.menu')

      </div>

      <div class="col-md-9">

        <div class="" style="border-left: 1px solid #dfdfdf">
          <div class="card-body customer-body">

            <h4 class="card-title">Mi Información - <span class="badge badge-light" style="background-color:#F1EBCD;">Programa de Regalos</span></h4>

            <div class="row">

              <div class="col-lg-6">

                <!-- cuenta -->
                <form class="" action="{{ route('giftregistry.updatepassword') }}" method="POST">

                  {{ csrf_field() }}

                  <input type="hidden" name="id" value="{{ $cuenta->id }}">

                  <div class="form-group">
                      <label for="nombre" class="col-form-label">Email</label>
                      <div>
                      <input class="form-control" type="text" name="email" value="{{ $cuenta->email }}" disabled>
                      </div>
                  </div>
                  <span class="badge badge-light" style="background-color:#F1EBCD;">
                    <p class="font-weight-bold">** Si desea actualizar su contraseña, digitela nuevamente.</p>
                  </span>
                  <div class="form-group">
                      <label for="nombre" class="col-form-label">Nueva contraseña</label>
                      <div>
                      <input class="form-control" type="password" name="password">
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="nombre" class="col-form-label">Confirmar contraseña</label>
                      <div>
                      <input class="form-control" type="password" name="confirm_password">
                      </div>
                  </div>

                  <button type="submit" class="btn btn-outline-secondary black linear mt-3">Actualizar</button>


                </form>
                <!-- / cuenta -->

              </div>

            </div>

          </div>
        </div>

      </div>


      </div>

    </div>
  </div>
</div>

@endsection

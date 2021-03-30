@extends('layouts.front', ['subtitle'=>'Cuenta'])
@section('contenido')
@include('partials.banner')


<div class="container contenido">


  @include('cuenta.layouts.session')


  <div class="card">
    <div class="card-body customer-body">


          <div class="row no-gutters">

              <div class="col-md-3">

                @include('cuenta.partials.menu')

              </div>

                <div class="col-md-9">

                  <div class="" style="border-left: 1px solid #dfdfdf">
                    <div class="card-body">

                        <h4 class="card-title">Cambiar contraseña</h4>

                        <div class="row">

                            <div class="col-md-12">

                                <!-- cuenta -->
                                <form action="{{route('cuenta.changepw')}}" method="POST">
                                  {{ csrf_field() }}

                                  <div class="form-group">
                                      <label for="nombre" class="col-form-label">Nueva contraseña</label>
                                      <div>
                                      <input class="form-control" type="password" name="password">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label for="nombre" class="col-form-label">Confirmar contraseña</label>
                                      <div>
                                      <input class="form-control" type="password" name="password_confirmation">
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

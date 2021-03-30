@extends('layouts.front', ['subtitle'=>'Cuenta'])
@section('contenido')
@include('partials.banner')


<div class="container contenido">


  @include('cuenta.layouts.session')


  <div class="card">
    <div class="card-body">


          <div class="row no-gutters">

              <div class="col-md-3">

                @include('cuenta.partials.menu')

              </div>


                <div class="col-md-9">

                  <div class="" style="border-left: 1px solid #dfdfdf">
                    <div class="card-body customer-body">

                        <h4 class="card-title">Mis datos</h4>

                        <div class="row">

                            <div class="col-md-12">

                                <!-- cuenta -->
                                    <form class="" action="{{route('cuenta.updtdetails')}}" method="POST">

                                      {{ csrf_field() }}
                                      <div class="row">
                                        <div class="col-6">
                                          <div class="form-group">
                                              <label for="nombre" class="col-form-label">Nombre</label>
                                              <div>
                                              <input class="form-control" type="text" name="nombre" value="{{ $user->name }}">
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                              <label for="nombre" class="col-form-label">Apellidos</label>
                                              <div>
                                              <input class="form-control" type="text" name="apellidos" value="{{ $user->apellidos }}">
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                          <label for="nombre" class="col-form-label">Email</label>
                                          <div>
                                          <input class="form-control" type="text" name="email" value="{{ $user->email }}" disabled>
                                          </div>
                                      </div>

                                      <div class="row">
                                        <div class="col-6">
                                          <div class="form-group">
                                              <label for="nombre" class="col-form-label">Teléfono</label>
                                              <div>
                                              <input class="form-control" type="text" name="telefono" value="{{ $user->telefono1 }}">
                                              </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <div class="form-group">
                                              <label for="nombre" class="col-form-label">Teléfono 2</label>
                                              <div>
                                              <input class="form-control" type="text" name="telefono2" value="{{ $user->telefono2 }}">
                                              </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                          <label for="nombre" class="col-form-label">Dirección</label>
                                          <div>
                                          <input class="form-control" type="text" name="direccion" value="{{ $user->direccion }}">
                                          </div>
                                      </div>
                                      
                                      <div class="form-group">
                                          <label for="nombre" class="col-form-label">DNI</label>
                                          <div>
                                          <input class="form-control" type="text" name="dni" value="{{ $user->dni }}">
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

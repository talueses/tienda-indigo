@extends('layouts.front', ['subtitle'=>'Cuenta'])
@section('contenido')
@include('partials.banner')

<div class="container contenido">

  @include('listaregalo.layouts.session')

  <div class="card">
    <div class="card-body customer-body">


          <div class="row no-gutters">

              <div class="col-md-3">

                @include('listaregalo.partials.menu')

              </div>


                <div class="col-md-9">

                  <div class="" style="border-left: 1px solid #dfdfdf; min-height: 300px;">
                    <div class="card-body">

                        <h4 class="card-title">Mis Listas</h4>

                        <div class="row">

                            <div class="col-md-12">
                                <!-- listas -->
                                <div class="table-responsive table-c-review">
                                  @if(!$listas->isEmpty())

                                    <table class="table" width="100%" cellspacing="0">
                                        <thead>
                                          <tr>
                                            <th width="10%">Código</th>
                                            <th>Evento</th>
                                            <th>Fecha del Evento</th>
                                            <th>Estado</th>
                                            <th></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($listas as $lista)
                                          <tr>
                                            <td>{{ $lista->codigo }}</td>
                                            <td>{{ $lista->titulo }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lista->fecha)->format('m/d/Y') }}</td>
                                            <td>
                                                <span class="badge {{ $lista->getBadge() }}">{{ $lista->getState('format') }}</span>
                                            </td>
                                            <td>

                                              <div class="btn-group float-right">
                                                <a href="{{ route('giftregistry.showList', $lista->codigo) }}">Ver detalles</a>
                                              </div>

                                            </td>
                                          </tr>
                                          @endforeach
                                        </tbody>
                                      </table>

                                  @else
                                    <div>
                                      <p>No existen listas.</p>
                                    </div>
                                  @endif

                                </div>
                                <!-- / listas -->
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

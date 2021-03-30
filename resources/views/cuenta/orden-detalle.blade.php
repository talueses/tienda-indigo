@extends('layouts.front', ['subtitle'=>'Cuenta'])
@section('contenido')
@include('partials.banner')
<div class="container contenido">

  <div class="card">
    <div class="card-body customer-body">

      <div class="row no-gutters">

        <div class="col-md-3">
          @include('cuenta.partials.menu')
        </div>

        <div class="col-md-9">

          <div class="" style="border-left: 1px solid #dfdfdf">
            <div class="card-body">

                <div class="row mt-5"><!-- BEGIN ORDER MSG -->

                    <div id="success_form" class="col-12 col-sm-12 mx-auto text-center" style="display:none;">
                      <i class="far fa-check-circle fa-4x text-success"></i>
                      <h3 class="title2 mt-3 text-success">¡Gracias por su compra!</h3>
                      <h5 class="h6" id="success_form_response">Se ha procesado el pago satisfactoriamente. Hemos enviado un mensaje a su correo con la información detallada de la orden. Si no logra visualizar el mensaje, asegúrese de revisar su carpeta SPAM.</h5>
                      <br>
                    </div>

                    <div id="error_form" class="col-12 col-sm-12 mx-auto text-center" style="display:none;">
                      <i class="fa fa-exclamation-circle fa-4x text-danger"></i>
                      <h3 class="title2 mt-3 text-danger">No se pudo completar la transacción</h3>
                      <h5 class="h6" id="error_form_response">Ha ocurrido un error, por favor intentelo de nuevo.</h5>
                      <br>
                    </div>

                </div><!-- END ORDER MSG -->

                <div id="detail_section"><!-- BEGIN DETAIL SECTION  -->
                      <h4 class="card-title">Resumen de orden</h4>

                      <input type="hidden" id="orden_id" value="{{$detalle_envio->orden_id}}"></input>

                      <div class="d-none">
                          <input {{ $detalle_envio->entrega == 'recojo_tienda' ? 'checked' : '' }} type="radio" name="modo_entrega" id="modo_tienda" value="recojo_tienda">

                          <input {{ $detalle_envio->entrega == 'delivery' ? 'checked' : '' }}  type="radio" name="modo_entrega" id="modo_delivery" value="delivery">

                          <input id="modo_factura" type="checkbox" name="modo_factura" {{ $detalle_envio->factura ? 'checked' : '' }}>

                          <input id="ruc" value="{{ $detalle_envio->ruc }}">
                          <input id="razon_social" value="{{ $detalle_envio->razon_social }}">

                          <input id="envio_departamento" type="text" value="{{ $detalle_envio->departamento }}">
                          <input id="envio_direccion" type="text" value="{{ $detalle_envio->direccion }}">

                      </div>

                      @if($detalle_envio->estado == 'Pendiente')
                      <div class="alert alert-warning" role="alert">
                        Casi terminado! Por favor haga click en "Completar Pago" para finalizar la compra.
                      </div>
                      @endif

                      @if($detalle_envio->estado == 'Calculando')
                      <div class="alert alert-warning" role="alert">
                        Casi terminado! El costo de envío sera enviado en los próximos días a su correo electrónico.
                      </div>
                      @endif

                      <div class="d-flex mb-2">
                        <h6 class="m-0 mr-2">Estado:</h6>
                        <span class="badge {{ $detalle_envio->getOrderBadge() }}"> {{ $detalle_envio->getOrderStatus() }} </span>
                      </div>

                      <div class="d-flex mb-2">
                        <h6 class="m-0 mr-2">Fecha de orden:</h6> <span style="font-size: 0.88em;">{{ $detalle_envio->created_at }}</span>
                      </div>

                      <div class="row">

                        <div class="col-md-6">
                            <!-- detalles entrega -->
                            <div class="card">
                              <div class="card-body" style="min-height: 170px;">

                                  <h6 class="card-title">Detalles de entrega</h6>
                                  <p class="card-text">

                                    @if($detalle_envio->direccion)<strong>Direccion:</strong> {{ $detalle_envio->direccion }} <br>@endif
                                    @if($detalle_envio->departamento)<strong>Departamento:</strong> {{ $detalle_envio->departamento }} <br> @endif
                                    @if($pais)<strong>Pais:</strong>{{ $pais->nombre }} @endif

                                  </p>
                                  @if($detalle_envio->tracking)<!-- BEGIN TRACKING -->
                                    <div class="external-link">
                                        <span class="badge badge-success"> Seguimiento <i class="fas fa-chevron-right" aria-hidden="true"></i> </span>
                                        <span class="badge badge-light">
                                          <a href="{{ $detalle_envio->tracking }}" target="_blank"> Ver tracking <i class="fas fa-external-link-alt"></i></a>
                                        </span>
                                    </div>
                                  @endif<!-- END TRACKING -->
                              </div>
                            </div>
                            <!-- / detalles entrega -->
                        </div>

                        <div class="col-md-6">
                            <!-- detalles entrega -->
                            <div class="card">
                              <div class="card-body" style="min-height: 170px;">

                                  <h6 class="card-title">Método de pago</h6>
                                  <p class="card-text">
                                    @if($detalle_envio->estado == 'Pagado')
                                     <strong> Tipo de Tarjeta:</strong> {{ ucfirst($metodo_pago) }}
                                      <br>
                                      <strong># Tarjeta:</strong>  {{ $detalle_envio->card }}
                                    @else
                                      No definido
                                    @endif
                                  </p>

                              </div>
                            </div>
                            <!-- / detalles entrega -->
                        </div>

                      </div>

                      <hr class="my-4">

                      <div class="row">

                        <div class="col-md-12">
                            <!-- resumen orden -->
                            <div class="card">
                              <div class="card-body">
                                  <div class="table-responsive table-c-review">
                                    <table class="table" width="100%" cellspacing="0">
                                      <thead>
                                        <tr>
                                          <th> &nbsp; </th>
                                          <th width="30%">Nombre del Producto</th>
                                          <th> Precio Unitario </th>
                                          <th> Recargo </th>
                                          <th> Cantidad </th>
                                          <th> Total </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($ordenes as $producto)
                                          <tr>
                                            <td>
                                              @if ($producto->img)
                                                <img src="/uploads/products/80x80_{{ $producto->img }}" alt="" height="80" width="80" style="object-fit: cover;">
                                              @else
                                                <img class="img-list-default" alt="">
                                              @endif
                                            </td>
                                            <td>
                                              {{ $producto->producto_nombre ." ". ucfirst($producto->color) }}
                                              @if (isset($producto->lista_regalo_id) )
                                              <br>
                                              <span>Lista Regalo: {{ $producto->codigo }}</span>
                                              <br>
                                                @if($producto->recargo > 0)
                                                  <span class="text-danger">Este producto tiene recargo por envio a domicilio </span>
                                                @endif
                                              @endif
                                            </td>
                                            <td>
                                              @if ($producto->dsct!=0)
                                                <small style="color: black"><strike>{{ getCurrencySign() . number_format($producto->precio_unidad, 2) }} </strike><br></small>
                                                <small style="color: red">- {{ getCurrencySign() . number_format($producto->dsct, 2) }}</small> <br>
                                                <small style="color: #5c116e;">{{ getCurrencySign() . number_format($producto->precio_unidad-$producto->dsct, 2) }} </small>
                                              @else
                                                <small style="color: black">{{ getCurrencySign() . number_format($producto->precio_unidad, 2) }} <br></small>
                                              @endif

                                            </td>
                                            <td>
                                              {{ getCurrencySign() . number_format($producto->recargo, 2) }}
                                            </td>
                                            <td>{{ $producto->cantidad }}</td>
                                            <td class="total_product_price">{{ getCurrencySign() . number_format((($producto->precio_unidad-$producto->dsct) + $producto->recargo) * $producto->cantidad, 2)  }}</td>
                                          </tr>

                                        @endforeach
                                        <tr style="border-top: 2px solid #b5b5b5;">
                                          <td colspan="4"></td>
                                          <td style="color: #444444;"><b>Subtotal</b></td>
                                          <td>{{ getCurrencySign() . number_format($subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                          <td colspan="4"></td>
                                          <td style="color: #444444;"><b>Envio</b></td>
                                          <td>
                                            @if($detalle_envio->costo_envio)
                                              {{ getCurrencySign() . number_format($detalle_envio->costo_envio, 2) }}
                                            @elseif($detalle_envio->estado == 'Pagado' && !$detalle_envio->costo_envio)
                                              {{ getCurrencySign() . '0.00'}}
                                            @else
                                              <span class="text-danger">Por confirmar</span>
                                            @endif
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="4"></td>
                                          <td style="color: #444444;"><b>Total</b></td>
                                          <td><span class="order-total">{{ getCurrencySign() . number_format($total, 2) }}</span></td>
                                        </tr>
                                      </tbody>
                                    </table>

                                    <div class="float-right">
                                        @if($detalle_envio->estado == 'Pendiente' && !is_null($detalle_envio->costo_envio))
                                            <button id="u_btn_checkout" class="continue btn btn-danger linear py-2 my-2"><p class="text-uppercase m-0 font-weight-bold" style="font-size: 13px;">Completar Pago</p></button>
                                        @endif
                                    </div>

                                  </div>

                              </div>
                            </div>
                            <!-- / resumen orden -->

                      </div><!-- END DETAIL SECTION -->

                  </div>

                  <div class="col-md-6">

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

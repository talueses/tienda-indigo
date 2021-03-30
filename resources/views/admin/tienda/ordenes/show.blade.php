@extends ('admin.layouts.master')

@section ('content')

<div  id="printto" class="container-fluid">
      <div class="page-head">
        <h2 class="page-title float-left">Orden Detalle </h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
          </ul>
        </div>
      </div>

      <!-- Breadcrumbs-->
      <ol class="breadcrumb d-print-none p-0">
        <li class="breadcrumb-item">
          <a href="{{ route('admin.orders') }}">Ordenes</a>
        </li>
        <li class="breadcrumb-item active">Orden Detalle</li>
      </ol>

      <div class="card mb-3 seccion">
    
        <div class="card-body">

          @if(is_null($detalle_envio->costo_envio) && ($detalle_envio->estado == 'Pendiente') || is_null($detalle_envio->costo_envio) && ($detalle_envio->estado == 'Calculando'))
          <div class="alert alert-warning" role="alert">
            <i class="fa fa-exclamation-triangle"></i> Falta confirmar costo de envio
          </div>
          @endif

          <h4 class="font-weight-bold">
            Orden #{{$detalle_envio->orden_id}}
            @if($detalle_envio->estado=='Pagado')
            <span class="btn-group float-right">
                <!-- @if($detalle_envio->estado!='Cancelado' ) -->
                <form class="form-inline d-print-none" action="{{ route('admin.order.delivered', $detalle_envio->orden_id) }}" method="post">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-action bg-warning text-white"><i class="fas fa-exclamation-triangle"></i> Marcar entregado </button>
                </form>
            <!-- @endif -->
            </span>
            @endif  
          </h4>

          <div class="clearfix">

            <div class="float-left">

              {{-- <span class="text-primary mr-4" style="cursor:pointer;text-decoration:underline;" id="imprimir">Imprimir</span>  --}}
              <span class="text-primary mr-4" style="cursor:pointer;text-decoration:underline;" onclick="window.print();">Imprimir</span>
              <!-- <a href="{{ route('admin.order.imprimir', $detalle_envio->orden_id)}}"> <span class="text-primary mr-4" style="cursor:pointer;text-decoration:underline;">Imprimir</span></a> -->


              @if($detalle_envio->estado == 'Pendiente' || $detalle_envio->estado == 'Calculando')
              <div class="btn-group">
                <button type="button" class="btn btn-action dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Más acciones
                </button>
                <div class="dropdown-menu">
                  <form class="form-inline d-print-none" action="{{ route('admin.order.cancel', $detalle_envio->orden_id) }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="accion" value="cancelar">
                    <button type="submit" class="dropdown-item bg-danger text-white"><i class="fas fa-exclamation-triangle"></i> Cancelar orden</button>
                  </form>
                </div>
              </div>
              @endif

            </div>

          </div>

          <br>

          <p>
            <b>Estado:</b>
            <span class="badge {{ $detalle_envio->getOrderBadge() }}"> {{ $detalle_envio->getOrderStatus() }} </span>
            <br>
            <b>Fecha de orden:</b> {{ $detalle_envio->created_at }}
            @if(!is_null($detalle_envio->delivery_at))
            <br>
            <b>Entregado:</b> {{ $detalle_envio->delivery_at }}
            @endif
            @if($detalle_envio->tracking)<!-- BEGIN TRACKING -->
              <div class="external-link">
                  <span class="badge badge-success"> Seguimiento <i class="fas fa-chevron-right" aria-hidden="true"></i> </span>
                  <span class="badge badge-light">
                    <a href="#"> Ver tracking <i class="fas fa-external-link-alt"></i></a>
                  </span>
              </div>
            @endif<!-- END TRACKING -->
          </p>

          <div class="row">
            @if($detalle_envio->estado == 'Pendiente' || $detalle_envio->estado == 'Calculando')
            <div class="col-6"> <!-- BEGIN SHIPPING COST -->

              <div class="clearfix d-print-none"> 
                <div class="float-left">

                    <h6 class="font-weight-bold">Costo de envio</h6>

                    <form class="form-inline d-print-none" action="{{ route('admin.order.updateShipCost', $detalle_envio->orden_id) }}" method="post">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <input type="text" class="form-control mr-sm-3" name="costo_envio" value="{{ $detalle_envio->costo_envio }}">
                      </div>

                      <button type="submit" class="btn btn-primary">Actualizar Costo de Envio</button>
                    </form>

                </div>
              </div>
            </div> <!-- END SHIPPING COST-->
            @endif
            <div class="col"> <!-- BEGIN TRACKING UPDATE -->

                <div class="clearfix d-print-none">
                  <div class="float-left">

                      <h6 class="font-weight-bold"> Tracking </h6>

                      <form class="form-inline d-print-none" action="{{ route('admin.order.updateTracking', $detalle_envio->orden_id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <input type="text" class="form-control mr-sm-3" name="tracking" value="{{ $detalle_envio->tracking }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar Tracking</button>
                      </form>

                  </div>
                </div>

            </div> <!-- END TRACKING UPDATE -->

          </div>

          <br>

          <h5 class="font-weight-bold">Detalles de Entrega</h5>
          <table  id="detalleentrega" style="border-collapse: collapse;width: 100%;">
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Tipo de entrega:</b> {{ ($detalle_envio->entrega == 'delivery') ? 'Delivery' : 'Recojo en tienda' }}</td>
                {{--<td><b>Departamento:</b> {{ ($detalle_envio->departamento) ? $detalle_envio->departamento : '--' }}</td>--}}
              </tr>
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Pais:</b> {{ isset($name_pais->nombre) ? $name_pais->nombre : '--' }}</td>
                <td><b>Departamento:</b> {{ ($name_depto) ? $name_depto : '--' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>Distrito:</b> {{ ($detalle_envio->distrito) ? $detalle_envio->distrito : '--' }}</td>
                <td><b>Direccion:</b> {{ ($detalle_envio->direccion) ? $detalle_envio->direccion : '--' }}</td>

              </tr>
          </table>

          <br>

          <h5 class="font-weight-bold">Detalles del Cliente</h5>

          <table style="border-collapse: collapse;width: 100%;">
              {{--z<tr style="height: 40px;">
                <td style="width: 50%;"><b>Correo electr&oacute;nico:</b> {{ isset($usuario->email) ? $usuario->email : '' }}</td>
                <td><b>Direcci&oacute;n:</b> {{ isset($usuario->direccion) ? $usuario->direccion : '' }}</td>
              </tr>--}}
              <tr style="height: 40px;">
                <td><b>Nombres:</b> {{ isset($usuario->name) ? $usuario->name : '' }}</td>
                <td><b>Email:</b> {{ isset($usuario->email) ? $usuario->email : '' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>Apellidos:</b> {{ isset($usuario->apellidos) ? $usuario->apellidos : '' }}</td>
                <td><b>Ciudad:</b> {{ isset($usuario->ciudad) ? $usuario->ciudad : '' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>Tel&eacute;fono:</b> {{ isset($usuario->telefono1) ? $usuario->telefono1 : '' }}</td>
                <td><b>Pa&iacute;s:</b> {{ isset($usuario->pais) ? $usuario->pais : '' }}</td>
              </tr>
              <tr style="height: 40px;">
                <td><b>DNI:</b> {{ isset($usuario->dni) ? $usuario->dni : '' }}</td>
                <td><b>Direccion:</b> {{ isset($usuario->direccion) ? $usuario->direccion : '' }}</td>
              </tr>

          </table>

          <br>

          <h5 class="font-weight-bold">Método de Pago</h5>

          <table style="border-collapse: collapse;width: 100%;">
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Tipo de Tarjeta:</b> {{ ucfirst($metodo_pago) }}</td>
                <td><b>Tarjeta:</b><h2>
                  @if ( $ordenes[0]->card!=null)
                  <strong class="text-info">**** **** **** {{ $ordenes[0]->card }}</strong>
                @endif  </h2> </td>
              </tr>
          </table>
          <hr>

            <!-- Datos de Factura -->
          <br>
          <h5 class="font-weight-bold">Información de facturación.</h5>
          <table style="border-collapse: collapse;width: 100%;">
              <tr style="height: 40px;">
                <td style="width: 50%;"><b>Número de RUC:</b> {{ $ordenes[0]->ruc }}</td>
                <td style="width: 50%;"><b>Razón social:</b> {{ $ordenes[0]->social_name }}</td>
              </tr>
          </table>
          <hr>


          <!-- resumen orden -->
          <div class="card">
            <div class="card-body">
                <div class="table-responsive table-c-review">
                  <table class="table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th width="10%">&nbsp;</th>
                        <th>SKU</th>
                        <th width="40%">Nombre del Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($ordenes as $producto)       
                        <tr>
                          <td>
                            @if(!$producto->img)
                                <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded border" alt="{{ $producto->producto_nombre }}">
                            @else
                                <img id="product_preview_img" src="{{ url('uploads/products', '80x80_'.$producto->img) }}" class="img-fluid" alt="{{ $producto->producto_nombre }}">
                            @endif
                          </td>
                          <td>{{ $producto->sku }}</td>
                          <td>
                            {{ $producto->producto_nombre ." ". ucfirst($producto->color) }}
                            @if (isset($producto->lista_regalo_id) )
                            <br>
                            <span>Lista Regalo: {{ $producto->codigo }}</span>
                            @endif
                          </td>
                          <td>
                            @if ($producto->dsct != 0)
                              <small style="color: black"><strike>{{ getCurrencySign() . number_format($producto->precio_unidad, 2) }}</strike></small>
                              <br><small style="color: red"><strong> - {{ getCurrencySign() . number_format($producto->dsct, 2) }}</strong></small><br>
                              <small style="color: #5c116e;"><strong>{{ getCurrencySign() . number_format($producto->precio_unidad-$producto->dsct, 2) }}</strong></small><br>
                            @else
                              <small style="color: black">{{ getCurrencySign() . number_format($producto->precio_unidad, 2) }}</small>
                            @endif
                          </td>
                          <td>{{ $producto->cantidad }}</td>
                          <td>{{ getCurrencySign() . number_format(($producto->precio_unidad - $producto->dsct)* $producto->cantidad, 2)  }}</td>
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

                </div>

            </div>
          </div>
          <!-- / resumen orden -->

          <hr>

          <h5 class="font-weight-bold">Historial</h5>
          <div class="table-responsive">
            <table class="table" width="100%" cellspacing="0">
              <tbody>
                <thead>
                  <tr>
                    <th>Fecha de Operacion</th>
                    <th>Estado de la Orden</th>
                  </tr>
                </thead>

                @foreach($historial as $key => $historia)
                  @if($historia)
                  <tr>
                    <td>{{ $historia }}</td>
                    <td>{{ ucfirst($key) }}</td>
                  </tr>
                  @endif
                @endforeach

              </tbody>
            </table>
          </div>

        </div>

      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirm_delete_artist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form id="form_delete_artist" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Eliminar el elemento seleccionado?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary cancel-artist-delete" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
          </div>
        </div>
      </form>
    </div>

@endsection
@section('scripts')
@stop
@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid pr-1 pl-1">

  @include('admin.layouts.errors')
  
  @if( ($lista->edicion_finalizada && !$lista->costo_envio && $lista->entrega == 'delivery') )
  <div role="alert" class="alert alert-danger">
    <div class="row">
        <div class="col-auto">
          <i class="fas fa-3x fa-exclamation-triangle"></i>
        </div>
        <div class="col-10">
            <p class="m-0">Esta lista espera confimación de costo de envio. <br> Una vez calculado la lista será pública.</p>
        </div>
    </div>
  </div>
  @endif

  @if($lista->entrega == 'delivery' && $lista->departamento != 'lima_metropolitana')
  <div class="card mb-3">
      <div class="card-header">
        <div class="row">
          <div class="col-6">Costo de envio</div>
          <div class="col-6">Tracking</div>
        </div>
      </div>
        <div class="card-body">

            <div class="row">
                
                <div class="col-6"> <!-- BEGIN shipping cost detail -->

                  <div class="clearfix d-print-none">
                    <div class="float-left">
                        <h6 class="font-weight-bold">Costo de envio</h6>

                        <form class="float-left form-inline d-print-none" action="{{ route('admin.giftregistry.updateShipcost') }}" method="post">
                          {{ csrf_field() }}
                          <input type="hidden" name="id" value="{{ $lista->id }}">

                          <div class="form-group">
                            <input type="text" class="form-control mr-sm-3" name="costo_envio" value="{{$lista->costo_envio}}">
                          </div>

                          <button type="submit" class="btn btn-danger">Actualizar Costo de Envio</button>
                        </form>

                        <form class="float-left ml-3 form-inline d-print-none" action="{{ route('admin.giftregistry.deleteShipcost') }}" method="post" style="padding-top:1px;">
                          {{ csrf_field() }}
                          <input type="hidden" name="id" value="{{ $lista->id }}">
                          <button type="submit" class="btn btn-secondary">Borrar Costo</button>
                        </form>
                    </div>
                  </div>
                
                </div> <!-- END shipping cost detail -->

                <div class="col-6"><!-- BEGIN tracking detail -->

                    <div class="clearfix d-print-none">
                      <div class="float-left">
                          <h6 class="font-weight-bold">Tracking</h6>

                          <form class="float-left form-inline d-print-none" action="{{ route('admin.giftregistry.updateTracking') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $lista->id }}">

                            <div class="form-group">
                              <input type="text" class="form-control mr-sm-3" name="tracking" value="{{ $lista->tracking }}">
                            </div>

                            <button type="submit" class="btn btn-danger">Actualizar Tracking</button>
                          </form>

                          <form class="float-left ml-3 form-inline d-print-none" action="{{ route('admin.giftregistry.deleteTracking') }}" method="post" style="padding-top:1px;">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $lista->id }}">
                            <button type="submit" class="btn btn-secondary">Borrar Tracking</button>
                          </form>

                      </div>
                    </div>
                
                </div><!-- END tracking detail -->
                
            </div> <!-- row -->
            
        </div>

    </div>
</div>
@endif

  @if($lista->edicion_finalizada && ($lista->entrega == 'recojo_tienda') )
  <div role="alert" class="alert alert-warning">
      <p class="m-0">Esta lista ya se encuentra publicada.</p>
  </div>
  @endif

  <form method="POST" action="{{ route('admin.giftregistry.updateList', $lista->id) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="page-head">
        <h2 class="page-title float-left">Programa de Regalos</h2>

        <div class="clearfix"></div>

        <div class="page-bar toolbarBox">

          <div class="float-left">
            <ul class="list-unstyled mt-2" style="margin-bottom: 0;">
              <li><b>Codigo de lista de regalos:</b> {{ $lista->codigo }}</li>
            </ul>
          </div>

          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.giftregistry.lists', $lista->cuenta_regalos_id) }}">Cancelar</a>
              </li>
              <li>
                  <button class="btn btn-primary btn-action" type="submit">Actualizar</button>
              </li>
          </ul>
        </div>
      </div>

      <div class="page-date">
          <div class="row">
            <div class="col-md-12"><small>Actualizado {{ $updated_at }}</small></div>
          </div>
      </div>


      <div class="row">

        <div class="col-sm-8">

            <div class="card mb-3">

            <div class="card-header">Detalles del Programa</div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">

                <div class="form-row">

                    <div class="form-group col-6">
                        <label for="titulo_evento" class="col-form-label">Título <span class="text-danger">*</span></label>
                        <div>
                        <input class="form-control" name="titulo_evento" type="text" id="titulo_evento" value="{{ $lista->titulo }}">
                        </div>
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-6">
                        <label for="fecha" class="col-form-label">Fecha del Evento <span class="text-danger">*</span></label>
                        <div>
                          <input id="fecha_evento" name="fecha_evento" type="text" class="form-control" value="{{ $lista->fecha }}" required="true">
                          <!--<input class="form-control" name="fecha" type="date" id="fecha" value="{{ $lista->fecha }}" min="2000-01-01">-->
                        </div>
                    </div>

                </div>


                <div class="form-group">
                    <label for="desc_evento">Descripción</label>
                    <textarea class="form-control" name="desc_evento" id="desc_evento" rows="4">{{ $lista->desc }}</textarea>
                </div>

                <div class="row">

                <div class="col-sm-12">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="organizador_uno">Nombre Organizador 1</label>
                            <input class="form-control" id="organizador_uno" name="organizador_uno" type="text" value="{{ $lista->organizador_uno }}">
                        </div>

                        <div class="form-group col">
                            <label for="organizador_dos">Nombre Organizador 2</label>
                            <input class="form-control" id="organizador_dos" name="organizador_dos" type="text" value="{{ $lista->organizador_dos }}">
                        </div>
                    </div>
                </div>

                </div>

            </div>
          </div>
        </div>
          <div class="card-footer small text-muted"></div>

    </div>



    @if($lista->entrega)
    <div class="card mb-3">
        <div class="card-header">
          <div class="row">
            <div class="col">
              Detalles de entrega 
            </div>
            <div class="col-2">
              @if($lista->entrega == 'delivery' && $lista->departamento == 'lima_metropolitana')
                <span class="badge badge-light border text-danger float-right" style="font-size: 0.9em;"> Envio gratis </span>
              @endif      
            </div>
          </div>
          
          
        </div>

        <div class="card-body">

            <div class="clearfix">
              <div class="float-left">

                  <h6>{{ $lista->entrega == 'recojo_tienda' ? 'Recojo en tienda' : 'Delivery' }}</h6>


                  <p>
                      @if($lista->entrega == 'delivery')
                          {{ ucfirst($lista->departamento) }} <br>
                          {{ ucfirst($lista->direccion) }}  {{ ($lista->distrito) ? ' - ' . ucfirst($lista->distrito) : '' }}
                      @endif
                  </p>

              </div>
            </div>

        </div>

      </div>
      @endif



  </div>

  <div class="col-sm-4">

              <div class="card mb-3">

                  <div class="card-header">Imagen del Programa</div>

                  <div class="card-body">
                    <div class="image-preview">
                      <img class="img-fluid" id="imgpreview" src="{{ url('/uploads/giftregistry/' . $lista->img) }}" alt="">
                    </div>

                    <p>Tamaño Referencial: (730 x 420px)</p>
                    <span class="btn btn-default btn-action btn-file">Escoger imagen <input type="file" name="img" onchange="readURL(this)"></span>

                    <a href="" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview float-right pt-2">Eliminar imagen</a>

                  </div>

                  <div class="card-footer small text-muted"></div></div>

              </div>

          </div>

      </form>




      <div class="row">

          <div class="col-sm-12">

              <div class="card mb-3">
                <div class="card-header">
                  Lista de Regalos 
                  @if(!$lista->edicion_finalizada)
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal_lista_productos">Agregar productos</button>
                  @endif
                </div>

                <div class="card-body">

                  <div class="clearfix mb-4">
                      <div class="float-left">
                          <a class="text-primary mr-4" href="{{ route('admin.giftregistry.exportGiftList', $lista->codigo) }}" style="cursor:pointer;text-decoration:underline;"><i class="fas fa-file-excel"></i> Descargar Excel</a>
                      </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Imagen</th>
                          <th>Regalo</th>
                          <th width="10">Color</th>
                          <th width="10">Solicitados</th>
                          <th width="10">Stock</th>
                          <th width="10">Recibidos</th>
                          <th width="10">Precio</th>
                          <th width="10">Dscto.</th>
                          <th>Total</th>
                          <th width="10"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($regalos as $producto)
                        <tr>
                          <td><img class="border" src="{{ $producto->img ? '/uploads/products/80x80_'.$producto->img : '/media/default.jpg'  }}" alt="" width="80" height="80" style="object-fit: cover;"></td>
                          <td><a href="{{ route('admin.product.edit', $producto->id) }}">{{ $producto->nombre }}</a></td>
                          <td>{{ $producto->color ? ucfirst($producto->color) : '--' }}</td>
                          <td>{{ $producto->solicitados }}</td>
                          <td>{{ $producto->stock }}</td>
                          <td>{{ $producto->recibidos }}</td>
                          <td style="width: 80px;">S/ {{ $producto->precio }}</td>
                          <td>
                              
                              @if ($producto->dsct_lista_regalo > 0)
                                <span data-real-id="{{ $producto->id }}" data-lista-regalo-dscto="{{ $producto->dsct_lista_regalo }}" data-precio="{{ $producto->precio }}" id="input_{{ $producto->id }}{{ isset($producto->color) ? '_'.$producto->color : '' }}" class="input-dscto dsct_lista_regalo">{{ $producto->dsct_lista_regalo }}</span>
                              @else
                                <span data-real-id="{{ $producto->id }}" data-lista-regalo-dscto="{{ $producto->precio }}" data-precio="{{ $producto->precio }}" id="input_{{ $producto->id }}{{ isset($producto->color) ? '_'.$producto->color : '' }}" class="input-dscto dsct_lista_regalo_off">--</span>
                              @endif

                          </td>
                          <td>S/ <span id="total_{{ $producto->id }}{{ isset($producto->color) ? '_'.$producto->color : '' }}">0.00</span> </td>
                          <td>
                            @if($producto->recibidos == 0 && !$lista->edicion_finalizada)
                              <a class="remove-product" data-toggle="modal" data-url="{{ route('weddinglist.remove') }}" data-id="{{ $producto->id }}" data-lista-regalos-id="{{ $lista->id }}" data-target="#confirm_delete_product" href="#"><i class="fas fa-trash-alt"></i></a>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>

          </div>

        </div>


    </div>


    <!-- modal eliminar producto programa de regalos -->
    <div class="modal fade" id="confirm_delete_product" tabindex="-1" role="dialog" aria-hidden="true">
      <form id="form_delete_product" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar producto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Eliminar el elemento seleccionado?
              <input type="hidden" name="cuenta_novios_id" value="{{ $lista->id }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary cancel-product-delete" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
          </div>
        </div>
      </form>
    </div>



    <!-- modal agregar producto programa de regalos -->
    <div class="modal fade" id="modal_lista_productos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Productos de la Tienda</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="table-responsive">
                  <table class="table" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      <input type="hidden" name="cuenta_novios_id" value="{{ $lista->id }}">
                      @foreach ($tienda_productos as $producto)
                      <tr>
                        <td><img src="{{ $producto->img ? '/uploads/products/80x80_'.$producto->img : '/media/default.jpg' }}" alt="" height="80" width="80" style="object-fit:cover;"></td>
                        <td><a href="{{ route('admin.product.edit', $producto->id) }}">{{ $producto->nombre }}</a></td>
                        <td>S/ {{ $producto->precio }}</td>
                        <td><button id="btn_add_regalo_{{$producto->id}}" class="btn btn-danger subtitle agregar-cuenta-novios" data-lista-codigo="{{ $lista->codigo }}" data-img="{{ $producto->img }}" data-title="{{ $producto->nombre }}" data-price="{{ $producto->precio }}" data-producto-id="{{ $producto->id }}" data-cuenta-id="{{ $lista->id }}" type="button" name="button"><i class="fa fa-gift"></i></button></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
          </div>
          <!--div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div-->
        </div>
      </div>
    </div>


    <!-- modal eliminar imagen programa de regalos -->
    <div class="modal fade" id="confirm_delete_image" tabindex="-1" role="dialog" aria-hidden="true">
      <form method="POST" action="{{ route('admin.giftregistry.removeImage', $lista->id) }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar imagen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Eliminar imagen?

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    @include('partials.modal-choose-gift')

@endsection

@section('scripts')
<script type="text/javascript">

  $('#fecha_evento').datepicker({
      language: 'es',
      startDate: 'today'
  });

  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#imgpreview').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
  }


  $(document).ready(function() {

      //for
      $.each( $('.input-dscto'), function(index, value){
        var $this = $(this);

        var id = $this.attr('id');
        //var value = $this.val().length > 0 ? $this.val() : 0.00;
        var value = $this.data('lista-regalo-dscto');

        var precio = $this.data('precio');
        var totalSpan = id.split("input")[1];

        precioFinal = parseFloat(precio) - parseFloat(value);
        precioFinal = precioFinal.toFixed(2);

        $('#total'+totalSpan).html(precioFinal);
      });

      $('.remove-product').click(function() {
        var id = $(this).attr('data-id');
        var listaRegalosId = $(this).attr('data-lista-regalos-id');
        var url = $(this).attr('data-url');
        $("#form_delete_product").attr("action", url);

        $('body').find('#form_delete_product').find( "input[name='id']" ).remove();
        $('body').find('#form_delete_product').append('<input name="id" type="hidden" value="'+ id +'">');
        $('body').find('#form_delete_product').append('<input name="lista_regalos_id" type="hidden" value="'+ listaRegalosId +'">');
      });

      $('.cancel-product-delete').click(function() {
        $('body').find('#form_delete_product').find( "input[name='id']" ).remove();
      });

  });
</script>
@stop

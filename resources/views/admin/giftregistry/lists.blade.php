@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Programa de Regalos</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('admin.giftregistry.create', $cuenta->id) }}" title="Añadir nueva lista">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nueva lista</div>
                </a>
              </li>
          </ul>
        </div>
      </div>

      @if (is_null($cuenta->activated_at))
        <div class="alert alert-danger" role="alert">
          <p class="m-0">Cuenta no activada por el usuario.</p>
        </div>
      @endif

      <div class="row">
        <div class="col-sm-8">
          <div class="card mb-3">
            <div class="card-header">Accesos</div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.giftregistry.updatePassword') }}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $cuenta->id }}">
                <div class="row">
                    <div class="col-sm-12">
                          <div class="form-row align-items-end">
                              <div class="form-group col">
                                  <label for="nombres">Correo <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" name="email" id="email" autocomplete="off" value="{{ $cuenta->email }}" disabled>
                              </div>

                              <div class="form-group col">
                                  <label for="apellidos">Contraseña <span class="text-danger">*</span></label>
                                  <input class="form-control" name="password" type="password" autocomplete="off">
                              </div>

                              <div class="form-group col">
                                    <input type="submit" class="btn btn-primary" value="Actualizar">
                              </div>

                          </div>
                    </div>
                </div>
                </form>
            </div>
          </div>
        </div>
      </div>


      <div class="card mb-3">
        <div class="card-header">Listas</div>

        <div class="card-body">
          <div class="clearfix mb-4">
              <div class="float-left">
                  <a class="text-primary mr-4" href="{{ route('admin.giftregistry.exportAcountList', [$cuenta->id]) }}" style="cursor:pointer;text-decoration:underline;"><i class="fas fa-file-excel"></i> Descargar Excel</a>
              </div>
          </div>
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Evento</th>
                  <th>Modo Entrega</th>
                  <th>Estado</th>
                  <th>Fecha</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
  
                @foreach($listas as $list)
                <tr>
                  <td>{{ $list->codigo }}</td>
                  <td>{{ $list->titulo }}</td>
                  <td>{{ ($list->entrega == 'recojo_tienda') ? 'Recojo en Tienda' : 'Delivery' }}</td>
                  <td>
                    <span class="badge {{ $list->getBadge() }}">{{ $list->getState('format') }}</span>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($list->fecha)->format('m/d/Y') }}</td>
                  <td>
                    <div class="btn-group float-right">
                      <a class="btn btn-default btn-action" href="{{ route('admin.giftregistry.showList', $list->codigo) }}"><i class="fas fa-pencil-alt"></i> Editar</a>
                    </div>
                  </td>
                </tr>
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
<script type="text/javascript">
  $(document).ready(function() {

      $('.remove-artist').click(function() {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        $("#form_delete_artist").attr("action", url);
        $('body').find('#form_delete_artist').append('<input name="id" type="hidden" value="'+ id +'">');
      });

      $('.cancel-artist-delete').click(function() {
        $('body').find('#form_delete_artist').find( "input" ).remove();
      });

  });
</script>
@stop

@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Eventos</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('exhibition.create') }}" title="Añadir nuevo evento">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nuevo evento</div>
                </a>
              </li>
          </ul>
        </div>
      </div>


      <div class="card mb-3">
        <div class="card-header">Eventos</div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Hora</th>
                  <th>Evento</th>
                  <th>Lugar</th>
                  <th>Distrito</th>
                  <th>Precio</th>
                  <th></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Hora</th>
                  <th>Evento</th>
                  <th>Lugar</th>
                  <th>Distrito</th>
                  <th>Precio</th>
                  <th></th>
                </tr>
              </tfoot>
              <tbody>
                  @foreach ($exposiciones as $exposicion)
                      <tr>
                        <td>{{ $exposicion->hora }}</td>
                        <td>{{ $exposicion->titulo }}</td>
                        <td>{{ $exposicion->lugar }}</td>
                        <td>{{ $exposicion->distrito }}</td>
                        <td>{{ $exposicion->precio }}</td>
                        <td>
                          <div class="btn-group float-right">
                              <a class="btn btn-default btn-action" href="{!! URL::route('exhibition.edit', $exposicion->slug) !!}"><i class="fas fa-pencil-alt"></i> Modificar</a>
                              <button type="button" class="btn btn-default btn-action dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <ul class="dropdown-menu">
                                <a class="dropdown-item remove-artist" data-toggle="modal" data-url="{{ route('exhibition.destroy', $exposicion->id) }}" data-id="{{ $exposicion->id }}" data-target="#confirm_delete_artist" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
                              </ul>
                          </div>
                        </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>

          {{ $exposiciones->links() }}
        </div>
        <div class="card-footer small text-muted"></div>
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

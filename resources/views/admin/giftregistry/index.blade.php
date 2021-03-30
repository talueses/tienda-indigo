@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Programa de Regalos</h2>

        <div class="page-bar toolbarBox">
          <!--
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li></li>
          </ul>
          -->
        </div>
      </div>

      <div class="card mb-3">
          <div class="card-header">Descripción</div>
          <div class="card-body">

            <form action="{{ route('admin.giftregistry.description') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea class="form-control" name="description" rows="4" cols="80">{{ $programa_novios_description }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary float-right">Guardar</button>
                </div>
            </form>

          </div>
      </div>

      <div class="card mb-3">
        <div class="card-header">

          <div class="row">
            <div class="col">Programa de Regalos</div>
            <div class="float-right mr-3">
            <a class="btn btn-primary btn-action" data-toggle="collapse" href="#addNewRegalosUser" role="button" aria-expanded="false" aria-controls="addNewRegalosUser">Agregar cuenta</a>
            </div>
          </div>

          <!-- Begin Add new regalos cuenta user -->
          <div class="card collapse" id="addNewRegalosUser">
            
            <div class="card-body">

                <form method="post" action="{{ route('admin.giftregistry.createActivatedRegalosUser') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="form-row align-items-end">

                                <div class="form-group col">
                                    <label for="nombres">Correo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" autocomplete="off">
                                </div>

                                <div class="form-group col">
                                    <label for="apellidos">Contraseña <span class="text-danger">*</span></label>
                                    <input class="form-control" name="password" type="password" autocomplete="off">
                                </div>

                                <div class="form-group col">
                                      <input type="submit" class="btn btn-primary" value="Crear">
                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>
            
          </div>
          <!-- End add new regalos cuenta user -->

          
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Cuenta Regalos</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($listas as $cuenta)
                <tr>
                  <td>{{ $cuenta->email }}</td>
                  <td>
                    <div class="btn-group float-right">
                      <a class="btn btn-default btn-action" href="{{ route('admin.giftregistry.lists', $cuenta->id) }}">Ver</a>
                    </div>
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

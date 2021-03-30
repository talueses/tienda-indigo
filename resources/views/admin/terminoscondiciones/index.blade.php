@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">
        <h2 class="page-title float-left">Términos y Condiciones</h2>

        <!--div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                <a class="btn btn-primary pointer" href="{{ route('notes.create') }}" title="Añadir nueva nota">
                  <i class="fas fa-plus-circle"></i>
                  <div>Añadir nueva nota</div>
                </a>
              </li>
          </ul>
        </div-->

      </div>


      <div class="card mb-3">

        <div class="card-body">

          <div class="table-responsive">
            <table class="table" width="100%" cellspacing="0">

              <tbody>

                @foreach($generales as $condicion)
                <tr>
                  <td>{{ $condicion->format_nombre }}</td>
                  <td>
                        <div class="btn-group float-right">
                          <a class="btn btn-default btn-action" href="{{ route('admin.terminosycondiciones.edit', $condicion->nombre) }}"><i class="fas fa-pencil-alt"></i> Editar</a>
                        </div>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>

          {{-- $emails->links() --}}

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
<script>
$('.email_subscribe').on('click', function(){

    var emailSub = $(this).is(':checked') ? 1 : 0;
    var emailId = $(this).data('email-id');

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "GET",
        url: "newsletter/subscribe",
        data: { active: emailSub, emailId: emailId }
    })
    .done(function(msg){
    });

});
</script>
@endsection

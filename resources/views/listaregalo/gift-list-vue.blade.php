@extends('layouts.front', ['subtitle'=> $lista->codigo ? $lista->codigo : 'Detalle' ])
@section('contenido')
@include('partials.banner')
<style>
.table thead th {
    font-size: 0.9em!important;
}
</style>
<div class="container contenido" id="app">
  
  @include('listaregalo.layouts.session')

  <div class="card">
    <div class="card-body customer-body">

      <div class="row no-gutters">

        <!-- BEGIN GIFT MENU -->
        <div class="col-md-3"> 
          @include('listaregalo.partials.menu') 
        </div>
        <!-- END GIFT MENU -->

        <!-- BEGIN VUE GIFT DETAIL -->
        <gift-detail :list="{{ $lista }}"> <gift-detail/>
        <!-- END VUE GIFT DETAIL -->

      </div>

    </div>
    
  </div>

</div>

<!-- compartir enlace -->
<div class="modal fade" id="share_link" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title subtitle" id="exampleModalLabel">Compartir lista de regalos</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p>Envía el siguiente código <kbd class="mx-2">{{ $lista->codigo }}</kbd> ó comparte el siguiente enlace para que tus invitados puedan acceder a tu lista de regalos.</p>

          <div class="input-group mb-3">
            <input id="copy_input" type="text" value="{{ route('home.novios.search', 'codigo='.$lista->codigo) }}" class="form-control">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="button" id="btn_copy_link" data-toggle="tooltip" data-placement="button" title="Copy to Clipboard">Copiar</button>
            </div>
          </div>

          <p id="copied_link" class="text-center mb-0" style="display: none;">Copiado!</p>

      </div>
    </div>
  </div>
</div>
<!-- //compartir enlace -->

<!-- modal eliminar imagen -->
<div class="modal fade" id="confirm_delete_image" tabindex="-1" role="dialog" aria-hidden="true">
  <form method="POST" action="{{ route('giftregistry.removeimage', $lista->id) }}">
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
          <p>¿Seguro de eliminar imagen de lista?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary linear" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-outline-secondary black linear">Eliminar</button>
        </div>
      </div>
    </div>
  </form>
</div>

@endsection

@section('javascript')
<script>
$('#fecha_evento').datepicker({ language: 'es', startDate: 'today' })
</script>
@endsection

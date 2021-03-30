@extends('layouts.front', ['subtitle'=>'Cuenta'])
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

        <div class="col-md-3">

          @include('listaregalo.partials.menu')

        </div>


        <div class="col-md-9">

<div class="gift-registry-content">
  <div class="card-body">

    <div class="mb-3">
        <button style="font-size: 0.9em;" type="button" name="button" class="subtitle btn btn-outline-secondary linear" data-toggle="modal" data-target="#share_link" class="delete-preview mt-2"><i class="fas fa-share-alt mr-2"></i> Compartir lista de regalo</button>
        <a style="font-size: 0.9em;" class="subtitle btn btn-outline-secondary linear" href="{{ route('listaregalo.preview', $lista->codigo) }}" target="_blank"><i class="fas fa-eye mr-2"></i> Vista previa</a>
        <div class="subtitle btn" style="font-size: 0.9em;">
            Estado: <span class="badge {{ $lista->getBadge() }}"> {{ $lista->getState('format') }} </span>
        </div>
        <div class="subtitle btn" style="font-size: 0.9em;">
          <div class="costo-envio">
            Costo de envio:
            @if($lista->entrega == 'delivery' && $lista->departamento != 'lima_metropolitana') 
                @if($lista->costo_envio)
                  <span id="costo_envio_lista_regalo" class="badge badge-light border text-danger" style="font-size: 0.9em;">S/. {{ $lista->costo_envio }}</span>
                @else
                  <span id="costo_envio_lista_regalo" class="badge badge-light border text-secondary" style="font-size: 0.9em;">Por confirmar</span>
                @endif
            @elseif($lista->entrega == 'delivery' && $lista->departamento == 'lima_metropolitana')
              <span id="costo_envio_lista_regalo" class="badge badge-light border text-danger" style="font-size: 0.9em;"> Envio gratis </span>
            @else
              <span id="costo_envio_lista_regalo" class="badge badge-light border text-danger" style="font-size: 0.9em;"> Recoger en tienda </span>
            @endif
          </div>
        </div>
        @if($lista->tracking)<!-- BEGIN TRACKING -->
          <div class="external-link">
              <span class="badge badge-success"> Seguimiento <i class="fas fa-chevron-right" aria-hidden="true"></i> </span>
              <span class="badge badge-light">
                <a href="{{ $lista->tracking }}" target="_blank"> Ver tracking <i class="fas fa-external-link-alt"></i></a>
              </span>
          </div>
        @endif<!-- END TRACKING -->
    </div>

    <ul class="nav nav-tabs nav-tabs-gift">
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#menu_detalles_lista">Detalles de Lista</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#menu_regalos">Regalos</a>
        </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane container fade" id="menu_detalles_lista">

        <div class="row">

            <div class="col-md-12">

                <form method="POST" action="{{ route('home.novios.update', $lista->codigo) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                  <div class="form-group">

                      <label for="evento">Imagen del Evento</label>
                      <div class="image-preview mb-3"> <!-- img-cont-full r1-1 -->

                        @if(!$lista->img)
                          <img class="img-fluid rounded border" id="imgpreview" src="{{ url('/media/default.jpg') }}" alt="{{ $lista->titulo }}" style="max-width: 130px;">
                        @else
                          <img class="img-fluid rounded border" id="imgpreview" src="{{ '/uploads/giftregistry/'.$lista->img }}" alt="{{ $lista->titulo }}" style="max-width: 130px;">
                        @endif

                        <div class="d-inline p-2 delete-preview mt-2 text-center">
                          <a href="#" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview mt-2 text-danger"><i class="fas fa-trash-alt"></i></a>
                        </div>

                      </div>

                      <span class="d-inline p-2 btn btn-outline-secondary linear px-4 btn-file mt-2 subtitle" style="font-size:14px;">Escoger imagen <input type="file" id="select_img_wedding_account" name="img"></span>

                    </div>

                  <div class="form-row">
                    <div class="form-group col-6">
                      <label for="titulo_evento">Código</label>
                      <input class="form-control" type="text" value="{{ $lista->codigo }}" disabled>
                    </div>
                  </div>

                  <div class="form-row">
                    <div class="form-group col">
                      <label for="titulo_evento">Título del Evento</label>
                      <input type="text" class="form-control" id="titulo_evento" name="titulo_evento" value="{{ $lista->titulo }}" placeholder="">
                    </div>

                    <div class="form-group col">
                      <!--<label for="fecha_evento">Fecha del Evento</label>
                      <input class="form-control" id="fecha_evento" name="fecha_evento" value="{{ $lista->fecha }}" type="date" min="2000-01-01">-->
                      <label for="fecha_evento">Fecha del Evento</label>
                      <input id="fecha_evento" name="fecha_evento" type="text" class="form-control" value="{{ $lista->fecha }}" required="true">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="desc_evento">Descripción</label>
                    <textarea class="form-control" id="desc_evento" name="desc_evento" placeholder="">{{ $lista->desc }}</textarea>
                  </div>

                  <div class="form-row">
                      <div class="form-group col">
                          <label for="organizador_uno">Nombre Organizador 1</label>
                          <input class="form-control" id="organizador_uno" name="organizador_uno" value="{{ $lista->organizador_uno }}" type="text">
                      </div>

                      <div class="form-group col">
                          <label for="organizador_dos">Nombre Organizador 2</label>
                          <input class="form-control" id="organizador_dos" name="organizador_dos" value="{{ $lista->organizador_dos }}" type="text">
                      </div>
                  </div>

                  <h4 class="h5 mt-4">Detalles de entrega</h4>

                  @if ($lista->getState() == 'edicion')
                    <div class="form-row">

                        <div class="form-group col">
                            <label for="modo_entrega">Tipo</label>
                            <select name="modo_entrega" id="modo_entrega" class="form-control" required>
                                <option value="recojo_tienda" {{ ($lista->entrega == 'recojo_tienda') ? 'selected':'' }}>Recojo en Tienda</option>
                                <option value="delivery" {{ ($lista->entrega == 'delivery') ? 'selected':'' }}>Delivery</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col">
                            <label for="envio_departamento">Departamento</label>
                            <select name="envio_departamento" id="envio_departamento" class="form-control" {{ !is_null($lista->departamento) ? '' : 'disabled' }} required>
                                <option value="amazonas" {{ ($lista->departamento == 'amazonas') ? 'selected':'' }}>Amazonas</option>
                                <option value="ancash" {{ ($lista->departamento == 'ancash') ? 'selected':'' }}>Ancash</option>
                                <option value="apurimac" {{ ($lista->departamento == 'apurimac') ? 'selected':'' }}>Apurimac</option>
                                <option value="arequipa" {{ ($lista->departamento == 'arequipa') ? 'selected':'' }}>Arequipa</option>
                                <option value="ayacucho" {{ ($lista->departamento == 'ayacucho') ? 'selected':'' }}>Ayacucho</option>
                                <option value="cajamarca" {{ ($lista->departamento == 'cajamarca') ? 'selected':'' }}>Cajamarca</option>
                                <option value="callao" {{ ($lista->departamento == 'callao') ? 'selected':'' }}>Callao</option>
                                <option value="cusco" {{ ($lista->departamento == 'cusco') ? 'selected':'' }}>Cusco</option>
                                <option value="huancavelica" {{ ($lista->departamento == 'huancavelica') ? 'selected':'' }}>Huancavelica</option>
                                <option value="huanuco" {{ ($lista->departamento == 'huanuco') ? 'selected':'' }}>Huanuco</option>
                                <option value="ica" {{ ($lista->departamento == 'ica') ? 'selected':'' }}>Ica</option>
                                <option value="junin" {{ ($lista->departamento == 'junin') ? 'selected':'' }}>Junin</option>
                                <option value="la_libertad" {{ ($lista->departamento == 'la_libertad') ? 'selected':'' }}>La Libertad</option>
                                <option value="lambayeque" {{ ($lista->departamento == 'lambayeque') ? 'selected':'' }}>Lambayeque</option>
                                <option value="lima" {{ ($lista->departamento == 'lima') ? 'selected':'' }}>Lima</option>
                                <option value="lima_metropolitana" {{ ($lista->departamento == 'lima_metropolitana') ? 'selected':'' }}>Delivery sin recargo</option>
                                <option value="loreto" {{ ($lista->departamento == 'loreto') ? 'selected':'' }}>Loreto</option>
                                <option value="madre_de_dios" {{ ($lista->departamento == 'madre_de_dios') ? 'selected':'' }}>Madre De Dios</option>
                                <option value="moquegua" {{ ($lista->departamento == 'moquegua') ? 'selected':'' }}>Moquegua</option>
                                <option value="pasco" {{ ($lista->departamento == 'pasco') ? 'selected':'' }}>Pasco</option>
                                <option value="piura" {{ ($lista->departamento == 'piura') ? 'selected':'' }}>Piura</option>
                                <option value="puno" {{ ($lista->departamento == 'puno') ? 'selected':'' }}>Puno</option>
                                <option value="san_martin" {{ ($lista->departamento == 'san_martin') ? 'selected':'' }}>San Martin</option>
                                <option value="tacna" {{ ($lista->departamento == 'tacna') ? 'selected':'' }}>Tacna</option>
                                <option value="tumbes" {{ ($lista->departamento == 'tumbes') ? 'selected':'' }}>Tumbes</option>
                                <option value="ucayali" {{ ($lista->departamento == 'ucayali') ? 'selected':'' }}>Ucayali</option>
                            </select>
                        </div>

                        <div class="form-group col">
                            <label for="envio_lima_metropolitana">Distrito</label>
                            <select name="envio_lima_metropolitana" id="envio_lima_metropolitana" class="form-control" {{ !is_null($lista->distrito) ? '' : 'disabled' }} required>
                              <option value="barranco" {{ ($lista->distrito == 'barranco') ? 'selected':'' }}>Barranco</option>
                              <option value="miraflores" {{ ($lista->distrito == 'miraflores') ? 'selected':'' }}>Miraflores</option>
                              <option value="surco" {{ ($lista->distrito == 'surco') ? 'selected':'' }}>Surco</option>
                              <option value="san_borja" {{ ($lista->distrito == 'san_borja') ? 'selected':'' }}>San Borja</option>
                              <option value="surquillo" {{ ($lista->distrito == 'surquillo') ? 'selected':'' }}>Surquillo</option>
                              <option value="san_isidro" {{ ($lista->distrito == 'san_isidro') ? 'selected':'' }}>San Isidro</option>
                              <option value="chorrillos" {{ ($lista->distrito == 'chorrillos') ? 'selected':'' }}>Chorrillos</option>

                              <option value="cercado" {{ ($lista->distrito == 'cercado') ? 'selected':'' }}>Cercado</option>
                              <option value="san_luis" {{ ($lista->distrito == 'san_luis') ? 'selected':'' }}>San Luis</option>
                              <option value="brena" {{ ($lista->distrito == 'brena') ? 'selected':'' }}>Breña</option>
                              <option value="la_victoria" {{ ($lista->distrito == 'la_victoria') ? 'selected':'' }}>La Victoria</option>
                              <option value="rimac" {{ ($lista->distrito == 'rimac') ? 'selected':'' }}>Rimac</option>
                              <option value="lince" {{ ($lista->distrito == 'lince') ? 'selected':'' }}>Lince</option>
                              <option value="san_miguel" {{ ($lista->distrito == 'san_miguel') ? 'selected':'' }}>San Miguel</option>
                              <option value="jesus_maria" {{ ($lista->distrito == 'jesus_maria') ? 'selected':'' }}>Jesús María</option>
                              <option value="magdalena" {{ ($lista->distrito == 'magdalena') ? 'selected':'' }}>Magdalena</option>
                              <option value="pblo_libre" {{ ($lista->distrito == 'pblo_libre') ? 'selected':'' }}>Pblo. Libre</option>
                          </select>
                        </div>

                        <div class="form-group col-12">
                            <label for="direccion" for="direccion">Dirección</label>
                            <input id="direccion" class="form-control" name="direccion" value="{{ !is_null($lista->direccion) ? $lista->direccion : '' }}" type="text" {{ !is_null($lista->direccion) ? '' : 'disabled' }} required>
                        </div>

                        <div class="col-12">
                            <hr class="mb-2">
                              <p class="text-center mb-0">
                                <small class="d-flex align-items-center">
                                  <i class="fas fa-truck fa-border fa-3x text-secondary mr-2"></i> Delivery gratuito<br> solo en Lima.
                                  {{ $free_delivery }}
                                </small>
                              </p>
                            <hr class="my-2">
                        </div>

                        <button id="save_list" type="submit" class="btn btn-dark linear">Actualizar</button>

                    </div>

                  @else
                    <div class="form-row mt-4">

                      <div class="col-12">
                        <h6>{{ $lista->entrega == 'recojo_tienda' ? 'Recojo en tienda' : 'Delivery' }}</h6>
                        <p>
                            @if($lista->entrega == 'delivery')
                                {{ ucfirst($lista->departamento) }} <br>
                                {{ ucfirst($lista->direccion) }}  {{ ($lista->distrito) ? ' - ' . ucfirst($lista->distrito) : '' }}
                            @endif
                        </p>
                      </div>

                      <button id="save_list" type="submit" class="btn btn-dark linear">Actualizar</button>
                    </div>
                  @endif

                </form>

            </div>

        </div>
      </div>
      <div class="tab-pane container active" id="menu_regalos">
        <div class="row">  
            @include('listaregalo.partials.table-regalos')
        </div>
      </div>
    </div>

  </div>
</div>

</div>
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
  <form method="POST" action="{{ route('giftregistry.removeimage', $cuenta->id) }}">
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

  $('#fecha_evento').datepicker({
      language: 'es',
      startDate: 'today'
  });


  $('#modo_entrega').on('change', function(e) {
      $this = $(this);
      
      if ($this.val() == 'delivery') {

          if ($('#envio_departamento').val() == 'lima_metropolitana') {
            $('#envio_lima_metropolitana').prop('disabled', false);
          } else {
            $('#envio_lima_metropolitana').prop('disabled', true);
          }

          $('#envio_departamento').prop('disabled', false);
          $('#direccion').prop('disabled', false);

      } else {

          $('#envio_departamento').prop('disabled', true);
          $('#envio_lima_metropolitana').prop('disabled', true);
          $('#direccion').prop('disabled', true);
      }

  });

  $('#envio_departamento').on('change', function() {
      $this = $(this);

      if ($this.val() != 'lima_metropolitana') {
        $('#envio_lima_metropolitana').prop('disabled', true);
      } else {
        $('#envio_lima_metropolitana').prop('disabled', false);
      }

  });


</script>
@endsection

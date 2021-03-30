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

                        <h4 class="card-title">Nueva Lista</h4>

                        <div class="row">

                            <div class="col-md-12">


                                <form method="POST" action="{{ route('giftregistry.createlist') }}" enctype="multipart/form-data">
                                  {{ csrf_field() }}

                                  <div class="form-group">

                                      <label for="evento">Imagen del Evento</label>
                                      <div class="image-preview mb-3"> <!-- img-cont-full r1-1 -->

                                        <img class="img-fluid rounded border" id="imgpreview" src="{{ url('/media/default.jpg') }}" alt="Nueva imagen" style="max-width: 130px;">

                                        <div class="d-inline p-2 delete-preview mt-2 text-center">
                                          <a href="#" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview mt-2 text-danger"><i class="fas fa-trash-alt"></i></a>
                                        </div>

                                      </div>

                                      <span class="d-inline p-2 btn btn-outline-secondary linear px-4 btn-file mt-2 subtitle" style="font-size:14px;">Escoger imagen <input type="file" id="select_img_wedding_account" name="img"></span>

                                    </div>



                                  <div class="form-group">
                                    <label for="titulo_evento">Título del Evento</label>
                                    <input type="text" class="form-control" id="titulo_evento" name="titulo_evento" value="{{ old('titulo_evento') }}">
                                  </div>

                                  <div class="form-group">
                                    <label for="fecha_evento">Fecha del Evento</label>
                                    <input id="fecha_evento" name="fecha_evento" type="text" class="form-control" value="{{ old('fecha_evento') }}" required="true">
                                  </div>

                                  <div class="form-group">
                                    <label for="desc_evento">Descripción</label>
                                    <textarea class="form-control" id="desc_evento" name="desc_evento" value="{{ old('desc_evento') }}"></textarea>
                                  </div>

                                  <div class="form-row">
                                      <div class="form-group col">
                                          <label for="organizador_uno">Nombre Organizador 1</label>
                                          <input class="form-control" id="organizador_uno" name="organizador_uno" type="text" value="{{ old('organizador_uno') }}">
                                      </div>

                                      <div class="form-group col">
                                          <label for="organizador_dos">Nombre Organizador 2</label>
                                          <input class="form-control" id="organizador_dos" name="organizador_dos" type="text" value="{{ old('organizador_dos') }}">
                                      </div>
                                  </div>


                                  <h4 class="h5 mt-4">Detalles de entrega</h4>


                                  <div class="form-row">

                                      <div class="form-group col">
                                          <label for="modo_entrega">Tipo</label>
                                          <select name="modo_entrega" id="modo_entrega" class="form-control" required>
                                              <option value="recojo_tienda">Recojo en Tienda</option>
                                              <option value="delivery">Delivery</option>
                                          </select>
                                      </div>

                                  </div>


                                  <div class="form-row">

                                      <div class="form-group col">
                                          <label for="envio_departamento">Departamento</label>
                                          <select name="envio_departamento" id="envio_departamento" class="form-control" required disabled>
                                              <option value="amazonas">Amazonas</option>
                                              <option value="ancash">Ancash</option>
                                              <option value="apurimac" >Apurimac</option>
                                              <option value="arequipa">Arequipa</option>
                                              <option value="ayacucho">Ayacucho</option>
                                              <option value="cajamarca">Cajamarca</option>
                                              <option value="callao">Callao</option>
                                              <option value="cusco">Cusco</option>
                                              <option value="huancavelica">Huancavelica</option>
                                              <option value="huanuco">Huanuco</option>
                                              <option value="ica">Ica</option>
                                              <option value="junin">Junin</option>
                                              <option value="la_libertad">La Libertad</option>
                                              <option value="lambayeque">Lambayeque</option>
                                              <option value="lima">Lima</option>
                                              <option value="lima_metropolitana">Delivery sin recargo</option>
                                              <option value="loreto">Loreto</option>
                                              <option value="madre_de_dios">Madre De Dios</option>
                                              <option value="moquegua">Moquegua</option>
                                              <option value="pasco">Pasco</option>
                                              <option value="piura">Piura</option>
                                              <option value="puno">Puno</option>
                                              <option value="san_martin">San Martin</option>
                                              <option value="tacna">Tacna</option>
                                              <option value="tumbes">Tumbes</option>
                                              <option value="ucayali">Ucayali</option>
                                          </select>
                                      </div>

                                      <div class="form-group col">
                                          <label for="envio_lima_metropolitana">Distrito</label>
                                          <select name="envio_lima_metropolitana" id="envio_lima_metropolitana" class="form-control" required disabled>
                                            <option value="barranco">Barranco</option>
                                            <option value="miraflores">Miraflores</option>
                                            <option value="surco">Surco</option>
                                            <option value="san_borja">San Borja</option>
                                            <option value="surquillo">Surquillo</option>
                                            <option value="san_isidro">San Isidro</option>
                                            <option value="chorrillos">Chorrillos</option>

                                            <option value="cercado">Cercado</option>
                                            <option value="san_luis">San Luis</option>
                                            <option value="brena">Breña</option>
                                            <option value="la_victoria">La Victoria</option>
                                            <option value="rimac">Rimac</option>
                                            <option value="lince">Lince</option>
                                            <option value="san_miguel">San Miguel</option>
                                            <option value="jesus_maria">Jesús María</option>
                                            <option value="magdalena">Magdalena</option>
                                            <option value="pblo_libre">Pblo. Libre</option>
                                        </select>
                                      </div>

                                      <div class="form-group col-12">
                                          <label for="direccion" for="direccion">Dirección</label>
                                          <input id="direccion" class="form-control" name="direccion" type="text" required disabled>
                                      </div>
                                  </div>


                                  <button id="save_list" type="submit" class="btn btn-outline-secondary linear">Crear lista</button>


                                </form>

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

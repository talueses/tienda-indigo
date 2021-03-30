@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form method="POST" action="{{ route('admin.giftregistry.storeList', $cuenta->id) }}" enctype="multipart/form-data">
      {{ csrf_field() }}

      <div class="page-head">
        <h2 class="page-title float-left">Crear programa de regalos</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.giftregistry.lists', $cuenta->id) }}">Cancelar</a>
              </li>
              <li>
                  <button class="btn btn-primary btn-action" type="submit">Guardar</button>
              </li>
          </ul>
        </div>

      </div>

      <div class="page-date">
          <div class="row">
            <div class="col-md-12"><small></small></div>
          </div>
      </div>

      @include('admin.layouts.errors')
      <!-- card -->
        <div class="row">

          <div class="col-sm-8">

                <div class="card mb-3">

                    <div class="card-header">Detalles del Programa</div>

                    <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="form-row">

                                <div class="form-group col-6">
                                    <label for="nombre" class="col-form-label">Título <span class="text-danger">*</span></label>
                                    <div>
                                    <input class="form-control" name="titulo_evento" type="text" id="nombre">
                                    </div>
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-6">
                                    <label for="fecha" class="col-form-label">Fecha del Evento <span class="text-danger">*</span></label>
                                    <div>
                                        <input id="fecha_evento" name="fecha_evento" type="text" class="form-control" required="true">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="desc_evento">Descripción</label>
                                <textarea class="form-control" name="desc_evento" id="desc_evento" rows="4"></textarea>
                            </div>



                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label for="nombres">Nombre Organizador 1</label>
                                            <input class="form-control" name="organizador_uno" type="text">
                                        </div>

                                        <div class="form-group col">
                                            <label for="apellidos">Nombre Organizador 2</label>
                                            <input class="form-control" name="organizador_dos" type="text">
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    </div>
                    <div class="card-footer small text-muted"></div>

                </div>


                <div class="card mb-3">
                    <div class="card-header">Detalles de entrega</div>

                    <div class="card-body">

                        <div class="form-row">

                            <div class="form-group col">
                                <label for="modo_entrega">Tipo</label>
                                <select name="modo_entrega" id="modo_entrega" class="form-control" required>
                                    <!-- No hay recojo en tienda por solicitud del cliente.-->
                                    <option value="recojo_tienda">No hay entrega en tienda</option>
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


                    </div>

                  </div>


          </div>





          <div class="col-sm-4">

              <div class="card mb-3">

                <div class="card-header">Imagen del Programa</div>

                <div class="card-body">
                  <div class="image-preview">
                    <img class="img-fluid" id="imgpreview" src="" alt="">
                  </div>

                  <p>Tamaño Referencial: (730 x 420px)</p>
                  <span class="btn btn-default btn-action btn-file">Escoger imagen <input type="file" name="img" onchange="readURL(this)"></span>

                </div>

                <div class="card-footer small text-muted"></div>
              </div>

          </div>

        </div>
      <!-- /card -->

  </form>


</div>

@endsection

@section('scripts')
<script type="text/javascript">

  $('#fecha_evento').datepicker({
      language: 'es',
      startDate: 'today'
  });

  $('#modo_entrega').on('change', function(e) {
      $this = $(this);
      console.log($this);

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

  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#imgpreview').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>
@stop

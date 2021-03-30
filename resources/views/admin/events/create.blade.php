@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form id="create_event_form" method="POST" action="{{ route('exhibition.store') }}" enctype="multipart/form-data" target="_blank">
      {{ csrf_field() }}

      <input type="hidden" name="preview" value="false">

      <div class="page-head">
        <h2 class="page-title float-left">Crear Evento</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <!--
              <li>
                  <a class="btn btn-default btn-action preview">Ver Preview</a>
              </li>
              -->
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('exhibitions') }}">Cancelar</a>
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

                <div class="card-header">Detalles del Evento</div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="titulo" class="col-form-label">Titulo <span class="text-danger">*</span></label>
                            <div>
                              <input class="form-control {{$errors->has('titulo') ? 'border-danger' : ''}}" name="titulo" type="text" id="titulo" value="{{ old('titulo') }}">
                            </div>
                          </div>

                          <div class="form-group col-6">
                              <label for="publicado" class="col-form-label">Estado</label>
                              <div class="clearfix"></div>
                              <div class="estado-switch">
                                <div>Borrador</div> <input type="checkbox" checked="true" name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                              </div>
                          </div>

                        </div>

                        <div class="form-group">
                            <label for="artista" class="col-form-label">Artista</label>
                            <div>
                                <input class="form-control col-6" name="artista" type="text" id="artista" value="{{ old('artista') }}">
                            </div>
                        </div>

                        <div class="form-group">
                          <label for="desc">Descripción</label>
                          <div class="loading-sm">
                              <textarea id="desc" name="desc">{{ old('desc') }}</textarea>
                          </div>
                        </div>


                        <div class="form-row">

                          <div class="form-group col-6">
                            <label for="fecha_inicio" class="col-form-label">Fecha Inicio <span class="text-danger">*</span></label>
                            <div>
                              <input type="date" class="form-control {{$errors->has('titulo') ? 'border-danger' : ''}}" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}">
                            </div>
                          </div>

                          <div class="form-group col-6">
                            <label for="fecha_fin" class="col-form-label">Fecha Fin</label>
                            <div>
                              <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}">
                            </div>
                          </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                            <label for="hora" class="col-form-label">Hora <span class="text-danger">*</span></label>
                            <div>
                              <input type="time" class="form-control {{$errors->has('hora') ? 'border-danger' : ''}}" name="hora" id="hora" value="{{ old('hora') }}">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="precio" class="col-form-label">Precio <span class="text-danger">*</span></label>
                            <div>


                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">S/</span>
                                </div>
                                <input type="number" class="form-control {{$errors->has('precio') ? 'border-danger' : ''}}" aria-label="Cantidad" name="precio" id="precio" min="0" step="0.01" value="{{ old('precio') }}">

                              </div>


                            </div>
                          </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                            <label for="lugar" class="col-form-label">Lugar <span class="text-danger">*</span></label>
                            <div>
                              <input type="text" class="form-control {{$errors->has('lugar') ? 'border-danger' : ''}}" name="lugar" id="lugar" placeholder="Museo Central" value="{{ old('lugar') }}">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="distrito" class="col-form-label">Distrito <span class="text-danger">*</span></label>
                            <div>
                              <input type="text" class="form-control {{$errors->has('distrito') ? 'border-danger' : ''}}" name="distrito" id="distrito" placeholder="Lima" value="{{ old('distrito') }}">
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="direccion">Dirección</label>
                          <input class="form-control" name="direccion" type="text" id="direccion" value="{{ old('direccion') }}">
                        </div>


                        <!-- <div class="form-group">
                          <label for="direccion">Tags</label>
                          <textarea class="form-control" name="tags" id="tags" rows="4" col="8">{{ old('tags') }}</textarea>
                          <small id="emailHelp" class="form-text text-muted">Separar los tags con comas.</small>
                        </div> -->

                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>

          </div>

          <div class="col-sm-4">

              <div class="card mb-3">

                <div class="card-header">Imagen del Evento</div>

                <div class="card-body">
                  <div class="image-preview">
                    <img class="img-fluid" id="imgpreview" src="" alt="">
                  </div>

                  <p>Tamaño Referencial: (960 x 542px)</p>
                  <span class="btn btn-default btn-action btn-file">Escoger imagen <input type="file" name="img" onchange="readURL(this)"></span>

                </div>

                <div class="card-footer small text-muted"></div>
              </div>

          </div>

        </div>
      <!-- /card -->



      <!-- Galeria -->
      <div class="card mb-3">

        <div class="card-header">Galería</div>

        <div class="card-body">
              <div id="uploadImgs" class="mb-2" style="width:100%;display:inline-block;line-height: 30px;">
                  <span class="float-left btn btn-default btn-action btn-file"><i class="fas fa-images"></i> Escoger imagenes <input type="file" id="gal_images" name="images[]" multiple /></span> <small>&nbsp; (se puede escoger más de una)</small>
                  <br>
              </div>

              <div class="container-gallery">
                  <ul class="new_list"></ul>
              </div>
        </div>

        <div class="card-footer small text-muted"></div>

      </div>
      <!-- / Galeria -->

  </form>

</div>

@endsection

@section('scripts')
<script type="text/javascript">

  $('.btn-action[type="submit"]').on('click', function(e) {
      e.preventDefault();

      var form = $('#create_event_form');
      $('input[name="preview"]').val(0);
      form.attr('target', '_self');

      form.submit();

  });

  $('.btn-action.preview').on('click', function(e) {
      e.preventDefault();

      $('input[name="preview"]').val(1);

      var form = $('#create_event_form');
      form.attr('target', '_blank');
      form.submit();

      $('input[name="preview"]').val(0);
      form.attr('target', '_self');
  });

  $(document).ready(function() {

    tinymce.init({
      selector: 'textarea#desc',
      language: 'es_MX',
      language_url: '/tinymce/langs/es_MX.js',
      plugins: 'image code media link',
      height: 250,
      toolbar: 'undo redo | image media link code',

      fontsize_formats: '11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 24px 36px 48px',

      media_live_embeds: true,

      automatic_uploads: true,
      images_reuse_filename: true,

      file_picker_types: 'media', //only for videos

      file_picker_callback: function(callback, value, meta) {

        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', '/jpg/jpeg/png/video/*');

        input.onchange = function() {

          var file = this.files[0];
          //console.log('video file', file);

          var reader = new FileReader();
          reader.readAsDataURL(file);

          reader.onload = function() {

            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.open('POST', '/admin/events/vid/uploadvideos');
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content') );

            xhr.onload = function() {
              var json;

              if (xhr.status != 200) {
                //failure('HTTP Error: ' + xhr.status);
                console.error('HTTP Error: ' + xhr.status);
                return;
              }

              if (xhr.responseText.includes("error")) {
                alert('el archivo excede el límite permitido: 2MB');
                return;
              }

              json = JSON.parse(xhr.responseText);

              if (!json || typeof json.location != 'string') {
                //failure('Invalid JSON: ' + xhr.responseText);

                console.log('HTTP Error: ' + json.error);
                return;
              }

              if (meta.filetype == 'media') {
                callback(json.location);
              }
              //success(json.location);
            };

            formData = new FormData();
            formData.append('file', file);

            xhr.send(formData);

          };

        };

        input.click();

      },

      // we override default upload handler to simulate successful upload
      images_upload_handler: function (blobInfo, success, failure) {

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/events/img/uploadimages');
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content') );

        xhr.onload = function() {
          var json;

          if (xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
          }

          json = JSON.parse(xhr.responseText);

          if (!json || typeof json.location != 'string') {
            failure('Invalid JSON: ' + xhr.responseText);
            return;
          }

          console.log(json);
          success(json.location);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
      }
    });

    $('#desc').parent().removeClass('loading-sm');

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

    $('#images').on('change', function(e) {
      var fileC = new Array();
      var files = e.target.files;

      $('#galeriaproducto').html('');

      $.each(files, function(i, file){

          fileC.push(file);

          var reader = new FileReader();
          reader.onload = function (e) {
            var t = '<div class="p-3 temp_img_g"><div class="mb-2"><img class="rounded border img-gallery" src="'+e.target.result+'" alt="'+file.name+'"></div></div>';
            $('#galeriaproducto').append(t);
          };
          reader.readAsDataURL(file);
      });
    });
</script>
@stop

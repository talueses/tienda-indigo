@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form id="create_artist_form" method="POST" action="{{ route('admin.artist.store') }}" enctype="multipart/form-data" target="_blank">
      {{ csrf_field() }}

      <input type="hidden" name="preview" value="false">

      <div class="page-head">
        <h2 class="page-title float-left">Nuevo Artista</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action preview">Ver Preview</a>
              </li>
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.artists') }}">Cancelar</a>
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

    <div class="row">

      <div class="col-sm-8">

          <div class="card mb-3">

            <div class="card-header">Perfil</div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="publicado" class="col-form-label">Estado</label>
                            <div class="clearfix"></div>
                            <div class="estado-switch">
                              <div>Borrador</div> <input type="checkbox" checked="true" name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                            </div>
                        </div>

                        <div class="form-group col">
                            <label for="destacado" class="col-form-label">Destacado</label>
                            <div class="clearfix"></div>

                              <input type="checkbox" selected="false" name="destacado"/>

                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                          <label for="nombres">Nombres <span class="text-danger">*</span></label>
                          <input type="text" class="form-control {{$errors->has('nombres') ? 'border-danger' : ''}}" name="nombres" id="nombres" value="{{ old('nombres') }}">
                        </div>

                        <div class="form-group col">
                          <label for="apellidos">Apellidos <span class="text-danger">*</span></label>
                          <input type="text" class="form-control {{$errors->has('apellidos') ? 'border-danger' : ''}}" name="apellidos" id="apellidos" value="{{ old('apellidos') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bio">Biografía <span class="text-danger">*</span></label>

                        <div class="loading-sm {{$errors->has('bio') ? 'border-danger' : ''}}">
                          <textarea id="bio" name="bio">{{ old('bio') }}</textarea>
                        </div>
                    </div>


                    <div class="form-row">

                          <div class="form-group col">
                            <label for="pais">Pais <span class="text-danger">*</span></label>
                            <input type="text" name="pais" class="form-control {{$errors->has('pais') ? 'border-danger' : ''}}" id="pais" value="{{ old('pais') }}">
                          </div>

                          <div class="form-group col">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control" id="ciudad" value="{{ old('ciudad') }}">
                          </div>

                    </div>


                    <div class="form-row">

                        <div class="form-group col-6">
                          <label for="telefono">Telefono</label>
                          <input type="text" name="telefono" class="form-control" id="telefono" value="{{ old('telefono') }}">
                        </div>

                    </div>

                </div>
              </div>
            </div>
            <div class="card-footer small text-muted"></div>
          </div>

          <div class="card mb-3">

            <div class="card-header">Detalles</div>

              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">

                      <div class="form-row">
                        <div class="form-group col">
                          <label for="peso" class="col-form-label">Estudios</label>
                          <div class="control-form-summernote">
                            <!--textarea name="estudios" id="estudios" class="form-control" cols="8" rows="8"></textarea-->
                            <textarea id="estudios" name="estudios">{{ old('estudios') }}</textarea>
                          </div>
                        </div>

                        <div class="form-group col">
                          <label for="tamano" class="col-form-label">Muestras</label>
                          <div class="control-form-summernote">
                            <!--textarea name="muestras" id="muestras" class="form-control" cols="8" rows="8"></textarea-->
                            <textarea id="muestras" name="muestras">{{ old('muestras') }}</textarea>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="premios">Premios</label>
                        <div class="control-form-summernote">
                          <textarea name="premios" id="premios" class="form-control" cols="8" rows="8">{{ old('premios') }}</textarea>
                        </div>
                      </div>


                  </div>
                </div>
              </div>
              <div class="card-footer small text-muted"></div>

            </div>

      </div>

      <div class="col-sm-4">

          <div class="card mb-3">

            <div class="card-header">Imagen del Artista</div>

            <div class="card-body">

              <div class="image-preview">
                <img class="img-fluid" id="imgpreview" src="" alt="">
              </div>

              <p>Tamaño Referencial: (510 x 510px)</p>
              <span class="btn btn-default btn-action btn-file">Escoger imagen <input id="file" type="file" name="img" onchange="readURL(this)"></span>

            </div>
            <div class="card-footer small text-muted"></div>
          </div>


          <div class="card mb-3">
            <div class="card-header">Imagen de Portada</div>
            <div class="card-body">

              <div class="image-preview" style="height: 100px;width: auto;">
                <img class="img-fluid" id="imgpreview_portada" src="" alt="" style="object-fit: cover;width: 100%;">
              </div>
              <p>Tamaño Referencial: (1680 x 240 px)</p>
              <span class="btn btn-default btn-action btn-file">Escoger imagen <input id="file_portada" type="file" name="img_portada" onchange="readURLPortada(this)"></span>

            </div>
            <div class="card-footer small text-muted"></div>
          </div>

      </div>

    </div>

  </form>

</div>

@endsection

@section('scripts')
<script type="text/javascript">

  $('.btn-action[type="submit"]').on('click', function(e) {
      e.preventDefault();

      var form = $('#create_artist_form');
      $('input[name="preview"]').val(0);
      form.attr('target', '_self');

      form.submit();

  });

  $('.btn-action.preview').on('click', function(e) {
    e.preventDefault();

    $('input[name="preview"]').val(1);

    var form = $('#create_artist_form');
    form.attr('target', '_blank');
    form.submit();

    $('input[name="preview"]').val(0);
    form.attr('target', '_self');
  });

    $(document).ready(function() {

      tinymce.init({
          selector: 'textarea#bio',
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

        tinymce.init({
            selector: 'textarea#muestras',
            language: 'es_MX',
            language_url: '/tinymce/langs/es_MX.js',
            plugins: 'code',
            height: 250,
            toolbar: 'undo redo | image code',

            automatic_uploads: true,
            images_reuse_filename: true,
        });

        tinymce.init({
            selector: 'textarea#premios',
            language: 'es_MX',
            language_url: '/tinymce/langs/es_MX.js',
            plugins: 'code',
            height: 250,
            toolbar: 'undo redo | image code',

            automatic_uploads: true,
            images_reuse_filename: true,
        });

        tinymce.init({
            selector: 'textarea#estudios',
            language: 'es_MX',
            language_url: '/tinymce/langs/es_MX.js',
            plugins: 'code',
            height: 250,
            toolbar: 'undo redo | image code',

            automatic_uploads: true,
            images_reuse_filename: true,
        });


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

  function readURLPortada(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#imgpreview_portada').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>
@stop

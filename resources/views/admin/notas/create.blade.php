@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data">
      {{ csrf_field() }}

      <div class="page-head">
        <h2 class="page-title float-left">Crear Nota</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('notes') }}">Ver Preview</a>
              </li>
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('notes') }}">Cancelar</a>
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

                <div class="card-header">Detalles de la Nota</div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="titulo" class="col-form-label">Título <span class="text-danger">*</span></label>
                            <div>
                              <input class="form-control" name="titulo" type="text" id="titulo" required>
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
                          <label for="fuente" class="col-form-label">Fuente</label>
                          <div>
                              <input class="form-control col-6" value="" name="fuente" type="text" id="fuente">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="fecha" class="col-form-label">Fecha <span class="text-danger">*</span></label>
                          <div>
                              <input class="form-control col-6" name="fecha" type="text" id="fecha" required>
                          </div>
                        </div>


                        <div class="form-group">
                          <label for="desc">Descripción <span class="text-danger">*</span></label>
                          <div class="loading-sm">
                              <textarea name="desc" id="desc"></textarea>
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

                <div class="card-header">Imagen de la Nota</div>

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

  $('#fecha').datepicker({
      language: 'es'
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
              var t = '<div class="list-group-item list-group-item-action" href="#"><div class="media"><img class="d-flex mr-3 rounded img-gallery" src="'+e.target.result+'" alt="'+file.name+'"><div class="media-body align-self-center"><strong>'+file.name+'</strong></div></div></div>';

              $('#galeriaproducto').append(t);
          };
          reader.readAsDataURL(file);
      });
    });
</script>
@stop

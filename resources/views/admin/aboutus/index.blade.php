@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form method="POST" action="{{ route('admin.aboutus') }}" enctype="multipart/form-data">
      {{ csrf_field() }}

      <div class="page-head">
        <h2 class="page-title float-left">Editar Nosotros</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action" target="_blank" href="{{ route('home.nosotros') }}">Ver Página</a>
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

                <!--div class="card-header"></div-->

                <div class="loading">
                    <textarea id="desc" name="editordata">@if($nosotros){{ $nosotros->contenido }}@endif</textarea>
                </div>

                <div class="card-footer small text-muted"></div>
              </div>

          </div>

          <div class="col-sm-4">

              <div class="card mb-3">

                <div class="card-header">Imagen de la Exposición</div>

                <div class="card-body">
                  <div class="image-preview">
                    <img class="img-fluid" id="imgpreview" src="@if($nosotros){{ url($nosotros->img) }}@endif" alt="">
                  </div>

                  <p>Tamaño Referencial: (555 x 555px)</p>
                  <span class="btn btn-default btn-action btn-file">Escoger imagen <input type="file" name="img" onchange="readURL(this)"></span>

                  <a href="#" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview float-right pt-2">Eliminar imagen</a>

                </div>

                <div class="card-footer small text-muted"></div>
              </div>


          </div>

        </div>
      <!-- /card -->

  </form>


</div>


<!-- modal eliminar imagen cover -->
    <div class="modal fade" id="confirm_delete_image" tabindex="-1" role="dialog" aria-hidden="true">
      <form method="POST" action="{{ route('admin.aboutus.deleteImage') }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar imagen de portada</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Eliminar imagen?

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

    tinymce.init({
        selector: 'textarea#desc',
        language: 'es_MX',
        language_url: '/tinymce/langs/es_MX.js',
        setup : function(ed) {
          ed.on('init', function (ed) {
            this.getDoc().body.style.fontSize = '14px';
            this.getDoc().body.style.fontFamily = 'Arial, sans-serif';
          });
        },
        plugins: [
          "autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount media code"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media code",
        height: 650,

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

      $('#desc').parent().removeClass('loading');

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

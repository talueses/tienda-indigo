@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form method="POST" action="{{ route('admin.terminosycondiciones') }}" enctype="multipart/form-data">
      {{ csrf_field() }}

      <div class="page-head">
        <h2 class="page-title float-left">Editar Término</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action" target="_blank" href="{{ route($link) }}">Ver Página</a>
              </li>
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.terminosycondiciones') }}">Cancelar</a>
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

                <input type="hidden" name="termino_id" value="{{ $condicion->id }}">

                <div class="loading">
                    <textarea id="desc" name="editordata">@if($condicion){{ $condicion->valor }}@endif</textarea>
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


  $(document).ready(function() {

    tinymce.init({
        selector: 'textarea#desc',
        language: 'es_MX',
        language_url: '/tinymce/langs/es_MX.js',
        plugins: 'image code media link',
        height: 650,
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

      $('#desc').parent().removeClass('loading');

  });

</script>
@stop

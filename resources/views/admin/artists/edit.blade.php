@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form id="edit_artist_form" method="POST" action="{{ route('admin.artist.update', $artista->id) }}" enctype="multipart/form-data" target="_blank">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <input type="hidden" name="preview" value="false">

      <div class="page-head">
        <h2 class="page-title float-left">Editar Artista</h2>


        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action preview" target="_blank">Ver Preview</a>
              </li>
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.artists') }}">Cancelar</a>
              </li>
              <li>
                  <button class="btn btn-primary btn-action" type="submit">Actualizar</button>
              </li>
          </ul>
        </div>

      </div>

      <div class="page-date">
          <div class="row">
            <div class="col text-left">
              <div class="external-link">
                  <span class="badge badge-light">
                    <a href="{{ route('home.artista.detail', $artista->slug) }}" target="_blank">{{ route('home.artista.detail', $artista->slug) }} <i class="fas fa-external-link-alt"></i></a>
                  </span>                  
              </div>
            </div>
            <div class="col"><small>Actualizado {{ $artista->updatedAt() }}</small></div>
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
                                <div>Borrador</div> <input type="checkbox" {{ ($artista->publicado) ? 'checked="true"' : '' }} name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                              </div>
                          </div>

                          <div class="form-group col">
                              <label for="destacado" class="col-form-label">Destacado</label>
                              <div class="clearfix"></div>

                              <input type="checkbox" {{ ($artista->destacado) ? 'checked="true"' : '' }} selected="false" name="destacado"/>
                          </div>

                      </div>


                      <div class="form-row">

                          <div class="form-group col">
                            <label for="nombres">Nombres <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $artista->nombres }}" class="form-control" name="nombres" id="nombres" placeholder="">
                          </div>

                          <div class="form-group col">
                            <label for="apellidos">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $artista->apellidos }}" class="form-control" name="apellidos" id="apellidos" placeholder="">
                          </div>

                      </div>


                      <div class="form-group">
                          <label for="bio">Biografía <span class="text-danger">*</span></label>

                          <div class="loading-sm">
                            <textarea id="bio" name="bio">{{ $artista->bio }}</textarea>
                          </div>
                      </div>


                      <div class="form-row">

                          <div class="form-group col">
                            <label for="pais">Pais <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $artista->pais }}" name="pais" class="form-control" id="pais" placeholder="">
                          </div>

                          <div class="form-group col">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" value="{{ $artista->ciudad }}" name="ciudad" class="form-control" id="ciudad" placeholder="">
                          </div>

                      </div>

                      <div class="form-row">

                          <div class="form-group col-6">
                            <label for="telefono">Telefono</label>
                            <input type="text" value="{{ $artista->telefono }}" name="telefono" class="form-control" id="telefono">
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
                                  <!--textarea name="estudios" id="estudios" class="form-control" cols="8" rows="8">{{-- $artista->estudios --}}</textarea-->
                                  <textarea id="estudios" name="estudios">{{ $artista->estudios }}</textarea>
                                </div>
                              </div>

                              <div class="form-group col">
                                <label for="tamano" class="col-form-label">Muestras</label>
                                <div class="control-form-summernote">
                                  <!--textarea name="muestras" id="muestras" class="form-control" cols="8" rows="8">{{ $artista->muestras }}</textarea-->
                                  <textarea id="muestras" name="muestras">{{ $artista->muestras }}</textarea>
                                </div>
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="otros">Premios</label>
                              <div class="control-form-summernote">
                                <!--textarea name="premios" id="premios" class="form-control" cols="8" rows="8">{{ $artista->premios }}</textarea-->
                                <textarea id="premios" name="premios">{{ $artista->premios }}</textarea>
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
                  <img class="img-fluid" id="imgpreview" src="{{ $artista->img }}" alt="">
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
                  <img class="img-fluid" id="imgpreview_portada" src="{{ $artista->img_portada }}" alt="" style="object-fit: cover;width: 100%;">
                </div>
                <p>Tamaño Referencial: (1680 x 240 px)</p>
                <span class="btn btn-default btn-action btn-file">Escoger imagen <input id="file_portada" type="file" name="img_portada" onchange="readURLPortada(this)"></span>

                <a href="#" data-toggle="modal" data-target="#confirm_delete_imagecover" class="delete-preview float-right pt-2">Eliminar imagen</a>

              </div>

              <div class="card-footer small text-muted"></div>
            </div>

        </div>


      </div>

  </form>

</div>


    <!-- modal eliminar imagen cover -->
    <div class="modal fade" id="confirm_delete_imagecover" tabindex="-1" role="dialog" aria-hidden="true">
      <form method="POST" action="{{ route('admin.artist.removeCoverImage', $artista->id) }}">
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
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Eliminar</button>
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

      var form = $('#edit_artist_form');
      $('input[name="preview"]').val(0);
      form.attr('target', '_self');

      form.submit();

  });

  $('.btn-action.preview').on('click', function(e) {
      e.preventDefault();

      $('input[name="preview"]').val(1);

      var form = $('#edit_artist_form');
      form.attr('target', '_blank');
      form.submit();

      $('input[name="preview"]').val(0);
      form.attr('target', '_self');
  });

  $(document).ready(function() {

    tinymce.init({
        selector: 'textarea#bio',

        setup : function(ed) {
            ed.on('init', function (ed) {
              this.getDoc().body.style.fontSize = '14px';
              this.getDoc().body.style.fontFamily = 'Arial, sans-serif';
            });
        },
        resize: false,
        language: 'es_MX',
        language_url: '/tinymce/langs/es_MX.js',
        plugins: [
          "autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount media code table"
        ],//'image code media link',
        toolbar: "insertfile undo redo | styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media code",
        //toolbar: 'undo redo | image media link code',
        height: 250,
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
        selector: 'textarea#estudios',
        setup : function(ed) {
          ed.on('init', function (ed) {
            this.getDoc().body.style.fontSize = '14px';
            this.getDoc().body.style.fontFamily = 'Arial, sans-serif';
          });
        },
        language: 'es_MX',
        language_url: '/tinymce/langs/es_MX.js',
        plugins: 'code',
        height: 250,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code',
        fontsize_formats: '11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 24px 36px 48px',

        automatic_uploads: true,
        images_reuse_filename: true,
    });

    tinymce.init({
        selector: 'textarea#muestras',
        setup : function(ed) {
          ed.on('init', function (ed) {
            this.getDoc().body.style.fontSize = '14px';
            this.getDoc().body.style.fontFamily = 'Arial, sans-serif';
          });
        },
        language: 'es_MX',
        language_url: '/tinymce/langs/es_MX.js',
        plugins: 'code',
        height: 250,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code',
        fontsize_formats: '11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 24px 36px 48px',

        automatic_uploads: true,
        images_reuse_filename: true,
    });

    tinymce.init({
        selector: 'textarea#premios',
        setup : function(ed) {
          ed.on('init', function (ed) {
            this.getDoc().body.style.fontSize = '14px';
            this.getDoc().body.style.fontFamily = 'Arial, sans-serif';
          });
        },
        language: 'es_MX',
        language_url: '/tinymce/langs/es_MX.js',
        plugins: 'code',
        height: 250,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link code',
        fontsize_formats: '11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 24px 36px 48px',

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

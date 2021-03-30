@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form method="POST" action="{{ URL::route('notes.update', $nota->id) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <div class="page-head">
        <h2 class="page-title float-left">Actualizar Nota</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <!--<li>
                  <a class="btn btn-default btn-action" href="{{ route('notes') }}">Ver Nota</a>
              </li>-->
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('notes') }}">Cancelar</a>
              </li>
              <li>
                  <button class="btn btn-primary btn-action" type="submit">Actualizar</button>
              </li>
          </ul>
        </div>

      </div>

      <div class="page-date">
          <div class="row">
            <div class="col-md-12"><small>Actualizado {{ $nota->updatedAt() }}</small></div>
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
                            <label for="evento" class="col-form-label">Titulo <span class="text-danger">*</span></label>
                            <div>
                              <input class="form-control" value="{{ $nota->titulo }}" name="titulo" type="text" id="evento">
                            </div>
                          </div>

                          <div class="form-group col">
                              <label for="publicado" class="col-form-label">Estado</label>
                              <div class="clearfix"></div>
                              <div class="estado-switch">
                                <div>Borrador</div> <input type="checkbox" {{ ($nota->publicado) ? 'checked="true"' : '' }} name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                              </div>
                          </div>

                        </div>

                        <div class="form-group">
                          <label for="fuente" class="col-form-label">Fuente</label>
                          <div>
                              <input class="form-control col-6" value="{{ $nota->fuente }}" name="fuente" type="text" id="fuente">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="fecha" class="col-form-label">Fecha <span class="text-danger">*</span></label>
                          <div>
                              <input class="form-control col-6" value="{{ $nota->fecha }}" name="fecha" type="text" id="fecha">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="desc">Descripción <span class="text-danger">*</span></label>
                          <div class="loading-sm">
                              <textarea name="desc" id="desc">{{ $nota->desc }}</textarea>
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
                    <img class="img-fluid" id="imgpreview" src="{{ $nota->img }}" alt="">
                  </div>

                  <p>Tamaño Referencial: (960 x 542px)</p>

                  <span class="btn btn-default btn-action btn-file">Escoger imagen <input id="file" type="file" name="img" onchange="readURL(this)"></span>

                </div>

                <div class="card-footer small text-muted"></div>
              </div>


          </div>

        </div>
      <!-- /card -->
    </form>


    <!-- Galeria -->
    <div class="card mb-3">

      <div class="card-header">Galería</div>

      <div class="card-body">

          <form method="POST" action="{{ URL::route('note.saveGallery', $nota->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div id="uploadImgs" class="mb-2" style="width:100%;display:inline-block;line-height: 30px;">
                <span class="float-left btn btn-default btn-action btn-file"><i class="fas fa-images"></i> Escoger imagenes <input type="file" id="gal_images" name="images[]" multiple /></span> <small>&nbsp; (se puede escoger más de una)</small>

                <button type="button" class="ml-2 btn btn-default btn-action float-right cancel-upl-gallery" style="display:none;">Cancelar</button>
                <button type="submit" class="float-right btn btn-danger" id="uploadGallery" style="display:none;" >Subir imagenes</button>
                <br>
            </div>
          </form>

            <a href="javascript:void(0);" class="btn btn-default btn-action reorder_link"><i class="fas fa-sort"></i> Reordenar</a>

            <div class="editReOrder_m" style="display:none;">
                <button type="button" class="mr-2 btn btn-default btn-action float-left cancel-edit-order">Cancelar</button>
                <a href="javascript:void(0);" class="btn btn-default btn-danger" id="saveReorder">Guardar Orden</a>
            </div>

            <div id="reorderHelper" class="light_box" style="display:none;">1. Mover la posición de las fotos para ordenar.<br>2. Click en 'Guardar Orden' al finalizar.</div>
            <div class="container-gallery">
                <ul class="reorder_ul reorder-photos-list">

                  @foreach ($nota->galeria_img as $key => $img)
                    <li id="image_li_{{$key}}" class="ui-sortable-handle">
                        <a href="javascript:void(0);" style="float:none;" class="image_link">
                            <img src="{{ '/uploads/notes/shop/'.$img }}" style="object-fit:cover;" width="250" height="156" alt="">
                        </a>
                        <br>
                        <a class="remove-img-galeria" data-toggle="modal" data-url="{{ route('exhibition.destroy.galleryimage', $img) }}" data-id="{{ $img }}" data-target="#confirm_delete_galleryimage" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
                    </li>
                  @endforeach

                </ul>
            </div>

            <div class="container-gallery">
                <ul class="new_list"></ul>
            </div>


      </div>

      <div class="card-footer small text-muted"></div>

    </div>
    <!-- / Galeria -->


</div>


  <!-- Modal -->
  <div class="modal fade" id="confirm_delete_galleryimage" tabindex="-1" role="dialog" aria-hidden="true">
      <form id="form_delete_galleryimage" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <input type="hidden" name="event_id" value="{{ $nota->id }}">
        <input type="hidden" name="event_slug" value="{{ $nota->slug }}">


        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar imagen</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Eliminar el elemento seleccionado?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary cancel-galleryimage-delete" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
          </div>
        </div>

      </form>
    </div>


@endsection



@section('scripts')
<script type="text/javascript">

  $('#fecha').datepicker({
      language: 'es'
  });


  $(document).ready(function() {

    $('.remove-img-galeria').click(function() {
      var id = $(this).attr('data-id');
      var url = $(this).attr('data-url');
      $("#form_delete_galleryimage").attr("action", url);
      $('body').find('#form_delete_galleryimage').append('<input name="id" type="hidden" value="'+ id +'">');
    });

    $('.cancel-galleryimage-delete').click(function() {
      $('body').find('#form_delete_galleryimage').find( "input" ).remove();
    });

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


  $("#saveReorder").click(function( e ){
      e.preventDefault();

      $("ul.reorder-photos-list").sortable('destroy');
      $("#reorderHelper").html( "Guardando cambios... Por favor no cierre esta página." ).removeClass('light_box').addClass('notice notice_info');

      var galeriaImg = [];
      $("ul.reorder-photos-list li").each(function() {
        galeriaImg.push($(this).find('img').attr('src').substr(20));
      });

      $.ajax({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "post", url: "/admin/notes/galleryimage/updateposition/<?= $nota->id; ?>",
        data: { data: galeriaImg},
        success: function(msg, data) {
          //console.log(msg, data);
            if (msg.success) {
                window.location.reload();
            }
        }
      });
      return false;
  });

</script>
@stop

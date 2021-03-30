 @extends ('admin.layouts.master')

@section ('content')
<div class="container-fluid">

    <form id="exposicionform" method="POST" action="{{ URL::route('exhibition.update', $exposicion->id) }}" enctype="multipart/form-data" target="_blank">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <input type="hidden" name="preview" value="false">

      <div class="page-head">
        <h2 class="page-title float-left">Actualizar Evento</h2>

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
                  <button class="btn btn-primary btn-action" type="submit">Actualizar</button>
              </li>
          </ul>
        </div>

      </div>

      <div class="page-date">
          <div class="row">
            <div class="col-md-12"><small>Actualizado {{ $exposicion->updatedAt() }}</small></div>
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
                              <input class="form-control {{$errors->has('titulo') ? 'border-danger' : ''}}" value="{{ $exposicion->titulo }}" name="titulo" type="text" id="titulo">
                            </div>
                          </div>

                          <div class="form-group col">
                              <label for="publicado" class="col-form-label">Estado</label>
                              <div class="clearfix"></div>
                              <div class="estado-switch">
                                <div>Borrador</div> <input type="checkbox" {{ ($exposicion->publicado) ? 'checked="true"' : '' }} name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                              </div>
                          </div>

                        </div>

                        <div class="form-group">
                          <label for="artista" class="col-form-label">Artista</label>
                          <div>
                              <input class="form-control col-6" value="{{ $exposicion->artista }}" name="artista" type="text" id="artista">
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="desc">Descripción</label>
                          <div class="loading-sm">
                              <textarea name="desc" id="desc">{{ $exposicion->desc }}</textarea>
                          </div>
                        </div>

                        <div class="form-row">

                          <div class="form-group col-6">
                            <label for="fecha_inicio" class="col-form-label">Fecha Inicio <span class="text-danger">*</span></label>
                            <div>
                            <input type="date" class="form-control" value="{{ $exposicion->fecha_inicio }}" name="fecha_inicio" id="fecha_inicio">
                            </div>
                          </div>

                          <div class="form-group col-6">
                            <label for="fecha_fin" class="col-form-label">Fecha Fin</label>
                            <div>
                              <input type="date" class="form-control" value="{{ $exposicion->fecha_fin }}" name="fecha_fin" id="fecha_fin">
                            </div>
                          </div>

                        </div>



                        <div class="form-row">
                            <div class="form-group col">
                            <label for="hora" class="col-form-label">Hora <span class="text-danger">*</span></label>
                            <div>
                              <input type="time" class="form-control" value="{{ $exposicion->hora }}" name="hora" id="hora">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="precio" class="col-form-label">Precio <span class="text-danger">*</span></label>
                            <div>

                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">S/</span>
                                </div>
                                <input type="number" value="{{ $exposicion->precio }}" class="form-control" aria-label="Cantidad" name="precio" id="precio" min="0" step="0.01">

                              </div>

                            </div>
                          </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                            <label for="lugar" class="col-form-label">Lugar <span class="text-danger">*</span></label>
                            <div>
                              <input type="text" class="form-control" value="{{ $exposicion->lugar }}" name="lugar" id="lugar">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="distrito" class="col-form-label">Distrito <span class="text-danger">*</span></label>
                            <div>
                              <input type="text" class="form-control" value="{{ $exposicion->distrito }}" name="distrito" id="distrito">
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="direccion">Dirección</label>
                          <input class="form-control" value="{{ $exposicion->direccion }}" name="direccion" type="text" id="direccion">
                        </div>

                        <!-- <div class="form-group">
                          <label for="direccion">Tags</label>
                            <div class="loading-sm form-control-textarea">
                              <textarea name="tags" id="tags">{{-- $exposicion->tags --}}</textarea>
                            </div>

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

                  <div class="img-cont-full bg-secondary r16-9 mb-3">
                    <img class="img-fluid" id="imgpreview" {{ $exposicion->img ? "src=/uploads/exhibitions/{$exposicion->img}" : "" }} alt="">
                  </div>

                  <p>Tamaño Referencial: (960 x 542px)</p>
                  <span class="btn btn-default btn-action btn-file">Escoger imagen <input id="file" type="file" name="img" onchange="readURL(this)"></span>

                  <a href="" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview float-right pt-2">Eliminar imagen</a>

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

          <form method="POST" action="{{ URL::route('exhibition.saveGallery', $exposicion->id) }}" enctype="multipart/form-data">
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

                  @foreach ($exposicion->galeria_img as $key => $img)
                    <li id="image_li_{{$key}}" class="ui-sortable-handle">
                        <a href="javascript:void(0);" style="float:none;" class="image_link">
                            <img src="{{ '/uploads/exhibitions/shop/'.$img }}" style="object-fit:cover;" width="250" height="156" alt="">
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
        <input type="hidden" name="event_id" value="{{ $exposicion->id }}">
        <input type="hidden" name="event_slug" value="{{ $exposicion->slug }}">


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


    <!-- modal eliminar imagen -->
    <div class="modal fade" id="confirm_delete_image" tabindex="-1" role="dialog" aria-hidden="true">
      <form method="POST" action="{{ route('exhibition.removeImage', $exposicion->id) }}">
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

  $('.btn-action[type="submit"]').on('click', function(e) {
      e.preventDefault();

      var form = $('#exposicionform');
      $('input[name="preview"]').val(0);
      form.attr('target', '_self');

      form.submit();

  });

  $('.btn-action.preview').on('click', function(e) {
      e.preventDefault();

      $('input[name="preview"]').val(1);

      var form = $('#exposicionform');
      form.attr('target', '_blank');
      form.submit();

      $('input[name="preview"]').val(0);
      form.attr('target', '_self');
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


    $('#desc').parent().removeClass('loading-sm');

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


  $("#saveReorder").click(function( e ){
      e.preventDefault();

      $("ul.reorder-photos-list").sortable('destroy');
      $("#reorderHelper").html( "<p>Guardando cambios... Por favor no cierre esta página.</p>" );//.removeClass('light_box').addClass('notice notice_info');

      var galeriaImg = [];
      $("ul.reorder-photos-list li").each(function() {
        galeriaImg.push($(this).find('img').attr('src').substr(26));
      });

      $.ajax({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: "post", url: "/admin/events/galleryimage/updateposition/<?= $exposicion->id; ?>",
        data: { data: galeriaImg},
        success: function(msg, data) {
            if (msg.success) {
                window.location.reload();
            }
        }
      });
      return false;
  });


</script>
@stop

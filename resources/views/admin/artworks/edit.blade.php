@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

<form id="edit_obra_form" method="POST" action="{{ route('admin.artwork.update', $obra->id) }}" enctype="multipart/form-data" target="_blank">
  {{ csrf_field() }}
  {{ method_field('PUT') }}

  <input type="hidden" name="preview" value="false">

  <div class="page-head">
    <h2 class="page-title float-left">Editar Obra</h2>

    <div class="page-bar toolbarBox">
      <ul id="toolbar-nav" class="nav nav-pills float-right">
          <li>
              <a class="btn btn-default btn-action preview">Ver Preview</a>
          </li>
          <li>
              <a class="btn btn-default btn-action" href="{{ route('admin.artworks') }}">Cancelar</a>
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
              <a href="{{ route('home.obra.detail', $obra->slug) }}" target="_blank">{{ route('home.obra.detail', $obra->slug) }} <i class="fas fa-external-link-alt"></i></a>
            </span>
        </div>
      </div>
      <div class="col"><small>Actualizado {{ $obra->updatedAt() }}</small></div>
    </div>
  </div>

  @include('admin.layouts.errors')
  <!-- card -->
    <div class="row">

      <div class="col-sm-8">
        <div class="card mb-3">
          <div class="card-header">Detalles del Producto</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-row">
                    <div class="form-group col-6">
                      <label for="nombre" class="col-form-label">Nombre <span class="text-danger">*</span></label>
                      <div>
                        <input class="form-control" value="{{ $obra->nombre }}" name="nombre" type="text" id="nombre">
                      </div>
                    </div>
                    <div class="form-group col">
                      <label for="publicado" class="col-form-label">Estado</label>
                      <div class="clearfix"></div>
                      <div class="estado-switch">
                        <div>Borrador</div> <input type="checkbox" {{ ($obra->publicado) ? 'checked="true"' : '' }} name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                      </div>
                    </div>
                  </div>
                    <div class="form-group">
                      <label for="desc">Descripción Corta <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="desc_corta" id="desc_corta" rows="3" col="8">{{ $obra->desc_corta }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="desc">Descripción</label>
                      <textarea class="form-control" name="desc" id="desc" rows="5" col="8">{{ $obra->desc }}</textarea>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-6">
                        <label for="stock" class="col-form-label">Artista</label>
                        <div>
                          <select name="artista" class="form-control" id="artista">
                            <option value="0">Ninguno</option>
                            @foreach ($artistas as $artista)
                              <option value="{{ $artista->id }}" {{ (isset($obra->artista->id) && $artista->id == $obra->artista->id) ? 'selected' : '' }}>{{ $artista->nombres }} {{ $artista->apellidos }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-6">
                        <label for="anio" class="col-form-label">Año</label>
                        <div>
                          <input type="text" class="form-control" name="anio" id="anio" value="{{ $obra->anio }}">
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                          <label for="categoria">Categoría <span class="text-danger">*</span></label>
                          <select name="categoria" class="form-control" id="categoria">
                            @foreach ($categorias as $categoria)
                              <option value="{{ $categoria->id }}" {{ ($categoria->id == $obra->categoria_id) ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-6">
                          <label for="material">Materiales</label>
                              <select name="materiales[]" class="form-control materials-multiple" multiple="multiple" id="materiales">
                                  @foreach ($materiales as $material)
                                    <option value="{{ $material->id }}"
                                      @foreach($obra->materiales()->get() as $s) @if($material->id == $s->id) selected="selected" @endif @endforeach >
                                        {{ $material->nombre }}
                                    </option>
                                  @endforeach
                              </select>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="card-footer small text-muted"></div>
          </div>

          <!-- BEGIN DISPONIBLE EN TIENDA -->
          <div class="card mb-3">
            <div class="card-header">
              Disponibilidad en tienda
              @if ($obra->producto != null)
              <div class="float-right">
                <i class="fa fa-check-circle fa-2x text-success align-middle"></i> &nbsp;
                <span class="align-middle font-weight-bold">Obra en tienda</span> &nbsp;
              </div>
              @else
              <div class="float-right">
                <button id="crear_en_tienda_btn" class="btn btn-default btn-action float-right" type="button" name="button">
                  Crear en tienda
                </button>
              </div>
              @endif
            </div>
            <div class="card-body">
              <i id="loading_spinner" class="fa fa-spinner fa-spin ml-2 d-none"></i>
              <div id="sync_artwork_response"></div>
              @if ($obra->producto != null)
              <table style="width: 100%;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>SKU</th>
                  <th>Categoria</th>
                  <th>Acciones</th>
                </tr>
              </thead>
                <tbody>
                  <tr>
                    <td>{{ $obra->producto->id }}</td>
                    <td>{{ $obra->producto->sku ? $obra->producto->sku : 'No tiene'  }}</td>
                    <td>{{ $obra->producto->categoria ? $obra->producto->categoria->nombre : 'No categorizado' }}</td>
                    <td>
                      <button id="sync_artwork" class="btn btn-default btn-action" type="button" name="button" {{ $obra->producto ? '' : 'disabled="true"' }}>Sincronizar</button>
                      <a id="ver_en_tienda_btn" class="btn btn-default btn-action">
                        Ver en tienda
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
              @endif
            </div>
            <div class="card-footer small text-muted"></div>
          </div>
          <!-- END DISPONBILE EN TIENDA -->

          <div class="card mb-3">

            <div class="card-header">Detalles</div>

            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">

                    <div class="form-row">
                      <div class="form-group col">
                        <label for="peso" class="col-form-label">Peso (kg)</label>
                        <div>
                          <input type="number" value="{{ $obra->peso }}" class="form-control" name="peso" id="peso" step="0.01">
                        </div>
                      </div>

                      <div class="form-group col">
                        <label for="tamano" class="col-form-label">Dimensiones (alto x ancho x largo cm)</label>
                        <div>
                          <input type="text" value="{{ $obra->tamano }}" class="form-control" name="tamano" id="tamano">
                        </div>
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

            <div class="card-header">Imagen de la Obra</div>

            <div class="card-body">

              <div class="image-preview">
                <img class="img-fluid" id="imgpreview" src="{{ $obra->img }}" alt="">
              </div>
              <p>Tamaño Referencial: (540 x 540px)</p>
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

      <form method="POST" action="{{ route('admin.artwork.saveGallery', $obra->id) }}" enctype="multipart/form-data">
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

              @foreach ($obra->galeria_img as $key => $img)
                <li id="image_li_{{$key}}" class="ui-sortable-handle">
                    <a href="javascript:void(0);" style="float:none;" class="image_link">
                        <img src="{{ '/uploads/artworks/shop/'.$img }}" style="object-fit:cover;" width="250" height="156" alt="">
                    </a>
                    <br>
                    <a class="remove-img-galeria" data-toggle="modal" data-url="{{ route('admin.artwork.destroy.galleryimage', $img) }}" data-id="{{ $img }}" data-target="#confirm_delete_galleryimage" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
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
      <input type="hidden" name="slug" value="{{ $obra->slug }}">


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
<!-- BEGIN Modal Eliminar producto -->
@include('admin.layouts.delete-modal-item', ['title'=>'Eliminar producto'])
<!-- END Modal Eliminar producto -->
@endsection

@section('scripts')
<script type="text/javascript">

$('#crear_en_tienda_btn').click(replicateProduct);

$('#ver_en_tienda_btn').on('click', function(e) {
    e.preventDefault();
    window.open("<?= route('admin.product.edit', $obra->producto ? $obra->producto->id : '' ) ?>", '_blank');
});

$('.remove-img-galeria').click(function() {
  var id = $(this).attr('data-id');
  var url = $(this).attr('data-url');
  $("#form_delete_galleryimage").attr("action", url);
  $('body').find('#form_delete_galleryimage').append('<input name="id" type="hidden" value="'+ id +'">');
});

$('.cancel-galleryimage-delete').click(function() {
  $('body').find('#form_delete_galleryimage').find( "input" ).remove();
});

$('.materials-multiple').select2({ placeholder: 'Seleccionar material' });

$('.btn-action[type="submit"]').on('click', function(e) {
    e.preventDefault();

    var form = $('#edit_obra_form');
    $('input[name="preview"]').val(0);
    form.attr('target', '_self');

    form.submit();

});

$('.btn-action.preview').on('click', function(e) {
  e.preventDefault();

  $('input[name="preview"]').val(1);

  var form = $('#edit_obra_form');
  form.attr('target', '_blank');
  form.submit();

  $('input[name="preview"]').val(0);
  form.attr('target', '_self');
});

$('#sync_artwork').on('click', function(e) {

      e.preventDefault();
      $('#loading_spinner').removeClass('d-none');

      var form = $('#edit_obra_form');
      $('input[name="preview"]').val(0);
      form.attr('target', '_self');
      form.submit();

      var data = {
        "artwork_id": <?= $obra->id ?>,
        "artwork_slug": "<?= $obra->producto ? $obra->producto->slug : '' ?>"
      }

      axios.post('/admin/artworks/syncproduct', data )
        .then(function (response) {
          // handle success
          console.log(response);

          $('#sync_artwork_response').html('<div class="alert alert-success mt-3" role="alert"><p class="mb-0">Obra actualizada en tienda.</p></div>');

        })
        .catch(function (error) {
          // handle error
          console.log(error);
          $('#sync_artwork_response').html('<div class="alert alert-danger mt-3" role="alert"><p class="mb-0">Hubo un error al actualizar.</p></div>');
        })
        .finally(function () {
          // always executed
        });

        setTimeout(function(){
          $('#loading_spinner').addClass('d-none');
        }, 2000);

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

function replicateProduct(e) {

    e.preventDefault();
    $('#loading_spinner').removeClass('d-none');

    var data = {
      "artwork_id": <?= $obra->id ?>
    }

    axios.post('/admin/artworks/replicateproduct', data )
      .then(function (response) {
        
        if (response.data.success) {
            $('#sync_artwork_response').html('<div class="alert alert-success mt-3" role="alert"><p class="mb-0">Obra creada en tienda.</p></div>');
        }

        $('#crear_en_tienda_btn').html('Ver en tienda');
        $('#crear_en_tienda_btn').attr('id', 'ver_en_tienda_btn');
      })
      .catch(function (error) {
        // handle error
        console.log(error);
        $('#sync_artwork_response').html('<div class="alert alert-danger mt-3" role="alert"><p class="mb-0">Hubo un error al actualizar.</p></div>');
      })
      .finally(function () {

        setTimeout(function() {
          location.reload(true);
        }, 2000);
        
      });


      setTimeout(function(){
        $('#loading_spinner').addClass('d-none');
      }, 2000);
}

$('#images').on('change', function(e) {
  var fileC = new Array();

  $('img.img-gallery.new').parent().parent().remove();
  var files = e.target.files;
  $('.temp_img_g').remove();

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


$("#saveReorder").click(function( e ){
    e.preventDefault();

    $("ul.reorder-photos-list").sortable('destroy');
    $("#reorderHelper").html( "Guardando cambios... Por favor no cierre esta página." ).removeClass('light_box').addClass('notice notice_info');

    var galeriaImg = [];
    $("ul.reorder-photos-list li").each(function() {
      galeriaImg.push($(this).find('img').attr('src').substr(23));
    });

    $.ajax({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post", url: "/admin/artworks/galleryimage/updateposition/<?= $obra->id; ?>",
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

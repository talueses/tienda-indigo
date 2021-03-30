@extends ('admin.layouts.master')

@section ('content')
<div class="container-fluid">

    <form id="edit_obra_form" method="POST" action="/admin/products/{{$producto->id}}" enctype="multipart/form-data" target="_blank">
      {{ csrf_field() }}
      {{ method_field('PUT') }}

      <input type="hidden" name="preview" value="false">

      <div class="page-head">
        <h2 class="page-title float-left">Editar Producto</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action preview">Ver Preview</a>
              </li>
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.products') }}">Cancelar</a>
              </li>
              <li>
                  <button class="btn btn-primary btn-action" type="submit">Actualizar</button>
              </li>
          </ul>
        </div>
      </div>

      <div class="page-date">
          <div class="row">
            <div class="col-md-12"><small>Actualizado {{ $updated_at }}</small></div>
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
                              <input class="form-control" value="{{ $producto->nombre }}" name="nombre" type="text" id="nombre">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="publicado" class="col-form-label">Estado</label>
                            <div class="clearfix"></div>
                            <div class="estado-switch">
                              <div>Borrador</div> <input type="checkbox" {{ ($producto->publicado) ? 'checked="true"' : '' }} name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="desc">Descripción Corta</label>
                          <textarea class="form-control" name="desc_corta" id="desc" rows="3" col="8">{{ $producto->desc_corta }}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="desc">Descripción <span class="text-danger">*</span></label>
                          <textarea class="form-control" name="desc" id="desc" rows="5" col="8">{{ $producto->desc }}</textarea>
                        </div>
                        <div class="form-row">

                          <div class="form-group col">
                            <label for="artista" class="col-form-label">Artista <span class="text-danger">*</span></label>
                            <div>
                              <select name="artista" class="form-control" id="artista">
                                <!--option value="0">Ninguno</option-->
                              @foreach ($artistas as $artista)
                                <option value="{{ $artista->id }}" {{ ($artista->id == $producto->artista_id) ? 'selected' : '' }}>{{ $artista->nombres }} {{ $artista->apellidos }}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>


                          <div class="form-group col">
                            <label for="sku" class="col-form-label">Tipo de Producto <span class="text-danger">*</span></label>
                            <div>
                              <select name="tipo" class="form-control" id="tipo">
                                @foreach ($tipos as $tipo)
                                  <option value="{{ $tipo->id }}" {{ ($tipo->id == $producto->tipo_id) ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>


                        </div>

                        <div class="form-row">

                            <div class="form-group col-6">
                              <label for="categoria">Categoría <span class="text-danger">*</span></label>
                              <select name="categoria" class="form-control" id="categoria">
                                <!--option value="0">Ninguno</option-->
                                @foreach ($categorias as $categoria)
                                  <option value="{{ $categoria->id }}" {{ ($categoria->id == $producto->categoria_id) ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                              </select>
                            </div>

                            <div class="form-group col-6">
                              <label for="material">Materiales</label>
                                  <select name="materiales[]" class="form-control materials-multiple" multiple="multiple" id="materiales">
                                      @foreach ($materiales as $material)

                                            <option value="{{ $material->id }}"
                                              @foreach($materiales_seleccionados as $s) @if($material->id == $s->id) selected="selected" @endif @endforeach >
                                                {{ $material->nombre }}
                                            </option>

                                      @endforeach
                                  </select>
                            </div>

                        </div>



                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="sku" class="col-form-label">Colores</label>
                            <div>
                            <input type="hidden" id="producto_colores" name="producto_colores" value="">

                            <table class="table table-bordered" id="productoColorTb">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                            <th>Stock</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tr>
                                      <td width='220'>
                                          <input id="color_name_table" type="text" class="required-entry form-control">
                                      <td>
                                          <input id="color_stock_table" type="text" class="required-entry form-control">
                                      </td>
                                      <td>
                                          <button class="btn btn-large btn-default btn-action add" type="button">Agregar</button>
                                      </td>
                                    </tr>

                            </table>

                          </div>
                          </div>

{{-- 
                          <div class="form-group col-md-6">
                            <label for="dsct_lista_regalo" class="col-form-label">Descuento para Lista Regalos</label>
                            <div>
                              <input class="form-control" value="{{ $producto->dsct_lista_regalo }}" name="dsct_lista_regalo" type="text" id="dsct_lista_regalo">
                            </div>
                          </div> --}}

                        </div>


                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>


              <div class="card mb-3">

                <div class="card-header">Inventario</div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">

                        <div class="form-row">
                          <div class="form-group col-4">
                            <label for="precio" class="col-form-label">Precio <span class="text-danger">*</span></label>
                            <div>

                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">S/</span>
                                </div>
                                <input type="number" value="{{ $producto->precio }}" class="form-control" aria-label="Cantidad" name="precio" id="precio" min="0" step="0.01">
                              </div>


                            </div>
                          </div>
                        </div>

                          <div class="form-row">
                            <div class="form-group col">
                            <label for="sku" class="col-form-label">SKU</label>
                            <div>
                              <input type="text" class="form-control" value="{{ $producto->sku }}" name="sku" id="sku" placeholder="">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="stock" class="col-form-label">Stock <span class="text-danger">*</span></label>
                            <div>
                              <input type="number" class="form-control" value="{{ $producto->stock }}" name="stock" id="stock" min="0">
                            </div>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col">
                            <label for="peso" class="col-form-label">Peso (kg)</label>
                            <div>
                              <input type="number" class="form-control" value="{{ $producto->peso }}" name="peso" id="peso" placeholder="" min="0" step="0.01">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="tamano" class="col-form-label">Dimensiones (alto x ancho x largo cm)</label>
                            <div>
                              <input type="text" class="form-control" value="{{ $producto->tamano }}" name="tamano" id="tamano" placeholder="">
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="otros_detalles">Otros detalles</label>
                          <textarea class="form-control" name="otros_detalles" id="otros_detalles" rows="6" col="8">{{ $producto->otros_detalles }}</textarea>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer small text-muted"></div>
              </div>

          </div>

          <div class="col-sm-4">

              <div class="card mb-3">

                <div class="card-header">Imagen del Producto</div>

                <div class="card-body">

                  <div class="image-preview">
                    <img class="img-fluid" id="imgpreview" src="{{ url('uploads/products/'.$producto->img) }}" alt="">
                  </div>

                  <p>Tamaño Referencial: (350 x 350px)</p>
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

        <form method="POST" action="{{ URL::route('product.saveGallery', $producto->id) }}" enctype="multipart/form-data">
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

                @foreach ($producto->galeria_img as $key => $img)
                  <li id="image_li_{{$key}}" class="ui-sortable-handle">
                      <a href="javascript:void(0);" style="float:none;" class="image_link">
                          <img src="{{ url('/uploads/products/shop/'.$img) }}" style="object-fit:cover;" width="250" height="156" alt="">
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
        <input type="hidden" name="slug" value="{{ $producto->slug }}">


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
  /* Variables */
  var listaColores = <?= json_encode($producto->color); ?>;
  var colorRow = $(".colorRow");

  if(listaColores){
    $.each(listaColores, function(x,item){
      rr(item.color, item.stock);
    });
  }

  setInputValue();

  /* Functions */
  function addRow(){

    //alert('add row');

    var colorName = $('#color_name_table').val();
    var colorStock = $('#color_stock_table').val();

    if(colorName.length == 0 || colorStock.length == 0 || isNaN(colorStock)){
      return;
    }

    var repetido = validarColor(colorName);

    if(!repetido){
      listaColores.push({color: colorName.toLowerCase(), stock: parseInt(colorStock)});
        rr(colorName, colorStock);

        setInputValue();
        $('#producto_colores').val(JSON.stringify(listaColores));
    }else{
      //alert('Color ya existe');
      console.log(listaColores);
    }
    calcularStock();
  }
  function removeRow(button){
    button.closest("tr").remove();
    var color = button.data('color');

    var key;
    $.each(listaColores, function(x, item){
      if (item.color.toLowerCase() == color.toLowerCase()) {
        key = x;
      }
    });
    listaColores.splice(key,1);
    setInputValue();
    calcularStock();
  }

  function rr(colorName, colorStock){
    var tr = "<tr class='colorRow'>";
        tr += "<td width='220'>";
        tr += "<span class='color_name_table'>"+colorName+"</span>";
        tr += "<td><span class='color_stock_table'>"+colorStock+"</span></td>";
        tr += "<td><i class='fas fa-trash-alt remove' data-color="+colorName+"></i></td>";
        tr += "</tr>";

        $('#productoColorTb').append(tr);
        //colorRow.clone(true, true).appendTo("#productoColorTb");
  }

  function setInputValue(){
    $('#producto_colores').val(JSON.stringify(listaColores));
  }

  function calcularStock(){
    var total = 0;
    $.each($('.color_stock_table'), function(x,item){
      total += parseInt(item.innerHTML);
    });
    $('#stock').val(total);
  }

  function validarColor(color){
    var repetido = false;
    $.each(listaColores, function(x, item){
      if (item.color.toLowerCase() == color.toLowerCase()) {
        repetido = true;
      }
    });
    return repetido;
  }

  /* Doc ready */
  $(".add").on('click', function (){
    if($("#productoColorTb tr").length < 17){
      addRow();
    }
    $(this).closest("tr").appendTo("#productoColorTb");
  });

  $("#productoColorTb").on('click', '.remove', function (){
      removeRow($(this));
  });




  ///////////////////////////////////////////////////////////////////////

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

  $(function () {

    $('.remove-img-galeria').click(function() {
      var id = $(this).attr('data-id');
      var url = $(this).attr('data-url');
      $("#form_delete_galleryimage").attr("action", url);
      $('body').find('#form_delete_galleryimage').append('<input name="id" type="hidden" value="'+ id +'">');
    });

    $('.cancel-galleryimage-delete').click(function() {
      $('body').find('#form_delete_galleryimage').find( "input" ).remove();
    });

    $('.materials-multiple').select2({
      placeholder: 'Seleccionar material'
    });

    $("#producto_color").select2({
      tags:[],
      tokenSeparators: [",", " "]
    });

    $("#producto_tamano").select2({
      tags:[],
      tokenSeparators: [",", " "]
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

  function previewImg() {

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
        method: "post", url: "/admin/products/galleryimage/updateposition/<?= $producto->id; ?>",
        data: { data: galeriaImg},
        success: function(msg, data) {
            if (data) {
                window.location.reload();
            }
        }
      });
      return false;
  });

</script>
@stop

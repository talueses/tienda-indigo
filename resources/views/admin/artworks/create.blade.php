 @extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

  <form id="create_obre_form" method="POST" action="{{ route('admin.artwork.store') }}" enctype="multipart/form-data" target="_blank">
      {{ csrf_field() }}

      <input type="hidden" name="preview" value="false">

      <div class="page-head">
        <h2 class="page-title float-left">Nueva Obra</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>
                  <a class="btn btn-default btn-action preview">Ver Preview</a>
              </li>
              <li>
                  <a class="btn btn-default btn-action" href="{{ route('admin.artworks') }}">Cancelar</a>
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

                <div class="card-header">Detalles del Producto</div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-row">
                          <div class="form-group col-6">
                            <label for="nombre" class="col-form-label">Nombre <span class="text-danger">*</span></label>
                            <div>
                              <input class="form-control {{$errors->has('nombre') ? 'border-danger' : ''}}" name="nombre" type="text" id="nombre" value="{{old('nombre')}}">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="publicado" class="col-form-label">Estado</label>
                            <div class="clearfix"></div>
                            <div class="estado-switch">
                              <div>Borrador</div> <input type="checkbox" checked="true" name="publicado" id="switch"/><label class="switch" for="switch">Toggle</label> <div>Publicado</div>
                            </div>
                          </div>

                        </div>
                        <div class="form-group">
                          <label for="desc">Descripción Corta <span class="text-danger">*</span></label>
                          <textarea class="form-control {{$errors->has('desc_corta') ? 'border-danger' : ''}}" name="desc_corta" id="desc_corta" rows="3" col="8">{{old('desc_corta')}}</textarea>
                        </div>
                        <div class="form-group">
                          <label for="desc">Descripción</label>
                          <textarea class="form-control" name="desc" id="desc" rows="5" col="8">{{old('desc')}}</textarea>
                        </div>
                        <div class="form-row">

                          <div class="form-group col-6">
                            <label for="stock" class="col-form-label">Artista</label>
                            <div>
                              <select name="artista" class="form-control" id="artista" value="{{old('artista')}}">
                                <option value="0">Ninguno</option>
                              @foreach ($artistas as $artista)
                                <option value="{{ $artista->id }}">{{ $artista->nombres }} {{ $artista->apellidos }}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>

                          <div class="form-group col-6">
                            <label for="anio" class="col-form-label">Año</label>
                            <div>
                              <input type="text" class="form-control" name="anio" id="anio" value="{{old('anio')}}">
                            </div>
                          </div>


                        </div>

                        <div class="form-row">

                            <div class="form-group col-6">
                              <label for="categoria">Categoría <span class="text-danger">*</span></label>
                                  <select name="categoria" class="form-control {{$errors->has('categoria') ? 'border-danger' : ''}}" id="categoria" value="{{old('categoria')}}">
                                      <!--option value="0">Ninguno</option-->
                                      @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                      @endforeach
                                  </select>
                            </div>

                            <div class="form-group col-6">
                              <label for="material">Materiales</label>
                                  <select name="materiales[]" class="form-control materials-multiple" multiple="multiple" id="materiales">
                                      @foreach ($materiales as $material)
                                        <option value="{{ $material->id }}">{{ $material->nombre }}</option>
                                      @endforeach
                                  </select>
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
                            <label for="peso" class="col-form-label">Peso (kg)</label>
                            <div>
                              <input type="number" class="form-control" name="peso" id="peso" placeholder="" step="0.01" value="{{old('peso')}}">
                            </div>
                          </div>

                          <div class="form-group col">
                            <label for="tamano" class="col-form-label">Dimensiones (alto x ancho x largo cm)</label>
                            <div>
                              <input type="text" class="form-control" name="tamano" id="tamano" value="{{old('tamano')}}">
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
                    <img class="img-fluid" id="imgpreview" src="" alt="">
                  </div>
                  <p>Tamaño Referencial: (540 x 540px)</p>
                  <span class="btn btn-default btn-action btn-file">Escoger imagen <input id="file" type="file" name="img" onchange="readURL(this)"></span>

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

      var form = $('#create_obre_form');
      $('input[name="preview"]').val(0);
      form.attr('target', '_self');

      form.submit();

  });

  $('.btn-action.preview').on('click', function(e) {
    e.preventDefault();

    $('input[name="preview"]').val(1);

    var form = $('#create_obre_form');
    form.attr('target', '_blank');
    form.submit();

    $('input[name="preview"]').val(0);
    form.attr('target', '_self');
  });

  $(function () {
    $('.materials-multiple').select2({
      placeholder: 'Seleccionar material'
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

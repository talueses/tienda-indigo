@extends ('admin.layouts.master')

@section ('content')

<div class="container-fluid">

      <div class="page-head">

        @include('admin.layouts.errors')

        <h2 class="page-title float-left">Inicio</h2>

        <div class="page-bar toolbarBox">
          <ul id="toolbar-nav" class="nav nav-pills float-right">
              <li>

              </li>
          </ul>
        </div>

      </div>

      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <div class="col p-0">
                      Sliders - Inicio
                    </div>

                    <div class="col p-0">
                      <button type="button" class="btn btn-default btn-action float-right" data-toggle="modal" data-target="#addSlider">Agregar Slider</button>
                    </div>

                  </div>
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 my-auto">
                            <div id="list_group_slider" class="list-group list-group-flush small">

                              @foreach ($sliders as $slider)
                                <div id="{{ $slider->id }}" class="list-group-item list-group-item-action" href="#">
                                  <div class="media">

                                    @if ($slider->video)
                                      <video style="width: 100%;" src="{{ 'uploads/vid/' . $slider->contenido }}" controls>
                                          Your browser does not support the video tag.
                                      </video>
                                    @else
                                    <div class="media-body img-cont-full r8-3"><img class="d-flex mr-3 rounded img-slider-gallery" src="{{ url('uploads/home/gallery/'.$slider->img) }}" alt=""></div>
                                    @endif

                                  </div>

                                  <div class="slider-actions">
                                    <p class="float-left">{{ $slider->contenido }}</p>

                                    @if ($slider->video)

                                      <a class="remove-slide" data-toggle="modal" data-url="{{ route('home.destroyvideo', $slider->id) }}" data-id="{{ $slider->id }}" data-target="#confirm_delete_slide" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>

                                    @else
                                      <a class="update-slide pr-2" data-toggle="modal" data-url="{{ route('home.updateslide', $slider->id) }}" data-id="{{ $slider->id }}" data-img="{{ url('uploads/home/gallery/'.$slider->img) }}" data-caption="{{ $slider->contenido }}" data-target="#edit_slide" href="#"><i class="fas fa-pencil-alt"></i> Modificar</a>

                                      <a class="remove-slide" data-toggle="modal" data-url="{{ route('home.destroyslide', $slider->id) }}" data-id="{{ $slider->id }}" data-target="#confirm_delete_slide" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                    @endif


                                  </div>
                                </div>
                              @endforeach

                            </div>
                    </div>

                  </div>
                </div>


            <div class="card-footer small text-muted"></div>
          </div>


          <!-- gestor imagen -->

            <div class="card mb-3">

              <div class="card-header">
                Gestor de Imagen - Inicio
              </div>

                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12 my-auto">
                          <div id="list_group_slider" class="list-group list-group-flush small">

                                <div id="1" class="list-group-item list-group-item-action" href="#">
                                  <div class="media">

                                    <div class="media-body img-cont-full r8-3">
                                      <img class="d-flex mr-3 rounded img-slider-gallery border" src="{{ url($img_tienda) }}" alt="">
                                    </div>
                                  </div>

                                  <div class="actions mt-2">
                                    <p class="float-left font-weight-bold">TIENDA</p>

                                    <a class="update-home-img pr-2 float-right" data-toggle="modal" data-img="{{ url($img_tienda) }}" data-target="#edit_home_img" data-name="tienda" href="#"><i class="fas fa-pencil-alt"></i> Modificar</a>
                                  </div>

                                </div>


                                <div id="2" class="list-group-item list-group-item-action" href="#">
                                  <div class="media">

                                    <div class="media-body img-cont-full r8-3">
                                      <img class="d-flex mr-3 rounded img-slider-gallery border" src="{{ url($img_artistas) }}" alt="">
                                    </div>
                                  </div>

                                  <div class="actions mt-2">
                                    <p class="float-left font-weight-bold">ARTISTAS</p>

                                    <a class="update-home-img pr-2 float-right" data-toggle="modal" data-img="{{ url($img_artistas) }}" data-target="#edit_home_img" data-name="artistas" href="#"><i class="fas fa-pencil-alt"></i> Modificar</a>
                                  </div>

                                </div>

                          </div>
                      </div>

                    </div>
                  </div>

                <div class="card-footer small text-muted"></div>
            </div>



            <!-- modal -->

            <div class="modal fade" id="edit_home_img" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Editar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form id="form_edit_home_image" action="{{ route('home.updatehomeimage') }}" method="post" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="modal-body">

                            <div class="form-group">

                              <div class="image-preview-img">
                                  <div class="img-cont-full r8-3">
                                    <img id="imgpreview_edit_home" class="img-fluid bg-light border" src="{{ url('/') }}/media/default.jpg" alt="">
                                  </div>
                                  <span class="btn btn-default btn-action btn-file mt-2">Escoger imagen <input id="file_preview_home" type="file" name="img"></span>
                              </div>

                            </div>

                            <input type="hidden" class="home_image_name" name="home_image_name" value="">

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </div>

                  </form>

                </div>
              </div>
            </div>


          <!-- //gestor imagen -->


        </div>

        <div class="col-lg-4">

          <form action="{{ route('admin.general') }}" method="post">
              {{ csrf_field() }}

            <div class="card mb-3">

                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <div class="col p-0">
                        Redes Sociales
                      </div>

                      <div class="col p-0">
                        <button class="btn btn-primary float-right" type="submit">Guardar</button>
                      </div>

                    </div>
                  </div>

                  <div class="card-body">

                      <div class="">

                          <div class="form-group">
                            <label for="gen_facebook">Facebook</label>
                            <input type="text" name="facebook" class="form-control" id="gen_facebook" value="{{ isset($generales['facebook']) ? $generales['facebook'] : '' }}">
                          </div>

                          <div class="form-group">
                            <label for="gen_instagram">Instagram</label>
                            <input type="text" name="instagram" class="form-control" id="gen_instagram" value="{{ isset($generales['instagram']) ? $generales['instagram'] : '' }}">
                          </div>

                          <div class="form-group">
                            <label for="gen_twitter">Twitter</label>
                            <input type="text" name="twitter" class="form-control" id="gen_twitter" value="{{ isset($generales['twitter']) ? $generales['twitter'] : '' }}">
                          </div>

                          <div class="form-group">
                            <label for="gen_tripadvisor">Tripadvisor</label>
                            <input type="text" name="tripadvisor" class="form-control" id="gen_tripadvisor" value="{{ isset($generales['tripadvisor']) ? $generales['tripadvisor'] : '' }}">
                          </div>

                      </div>

                  </div>
                  <div class="card-footer small text-muted"></div>

            </div>


            <div class="card mb-3">
                <div class="card-header">
                  <i class="fa fa-pie-chart"></i>Datos Generales
                </div>
                <div class="card-body">

                  <div class="">

                    <div class="form-group">
                      <label for="gen_free_delivery">Delivery Gratuito</label>
                      <input type="text" name="free_delivery" class="form-control" id="gen_free_delivery" value="{{ isset($generales['free_delivery']) ? $generales['free_delivery'] : '' }}">
                    </div>

                    <div class="form-group">
                      <label for="gen_tel1">Teléfonos</label>
                      <input type="text" name="telefonos" class="form-control" id="gen_tel1" value="{{ isset($generales['telefonos']) ? $generales['telefonos'] : '' }}">
                    </div>

                    <div class="form-group">
                      <label for="gen_direccion">Dirección</label>
                      <input type="text" name="direccion" class="form-control" id="gen_direccion" value="{{ isset($generales['direccion']) ? $generales['direccion'] : '' }}">
                    </div>

                    <div class="form-group">
                      <label for="gen_horarios">Horarios</label>
                      <textarea class="form-control" name="horarios" id="gen_horarios" cols="30" rows="4">{{ isset($generales['horarios']) ? $generales['horarios'] : '' }}</textarea>
                    </div>

                  </div>

                </div>
                <div class="card-footer small text-muted"></div>

            </div>

          </form>

        </div>

      </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="confirm_delete_slide" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form id="form_delete_slide" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Eliminar Slide</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Eliminar slide?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary cancel-slide-delete" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Eliminar</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="modal fade" id="addSlider" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Agregar Slider</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
              <div class="modal-body">

                  <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                      <button id="select_img" type="button" class="btn btn-action select-slide">Imagen</button>
                      <button id="select_video" type="button" class="btn btn-action">URL Video</button>
                    </div>
                  </div>

                  <br>

                    <div class="form-group">

                      <div class="image-preview-img">
                          <form id="save_slide" method="post" action="{{ route('home.addslide') }}" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            <div class="img-cont-full r8-3">
                              <img class="img-fluid bg-light border" src="" alt="">
                            </div>
                            <span class="btn btn-default btn-action btn-file mt-2">Escoger imagen <input id="file_add_preview" type="file" name="img"></span>

                            <button type="submit" class="btn btn-primary mt-2">Guardar</button>

                          </form>
                      </div>

                      <div class="image-preview-video" style="display: none;">
                          <!--div class="form-group">
                            <label for="">URL Video</label>
                            <input class="form-control" type="text" name="slide_url">
                          </div-->

                          <form action="{{ url('admin/video/upload') }}" method='post' enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="file" name="file_video"/><br><br>
                            <input type="submit" class="btn btn-primary" value="Subir video"/>
                          </form>

                      </div>

                    </div>

                    <input type="hidden" class="slide_name" name="slide_name" value="">
                    <input type="hidden" class="is_video" name="is_video" value="0">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-action" data-dismiss="modal">Cancelar</button>
              </div>



        </div>
      </div>
    </div>


    <div class="modal fade" id="edit_slide" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar Slider</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form id="form_edit_slide" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <div class="modal-body">

                  <!--div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                      <button id="select_img_edit" type="button" class="btn btn-secondary select-slide">Imagen</button>
                      <button id="select_video_edit" type="button" class="btn btn-secondary">URL Video</button>
                    </div>
                  </div-->
                  <!--br-->

                    <div class="form-group">

                      <div class="image-preview-img">
                          <div class="img-cont-full r8-3">
                            <img id="imgpreview_edit" class="img-fluid bg-light border" src="" alt="">
                          </div>
                          <span class="btn btn-default btn-action btn-file mt-2">Escoger imagen <input id="file_preview" type="file" name="img"></span>
                      </div>

                      <div class="image-preview-video" style="display: none;">
                          <div class="form-group">
                            <label for="">URL Video</label>
                            <input class="form-control" id="videourl_edit" type="text" name="slide_url">
                          </div>
                      </div>

                    </div>

                    <div class="form-group">
                      <label for="slide_caption">Caption</label>
                      <textarea class="form-control" id="slide_caption_edit" name="slide_caption" cols="20" rows="2"></textarea>
                    </div>

                    <input type="hidden" class="slide_name" name="slide_name" value="">
                    <input type="hidden" class="is_video" name="is_video" value="0">
                    <input type="hidden" id="old_img" name="old_img">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-action" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Actualizar</button>
              </div>

          </form>

        </div>
      </div>
    </div>

@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
      /*$('#summernote').summernote({
        height: 150,
        lang: 'es-ES' // default: 'en-US'
      });*/

      setNameSlider();

  });

  $('#file_preview, #file_add_preview').on('change', function(){

    /*console.log("changing image");
    return;*/

    var input = this;
    //var img = $(this).parent().siblings().eq(0).find('.img-fluid').eq(0);
    var img = $('#addSlider .image-preview-img img');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
          img.attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }

  });

  function changeView($this, view) {
      var form = $this.parents().eq(3);
      var buttonClass = 'select-slide';
      $this.addClass(buttonClass);
      $this.siblings().eq(0).removeClass(buttonClass);

      setNameSlider();

      switch (view) {
        case 'video':
          form.find('.image-preview-video').show();
          form.find('.image-preview-img').hide();
          form.find('.is_video').val(1);

        break;

        case 'img':
          form.find('.image-preview-img').show();
          form.find('.image-preview-video').hide();
          form.find('.is_video').val(0);
        break;
      }

  }

  function setNameSlider() {
      var nro = $('#list_group_slider').children().length + 1;
      $('.slide_name').val('slide'+nro);
  }

  //Slide options buttons
  $('#select_img, #select_img_edit').on('click', function(){
      changeView($(this), 'img');
  });
  $('#select_video, #select_video_edit').on('click', function(){
      changeView($(this), 'video');
  });

  // Update slide modal
  $('.update-slide').click(function(){
      var $this = $(this);
      var id = $this.data('id');
      var url = $this.data('url');
      var caption = $this.data('caption');

      if ($this.data('url-video')) {
        $('#form_edit_slide').find('.is_video').val(true);
        $('#videourl_edit').val($this.data('url-video'));
        $('#select_video_edit').click();
        var img = '';
      } else {
        $('#form_edit_slide').find('.is_video').val(false);
        $('#old_img').val($this.data('img'));
        $('#select_img_edit').click();
        var img = $this.data('img');
      }

      $('#form_edit_slide').attr("action", url);
      $('body').find('#form_edit_slide').append('<input name="id" type="hidden" value="'+ id +'">');
      $('#imgpreview_edit').attr('src', img);
      $('#slide_caption_edit').html(caption);
  });

  //Slide delete modal
  $('.remove-slide').click(function() {
    var id = $(this).attr('data-id');
    var url = $(this).attr('data-url');
    $("#form_delete_slide").attr("action", url);
    $('body').find('#form_delete_slide').append('<input name="id" type="hidden" value="'+ id +'">');
  });

  //Slide cancel modal
  $('.cancel-slide-delete').click(function() {
    $('body').find('#form_delete_slide').find( "input" ).remove();
  });

</script>
@stop

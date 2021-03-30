@extends('layouts.front', ['subtitle'=>'Iniciar Sesión'])
@section('contenido')
@include('partials.banner')
<div class="container contenido">
  <div class="row">
    @if(!isset($cuenta))

    <div class="col-12 mt-4">
      <div class="row justify-content-around">
        <div class="col-lg-5">

          <div class="card my-3">

            <div class="card-body">

              <h4 class="pb-3">Iniciar Sesión</h4>


                  <form class="" action="{{ route('home.login') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                      <input type="text" class="form-control subtitle" value="{{ old('email') }}" placeholder="Correo electrónico" name="email" required autofocus>
                      @if ($errors->has('email'))
                          <span class="help-block">
                              <small class="text-danger">{{ $errors->first('email') }}</small>
                          </span>
                      @endif
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control subtitle" placeholder="Contraseña" name="password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <small class="text-danger">{{ $errors->first('password') }}</small>
                          </span>
                      @endif
                    </div>

                    <div class="form-group">
                      <div class="form-check pl-0 float-right">
                        <a class="d-block" href="{{ route('customer.password.request') }}">He olvidado mi contraseña</a>
                      </div>
                    </div>
                    <br>

                    <button type="submit" class="btn btn-outline-secondary linear w-100 py-2 my-2">Ingresar</button>

                    <p class="message mt-3"><small>¿No tienes cuenta? <a href="{{ route('customer.register') }}">Registrate aquí</a></small></p>

                  </form>

            </div>

          </div>
        </div>

      </div>
    </div>
    @elseif(auth('boda')->check())

      @if(Session::has('message'))
        <div class="container-fluid">
          <div class="alert-message alert alert-{!!Session::get('message')['type']!!}">
              <a class="close" data-dismiss="alert">&times;</a>
              {!!Session::get('message')['message']!!}
          </div>
        </div>
      @endif



    <div class="col-12">

      <div class="delete-preview mb-3 mt-0">
          <button type="button" name="button" class="btn btn-success subtitle px-4" data-toggle="modal" data-target="#share_link" class="delete-preview mt-2"><i class="fas fa-share-alt mr-2"></i> Compartir lista de regalo</button>
      </div>



        <div class="row">


            <div class="col-lg-8">

              <form action="{{ route('home.novios.update', $cuenta->id) }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}

              <div class="card">

                <div class="card-header bg-white d-inline-flex">
                    <h4 class="pt-1">Detalles de la cuenta</h4>
                    <button type="submit" class="pull-right ml-auto btn btn-info px-4"><p class="m-0 subtitle">Actualizar</p></button>
                </div>

                <div class="card-body">
                  <div class="">
                    <div class="" id="wedding-account-det" role="tabpanel">



                        <div class="row">

                          <div class="col-lg-12">
                                <div class="row">
                                  <div class="col-lg-5">

                                      <div class="row">

                                          <div class="col-md-12">
                                              <div class="img-cont-full r1-1 image-preview bg-secondary">
                                                <img class="img-fluid rounded" id="imgpreview" src="{{ $cuenta->img }}" alt="{{ $cuenta->titulo }}">
                                              </div>

                                              <div class="d-flex">

                                                <span class="d-inline p-2 btn btn-outline-secondary px-4 btn-file mt-2 subtitle">Escoger imagen <input type="file" id="select_img_wedding_account" name="img"></span>

                                                <div class="d-inline p-2 delete-preview mt-2 text-center">
                                                    <a href="#" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview mt-2 text-danger"><i class="fas fa-trash-alt"></i></a>
                                                </div>

                                              </div>

                                          </div>

                                      </div>

                                  </div>
                                  <div class="col-lg-7">
                                    <h4>{{ $cuenta->titulo }}</h4>



                                    <div class="row">
                                      <div class="col-sm-12">

                                        <div class="form-row">

                                          <div class="form-group col-6">
                                              <label for="nombre" class="col-form-label">Codigo</label>
                                              <div>
                                              <input class="form-control" type="text" value="{{ $cuenta->codigo }}" disabled>
                                              </div>
                                          </div>

                                        </div>


                                        <div class="form-row">
                                            <div class="form-group col">
                                                <label for="nombres">Título</label>
                                                <input class="form-control" name="nombre" value="{{ $cuenta->titulo }}" type="text">
                                            </div>

                                            <div class="form-group col">
                                                <label for="apellidos">Fecha del Matrimonio</label>
                                                <input class="form-control" name="fecha" value="{{ $cuenta->fecha }}" type="date" min="2000-01-01">
                                            </div>
                                        </div>

                                          <div class="form-group">
                                              <label for="desc">Descripción</label>
                                              <textarea class="form-control" name="desc" id="desc" rows="4">{{ $cuenta->desc }}</textarea>
                                          </div>
                                      </div>
                                    </div>


                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="nombres">Nombres Novio</label>
                                                    <input class="form-control" name="novio" value="{{ $cuenta->novio }}" type="text">
                                                </div>

                                                <div class="form-group col">
                                                    <label for="apellidos">Nombres Novia</label>
                                                    <input class="form-control" name="novia" value="{{ $cuenta->novia }}" type="text">
                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                  </div>

                              </div>
                          </div>

                        </div>


                    </div>


                  </div>
                </div>



            </div>

              </form>

            </div>



            <div class="col-lg-4">

              <form action="{{ route('home.novios.updatepassword', $cuenta->id) }}" method="post">
              {{ csrf_field() }}

              <div class="card">

                <div class="card-header bg-white d-inline-flex">
                    <h4>Accesos</h4>
                    <button type="submit" class="pull-right ml-auto btn btn-info px-4"><p class="m-0 subtitle">Guardar</p></button>
                </div>

                  <div class="card-body">

                        <div class="row">

                          <div class="col-lg-12">
                              <div class="form-row">
                                  <div class="form-group col-12">
                                      <label for="nombres">Email</label>
                                      <input class="form-control" name="email" value="{{ $cuenta->email }}" type="text">
                                  </div>

                                  <div class="form-group col-12">
                                      <label for="apellidos">Nueva Contraseña</label>
                                      <input class="form-control" name="password" value="" type="password">
                                  </div>

                                  <div class="form-group col-12">
                                      <label for="apellidos">Confirmar Contraseña</label>
                                      <input class="form-control" name="confirm_password" value="" type="password">
                                  </div>
                              </div>
                          </div>

                        </div>


                  </div>

              </div>


              </form>


            </div>



        </div>

        <!-- -->
        <div class="prev-element">
            <a href="{{ route('home.tienda') }}" class="btn btn-outline-secondary">Ir a la tienda</a> (añade los productos a tu lista de regalo desde la tienda)
        </div>

          <div class="row">

                @foreach($products as $product)
                  <div class="col-lg-3 text-center prev-tienda-item my-4">
                    <div class="w-100 img-cont-full r1-1">
                      <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded" alt="">
                      <span class="bagde bagde-left-bottom bg-warning text-white">{{ 'S/ '.$product->precio }}</span>
                    </div>
                    <div class="w-100 card pb-2 mt-2">
                      <p class="footing-name" title="{{ $product->nombre }}">{{ $product->nombre }}</p>
                      <p class="mb-1"><small>{{ $product->categoria->nombre }}</small></p>
                      <div class="row justify-content-center mb-1">
                        <div class="col-auto">
                          <a href="{{ route('home.tienda.producto', $product->slug) }}" class="btn btn-link text-secondary"><i class="fa fa-eye"></i> </a>
                        </div>
                        <div class="col-auto">
                          <a class="remove-product btn btn-link text-warning" data-toggle="modal" data-target="#confirm_delete_product" data-url="{{ route('home.novios.removeproduct') }}" data-id="{{ $product->id }}" href="#"><i class="fas fa-trash-alt"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach

          </div>
        <!-- // -->


    </div>
    @else
    <div class="col-12">
      <div class="row">
        <div class="col-lg-8">
          <ul class="list-unstyled">
            <li><h2 class="text-muted text-uppercase">{{ $cuenta->titulo }}</h2></li>
            <li><h4 class="subtitle text-info">{{ $cuenta->novia.' & '.$cuenta->novio }}</h4></li>
            <li><p>{{ $cuenta->desc }}</p></li>
            <li class="d-flex align-items-center justify-content-start mb-3"><i class="fa fa-calendar-check text-success fa-2x mr-2"></i><span class="pt-2">{{ strftime('%d de %B del %Y', strtotime($cuenta->fecha)) }}</span></li>
            <li class="d-flex align-items-center justify-content-start"><i class="fa fa-gift text-warning fa-2x mr-2"></i><span class="pt-2">{{ $cuenta->productos->count().' regalos enlistados' }}</span></li>
          </ul>
        </div>
        <div class="col-lg-4">
          <div class="w-100 r1-1 img-cont-full text-center">
            <img src="{{ url('uploads/weddinglists',$cuenta->img ?: 'default.jpg' ) }}" class="img-fluid" alt="">
          </div>
        </div>
        <div class="col-12">
          <div class="row">
          @foreach($cuenta->productos as $product)
            <div class="col-lg-3 text-center prev-tienda-item my-4">
              <div class="w-100 img-cont-full r1-1">
                <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded" alt="">
                <span class="bagde bagde-left-bottom bg-warning text-white">{{ 'S/ '.$product->precio }}</span>
              </div>
              <div class="w-100 card pb-2 mt-2">
                <p class="footing-name" title="{{ $product->nombre }}">{{ $product->nombre }}</p>
                <p class="mb-1"><small>{{ $product->categoria->nombre }}</small></p>
                <div class="row justify-content-center mb-1">
                  <div class="col-auto">
                    <a href="#" class="btn btn-link"><i class="fa fa-share-alt"></i></a>
                  </div>
                  <div class="col-auto">
                    <a href="{{ route('home.tienda.producto', $product->slug) }}" class="btn btn-link text-secondary"><i class="fa fa-eye"></i> </a>
                  </div>
                  <div class="col-auto">
                    <a href="#" class="btn btn-link text-warning"><i class="fa fa-cart-plus"></i> </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          </div>
        </div>
      </div>
    </div>

    @endif
  </div>
</div>


    @if(isset($cuenta) && auth('boda')->check())

      <!-- modal eliminar producto -->
      <div class="modal fade" id="confirm_delete_product" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="form_delete_product" method="POST" action="">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Eliminar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ¿Eliminar el elemento seleccionado?
                <input type="hidden" name="cuenta_novios_id" value="{{ $cuenta->id }}">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-product-delete" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Eliminar</button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <!-- modal eliminar imagen -->
        <div class="modal fade" id="confirm_delete_image" tabindex="-1" role="dialog" aria-hidden="true">
          <form method="POST" action="{{ route('home.novios.removeimage', $cuenta->id) }}">
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


        <!-- compartir enlace -->
        <div class="modal fade" id="share_link" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title subtitle" id="exampleModalLabel">Compartir lista de regalos</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <p>Envía el siguiente código <kbd class="mx-2">{{ $cuenta->codigo }}</kbd> ó comparte el siguiente enlace para que tus invitados puedan acceder a tu lista de regalos.</p>

                  <div class="input-group mb-3">
                    <input id="copy_input" type="text" value="{{ route('home.novios.search', 'codigo='.$cuenta->codigo) }}" class="form-control">
                    <div class="input-group-append">
                      <button class="btn btn-secondary" type="button" id="btn_copy_link" data-toggle="tooltip" data-placement="button" title="Copy to Clipboard">Copiar</button>
                    </div>
                  </div>

                  <p id="copied_link" class="text-center mb-0" style="display: none;">Copiado!</p>

              </div>
            </div>
          </div>
        </div>
    @endif


@endsection

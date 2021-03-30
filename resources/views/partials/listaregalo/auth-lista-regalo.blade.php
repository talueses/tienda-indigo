@if(Session::has('message'))
  <div class="container-fluid">
    <div class="alert-message alert alert-{!!Session::get('message')['type']!!}">
        <a class="close" data-dismiss="alert">&times;</a>
        {!!Session::get('message')['message']!!}
    </div>
  </div>
@endif

@if($errors->count())
    <div class="container-fluid">
        <div class="alert alert-danger">
            <ul class="list-unstyled mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="col-12">

    @if (!$cuenta->edicion && is_null($cuenta->entrega))
      <div role="alert" class="alert alert-warning">
          <p class="m-0">Por favor seleccione el modo de entrega.</p>
      </div>
    @endif

  <div class="mb-3 mt-0">
      <button style="font-size: 0.9em;" type="button" name="button" class="subtitle btn btn-outline-success linear" data-toggle="modal" data-target="#share_link" class="delete-preview mt-2"><i class="fas fa-share-alt mr-2"></i> Compartir lista de regalo</button>
      <a style="font-size: 0.9em;" class="subtitle btn btn-outline-secondary linear" href="{{ route('listaregalo.preview', $cuenta->codigo) }}" target="_blank"><i class="fas fa-eye mr-2"></i> Vista previa</a>
  </div>

  <div class="row">
      <div class="col-lg-8">

        <form action="{{ route('home.novios.update', $cuenta->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="card">

          <div class="card-header bg-white d-inline-flex">
              <h4 class="pt-1 m-0" style="font-size: 1.19em;">Detalles de la cuenta</h4>
          </div>

          <div class="card-body">
            <div class="">
              <div class="" id="wedding-account-det" role="tabpanel">

                  <div class="row">

                      <div class="col-lg-12">
                        <h4 style="font-size: 1.19em;">{{ $cuenta->titulo }}</h4>



                        <div class="row">

                            <div class="col-md-5">
                              <div class="image-preview"> <!-- img-cont-full r1-1 -->
                                @if(!$cuenta->img)
                                  <img class="img-fluid rounded border" id="imgpreview" src="{{ url('/media/default.jpg') }}" alt="{{ $cuenta->titulo }}">
                                @else
                                  <img class="img-fluid rounded border" id="imgpreview" src="{{ $cuenta->img }}" alt="{{ $cuenta->titulo }}">
                                @endif
                              </div>

                              <div class="d-flex">

                                <span class="d-inline p-2 btn btn-outline-secondary linear px-4 btn-file mt-2 subtitle" style="font-size:14px;">Escoger imagen <input type="file" id="select_img_wedding_account" name="img"></span>

                                <div class="d-inline p-2 delete-preview mt-2 text-center">
                                    <a href="#" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview mt-2 text-danger"><i class="fas fa-trash-alt"></i></a>
                                </div>

                              </div>

                          </div>

                          <div class="col-md-7">

                              <div class="form-row">

                                <div class="form-group col-6">
                                    <label for="nombre" class="col-form-label">Código</label>
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
                                      <label for="apellidos">Fecha del Evento</label>
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
                                        <label for="nombres">Nombre Organizador 1</label>
                                        <input class="form-control" name="organizador_1" value="{{ $cuenta->novio }}" type="text">
                                    </div>

                                    <div class="form-group col">
                                        <label for="apellidos">Nombre Organizador 2</label>
                                        <input class="form-control" name="organizador_2" value="{{ $cuenta->novia }}" type="text">
                                    </div>
                                </div>
                            </div>

                        </div>

                      </div>

                      <!-- entrega delivery -->

                      <div class="col-lg-12">
                        @if (!$cuenta->edicion_finalizada)

                                  <div class="form-group mt-3">
                                      <h6>Modo de entrega</h6>

                                      <div class="row">

                                        <div class="col-5">
                                            <hr class="mb-2">
                                              <p class="text-center mb-0">
                                                <small class="d-flex align-items-center">
                                                  <i class="fas fa-truck fa-border fa-3x text-secondary mr-2"></i> Delivery gratuito<br> solo en Lima.
                                                </small>
                                              </p>
                                            <hr class="my-2">
                                        </div>

                                        <div class="col-7 pt-2">
                                            <input type="radio" name="modo_entrega" id="modo_tienda" value="recojo_tienda" {{ ($cuenta->entrega == 'recojo_tienda') ? 'checked':'' }}>
                                            <label for="modo_tienda">Recojo en tienda</label>
                                            <br>
                                            <input type="radio" name="modo_entrega" id="modo_delivery" value="delivery" {{ ($cuenta->entrega == 'delivery') ? 'checked':'' }}>
                                            <label for="modo_delivery">Delivery</label>
                                            <br>
                                        </div>

                                      </div>


                                  </div>

                                  <div class="row">

                                      <div class="col-sm-12">


                                          <div class="form-row">

                                              <div class="form-group col">
                                                  <label for="envio_departamento">Departamento</label>
                                                  <select name="envio_departamento" id="envio_departamento" class="form-control" {{ !is_null($cuenta->departamento) ? '' : 'disabled' }} required>
                                                      <option value="amazonas" {{ ($cuenta->departamento == 'amazonas') ? 'selected':'' }}>Amazonas</option>
                                                      <option value="ancash" {{ ($cuenta->departamento == 'ancash') ? 'selected':'' }}>Ancash</option>
                                                      <option value="apurimac" {{ ($cuenta->departamento == 'apurimac') ? 'selected':'' }}>Apurimac</option>
                                                      <option value="arequipa" {{ ($cuenta->departamento == 'arequipa') ? 'selected':'' }}>Arequipa</option>
                                                      <option value="ayacucho" {{ ($cuenta->departamento == 'ayacucho') ? 'selected':'' }}>Ayacucho</option>
                                                      <option value="cajamarca" {{ ($cuenta->departamento == 'cajamarca') ? 'selected':'' }}>Cajamarca</option>
                                                      <option value="callao" {{ ($cuenta->departamento == 'callao') ? 'selected':'' }}>Callao</option>
                                                      <option value="cusco" {{ ($cuenta->departamento == 'cusco') ? 'selected':'' }}>Cusco</option>
                                                      <option value="huancavelica" {{ ($cuenta->departamento == 'huancavelica') ? 'selected':'' }}>Huancavelica</option>
                                                      <option value="huanuco" {{ ($cuenta->departamento == 'huanuco') ? 'selected':'' }}>Huanuco</option>
                                                      <option value="ica" {{ ($cuenta->departamento == 'ica') ? 'selected':'' }}>Ica</option>
                                                      <option value="junin" {{ ($cuenta->departamento == 'junin') ? 'selected':'' }}>Junin</option>
                                                      <option value="la_libertad" {{ ($cuenta->departamento == 'la_libertad') ? 'selected':'' }}>La Libertad</option>
                                                      <option value="lambayeque" {{ ($cuenta->departamento == 'lambayeque') ? 'selected':'' }}>Lambayeque</option>
                                                      <option value="lima" {{ ($cuenta->departamento == 'lima') ? 'selected':'' }}>Lima</option>
                                                      <option value="lima_metropolitana" {{ ($cuenta->departamento == 'lima_metropolitana') ? 'selected':'' }}>Lima Metropolitana</option>
                                                      <option value="loreto" {{ ($cuenta->departamento == 'loreto') ? 'selected':'' }}>Loreto</option>
                                                      <option value="madre_de_dios" {{ ($cuenta->departamento == 'madre_de_dios') ? 'selected':'' }}>Madre De Dios</option>
                                                      <option value="moquegua" {{ ($cuenta->departamento == 'moquegua') ? 'selected':'' }}>Moquegua</option>
                                                      <option value="pasco" {{ ($cuenta->departamento == 'pasco') ? 'selected':'' }}>Pasco</option>
                                                      <option value="piura" {{ ($cuenta->departamento == 'piura') ? 'selected':'' }}>Piura</option>
                                                      <option value="puno" {{ ($cuenta->departamento == 'puno') ? 'selected':'' }}>Puno</option>
                                                      <option value="san_martin" {{ ($cuenta->departamento == 'san_martin') ? 'selected':'' }}>San Martin</option>
                                                      <option value="tacna" {{ ($cuenta->departamento == 'tacna') ? 'selected':'' }}>Tacna</option>
                                                      <option value="tumbes" {{ ($cuenta->departamento == 'tumbes') ? 'selected':'' }}>Tumbes</option>
                                                      <option value="ucayali" {{ ($cuenta->departamento == 'ucayali') ? 'selected':'' }}>Ucayali</option>
                                                  </select>
                                              </div>

                                              <div class="form-group col">
                                                  <label for="envio_lima_metropolitana">Distrito</label>
                                                  <select name="envio_lima_metropolitana" id="envio_lima_metropolitana" class="form-control" {{ !is_null($cuenta->distrito) ? '' : 'disabled' }} required>
                                                    <option value="barranco" {{ ($cuenta->distrito == 'barranco') ? 'selected':'' }}>Barranco</option>
                                                    <option value="miraflores" {{ ($cuenta->distrito == 'miraflores') ? 'selected':'' }}>Miraflores</option>
                                                    <option value="surco" {{ ($cuenta->distrito == 'surco') ? 'selected':'' }}>Surco</option>
                                                    <option value="san_borja" {{ ($cuenta->distrito == 'san_borja') ? 'selected':'' }}>San Borja</option>
                                                    <option value="surquillo" {{ ($cuenta->distrito == 'surquillo') ? 'selected':'' }}>Surquillo</option>
                                                    <option value="san_isidro" {{ ($cuenta->distrito == 'san_isidro') ? 'selected':'' }}>San Isidro</option>
                                                    <option value="chorrillos" {{ ($cuenta->distrito == 'chorrillos') ? 'selected':'' }}>Chorrillos</option>

                                                    <option value="cercado" {{ ($cuenta->distrito == 'cercado') ? 'selected':'' }}>Cercado</option>
                                                    <option value="san_luis" {{ ($cuenta->distrito == 'san_luis') ? 'selected':'' }}>San Luis</option>
                                                    <option value="brena" {{ ($cuenta->distrito == 'brena') ? 'selected':'' }}>Breña</option>
                                                    <option value="la_victoria" {{ ($cuenta->distrito == 'la_victoria') ? 'selected':'' }}>La Victoria</option>
                                                    <option value="rimac" {{ ($cuenta->distrito == 'rimac') ? 'selected':'' }}>Rimac</option>
                                                    <option value="lince" {{ ($cuenta->distrito == 'lince') ? 'selected':'' }}>Lince</option>
                                                    <option value="san_miguel" {{ ($cuenta->distrito == 'san_miguel') ? 'selected':'' }}>San Miguel</option>
                                                    <option value="jesus_maria" {{ ($cuenta->distrito == 'jesus_maria') ? 'selected':'' }}>Jesús María</option>
                                                    <option value="magdalena" {{ ($cuenta->distrito == 'magdalena') ? 'selected':'' }}>Magdalena</option>
                                                    <option value="pblo_libre" {{ ($cuenta->distrito == 'pblo_libre') ? 'selected':'' }}>Pblo. Libre</option>
                                                </select>
                                              </div>

                                              <div class="form-group col-12">
                                                  <label for="direccion" for="direccion">Dirección</label>
                                                  <input id="direccion" class="form-control" name="direccion" value="{{ !is_null($cuenta->direccion) ? $cuenta->direccion : '' }}" type="text" {{ !is_null($cuenta->direccion) ? '' : 'disabled' }} required>
                                              </div>
                                          </div>
                                      </div>

                                  </div>

                                  @endif

                                  @if ($cuenta->edicion_finalizada)
                                    <div class="mt-3">
                                      <b>Método de Entrega:</b> {{ $cuenta->entrega }}
                                      <p>Cambiar la información de entrega no es posible si la edición se encuentra finalizada.</p>
                                    </div>
                                  @endif


                                  <button type="submit" class="pull-right ml-auto btn btn-outline-secondary linear black px-4"><p class="m-0 subtitle">Actualizar</p></button>
                      </div>

                      <!-- / entrega delivery -->

                  </div>


              </div>


            </div>
          </div>



      </div>

        </form>

      </div>



      <div class="col-lg-4">

        <form action="{{ route('giftregistry.updatepassword', $cuenta->id) }}" method="post">
        {{ csrf_field() }}

        <div class="card">

          <div class="card-header bg-white d-inline-flex">
              <h4 class="pt-1 m-0" style="font-size: 1.19em;">Accesos</h4>
          </div>

            <div class="card-body">

                  <div class="row">

                    <div class="col-lg-12">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="nombres">Email</label>
                                <input class="form-control" name="email" value="{{ $cuenta->email }}" type="text">
                            </div>
                            <span class="badge badge-light" style="background-color:#F1EBCD;">
                              <p class="font-weight-bold">** Si desea actualizar su contraseña, digitela nuevamente.</p>
                            </span>
                            <div class="form-group col-12">
                                <label for="apellidos">Nueva Contraseña</label>
                                <input class="form-control" name="password" value="" type="password">
                            </div>

                            <div class="form-group col-12">
                                <label for="apellidos">Confirmar Contraseña</label>
                                <input class="form-control" name="confirm_password" value="" type="password">
                            </div>
                        </div>

                        <button type="submit" class="btn-block ml-auto btn btn-outline-secondary linear black px-4"><p class="m-0 subtitle">Actualizar accesos</p></button>
                    </div>

                  </div>

            </div>

        </div>


        </form>

      </div>

  </div>

  <!-- -->

  <div class="mt-4"></div>

  <hr class="mb-3">

  @if(!$cuenta->edicion_finalizada)
  <div class="mb-4">
    <a id="agregar_producto_tienda" href="{{ route('home.tienda') }}">
      <i class="fa fa-plus-circle"></i> Agregar productos desde la tienda
    </a>
  </div>
  @endif

  @if($cuenta->edicion_finalizada && ($cuenta->entrega == 'recojo_tienda') )
  <div role="alert" class="alert alert-warning">
      <p class="m-0">Esta lista ya se encuentra publicada.</p>
  </div>

  <form method="POST" action="{{ route('cancelCalcList') }}">
    {{ csrf_field() }}
    <input type="hidden" name="cuenta_lista_regalo" value="{{ $cuenta->codigo }}">
    <button type="submit" class="btn btn-sm btn-info linear px-4 mb-3">Cancelar lista</button>
  </form>
  @endif


  @if($cuenta->entrega == 'delivery')
    <div class="costo-envio mt-2 mb-2">
      <b>Costo de envio: <span id="costo_envio_lista_regalo">
        @if($cuenta->costo_envio)
          S/. {{ $cuenta->costo_envio }}
        @else
          --
        @endif
      </span> </b>
    </div>
   @endif


   @if ( $cuenta->edicion_finalizada && !$cuenta->costo_envio && ($cuenta->entrega == 'delivery') )
      <div>
        <div role="alert" class="alert alert-info">
          <p class="m-0">Se ha enviado la lista para confirmar su costo de envío, una vez calculado la lista será pública.</p>
          <!--p class="m-0">Puede volver a modificar la lista mientras el costo de envio no esté hecho.</p-->
        </div>

        <form method="POST" action="{{ route('cancelCalcList') }}">
          {{ csrf_field() }}
          <input type="hidden" name="cuenta_lista_regalo" value="{{ $cuenta->codigo }}">
          <button type="submit" class="btn btn-sm btn-info linear px-4 mb-3">Cancelar cálculo</button>
        </form>

      </div>
  @endif


  @if($cuenta->entrega && !$cuenta->edicion_finalizada)
    <div role="alert" class="alert alert-warning">
      <p class="m-0">Haga clic en finalizar edición para calcular el costo de envío, una vez calculado la lista será pública.</p>
    </div>
  @endif


  <!--p>Recargo de delivery (por item): </p-->


  <div class="table-responsive">
    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">

      <thead>
        <tr>
          <th width="200"></th>
          <th>Regalo</th>
          <th>Color</th>
          <th>Solicitados</th>
          <th>Recibidos</th>
          <th>Precio por item</th>
          <th>Recargo delivery (Total)</th>
          <th>Total</th>
          <th></th>
        </tr>
      </thead>

      <tbody>

        @foreach($regalos as $product)
        <tr>
          <td class="pt-1 pb-1 pl-2">
            @if(!$product->img)
              <img src="{{ url('/media/default.jpg') }}" class="img-fluid rounded" style="width: 200px;height: 100px;object-fit: cover;" alt="">
            @else
              <img src="{{ url('uploads/products', $product->img) }}" class="img-fluid rounded" style="width: 200px;height: 100px;object-fit: cover;" alt="">
            @endif
          </td>
          <td>{{ $product->nombre }}</td>
          <td>{{ ucfirst($product->color) }}</td>
          <td>{{ $product->solicitados }}</td>
          <td>{{ $product->recibidos }}</td>
          <td>{!! getGiftItemPrice($product) !!}</td>
          <td><span>S/ {{ calcTotalChargeGiftItem($product) }}</span></td>
          <td><span>S/ {{ calcTotalGiftItem($product) }}</span></td>
          <td>
              @if ( !$cuenta->edicion_finalizada )
                <a class="remove-product btn btn-link text-warning" data-toggle="modal" data-target="#confirm_delete_product" data-url="{{ route('home.novios.removeproduct') }}" data-id="{{ $product->id }}" data-color="{{ $product->color }}" href="#"><i class="fas fa-trash-alt"></i></a>
              @endif
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  <!-- // -->



  @if($cuenta->entrega && !$cuenta->edicion_finalizada)
    <form method="POST" action="{{ route('saveList') }}">
      {{ csrf_field() }}
      <input type="hidden" name="cuenta_lista_regalo" value="{{ $cuenta->codigo }}">
      <button id="finalizar_edicion" type="submit" class="btn btn-sm btn-danger linear px-4 mb-2 float-right">Finalizar edición</button>
    </form>
  @endif


</div>

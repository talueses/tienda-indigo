@extends('layouts.front', ['subtitle'=>'Carrito de Compras'])
@section('contenido')
@include('partials.socialfixed')
@include('partials.banner', ['brand'=>['name'=>'Carrito de Compras', 'img'=> asset('media/banner.jpg')]])
<div class="container contenido">
  <div class="row justify-content-around">
    <div class="col-md-9">

      <h4>Orden Hecha</h4>

    </div>

    <div class="col-md-3">

        <div class="row">

            <div class="col-md-12">
              <h4 style="font-size: 18px;">RESUMEN DEL PEDIDO</h4>

              <hr class="mt-3 mb-2">
              <p class="text-center mb-0"><small class="d-flex align-items-center"><i class="fas fa-truck fa-border fa-3x text-secondary" style=""></i> Delivery gratuito solo en Lima.</small></p>
              <hr class="my-2">

              <div class="">

                  <ul class="list-unstyled p-0 mb-4 text-left">
                    <li><span class="mr-2 text-bold">Costo de envío:</span> <span class="float-right" id="costo_envio">--</span></li>
                    <li><span class="mr-2 text-bold text-uppercase">TOTAL:</span> <span id="total_price_order" class="float-right">S/ 0.00</span></li>
                  </ul>


                  <b>Modo de Entrega</b>
                  <hr>

                  <div class="form-group mt-2">

                    <input type="radio" name="modo_entrega" value="recojo_tienda" checked><span class="pl-2">Recojo en tienda</span><br>
                    <input type="radio" name="modo_entrega" value="delivery"><span class="pl-2">Delivery</span><br>

                  </div>


                  <!-- -->
                  <div class="form-row">
                    <div class="form-group col-12">

                      <label for="" class="col-form-label">Departamento</label>
                      <select id="envio_departamento" class="form-control" name="" disabled>

                        <option value="amazonas">Amazonas</option>
                        <option value="ancash">Ancash</option>
                        <option value="apurimac">Apurimac</option>
                        <option value="arequipa">Arequipa</option>
                        <option value="ayacucho">Ayacucho</option>
                        <option value="cajamarca">Cajamarca</option>
                        <option value="callao">Callao</option>
                        <option value="cusco">Cusco</option>
                        <option value="huancavelica">Huancavelica</option>
                        <option value="huanuco">Huanuco</option>
                        <option value="ica">Ica</option>
                        <option value="junin">Junin</option>
                        <option value="la_libertad">La Libertad</option>
                        <option value="Lambayeque">Lambayeque</option>
                        <option value="lima" selected>Lima</option>
                        <option value="loreto">Loreto</option>
                        <option value="madre_de_dios">Madre De Dios</option>
                        <option value="moquegua">Moquegua</option>
                        <option value="pasco">Pasco</option>
                        <option value="piura">Piura</option>
                        <option value="puno">Puno</option>
                        <option value="san_martin">San Martin</option>
                        <option value="tacna">Tacna</option>
                        <option value="tumbes">Tumbes</option>
                        <option value="ucayali">Ucayali</option>

                      </select>

                    </div>

                    <div class="form-group col-12">

                      <label for="" class="col-form-label">Dirección</label>
                      <input id="envio_direccion" class="form-control" type="text" name="" value="" disabled>

                    </div>

                    <div class="alert alert-warning" role="alert">
                      Para envíos con recargo, el costo de envío será calculado y luego será notificado a su correo para continuar su compra.
                    </div>

                    <div id="order_error_message" class="alert alert-danger w-100" role="alert" style="display:none;"></div>

                  </div>
                  <!-- -->

              </div>


              <a id="btn_checkout" class="continue btn btn-outline-secondary linear w-100 py-2 my-2"><p class="subtitle text-uppercase m-0"><i class="fa fa-shopping-cart mr-2"></i> Ir a checkout</p></a>
              <a style="display:none;" id="btn_generar_orden" class="continue btn btn-outline-secondary linear w-100 py-2 my-2"><p class="subtitle text-uppercase m-0"><i class="fa fa-shopping-cart mr-2"></i> Generar orden</p></a>

            </div>

        </div>

    </div>


  </div>
</div>
@endsection

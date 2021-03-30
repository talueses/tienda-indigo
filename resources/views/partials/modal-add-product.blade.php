<div class="modal fade" id="modal_add_product" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

      <div class="modal-body">


        <div class="row">

          <div class="col-6">
            <div class="row">

                <div class="col-md-12 mb-3">
                  <i class="fas fa-plus"></i> <span class="title ml-2">Agregar producto</span>
                </div>

                <div class="col-12">
                  <div class="mb-2">
                    <span id="modal_add_product_cart_title" style="font-size: 1.4em;">Item</span>
                  </div>
                </div>

                <div class="col-6">
                    <div class="product-image-container layer_cart_img">
                        <img id="modal_add_product_cart_img" class="img-fluid" src="" alt="">
                    </div>
                </div>

                <div class="col-6">

                  <div class="layer_cart_product_info">

                      <div class="">
                        <strong>Precio:</strong> <!-- Precio -->
                        S./<span id="modal_add_product_cart_price">0</span>
                      </div>
                  </div>

                </div>

            </div>
          </div>


          <div class="col-6 layer_cart_cart" style="border-left: 1px solid #e8e8e8;">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

            <span class="title"> <span class="ajax_cart_product_txt"></span>  </span>

            <input id="modal_add_product_cart_product_id" type="hidden" value="">
            <div id="modal_add_product_cart_select_stock"></div>

            <br>
            <br>
            <div class="row justify-content-center mb-1">
              <div class="button-container">
                <button id="btn_add_product_cart" class="continue btn btn-outline-secondary linear" title="Agregar" data-dismiss="modal">
                  <span>Agregar</span>
               </button>
            </div>
              <div class="col-auto">
                <a href="javascript:void(0);" id="modal_add_product_cart_href_eyes" class="btn btn-link text-secondary"><i class="fa fa-eye"></i> </a>
              </div>

              @if (!auth('boda')->check())
              <!--<div class="col-auto">
                <a href="#" class="btn btn-link text-secondary add_to_cart_btn" data-item="{{ $product->id }}" data-img="{{ $product->img }}" data-title="{{ $product->nombre }}" data-price="{{ $product->precio-$product->descuento }}" ><i class="fa fa-cart-plus"></i> </a>
              </div>-->
              @endif

            </div>

          </div>


        </div>

      </div>

    </div>
  </div>
</div>

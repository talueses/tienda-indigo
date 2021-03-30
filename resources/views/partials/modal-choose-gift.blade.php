<div class="modal fade" id="modal_choose_gift" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

      <div class="modal-body">


        <div class="row">

          <div class="col-6">
            <div class="row">

                <div class="col-md-12 mb-3">
                  <i class="fas fa-plus"></i> <span class="title ml-2">Agregar producto a mi lista</span>
                </div>

                <div class="col-12">
                  <div class="mb-2">
                    <span id="modal_choose_gift_title" style="font-size: 1.4em;">Item</span>
                  </div>
                </div>

                <div class="col-6">
                    <div class="product-image-container layer_cart_img">
                        <img id="modal_choose_gift_img" class="img-fluid" src="" alt="">
                    </div>
                </div>

                <div class="col-6">

                  <div class="layer_cart_product_info">

                      <div class="">
                        <strong>Precio:</strong> <!-- Precio -->
                        S./<span id="modal_choose_gift_price">0</span>
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

            <input id="modal_choose_gift_cuenta_id" type="hidden" value="">
            <input id="modal_choose_gift_product_id" type="hidden" value="">
            <div id="modal_choose_gift_select_stock"></div>

            <br>
            <br>

            <div class="button-container">
              <!-- btn_choose_gift |  btn_add_wedding_list  -->
                <button id="btn_choose_gift" class="continue btn btn-outline-secondary linear" title="Agregar" data-dismiss="modal">
                  <span>Agregar</span>
               </button>
            </div>

          </div>


        </div>

      </div>

    </div>
  </div>
</div>

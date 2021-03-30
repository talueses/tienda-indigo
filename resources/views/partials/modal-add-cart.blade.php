<div class="modal modal-cart fade" id="modal_cart" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-body">


        <div class="row">

          <div class="col-6">
            <div class="row">

                <div class="col-md-12 mb-3">
                  <i class="fas fa-check"></i> <span class="title ml-2">Se ha agregado el producto satisfactoriamente</span>
                </div>

                <div class="col-6">
                    <div class="product-image-container layer_cart_img">
                        <img id="modal_cart_img" class="img-fluid" src="" alt="">
                    </div>
                </div>

                <div class="col-6">

                  <div class="layer_cart_product_info">
                      <div class="">
                        <span id="layer_cart_product_title">Item</span>
                      </div>

                      <div class="">
                        <strong>Cantidad:</strong>
                        <span id="layer_cart_product_quantity">0</span>
                      </div>

                      <div class="">
                        <strong>Precio:</strong> <!-- Precio -->
                        S./<span id="layer_cart_product_price">0</span>
                      </div>
                  </div>

                </div>

            </div>
          </div>


          <div class="col-6 layer_cart_cart" style="border-left: 1px solid #e8e8e8;">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

            <span class="title"> <span class="ajax_cart_product_txt"> Hay  <span class="ajax_cart_quantity">#</span> item(s) en tu carro de compras. </span>  </span>


            <div class="button-container">
                <button class="continue btn btn-outline-secondary linear" title="Seguir comprando" data-dismiss="modal">
                  <span>
                   <i class="icon-chevron-left left"></i> Seguir comprando
                 </span>
               </button>

               <a class="btn btn-outline-secondary linear ml-2" href="/cart" title="Ir a carrito" rel="nofollow">
                 <span> Finalizar Compra<i class="icon-chevron-right right"></i></span>
               </a>
            </div>

          </div>


        </div>

      </div>

    </div>
  </div>
</div>

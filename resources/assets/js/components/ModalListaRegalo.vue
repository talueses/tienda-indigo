<template>

<div v-bind:class="{ 'modal-open' : open == true}">

  <div v-bind:class="{ 'show' : open == true}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-modal="true" v-bind:style= "[open ? {display: 'block', paddingRight: '15px' } : {display: 'none'}]">
    <div class="modal-dialog" role="document">
      <div class="modal-content">


        <div v-show="loading" class="modal-loading">
            <i class="fa fa-spinner fa-spin fa-5x fa-spinner"></i>
        </div>


        <div v-show="finished" class="modal-body">
            <div class="row justify-content-center align-items-center h-100">

                <div class="col-12 text-center">
                    <button type="button" class="close" aria-label="Close" @click="closeModal()">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <div>
                        <i class="fa fa-gift fa-4x text-warning mt-4"></i>

                        <p class="mt-4 fa-1x">Se ha agregado el producto a la lista de regalos</p>

                        <!-- BEGIN continuar comprando y ir a lista -->
                        <div class="mt-2 mb-2">
                            <div class="button-container">
                                <button class="continue btn btn-outline-secondary linear" title="Seguir comprando" @click="closeModal()">
                                  <span>
                                  <i class="icon-chevron-left left"></i>Continuar Agregando
                                </span>
                              </button>

                              <a class="btn btn-outline-secondary linear ml-2" title="Ir a la lista de regalos" @click="goToListUrl()">
                                <span> Ir a la lista de regalos<i class="icon-chevron-right right"></i></span>
                              </a>
                            </div>
                        </div>
                        <!-- END continuar comprando y ir a lista -->

                    </div>
                </div>

            </div>
        </div>


        <div v-show="!finished" class="modal-body " style="min-height: 303px;">

          <div class="row">

              <div class="col-6">
                <div class="row">

                    <div class="col-md-12 mb-3">
                      <i class="fas fa-plus"></i> <span class="title ml-2">Agregar producto</span>
                    </div>

                    <div class="col-12">
                      <div class="mb-2">
                        <span id="modal_add_product_cart_title" style="font-size: 1.4em;">{{ title }}</span>
                      </div>
                    </div>

                    <div class="col-12">

                      <div class="layer_cart_product_info">

                          <div class="mb-2">
                            <strong>Precio:</strong>
                            <span id="modal_add_product_cart_price">{{ 'S/ ' + price }}</span>
                          </div>
                      </div>

                    </div>

                    <div class="col-12">
                        <div class="product-image-container layer_cart_img">
                          <div class="img-cont-full r1-1">
                            <img id="modal_add_product_cart_img" class="img-fluid" v-bind:src="img" v-bind:alt="title">
                          </div>
                        </div>
                    </div>

                </div>


              </div>

              <div class="col-6 layer_cart_cart" style="border-left: 1px solid #e8e8e8;">

                  <button type="button" class="close" aria-label="Close" @click="closeModal()">
                    <span aria-hidden="true">&times;</span>
                  </button>

                  <span class="title"> <span class="ajax_cart_product_txt"></span>  </span>


                  <label for="listas">Lista</label>
                  <select style="font-size: 0.89rem;" v-model="giftRegistryList" id="listas" class='form-control'>
                    <option v-for="list in lists" :value="list.codigo">{{list.titulo}}</option>
                  </select>

                  <template v-if="hasColor && lists.length > 0  ">

                      <label for="color" class="pt-4">Color</label>
                      <select style="font-size: 0.89rem;" v-model="giftRegistryColor" id="color" class='form-control'>
                        <option v-for="color in colors" :value="color.color">{{color.color}}</option>
                      </select>

                      <label for="cantidad" class="pt-4">Cantidad</label>
                      <select v-model="giftRegistryQty" id="cantidad" class='form-control' :disabled="stock <= 0">
                        <option v-for="qty in stock" :value="qty">{{qty}}</option>
                      </select>

                  </template>

                  <template v-else="!hasColor">
                    <label for="cantidad" class="pt-4">Cantidad</label>
                    <select v-model="giftRegistryQty" id="cantidad" class='form-control' :disabled="stock <= 0">
                      <option v-for="qty in stock" :value="qty">{{qty}}</option>
                    </select>
                  </template>


                  <br>
                  <br>

                  <div class="button-container">

                        <template v-if="hasColor && lists.length > 0  ">
                         <button @click="addToList()" :disabled="!giftRegistryColor || !giftRegistryList || !giftRegistryQty" id="btn_add_product_cart" class="continue btn btn-outline-secondary linear" title="Agregar">
                            <span>Agregar</span>
                         </button>
                       </template>

                       <template v-else="!hasColor">
                         <button @click="addToList()" :disabled="!giftRegistryList || !giftRegistryQty" id="btn_add_product_cart" class="continue btn btn-outline-secondary linear" title="Agregar">
                            <span>Agregar</span>
                         </button>
                       </template>

                  </div>

              </div>


          </div>
        </div>


      </div>
    </div>
  </div>

  <div v-if="open" class="modal-backdrop fade show"></div>

</div>

</template>

<script>

    export default {
        props: ['open', 'product', 'giftaccountid'],
        data() {
            return {
              'title': '',
              'price': '',
              'img': '/media/default.jpg',
              'lists': [],
              'colors': [],
              'stock': [],
              'quantity': [],
              'hasColor': false,
              'giftRegistryList': null,
              'giftRegistryColor': null,
              'giftRegistryQty': null,
              'loading': true,
              'finished': false
            }
        },
        watch: {
          open: function(val) {
            if (val == true) {
              this.getStock()
            }
          },

          giftRegistryColor: function(val) {
            this.stock = this._getColorStock(val)
          }
        },
        methods: {
          goToListUrl() {
              window.location.replace('/programa-de-regalos/lista/detalle/' + this.giftRegistryList);
          },
          closeModal() {
            this.$emit('closemodal')
            this.loading = true
            this.clear()
          },
          addToList() {

              let vm = this
              vm.loading = true
              console.log('add to list');
              /**/
              let data = {
                cuenta_id : this.giftaccountid,
                producto_id : this.product,
                lista_codigo: this.giftRegistryList,
                cantidad : this.giftRegistryQty,
                color : this.giftRegistryColor
              }

              axios.post('/programa-de-regalos/lista/addproduct', data)
                .then(function (response) {
                    var resp = response.data
                    console.log('resp', resp);

                    vm.loading = false
                    vm.finished = true

                }).catch(function (error) {
                    //vm.errors = error.response.data;
                    vm.loading = false
              });
          },
          getStock() {
              let vm = this;
              let productId = this.product

              axios.post('/programa-de-regalos/getproductstock', {productId:productId})
                .then(function (response) {
                    var resp = response.data
                    vm.title = resp.data.title
                    vm.img = 'uploads/products/' + resp.data.img
                    vm.price = resp.data.price
                    vm.lists = resp.data.lists

                    vm.giftRegistryList = vm.giftRegistryList ? vm.giftRegistryList : vm.lists[0].codigo

                    if (vm._hasColor(resp.data.stock)) {
                      vm.hasColor = true
                      vm.colors = resp.data.stock

                      vm.giftRegistryColor = vm.colors[0].color
                      vm.giftRegistryQty = (vm.colors[0].stock > 0 ? 1 : null)
                    } else {
                        vm.stock = resp.data.stock[0].stock
                    }

                    vm.loading = false

                }).catch(function (error) {
                    //vm.errors = error.response.data;
                    vm.loading = false
              });

          },
          clear() {
            this.giftRegistryList = null
            this.giftRegistryColor = null
            this.giftRegistryQty = null
            this.hasColor = false
            this.colors = []
            this.loading = true
            this.finished = false
          },
          _getColorStock(val) {
            var stock = 0;
            for (var i = 0; i < this.colors.length; i++) {
              if ( this.colors[i].color == val) {
                stock = this.colors[i].stock;
              }
            }

            return stock;
          },
          _hasColor(items){
            var hasColor = false;
            for (var i = 0; i < items.length; i++) {
              if (items[i].hasOwnProperty('color')){
                hasColor = true;
              }
            }
            return hasColor;
          }
        },
        created() {
          let codeFromGiftList = localStorage.getItem('codeFromGiftList');
          if(codeFromGiftList && codeFromGiftList != null) 
          {
            this.giftRegistryList = codeFromGiftList
          }
        }
    }
</script>

<style scoped>
  .fa-spinner {
    margin-top: 150px;
    margin-bottom: 130px;
  }
</style>

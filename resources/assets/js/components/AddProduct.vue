<template>

  <div>

        <div v-show="loading" class="product-detail-loading">
            <i class="fa fa-spinner fa-spin fa-2x fa-spinner"></i>
        </div>

        <template v-if="!loading">

            <template v-if="hasColor">

                <div class="color-cart-box d-flex align-items-center">
                  <h5>color:</h5>
                  <div>
                    <select v-model="giftRegistryColor" class="form-control">
                      <option v-for="color in colors" :value="color.color">{{color.color}}</option>
                    </select>
                  </div>
                </div>

                <div class="qty-cart-box d-flex align-items-center">
                   <h5>cantidad:</h5>
                   <div>
                     <select v-model="giftRegistryQty" class="form-control" :disabled="stock <= 0">
                       <option v-for="qty in stock" :value="qty">{{qty}}</option>
                     </select>
                   </div>
                </div>

            </template>

            <template v-else="!hasColor">

                <div class="qty-cart-box d-flex align-items-center">
                   <h5>cantidad:</h5>
                   <div>
                     <select v-model="giftRegistryQty" class="form-control" :disabled="stock <= 0">
                       <option v-for="qty in stock" :value="qty">{{qty}}</option>
                     </select>
                   </div>
                </div>

            </template>


            <div class="col-lg-5 p-0">

                <button class="btn btn-outline-secondary black linear w-100 py-2 my-2" @click="addCart()" :disabled="!giftRegistryQty">
                  <p class="subtitle text-uppercase m-0" style="font-size: 13px;"><i class="fa fa-shopping-cart mr-2"></i> Agregar al carrito</p>
                </button>

            </div>

            <div class="mt-2 mb-2">
                <span v-if="msgResponse" style="font-size: 14px;"><i class="fa fa-check-circle"></i> {{ msgResponse }} </span>
                <div class="button-container" v-if="showEndingIcons">
                    <button class="continue btn btn-outline-secondary linear" title="Seguir comprando" @click="goToShopping()">
                      <span>
                      <i class="icon-chevron-left left"></i>Seguir comprando
                    </span>
                  </button>

                  <a class="btn btn-outline-secondary linear ml-2" href="/cart" title="Finalizar Compra" rel="nofollow">
                    <span> Finalizar Compra<i class="icon-chevron-right right"></i></span>
                  </a>
                </div>
            </div>

        </template>

  </div>

</template>

<script>

const functions = require('./functions')
const Cart = require('./Cart')
import CheckoutArea from './Checkout'
import Checkout from './CheckoutCart'
import { setTimeout } from 'timers';

    export default {
        props: ['product'],
        data() {
            return {
              'colors': [],
              'stock': [],
              'quantity': [],
              'hasColor': false,
              'giftRegistryColor': "",
              'giftRegistryQty': 0,
              'loading': true,
              'msgResponse': null,
              'showEndingIcons': false,
            }
        },
        mounted() {
          this.getProduct()
        },
        watch: {
          open: function(val) {
            if (val == true) {
              this.getStock()
            }
          },

          giftRegistryColor: function(val) {
            this.stock = this._getColorStock(val)
            this.giftRegistryQty = null
          }
        },
        methods: {
          goToShopping() {
            this.endingIcons()
            window.location.replace('tienda')
          },
          addCart() {

              console.log("add to cart");

              var vm = this;
              var product = {
                id: vm.product,
                quantity: vm.giftRegistryQty,
                color: vm.giftRegistryColor,
                wedding_list_id: ""
              }

              vm.msgResponse = Cart.add(product);
              functions.calcItemsInCart();

              this.endingIcons();

          },
          endingIcons() {
            this.giftRegistryQty = 0;
            this.showEndingIcons = this.showEndingIcons ? false : true;
            setTimeout(() => {
               this.msgResponse = null
               }, 3000);
          },
          setSuccessModal(msg) {

          },
          getProduct() {
              let vm = this;
              let productId = vm.product


              axios.post('/api/producto/getstock', {productId:productId})
                .then(function (response) {

                    var resp = response.data

                    if (vm._hasColor(resp.stock)) {
                      vm.hasColor = true
                      vm.colors = resp.stock

                      vm.giftRegistryColor = vm.colors[0].color
                      vm.giftRegistryQty = (vm.colors[0].stock > 0 ? 1 : null)
                    } else {
                        vm.stock = resp.stock[0].stock
                    }

                    vm.loading = false

                }).catch(function (error) {
                    //vm.errors = error.response.data;
                    vm.loading = false
              });

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

        }
    }
</script>

<style>

</style>

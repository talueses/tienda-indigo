<template>
 
    <div class="row justify-content-around bg-white pt-5 pb-4">

        <div class="col-md-9">
            <checkout :cart="cart" :cart-sub-total="cartSubTotal" :cart-total="cartTotal" :shipping-price="shippingPrice" @update="onUpdateCart"></checkout>
        </div>

        <div class="col-md-3">
            <checkout-area v-if="cart.products && cart.products.length" :cart-sub-total="cartSubTotal" :cart-total="cartTotal" :shipping-price="shippingPrice" :countries="countries" @update="onUpdateCart" @updateShippingPrice="onUpdateShippingPrice"></checkout-area>
        </div>
    </div>

</template>

<script>

    const functions = require('./functions')
    const Cart = require('./Cart')
    import CheckoutArea from './Checkout'
    import Checkout from './CheckoutCart'

    export default {
        data() {
            return {
                cart: [],
                shippingPrice: 0,
                cartSubTotal: 0,
                cartTotal: 0,
                countries: [],
                select_deptos:false,
                departamentos:[]
            }
        },
        mounted() {
            this.fetchData()
            this.fetchCountries()
        },
        methods: {
            fetchCountries() {
                var vm = this;

                axios.get('/api/countries')
                    .then(function (response) {
                        var data = response.data
                        vm.countries = data
                    })
                    .catch(function (error) {
                        //
                    });
            },
            fetchData() {
                var listLocal = functions.getCartList();
                var vm = this;
                    // TODO: sacar informacion del carro 
                  axios.post('/shopcartinfo', listLocal).then(function (response) {
                        var data = response.data
                        vm.cart = data
                        vm.getTotal()
                        console.log(vm.cart);
                  })
                  .catch(function (error) {
                      //vm.errors = error.response.data;
                  });
            },
            getSubtotal() {

                var a = 0;
                this.cart.products.map((b) => 
                {
                    let price = parseFloat(b.price-b.dsct);
                    a += (price * parseInt(b.quantity))
                })
                return a.toFixed(2)
            },
            getTotal() {
                
                this.cartSubTotal = this.getSubtotal()
                let grandTotal = Number(this.cartSubTotal + this.shippingPrice)
                this.cartTotal = grandTotal.toFixed(2)
            },
            onUpdateCart() {
                this.fetchData()
            },
            onUpdateShippingPrice(value) {
                
                this.shippingPrice = value
            }
        }
    }
</script>

<style>

</style>

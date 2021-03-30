<template>
    <div class="col-12" ref="giftContainer">

        <!-- BEGIN upside buttons -->
        <div v-if="list.edicion_finalizada == 1">
            
            <div role="alert" class="alert alert-warning mt-3" v-if="list.entrega == 'recojo_tienda'">
                <p class="m-0">Esta lista ya se encuentra publicada.</p>
            </div>

            <div role="alert" class="alert alert-info" v-if="list.entrega == 'delivery' && list.departamento == 'lima_metropolitana'">
                <a class="close" data-dismiss="alert">×</a>
                <p class="m-0">{{ freeDelivery }}</p>
            </div>

            <div role="alert" class="alert alert-info" v-if="list.entrega == 'delivery' && list.departamento != 'lima_metropolitana' && !list.costo_envio">
                <p class="m-0">El costo de envío y tiempo de entrega será enviado por correo electrónico.</p>
            </div>

            <div class="pt-3">
                <button type="button" class="btn btn-sm btn-info linear px-4 mb-3" v-on:click="editList()">Editar lista</button>
            </div>

        </div>
        <notifications group="notifications" position="bottom right"/>
        <!-- END upside buttons -->

        <div class="row justify-content-around bg-white pt-5 pb-4">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <checkout-gift :cart="newcart" :list="newList" @update="onUpdateCart"></checkout-gift>
            </div>
        </div>
        
        <!-- BEGIN downside buttons -->
        <div role="alert" class="alert alert-warning mt-3" v-if="list.entrega && !list.edicion_finalizada">
            <p class="m-0">Haga clic en finalizar edición para calcular el costo de envío, una vez calculado la lista será pública.</p>
        </div>

        <div class="action-add-gift-cart mb-4">
            <!-- agregar productos -->
            <div v-if="!list.edicion_finalizada">
                <a href="/tienda" class="btn btn-sm btn-danger linear px-4 mr-3 float-left" v-on:click="setCodeFromGiftList(list.codigo)">
                    <i class="fa fa-plus-circle"></i> Agregar productos desde la tienda
                </a>
            </div>
            <!-- // agregar productos -->

            <!-- finalizar edicion -->
            <div v-if="list.entrega && !list.edicion_finalizada">
                <button type="button" class="btn btn-sm btn-danger linear px-4 mb-2 float-left" v-on:click="finishList()">Finalizar edición</button>
            </div>
            <!-- // finalizar edicion -->
        </div>
        <!-- BEGIN downside buttons -->
    </div>
</template>

<script>
    import CheckoutGift from './CheckoutGiftCart'

    export default {
        props: ['list', 'freeDelivery'],
        data() {
            return {
                newcart: [],
                newList: {},
                newLocalList: []
            }
        },
        mounted() {
            this.fetchData()
        },
        components: {
            CheckoutGift
        },
        methods: {
            editList() {
                var vm = this
                let codeList = this.list.codigo

                axios.post('/programa-de-regalos/cancelarcalculolista', { cuenta_lista_regalo: codeList }).then(function (response) {
                    vm.toggleEdition()
                    vm.$emit('updateDetails')
                })
                .catch(function (error) {
                    console.log(error)
                })

            },
            finishList() {
                var vm = this
                let codeList = this.list.codigo

                axios.post('/programa-de-regalos/finalizarlista', { cuenta_lista_regalo: codeList }).then(function (response) {
                    vm.toggleEdition()
                    vm.$emit('updateDetails')
                })
                .catch(function (error) {
                    console.log(error)
                })

            },
            toggleEdition() {
                this.list.edicion_finalizada = this.list.edicion_finalizada == 1 ? 0 : 1
                this.fetchData()
            },
            setCodeFromGiftList(codeList) {
                localStorage.setItem('codeFromGiftList', codeList)
            },
            async getList() {
                var vm = this
            
                await axios.post('/api/giftproduct/list', { list_id: vm.list.id }).then(function (response) 
                {
                    if(response.data) 
                    {
                        vm.newLocalList = response.data

                    } else 
                    {
                      console.log('no hay productos en la lista')
                    }    
                    
                })
                .catch(function (error) {
                    console.log('ERROR: al actualizar el producto')
                    console.log(error)
                })

                return vm.newLocalList

            },
            fetchData() {
                var vm = this
                var loader = this.$loading.show({container: vm.$refs.giftContainer })

                vm.getList().then(function(res) {

                    vm.newLocalList.map((nl) =>
                    {
                        nl.id = nl.producto_id
                        nl.quantity = nl.solicitados
                        nl.price = nl.precio
                    })

                    axios.post('/shopcartinfo', { products: vm.newLocalList }).then(function (response) 
                    {
                        let data = response.data

                        data.products.map((d) =>
                        {
                            vm.newLocalList.map((nl) =>
                            {
                                if(d.id == nl.id) {
                                    d.recibidos = nl.recibidos
                                    d.recargo = nl.recargo
                                    d.dsct_lista_regalo = nl.dsct_lista_regalo
                                }
                            })
                            
                        })

                        vm.newcart = data

                        vm.$notify({
                            group: 'notifications',
                            type: 'info',
                            title: 'Lista de productos',
                            text: 'Se han cargado los productos de la lista de regalos'
                        })

                        loader.hide()

                    })
                    .catch(function (error) {
                        //vm.errors = error.response.data;
                        console.log('ERROR: al cargar el carrito de regalos')
                        console.log(error)
                    })

                    vm.newList = vm.list

                })
            },
            onUpdateCart() {
                this.fetchData()
            }
        }
    }
</script>

<style>

</style>

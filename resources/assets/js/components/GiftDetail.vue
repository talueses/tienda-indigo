<template>
    <div class="col-9">

        <!-- BEGIN NOTIFICATION -->
        <notifications group="notifications" position="bottom right"/>
        <!-- END NOTIFICATION -->

        <div class="gift-registry-content">
            
            <div class="card-body">

                <div class="mb-3">
                    <button style="font-size: 0.9em;" type="button" name="button" class="subtitle btn btn-outline-secondary linear" data-toggle="modal" data-target="#share_link">
                        <i class="fas fa-share-alt mr-2"></i> Compartir lista de regalo
                    </button>
                    <a style="font-size: 0.9em;" class="subtitle btn btn-outline-secondary linear" :href="`/programa-de-regalos/preview/${ giftDetail.codigo }`" target="_blank"><i class="fas fa-eye mr-2"></i> Vista previa</a>

                    <div class="subtitle btn" style="font-size: 0.9em;">
                        Estado: <span :class="`badge ${giftDetail.badge}`"> {{ giftDetail.state }} </span>
                    </div>
                    <div class="subtitle btn" style="font-size: 0.9em;">
                        <div class="costo-envio">
                            Costo de envio:
                                <template v-if="giftDetail.entrega == 'delivery' && giftDetail.departamento != 'lima_metropolitana'">
                                    <span v-if="giftDetail.costo_envio" class="badge badge-light border text-danger" style="font-size: 0.9em;">S/. {{ giftDetail.costo_envio }}</span>
                                    <span v-else  class="badge badge-light border text-secondary" style="font-size: 0.9em;">Por confirmar</span>    
                                </template>

                                <template v-else-if="giftDetail.entrega == 'delivery' && giftDetail.departamento == 'lima_metropolitana'">
                                    <span class="badge badge-light border text-danger" style="font-size: 0.9em;"> Envio gratis </span>        
                                </template>

                                <template v-else>
                                    <span class="badge badge-light border text-danger" style="font-size: 0.9em;"> Recoger en tienda </span>
                                </template>
                        </div>
                    </div>
                    <div class="external-link" v-if="giftDetail.tracking"><!-- BEGIN TRACKING -->
                        <span class="badge badge-success"> Seguimiento <i class="fas fa-chevron-right" aria-hidden="true"></i> </span>
                        <span class="badge badge-light">
                            <a :href="giftDetail.tracking" target="_blank"> Ver tracking <i class="fas fa-external-link-alt"></i></a>
                        </span>
                    </div><!-- END TRACKING -->
                </div>

                <ul class="nav nav-tabs nav-tabs-gift">
                    <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu_detalles_lista">Detalles de Lista</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#menu_regalos">Regalos</a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane container fade" id="menu_detalles_lista" ref="detailsContainer">

                        <div class="row">

                            <div class="col-md-12">
  
                                <div class="form-group">

                                    <label for="evento">Imagen del Evento</label>
                                    <div class="image-preview mb-3"> 
                                        <!-- BEGIN img-cont-full r1-1 -->
                                        <img  class="img-fluid rounded border" :src="imgPreview" :alt="giftDetail.titulo" style="max-width: 130px;">
                                    
                                        <!-- END img-cont-full r1-1 -->
                                        <div class="d-inline p-2 delete-preview mt-2 text-center">
                                            <a href="#" data-toggle="modal" data-target="#confirm_delete_image" class="delete-preview mt-2 text-danger"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </div>

                                    <span class="d-inline p-2 btn btn-outline-secondary linear px-4 btn-file mt-2 subtitle" style="font-size:14px;">
                                        Escoger imagen <input type="file" name="img" ref="file" @change="handleFileUpload()"/>
                                    </span>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                    <label for="titulo_evento">Código</label>
                                    <input class="form-control" type="text" :value="giftDetail.codigo" disabled>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="titulo_evento">Título del Evento</label>
                                        <input type="text" class="form-control" name="titulo_evento" v-model="giftDetail.titulo" placeholder="">
                                    </div>

                                    <div class="form-group col">
                                        <label for="fecha_evento">Fecha del Evento</label>
                                        <input id="fecha_evento" name="fecha_evento" type="text" class="form-control" v-model="giftDetail.fecha" required="true">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="desc_evento">Descripción</label>
                                    <textarea class="form-control" name="desc_evento" placeholder="" v-model="giftDetail.desc"></textarea>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="organizador_uno">Nombre Organizador 1</label>
                                        <input class="form-control" name="organizador_uno" v-model="giftDetail.organizador_uno" type="text">
                                    </div>

                                    <div class="form-group col">
                                        <label for="organizador_dos">Nombre Organizador 2</label>
                                        <input class="form-control" name="organizador_dos" v-model="giftDetail.organizador_dos" type="text">
                                    </div>
                                </div>

                                <h4 class="h5 mt-4">Detalles de entrega</h4>

                                <template v-if="!giftDetail.edicion_finalizada">

                                    <div class="form-row">

                                        <div class="form-group col">
                                            <label for="modo_entrega">Tipo</label>
                                            <select name="modo_entrega" v-model="giftDetail.entrega" class="form-control" required>
                                                <option value="recojo_tienda">Recojo en Tienda</option>
                                                <option value="delivery">Delivery</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col">
                                            <label for="envio_departamento">Departamento</label>
                                            <select v-model="giftDetail.departamento" class="form-control" :disabled="isDisableDepartments">
                                                <option value="lima" :selected="true">Lima</option>
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
                                                <option value="lambayeque">Lambayeque</option>
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

                                        <div class="form-group col">
                                            <label for="envio_lima_metropolitana">Distrito</label>
                                            <select v-model="giftDetail.distrito" class="form-control" :disabled="isDisableDistricts">
                                                <optgroup label="Delivery Gratuito">
                                                    <option value="barranco">Barranco</option>
                                                    <option value="miraflores">Miraflores</option>
                                                    <option value="surco">Surco</option>
                                                    <option value="san_borja">San Borja</option>
                                                    <option value="surquillo">Surquillo</option>
                                                    <option value="san_isidro">San Isidro</option>
                                                    <option value="chorrillos">Chorrillos</option>
                                                    <option value="cercado">Cercado</option>
                                                    <option value="san_luis">San Luis</option>
                                                    <option value="brena">Breña</option>
                                                    <option value="la_victoria">La Victoria</option>
                                                    <option value="rimac">Rimac</option>
                                                    <option value="lince">Lince</option>
                                                    <option value="san_miguel">San Miguel</option>
                                                    <option value="jesus_maria">Jesús María</option>
                                                    <option value="magdalena">Magdalena</option>
                                                    <option value="pblo_libre">Pblo. Libre</option>
                                                </optgroup>
                                                <hr>
                                                <optgroup label="Delivery con Recargo">
                                                    <option value="ancon">Ancon</option>
                                                    <option value="ate">Ate</option>
                                                    <option value="carabayllo">Carabayllo</option>
                                                    <option value="chaclacayo">Chaclacayo</option>
                                                    <option value="cieneguilla">Cieneguilla</option>
                                                    <option value="comas">Comas</option>
                                                </optgroup>
                                            </select>
                                        </div>

                                        <div class="form-group col-12">
                                            <label for="direccion">Dirección</label>
                                            <input name="direccion" class="form-control"  v-model="giftDetail.direccion" type="text" :disabled="isDisableAddress">
                                        </div>

                                        <div class="col-12">
                                            <hr class="mb-2">
                                            <p class="text-center mb-0">
                                                <small class="d-flex align-items-center">
                                                <i class="fas fa-truck fa-border fa-3x text-secondary mr-2"></i> Delivery gratuito<br> solo en Lima.
                                                {{ freeDelivery }}
                                                </small>
                                            </p>
                                            <hr class="my-2">
                                        </div>

                                    </div>

                                </template>

                                <template v-else>
                                    <div class="form-row mt-4">

                                        <div class="col-12">
                                            <h6>{{ giftDetail.entrega == 'recojo_tienda' ? 'Recojo en tienda' : 'Delivery' }}</h6>
                                            <p v-if="giftDetail.entrega == 'delivery'">
                                                {{ giftDetail.departamento }} <br>
                                                {{ giftDetail.direccion }} {{ giftDetail.distrito ? '- '+ giftDetail.distrito : ''}}
                                            </p>
                                        </div>
                                        
                                    </div>
                                </template>

                                <button class="btn btn-dark linear" @click="giftDetailUpdate()">Actualizar</button>

                            </div>

                        </div>
                    </div>

                    <div class="tab-pane container active" id="menu_regalos">
                        <div class="row">  
                            <div class="col-12">
                                <!-- BEGIN VUE GIFT CART -->
                                <gift-cart :list="giftDetail" :free-delivery="freeDelivery" @updateDetails="fetchGiftDetail"> </gift-cart>
                                <!-- END VUE GIFT CART -->
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<script>

    import GiftCart from './GiftCart'

    export default {
        props: ['list'],
        data: function() {
            return {
                giftDetail: this.list,
                freeDelivery: null,
                isDisableDepartments: false,
                isDisableDistricts: false,
                isDisableAddress: false,
                file: '',
                imgPreview: ''
            }
        },
        components: {
            GiftCart
        },
        mounted() {
            this.fetchGiftDetail()
            this.deliveryText()
        },
        watch: {
            'giftDetail.entrega': function (newVal, oldVal) {

                if (newVal == 'delivery') 
                {
                    this.isDisableDepartments = false
                    this.isDisableDistricts = false
                    this.isDisableAddress = false

                } else {
                    
                    this.isDisableDepartments = true
                    this.isDisableDistricts = true
                    this.isDisableAddress = true
        
                    this.giftDetail.departamento = null
                    this.giftDetail.direccion = null
                    this.giftDetail.distrito = null
                }
                console.log('metodo de entrega ' + newVal)
            },
            'giftDetail.departamento': function (newVal, oldVal) {
                var vm = this

                // axios.post('/api/district/isfreedelivery', { id: newVal }).then(function (response) {
                //     console.log(response)
                //     console.log(response.data)
                // })
                // .catch(function (error) {
                //     console.log(error)
                // }) 
                // deberia ir toda la logica de paises departamentos  distritos para poder hacer esto.

                if (newVal != 'lima') 
                {
                    vm.isDisableDistricts = true
                    vm.giftDetail.distrito = null
                } else {
                    vm.isDisableDistricts = false
                }
                console.log('Cambio el departamento ' + newVal)
            }
        },
        methods: {
            isInitDisabled() {
                let isInitDisabled = this.giftDetail.entrega === 'delivery' ? false : true
                this.isDisableDepartments = isInitDisabled
                this.isDisableDistricts = isInitDisabled
                this.isDisableAddress = isInitDisabled
                this.imgPreview = this.giftDetail.img ? `/uploads/giftregistry/${this.giftDetail.img}` : '/media/default.jpg'
            },
            deliveryText() {
                var vm = this

                axios.get('/api/free_delivery_text').then(function (response) {
                    vm.freeDelivery = response.data
                })
                .catch(function (error) {
                    console.log(error)
                })
            },
            fetchGiftDetail() {
                var vm = this
                var loader = this.$loading.show({container: vm.$refs.detailsContainer })

                axios.post('/api/giftproduct/detail', { id: vm.giftDetail.id }).then(function (response) {
                    
                    vm.giftDetail = response.data
                    
                    vm.isInitDisabled()

                    vm.$notify({
                        group: 'notifications',
                        type: 'info',
                        title: 'Detalles cargados',
                        text: `Los detalles de la lista  ${ vm.giftDetail.codigo } han sido cargados`
                    })

                    loader.hide()
                })
                .catch(function (error) {
                    console.log(error)
                }) 
            },
            giftDetailUpdate() {

                var vm = this
                var loader = this.$loading.show({container: vm.$refs.departmentContainer });

                axios.post('/api/giftproduct/detail/update', vm.giftDetail ).then(function (response) {

                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Lista actualizada',
                        text: `Los detalles de la lista  ${ vm.giftDetail.codigo } han sido actualizados`
                    })

                    loader.hide()

                    vm.fetchGiftDetail()

                })
                .catch(function (error) {
                    console.log(error)
                }) 
            },
            giftDetailPictureUpdate() {

                var vm = this

                let formData = new FormData();
                formData.append('img', vm.file);
                formData.append('id', vm.giftDetail.id);

                axios.post( '/api/giftproduct/detail/picture/update',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(function() {
                    console.log('SUCCESS!!');
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Lista actualizada',
                        text: `La imagen de la lista:  ${ vm.giftDetail.codigo } ha sido actualizada`
                    })
                })
                .catch(function() {
                    console.log('FAILURE!!');
                });

            },
            handleFileUpload() {
                var vm = this
                vm.file = vm.$refs.file.files[0];
                
                if (vm.file) 
                {
                    var reader = new FileReader()

                    reader.onload = function (e) {
                        vm.imgPreview  = e.target.result
                    }

                    reader.readAsDataURL(vm.file)

                    vm.giftDetailPictureUpdate()
                }
            }
        }
    }
</script>

<style>

</style>

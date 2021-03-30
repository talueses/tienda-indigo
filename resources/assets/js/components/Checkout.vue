<template>

    <div>

        <h4 style="font-size: 18px;">RESUMEN DEL PEDIDO</h4>

        <hr class="mt-3 mb-2">
        <p class="text-center mb-0">
            <small class="d-flex align-items-center">
                <i class="fas fa-truck fa-border fa-3x text-secondary" style=""></i>
                 Delivery gratuito solo en Lima.{{ ' '.free_delivery }}
            </small>
        </p>
        <hr class="my-2">

        <div class="">

            <ul class="list-unstyled p-0 mb-4 text-left">
            <li><span class="mr-2 text-bold">Costo de envío:</span> <span class="float-right" id="costo_envio">{{ shippingPrice ? shippingPrice : '--' }}</span></li>
            <li><span class="mr-2 text-bold text-uppercase">TOTAL:</span> <span id="total_price_order" class="float-right">S/. {{ cartTotal }}</span></li>
            </ul>


            <b>Modo de Entrega</b>
            <hr>

            <div class="form-group mt-2">

                <input type="radio" name="modo_entrega" id="modo_tienda" value="recojo_tienda" v-model="modoEntrega">
                <label for="modo_tienda">Recojo en tienda</label>
                <br>
                <input type="radio" name="modo_entrega" id="modo_delivery" value="delivery" v-model="modoEntrega">
                <label for="modo_delivery">Delivery</label>
                <br>

            </div>


            <b>Solicitud de Factura</b>
            <hr>

            <div class="form-group mt-2">

                <input type="checkbox" name="modo_factura" id="modo_factura"  v-model="solicitudFactura">
                <label for="modo_factura"> Si</label>

            </div>


            <div v-show="solicitudFactura" class="campos-factura">
                <div class="form-group">
                    <label for="ruc" class="col-form-label" id="ruc">RUC</label>
                    <input v-model="ruc" id="ruc" class="form-control" type="text">
                </div>

                <div class="form-group">
                    <label for="razon_social" class="col-form-label" id="rsocial">Razón Social</label>
                    <input v-model="razon_social" id="razon_social" class="form-control" type="text">
                </div>
            </div>

            <div class="form-row" v-show="modoEntrega=='delivery'">

                <div class="form-group col-12">
                    <label class="col-form-lavbel"> <strong>Dirección de Entrega.</strong></label><br>
                    <label for="envio_pais" class="col-form-label">Pais</label>
                    <select v-model="envioPais" id="envio_pais" class="form-control" :disabled="(modoEntrega == 'delivery') ? false : true">
                        <option v-for= "country in countries" :value="country.id" :data-name="country.nombre" >{{ country.nombre }}</option>
                    </select>
                </div>

                <div class="form-group col-12">
                    <label for="envio_departamento" class="col-form-label">Departamento</label>

                    <select v-if="envioPais==1" 
                            v-model="envioDepartamento" 
                            id="envio_departamento" 
                            class="form-control" 
                            :disabled="(modoEntrega == 'delivery' && envioPais == 1) ? false : true">
                    <option v-for= "depto in departments" :value="depto.nombre" :data-id="depto.id"> {{ depto.nombre }}</option>
                    </select>

                    <input  v-if="envioPais!=1"  
                            v-model="envioDepartamento"
                            id="envio_departamento"  
                            type="text" 
                            class="form-control"
                            >

                </div>

                <div class="form-group col-12" >
                    <label for="envio_lima" class="col-form-label">Distrito</label>
                    
                    <select v-if="envioPais==1 && countDist >0"
                            v-model="envioLimaMetropolitana" 
                            id="envio_lima" 
                            class="form-control">
                         <optgroup label="Delivery sin recargo.">
                            <option v-for= "dist in districts"  v-if="dist.is_free===1" :value="dist.nombre|lowercase" >{{ dist.nombre }}</option>
                          </optgroup>
                                <hr>
                          <optgroup label="Delivery con recargo.">
                            <option v-for= "dist in districts"  v-if="dist.is_free===0" :value="dist.nombre|lowercase" >{{ dist.nombre }}</option>
                          </optgroup>
                    </select>

                    <input v-if="envioPais==1 && countDist ==0"
                            v-model="envioLimaMetropolitana" 
                            id="envio_lima" 
                            class="form-control">
    
                    <input v-if="envioPais!=1"
                            v-model="envioLimaMetropolitana" 
                            id="envio_lima" 
                           type="text" 
                            class="form-control" 
                           >

                </div>

                <div class="form-group col-12">
                    <label for="" class="col-form-label">Dirección</label>
                    <input v-model="direccion" id="envio_direccion" class="form-control" type="text" :disabled="modoEntrega == 'delivery' ? false : true">
                </div>

                <div class="alert alert-warning" role="alert" v-if="!belongsLM">
                    Para envíos con recargo, el costo de envío será calculado y luego será notificado a su correo para continuar su compra.
                </div>


                <div id="order_error_message" class="alert alert-danger w-100" role="alert" style="display:none;"></div>

                </div>

                <div v-if="errors.length" class="alert alert-danger" role="alert">
                    <p>
                        <b>Se ha producido un error:</b>
                        <ul class="pl-3">
                            <li v-for="error in errors" v-bind:key="error.id">{{ error.text }}</li>
                        </ul>
                    </p>
                </div>
        </div>

        <input v-model="belongsLM" id="belongsLM" class="form-control" type="text" style="display: none;">
        
        <a v-show="modoEntrega=='recojo_tienda' || belongsLM " @click="checkout" id="btn_checkout" class="continue btn btn-outline-secondary linear w-100 py-2 my-2"><p class="subtitle text-uppercase m-0"><i class="fa fa-shopping-cart mr-2"></i> Comprar</p></a>

        <a v-show="modoEntrega=='delivery'" @click="generarOrden" id="btn_generar_orden" class="continue btn btn-outline-secondary linear w-100 py-2 my-2"><p class="subtitle text-uppercase m-0"><i class="fa fa-shopping-cart mr-2"></i> Generar orden</p></a>

    </div>


</template>

<script>

    import {getCartList, cleanLocalStorage, loading, hideLoading,calcItemsInCart } from './functions'
    Vue.filter('lowercase', function (value) {
        return value.toLowerCase();
    })

    export default {
        props: ['cartSubTotal', 'shippingPrice', 'cartTotal', 'countries'],
        data() {
            return {
                'errors': [],
                'departments':[],
                'districts':[],
                'modoEntrega': localStorage.getItem('modoEntrega') ? localStorage.getItem('modoEntrega') : '',
                'solicitudFactura': localStorage.getItem('modo_factura') ? localStorage.getItem('modo_factura') : false,
                // 'solicitudFactura': false,
                'envioPais': localStorage.getItem('envioPais') ? localStorage.getItem('envioPais') : 1,
                'distrito': localStorage.getItem('envio_departamento') ? localStorage.getItem('envio_departamento') : null,
                // 'distrito': null,
                'envioDepartamento':localStorage.getItem('envio_departamento') ? localStorage.getItem('envio_departamento') : null,
                'envioLimaMetropolitana': null,
                'direccion': '',
                'ruc':  localStorage.getItem('ruc') ? localStorage.getItem('ruc') : null,
                'razon_social':  localStorage.getItem('razon_social') ? localStorage.getItem('razon_social') : null,
                'belongsLM': false,
                'free_delivery':null,
                'idpais':1,
                'departmentId':null,
                'paisName':null,
            }
        },
        watch: {
            direccion: function(val)
            {
                localStorage.setItem('direccion', val);
            },
            ruc: function(val)
            {
                localStorage.setItem('ruc', val);
            },
            razon_social: function(val)
            {
                localStorage.setItem('razon_social', val);
            },
            envioPais: function(val) 
            {
                this.paisName=$("#envio_pais option:selected" ).attr('data-name')
                if(val != 1)
                {
                    this.belongsLM = false
                }
                localStorage.setItem('envioPais', val);
                this.countries;
            },
            modoEntrega: function(val) 
            {
                if (val == 'recojo_tienda') {
                    this.direccion = null;
                    this.envioDepartamento = null;
                    this.envioLimaMetropolitana = null;
                    this.$emit('updateShippingPrice', 0)
                }
                localStorage.setItem('modoEntrega', val);
            },
            belongsLM: function(val) 
            {
            
              if (val) {
                //checkout
                document.getElementById('btn_checkout').style.display = 'inline-block';
                document.getElementById('btn_generar_orden').style.display = 'none';
              } else {
                //order
                document.getElementById('btn_generar_orden').style.display = 'inline-block';
                document.getElementById('btn_checkout').style.display = 'none';
              }
              localStorage.setItem('belongsLM', val);

            },
            envioLimaMetropolitana: function(val) 
            {
                var valtext=this.getBySelectText('envio_departamento').toLowerCase()
                this.belongsToLimaMetropolitana(val);
                localStorage.setItem('envioLimaMetropolitana', val);
                // this.distrito=val
                localStorage.setItem('distrito', valtext);
            },
            envioDepartamento: function(val) 
            {
                this.departmentId=$("#envio_departamento option:selected").attr('data-id')
                this.fetchDistricts()
              if(this.modoEntrega == 'delivery') {
                    this.envioLimaMetropolitana = null
                    if (this.belongsLM) {
                        this.$emit('updateShippingPrice', 'Por confirmar')
                    } else {
                        this.$emit('updateShippingPrice', 0)
                    }
                localStorage.setItem('envioDepartamento', val);
                }
                this.fetchDepartments()
            },
            solicitudFactura: function(val) 
            {
                if (!val) {
                    this.ruc = null;
                    this.razon_social = null;
                }
                localStorage.setItem('solicitudFactura', val);
            }
        },
        computed: {
          countDist () {
            return this.districts && this.districts.length
          }
        },
        methods: {
            getBySelectText(item){
                 var ini=document.getElementById(item);
                 var valText = ini.options[ini.selectedIndex].text;
                 return valText;
            },
            getBySelectValue(item){
                 var ini=document.getElementById(item);
                 var val = ini.options[ini.selectedIndex].value;
                 return val;
            },
            fetchDistricts() {
                var vm = this;
                axios.post('/api/district/list', { id: vm.departmentId }).then(function (response) {
                        var data = response.data
                        vm.districts = data
                })
                .catch(function (error) {
                    console.log(error)
                });
            },
            fetchDepartments() {
                var vm = this;
                axios.post('/api/department/list', { id: vm.idpais }).then(function (response) {
                        var data = response.data
                        vm.departments = data
                }).catch(function (error) {
                    console.log(error)
                });
            },
            belongsToLimaMetropolitana: function(item) {

                var data = {
                  'distrito': item,
                  'iddepartamento': this.departmentId
                };
                var vm = this;

                axios.post('/api/countries/limametropolitana', data).then(function (response) {
                    var data = response.data
                    console.log(data)
                    vm.belongsLM = data.belongs
                })
                .catch(function (error) {
                    //
                });

            },
            checkout: function() {      
                this.errors = [];
                var vm = this
                if(this.modoEntrega=="recojo_tienda"){     
                    console.log('recojo en tienda')                                                                           
                    if (this.solicitudFactura == true) {
                        if (this.ruc == null || this.razon_social == null) {
                            console.log('dd')
                            this.errors.push({id:'solicitudFactura', text:"Se necesita completar ambos campos de RUC y Razon Social."});
                            console.log(this.errors)
                        }
                    }

                    if((this.solicitudFactura ==true && (this.ruc ==null || this.razon_social ==null ))){                                            
                        return
                    }
                }else {         
                        console.log('delivery compra')          
                       if ( !this.envioDepartamento) {
                        this.errors.push({id:'envioDepartamento', text:"Se necesita seleccionar un departamento"});
                        }

                        if ( !this.envioLimaMetropolitana ) {
                            this.errors.push({id:'envioLimaMetropolitana', text:"Se necesita seleccionar un distrito"});
                        }

                        if (!this.direccion) {
                            this.errors.push({id:'direccion', text:"Se necesita ingresar dirección."});
                        }

                        if (this.solicitudFactura == true) {
                            if (this.ruc == null || this.razon_social == null) {
                                this.errors.push({id:'solicitudFactura', text:"Se necesita completar ambos campos de RUC y Razon Social."});
                            }
                        }

                        if(this.solicitudFactura ==true && (this.ruc ==null || this.razon_social ==null )){   
                            console.log('rzocial')                                         
                            return
                        }

                        if(!(this.envioDepartamento.length>0 && this.envioLimaMetropolitana.length>0  && this.direccion.length >0))
                        {                  
                            return
                        }
                }
                var listLocal = getCartList();
                this.$emit('update');
                axios.post('/verifyauthstock', listLocal).then(function (response) {        
                    if (response.data.success) {
                        let total = parseFloat(response.data.data);
                        var grandTotal = parseInt(total * 100);

                        if (grandTotal > 0) {
                            Culqi.settings({
                                title: 'Galeria Indigo',
                                currency: 'PEN',
                                description: 'Orden',
                                amount: grandTotal.toFixed(2)
                            });
    
                            Culqi.open();
                            document.location.href = '#';
                        } else {
                            //show error
                            //$('#cart_order_error').show();
                        }
                    }
                })
                .catch(function (error) {
                    
                    var response = error.response.data
                    if (response.error == 'Unauthenticated') {
                        location.href = '/login';
                    }
                });

            },
            generarOrden: function() {
                this.errors = [];
                var vm = this
                loading()
                var listLocal = getCartList()
                var paisName=this.paisName
                var modoEntrega = this.modoEntrega
                var departamento = this.envioDepartamento
                var distrito= this.envioLimaMetropolitana
                var direccion = this.direccion
                var factura = this.solicitudFactura
                var ruc = this.ruc
                var razon_social = this.razon_social
                var pais = this.envioPais
                var belongsLM = this.belongsLM

                if ( !this.envioDepartamento) {
                    this.errors.push({id:'envioDepartamento', text:"Se necesita seleccionar un departamento"});
                }

                if ( !this.envioLimaMetropolitana ) {
                    this.errors.push({id:'envioLimaMetropolitana', text:"Se necesita seleccionar un distrito"});
                }

                if (!this.direccion) {
                    this.errors.push({id:'direccion', text:"Se necesita ingresar dirección."});
                }

                if (this.solicitudFactura == true) {
                  if (this.ruc == null || this.razon_social == null) {
                      this.errors.push({id:'solicitudFactura', text:"Se necesita completar ambos campos de RUC y Razon Social."});
                  }
                }

                if((!this.envioDepartamento 
                    && !this.envioLimaMetropolitana 
                    && !this.direccion) 
                    && (this.solicitudFactura ==true 
                    &&(this.ruc ==null || this.razon_social ==null ))
                ){                    
                    hideLoading()
                    return
                }

                var order = {
                    "list": listLocal,
                    modoEntrega,
                    "paisId": pais,
                    "paisName":paisName,
                    departamento,
                    direccion,
                    distrito,
                    "modoFactura": factura,
                    ruc,
                    "razonSocial": razon_social,
                    "freeDelivery": belongsLM
                }
                console.log(order)
                axios.post('/generateorder', order).then(function (response) {
        
                if(response.data.success) {
                        cleanLocalStorage()
                        calcItemsInCart()
                        document.getElementById('main_orden').innerHTML = '';
                        document.location.href = '#';
                        document.getElementById('success_form').style.display = "inline-block";
                        document.getElementById('success_form_non_free_delivery').style.display = "inline-block";
                    }
                    hideLoading();
                })
                .catch(function (error) {
                    console.log(error)
                    hideLoading();
                    var response = error.response.data
                    if (response.error == 'Unauthenticated') {
                        location.href = '/login';
                    }
                });

            }
        },
        mounted() {
            var vm = this            
            // $('#envio_pais').append('<option selected="selected" value="-1">- Selecciona -</option>').find('option:not(:first)').remove()
            $('#envio_pais').find('option').remove().end()
            this.fetchDepartments()
            axios.get('api/free_delivery_text').then(function (response) {
                vm.free_delivery = response.data
                localStorage.setItem('free_delivery', response.data);
                document.getElementById('success_form_free_delivery_text').innerHTML = response.data
            })
            .catch(function (error) {
                console.log(error)
            });
        }
    }
</script>

<style>

</style>

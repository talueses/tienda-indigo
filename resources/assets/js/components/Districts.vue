<template>

     <div class="row" ref="districtContainer">

        <div class="col-md-12">
            
            <div class="form-group col-12" v-if="showDistrictAdd"><!-- BEGIN DISTRICT ADD -->

                <label for="nonbre" class="col-form-label"> Nombre <span class="requerido">*</span></label>
                <div>
                    <input v-model="districtName" class="form-control" name="nombre" type="text" @keyup.enter="districtAdd()">
                </div>
                <label class="col-form-label ml-4">
                    <input type="checkbox" class="form-check-input mt-1" v-model="districtFree">Envio gratis ?
                </label>

                <ul class="nav nav-pills float-right">
                    <li>
                        <a class="btn btn btn-outline-dark mr-2 mt-2" @click="toggleDistrictAdd()">Cancelar</a>
                    </li>
                    <li>
                        <a class="btn btn-outline-primary mr-2 mt-2" @click="districtAdd()"> Agregar </a>
                    </li>
                </ul>
                
            </div><!-- END DISTRICT ADD -->

            <div class="form-group col-12" v-if="showDistrictUpdate && district"><!-- BEGIN DISTRICT UPDATE -->

                <label for="nonbre" class="col-form-label"> Nombre <span class="requerido">*</span></label>
                <div>
                    <input v-model="district.nombre" class="form-control" name="nombre" type="text" @keyup.enter="districtUpdate()">
                </div>
                <label class="col-form-label ml-4">
                    <input type="checkbox" class="form-check-input mt-1" v-model="district.is_free">Envio gratis ?
                </label>

                <ul class="nav nav-pills float-right">
                    <li>
                        <a class="btn btn btn-outline-dark mr-2 mt-2" @click="toggleDistrictUpdate()">Cancelar</a>
                    </li>
                    <li>
                        <a class="btn btn-outline-primary mr-2 mt-2" @click="districtUpdate()"> Actualizar </a>
                    </li>
                </ul>
                
            </div><!-- END DISTRICT UPDATE -->

        </div>

        <div class="col-md-12">
            <div class="form-group col-12">
                <label for="distritos" class="col-form-label"> Distritos </label>
                <ul class="list-group">
                    <li class="list-group-item" v-if="departmentId === null"> Seleccione un departamento para ver los distritos </li>
                    <li class="list-group-item" v-if="!showDistrictAdd && departmentId != null" v-on:click="toggleDistrictAdd()"> Agregar un nuevo distrito <span class="cart_quantity_delete float-right"> <i class="far fa-plus-square text-info"></i></span> </li>
                    <li v-for="(item, index) in districts"
                        :class="{ 'list-group-item active': activeIndex === index, 'list-group-item' : activeIndex != index}" :key="item.id"
                        @click="onChangeDistrict(item, index)">
                        {{ item.nombre }} 
                        <span v-on:click="districtRemove(index, item, $event)" class="cart_quantity_delete float-right ml-2"> <i class="fas fa-trash-alt text-danger"></i></span>
                        <span v-on:click="toggleDistrictUpdate(index, item, $event)" class="cart_quantity_delete float-right mr-2"> <i class="far fa-edit text-info"></i></span>
                    </li>
                </ul>
            </div>
        </div>

    </div>

</template>

<script>

    export default {
        props: [
            'departmentId'
        ],
        data() {
            return {
                districts: [],
                activeIndex: undefined,
                showDistrictAdd: false,
                showDistrictUpdate: false,
                districtName: null,
                districtFree: false,
                district: null
            }
        },
        watch: {
            departmentId: function(val) {
                this.fetchDistricts()
                this.showDistrictAdd = false
                if(this.district) 
                {
                    if(this.district.departamento_id != val) 
                    {
                        this.showDistrictUpdate = false
                    }

                }
            },
            showDistrictAdd: function(val) {
                if(val) 
                {
                    this.showDistrictUpdate = false
                }
            },
            showDistrictUpdate: function(val) {
                if(val) 
                {
                    this.showDistrictAdd = false
                }
            }
        },
        mounted() {
            if(this.departmentId) {
                this.fetchDistricts()
            }  
        },
        methods: {
            fetchDistricts() {
                var vm = this;
                var loader = this.$loading.show({container: vm.$refs.districtContainer });

                axios.post('/api/district/list', { id: vm.departmentId }).then(function (response) {
                        var data = response.data
                        vm.districts = data

                        vm.$notify({
                            group: 'notifications',
                            type: 'info',
                            title: 'Lista de distritos',
                            text: `Se han cargado total de ${ data.length } distritos para este departamento`
                        })

                        loader.hide()
                })
                .catch(function (error) {
                    console.log(error)
                });
            },
            onChangeDistrict(item, index) {
                this.activeIndex = index
                this.district = item
            },
            toggleDistrictAdd() {
                this.showDistrictAdd = this.showDistrictAdd ? false : true
            },
            toggleDistrictUpdate(index, item, $event) {
                this.showDistrictUpdate = this.showDistrictUpdate ? false : true
                this.district = this.showDistrictUpdate ? item : null
            },
            districtAdd() {
                var vm = this
                var loader = this.$loading.show({container: vm.$refs.districtContainer });

                let request = {
                    departamento_id: vm.departmentId,
                    is_free: vm.districtFree,
                    nombre : vm.districtName
                }

                axios.post('/api/district/create', request).then(function (response) {
 
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Se ha agregado un nuevo distrito',
                        text: vm.districtName
                    })

                    loader.hide()

                    vm.toggleDistrictAdd()

                    vm.fetchDistricts()
                })
                .catch(function (error) {
                    console.log(error)
                    vm.$notify({
                        group: 'notifications',
                        type: 'danger',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al agregar este departamento ' + vm.districtName
                    })
                })
            },
            districtUpdate() {
                var vm = this
                var loader = this.$loading.show({container: vm.$refs.districtContainer });

                let request = {
                    id: vm.district.id,
                    is_free: vm.district.is_free,
                    nombre : vm.district.nombre
                }

                axios.post('/api/district/update', request).then(function (response) {
 
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Se ha actalizado el distrito',
                        text: vm.district.nombre
                    })

                    loader.hide()

                })
                .catch(function (error) {
                    console.log(error)
                    vm.$notify({
                        group: 'notifications',
                        type: 'danger',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al agregar este departamento ' + vm.district.nombre
                    })
                })
            },
            districtRemove(index, item, $event) {
                var vm = this
                var loader = this.$loading.show({container: vm.$refs.districtContainer });

                axios.post('/api/district/delete', { id: item.id }).then(function (response) {
 
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Se ha eliminado el distrito',
                        text: item.nombre
                    })

                    loader.hide()

                    vm.fetchDistricts()

                })
                .catch(function (error) {
                    console.log(error)
                    vm.$notify({
                        group: 'notifications',
                        type: 'danger',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al eliminar este distrito ' + vm.item.nombre
                    })
                })
            }
        }
    }
</script>

<style>
li:hover {
    cursor: pointer;
}
.btn-primary {
    color: white !important;
}
</style>

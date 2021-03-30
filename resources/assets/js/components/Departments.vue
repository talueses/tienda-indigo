<template>

    <div class="row" ref="departmentContainer">

        <div class="col-md-12">

            <div class="form-group col-12" v-if="showDepartmentAdd"><!-- BEGIN DEPARTMENT ADD -->

                <label for="nonbre" class="col-form-label">Nombre <span class="requerido">*</span></label>
                <div>
                    <input v-model="departmentName" class="form-control" name="nombre" type="text" @keyup.enter="departmentAdd()">
                </div>

                <ul class="nav nav-pills float-right">
                    <li>
                        <a class="btn btn btn-outline-dark mr-2 mt-2" @click="toggleDepartmentAdd()"> Cancelar </a>
                    </li>
                    <li>
                        <a class="btn btn-outline-primary mr-2 mt-2" @click="departmentAdd()"> Agregar </a>
                    </li>
                </ul>
                
            </div><!-- END DEPARTMENT ADD -->

            <div class="form-group col-12" v-if="showDepartmentUpdate && department"><!-- BEGIN DEPARTMENT UPDATE -->

                <label for="nonbre" class="col-form-label">Nombre <span class="requerido">*</span></label>
                <div>
                    <input v-model="department.nombre" class="form-control" name="nombre" type="text" @keyup.enter="departmentUpdate()">
                </div>

                <ul class="nav nav-pills float-right">
                    <li>
                        <a class="btn btn btn-outline-dark mr-2 mt-2" @click="toggleDepartmentUpdate()"> Cancelar </a>
                    </li>
                    <li>
                        <a class="btn btn-outline-primary mr-2 mt-2" @click="departmentUpdate()"> Actualizar </a>
                    </li>
                </ul>
                
            </div><!-- END DEPARTMENT UPDATE -->
        </div>

        <div class="col-md-12">
            <div class="form-group col-12">
                <label for="departamentos" class="col-form-label"> Departamentos </label>
                <ul class="list-group">
                    <li class="list-group-item" v-if="!showDepartmentAdd" @click="toggleDepartmentAdd()"> Agregar un nuevo departamento <span class="cart_quantity_delete float-right"> <i class="far fa-plus-square text-info"></i></span> </li>
                    <li v-for="(item, index) in departments"
                        :class="{ 'list-group-item active': activeIndex === index, 'list-group-item' : activeIndex != index}" :key="item.id"
                        @click="onChangeDepartment(item, index)">
                        {{ item.nombre }}
                        <span @click="departmentRemove(index, item, $event)" class="cart_quantity_delete float-right ml-2"> <i class="fas fa-trash-alt text-danger"></i></span>
                        <span @click="toggleDepartmentUpdate(index, item, $event)" class="cart_quantity_delete float-right mr-2"> <i class="far fa-edit text-info"></i></span> 
                    </li>
                </ul>
            </div>
        </div>

    </div>

</template>

<script>

    export default {
        props: [
            'countryId'
        ],
        data() {
            return {
                departments: [],
                activeIndex: undefined,
                showDepartmentAdd: false,
                showDepartmentUpdate: false,
                departmentName: null,
                department: null
            }
        },
        watch: {
            department: function(val) {
                this.showDepartmentAdd = false
            },
            showDepartmentAdd: function(val) {
                if(val) 
                {
                    this.showDepartmentUpdate = false
                }
            },
            showDepartmentUpdate: function(val) {
                if(val) 
                {
                    this.showDepartmentAdd = false
                }
            }
        },
        mounted() {
            this.fetchDepartments()
        },
        methods: {
            fetchDepartments() {
                var vm = this;
                var loader = this.$loading.show({container: vm.$refs.departmentContainer });
                
                axios.post('/api/department/list', { id: vm.countryId }).then(function (response) {
                        var data = response.data
                        vm.departments = data

                        vm.$notify({
                            group: 'notifications',
                            type: 'info',
                            title: 'Lista de departamento',
                            text: `Se han cargado total de ${ data.length } departamentos para este pais`
                        })

                        loader.hide()                        
                })
                .catch(function (error) {
                    console.log(error)
                });
    
            },
            onChangeDepartment(item, index) {
                this.$emit('updateDepartment', item.id)
                this.activeIndex = index
                this.department = item
            },
            toggleDepartmentAdd() {
                this.showDepartmentAdd = this.showDepartmentAdd ? false : true
                this.showDepartmentUpdate = false
            },
            toggleDepartmentUpdate(index, item, $event) {
                this.showDepartmentUpdate = this.showDepartmentUpdate ? false : true
                this.showDepartmentAdd = false
                this.department = this.showDepartmentUpdate ? item : null
            },
            departmentAdd() {
                var vm = this;
                var loader = this.$loading.show({container: vm.$refs.departmentContainer });

                let request = {
                    pais_id: vm.countryId,
                    nombre : vm.departmentName
                }

                axios.post('/api/department/create', request).then(function (response) {
 
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Se ha agregado un nuevo departamento',
                        text: vm.departmentName
                    })
                    
                    loader.hide()

                    vm.toggleDepartmentAdd()

                    vm.fetchDepartments()
                })
                .catch(function (error) {
                    console.log(error)
                    vm.$notify({
                        group: 'notifications',
                        type: 'danger',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al agregar este departamento ' + vm.departmentName
                    })
                })
            },
            departmentUpdate() {
                var vm = this;
                var loader = this.$loading.show({container: vm.$refs.departmentContainer });

                let request = {
                    id: vm.department.id,
                    nombre : vm.department.nombre
                }
                
                axios.post('/api/department/update', request).then(function (response) {
 
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Se ha actalizado el departamento',
                        text: vm.department.nombre
                    })

                    loader.hide()

                })
                .catch(function (error) {
                    console.log(error)
                    vm.$notify({
                        group: 'notifications',
                        type: 'danger',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al agregar este departamento ' + vm.department.nombre
                    })
                })
            },
            departmentRemove(index, item, $event) {
                var vm = this
                var loader = this.$loading.show({container: vm.$refs.departmentContainer });
                
                axios.post('/api/department/delete', { id: item.id }).then(function (response) {
 
                    vm.$notify({
                        group: 'notifications',
                        type: 'success',
                        title: 'Se ha eliminado el departamento',
                        text: item.nombre
                    })
                    
                    loader.hide()

                    vm.fetchDepartments()

                })
                .catch(function (error) {
                    console.log(error)
                    vm.$notify({
                        group: 'notifications',
                        type: 'danger',
                        title: 'ERROR',
                        text: 'Ha ocurrido un error al eliminar este departamento ' + item.nombre
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

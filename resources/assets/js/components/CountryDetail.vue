<template>

    <div class="row">
        <!-- BEGIN NOTIFICATION -->
        <notifications group="notifications" position="bottom right"/>
        <!-- END NOTIFICATION -->
        <div class="col-md-6">
            <departments :country-id="countryId" @updateDepartment="onDepartmentChange"></departments>
        </div>

        <div class="col-md-6">
            <districts :department-id="departmentId"></districts>
        </div>
    </div>

</template>

<script>

    import Departments from './Departments'
    import Districts from './Districts'

    export default {
        props: [ 
            'countryId'
        ],
        data() {
            return {
                departmentId: null
            }
        },
        components: {
            Departments, Districts
        },
        methods: {
            onDepartmentChange(id) {
                this.departmentId = id
            }
        }
    }
</script>

<style>

</style>

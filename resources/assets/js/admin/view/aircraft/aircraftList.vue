<template>
    <div class="card card-table">
        <div class="card-header">
            Aircraft List
        </div>
        <div class="card-body">
            <data-table
                    :search="true"
                    :columns="columns"
                    :tableHeadline="'Aircraft'"
                    :ajax="{
                            url: '/admin/aircraft/category'
                        }"
            >
                <template slot="items" slot-scope="props">
                    <td>{{props.data.id}}</td>
                    <td>
                        <router-link :to="{name:'adminAircraftCategoryShow', params:{id:props.data.id}}">
                            {{props.data.name}}
                        </router-link>
                    </td>
                </template>
            </data-table>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                columns: [
                    {name: 'Id', field: 'id'},
                    {name: 'Name', field: 'name'}
                ]
            }
        },

    }
</script>
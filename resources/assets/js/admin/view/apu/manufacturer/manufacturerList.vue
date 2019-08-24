<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminApuManufacturerCreate'"
                :tableHeadline="'APU Manufacturers'"
                :searchField="'categories.name,manufacturers.name'"
                :modelName="'manufacturer'"
                :typeName="'apu'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminApuManufacturerShow', params:{id:props.data.id}}">
                        {{props.data.name}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminAircraftManufacturerShow', params:{id:props.data.id}}">
                        {{props.data.category_name}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch"  v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Manufacturer')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                   <div class="adjustAction">
                       <router-link :to="{name:'adminApuManufacturerEdit', params:{id:props.data.id}}" v-if="$root.$data.editPermission">
                           <i class="mdi mdi-edit"></i>
                       </router-link>
                   
                       <a @click.prevent="deleteMe(props.data.id)" href="" v-if="$root.$data.deletePermission">
                           <i class="mdi mdi-delete"></i>
                       </a>
                   </div>
                </td>
            </template>
        </data-table-join>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                status:null,
                url:'/manufacturer?type=apu',
                columns: [
                    {name: 'Name'},
                    {name: 'Category', nested:'categories.name'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/manufacturer/' + id).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            }
        }

    }
</script>

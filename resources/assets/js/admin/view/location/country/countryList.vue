<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminCountryCreate'"
                :tableHeadline="'Countries'"
                :searchField="'countries.name,continents.name,regions.name'"
                :modelName="'country'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminCountryShow', params:{id:props.data.id}}">
                        {{props.data.name}}
                    </router-link>

                </td>
                <td>
                    <router-link :to="{name:'adminCountryShow', params:{id:props.data.id}}">
                        {{props.data.continent_name}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminCountryShow', params:{id:props.data.id}}">
                        {{props.data.region_name}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch"  v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Country')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'adminCountryEdit', params:{id:props.data.id}}" v-if="$root.$data.editPermission">
                            <i class="mdi mdi-edit"></i>
                        </router-link>
                       
                        <a @click.prevent="deleteMe(props.data.id)" href=" " v-if="$root.$data.deletePermission">
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
                url: '/location/country',
                columns: [
                    {name: 'Name'},
                    {name: 'Continent', nested:'continents.name'},
                    {name: 'Region', nested:'regions.name'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods: {
            changeIsActive(data, e){
                this.$root.confirmationStatus().then(val => {
                    if (val) {
                        let url='location/country'
                        this.$root.isActive(data,e,url)
                        data.is_active==1?e.target.checked=0:e.target.checked=1;
                    }
                });
            },
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/location/country/' + id).then(response => {
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

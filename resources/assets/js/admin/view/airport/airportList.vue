<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminAirportCreate'"
                :tableHeadline="'Airports'"
                :searchField="'airports.name,airports.iata_code,airports.icao_code,cities.name,countries.name'"
                :modelName="'airport'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminAirportShow', params:{id:props.data.id}}">
                        {{props.data.name}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminAirportShow', params:{id:props.data.id}}">
                        {{props.data.city_name}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminAirportShow', params:{id:props.data.id}}">
                        {{props.data.country_name}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminAirportShow', params:{id:props.data.id}}">
                        {{props.data.iata_code}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminAirportShow', params:{id:props.data.id}}">
                        {{props.data.icao_code}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Airport')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'adminAirportEdit', params:{id:props.data.id}}"v-if="$root.$data.editPermission">
                            <i class="mdi mdi-edit"></i>
                        </router-link>
                        
                        <a @click.prevent="deleteMe(props.data.id)" href="#" v-if="$root.$data.deletePermission">
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
                url:'/airport',
                columns: [
                    {name: 'Name'},
                    {name: 'City',nested:'cities.name'},
                    {name: 'Country',nested:'countries.name'},
                    {name: 'IATA', nested:'iata_code'},
                    {name: 'ICAO', nested:'icao_code'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/airport/' + id).then(response => {
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

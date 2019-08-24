<template>
    <div class="card card-table custom-title-adjust">
        <data-table-user
                ref="dataTable"
                :addLink="'userApuCreate'"
                :search="true"
                :columns="columns"
                :searchField="'apus.title,apus.serial_number,apus.isActiveStatus'"
                :tableHeadline="'APU\'s'"
                :userAddButton="true"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <router-link :to="{name:'userApuShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.title.replace(/-/g, ' ')}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userApuShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.serial_number}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userApuShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.views}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                type="checkbox"
                                :checked="props.data.is_featured"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_featured', 'App-Apu')"

                        >
                        <span>
                            <label :for="props.data.id"></label>
                        </span>
                    </div>
                </td>

                <td>
                    <router-link
                            :class="props.data.isActiveStatus=='Pending Approval'?'text-dark-orange':
                            props.data.isActiveStatus=='Approved'?'text-success':
                            props.data.isActiveStatus=='Rejected'?'text-danger':null"

                            :to="{name:'userApuShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{ props.data.isActiveStatus}}
                    </router-link>
                </td>


                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                type="checkbox"
                                :checked="props.data.is_active_by_user"
                                name="swt2"
                                :id="props.data.id+1"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active_by_user', 'App-Apu')"
                        >
                        <span>
                            <label :for="props.data.id+1"></label>
                        </span>
                    </div>
                </td>

                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'userApuEdit', params:{id:props.data.id+'-'+props.data.title}}">
                            <i class="mdi mdi-edit"></i>
                        </router-link>

                        <a @click.prevent="deleteMe(props.data.id)" href="#">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </div>
                </td>
            </template>
        </data-table-user>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                auth:{},
                url:'/ajax/apu?fromSection=user',
                columns: [
                    {name: 'Title'},
                    {name: 'SN', nested:'apus.serial_number'},
                    {name: 'Views'},
                    {name: 'Promote Status', nested:'apus.is_featured'},
                    {name: 'Publish Status', nested:'apus.isActiveStatus'},
                    {name: 'Status', nested:'apus.is_active_by_user'},
                    {name: 'Action'}
                ],

            }
        },

        created(){


        },

        methods:{

            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/apu/' + id).then(response => {
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
<style scoped>
    .text-dark-orange{
        color:#ff9615;
    }
</style>

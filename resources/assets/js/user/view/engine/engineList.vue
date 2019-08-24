<template>
    <div class="card card-table custom-title-adjust">
        <data-table-user
                ref="dataTable"
                :addLink="'userEngineCreate'"
                :search="true"
                :columns="columns"
                :searchField="'engines.title,engines.esn,engines.isActiveStatus'"
                :tableHeadline="'Engines'"
                :userAddButton="true"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <router-link :to="{name:'userEngineShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.title.replace(/-/g, ' ')}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userEngineShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.esn}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userEngineShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.views}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                :checked="props.data.is_featured"
                                :id="props.data.id"
                                type="checkbox"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_featured', 'App-Engine')"
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

                            :to="{name:'userEngineShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{ props.data.isActiveStatus}}
                    </router-link>
                </td>

                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                type="checkbox"
                                :checked="props.data.is_active_by_user"
                                :id="props.data.id+1"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active_by_user', 'App-Engine')"
                        >
                        <span>
                            <label :for="props.data.id+1"></label>
                        </span>
                    </div>
                </td>

                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'userEngineEdit', params:{id:props.data.id+'-'+props.data.title}}">
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
                url:'/ajax/engine?fromSection=user',
                columns: [
                    {name: 'Title'},
                    {name: 'ESN'},
                    {name: 'Views'},
                    {name: 'Promote Status', nested:'engines.is_featured'},
                    {name: 'Publish Status', nested:'apus.isActiveStatus'},
                    {name: 'Status', nested:'engines.is_active_by_user'},
                    {name: 'Action'}
                ],
                switchTwo:null,
                switchOne:null,

            }
        },

        created(){


        },

        methods:{

            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/engine/' + id).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },

        }

    }
</script>
<style scoped>
    .text-dark-orange{
        color:#ff9615;
    }
</style>

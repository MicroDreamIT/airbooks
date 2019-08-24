<template>
    <div class="card card-table">
        <data-table
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminSubscriberCreate'"
                :tableHeadline="'Subscribers'"
                :searchField="'name,email'"
                :modelName="'subscriber'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminSubscriberShow', params:{id:props.data.id}}">
                        {{props.data.name}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'adminSubscriberShow', params:{id:props.data.id}}">
                        {{props.data.email}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Subscriber')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                    <router-link :to="{name:'adminSubscriberEdit', params:{id:props.data.id}}"v-if="$root.$data.editPermission">
                        <i class="mdi mdi-edit"></i>
                    </router-link>

                    <a @click.prevent="deleteMe(props.data.id)" href="#" v-if="$root.$data.deletePermission">
                        <i class="mdi mdi-delete"></i>
                    </a>
                </td>
            </template>
        </data-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                url:'/setting/subscriber',
                columns: [
                    {name: 'Name'},
                    {name: 'Email'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/setting/subscriber/' + id).then(response => {
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

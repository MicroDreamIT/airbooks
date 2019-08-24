<template>
    <div class="card card-table">
        <data-table
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminCannedEmailCreate'"
                :tableHeadline="'Canned Email'"
                :searchField="'message_type,subject'"
                :modelName="'cannedemail'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminCannedEmailShow', params:{id:props.data.id}}">
                        {{props.data.message_type}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminCannedEmailShow', params:{id:props.data.id}}">
                        {{props.data.subject}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Cannedemail')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                   <div class="adjustAction">
                       <router-link :to="{name:'adminCannedEmailEdit', params:{id:props.data.id}}"v-if="$root.$data.editPermission">
                           <i class="mdi mdi-edit"></i>
                       </router-link>
                     
                       <a @click.prevent="deleteMe(props.data.id)" href="" v-if="$root.$data.deletePermission">
                           <i class="mdi mdi-delete"></i>
                       </a>
                   </div>
                </td>
            </template>
        </data-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                url:'/canned-email',
                columns: [
                    {name: 'Message Type'},
                    {name: 'Subject'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/canned-email/' + id).then(response => {
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

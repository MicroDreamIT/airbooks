<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :addLink="'adminContactsCreate'"
                :search="true"
                :columns="columns"
                :tableHeadline="'Contacts'"
                :searchField="'first_name'"
                :modelName="'contact'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminContactsShow', params:{id:props.data.id}}">
                        {{props.data.first_name+' '+props.data.last_name}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'adminContactsShow', params:{id:props.data.id}}">
                        {{props.data.job_title?props.data.job_title.name:null}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'adminContactsShow', params:{id:props.data.id}}">
                        {{props.data.company?props.data.company.name:null}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_published"
                                :name="props.data.id"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_published', 'App-Contact')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>

                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'adminContactsEdit', params:{id:props.data.id}}" v-if="$root.$data.editPermission">
                            <i class="mdi mdi-edit"></i>
                        </router-link>
                       
                        <a @click.prevent="deleteMe(props.data.id)" href=" " v-if="$root.$data.deletePermission && $root.$data.user.contact.id!=props.data.id">
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
                url:'/contacts',
                columns: [
                    {name: 'Name', nested:'first_name'},
                    {name:'Job Title'},
                    {name: 'Company',nested:'companies.name'},
                    {name: 'Status',nested:'is_published'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{

            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/contacts/' + id).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage({type:'danger', message:'Contacts has been deleted successfully'})
                        })
                    }
                })
            }
        }

    }
</script>

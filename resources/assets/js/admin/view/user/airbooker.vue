<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addButton="false"
                :tableHeadline="'Airbookers'"
                :searchField="'contacts.first_name,contacts.last_name'"
                :modelName="'user'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                   {{props.data.contact.first_name+' '+props.data.contact.last_name}}
                </td>
                <td>
                    {{props.data.email}}
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="changeIsBooleanStatus(props.data, 'is_active', 'App-User')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                    <div class="adjustAction">
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
                status: null,
                url: '/admin/airbooker',
                columns: [
                    {name: 'Name',nested:'contacts.first_name'},
                    {name: 'Email'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods: {
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/admin-user/' + id).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },
            changeIsBooleanStatus(data, field, model){
                this.$root.confirmationStatus().then(val => {
                    if (val) {

                        axios.patch('/admin/ajax/' + field +'/'+ model +'/'  + data.id+'/edit/by-admin', {
                            status: data[field] == 1 ? 0 : 1
                        }).then(response=>{
                            data[field] = data[field] == 1 ? 0 : 1
                            this.$root.successMessage(response.data)
                        }).catch(error=>{

                        })
                    }
                })

            },
        }

    }
</script>

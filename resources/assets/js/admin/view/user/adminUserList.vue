<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminUserCreate'"
                :tableHeadline="'Admin Users'"
                :searchField="'name'"
                :modelName="'user'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td class="own-capitalize">

                        {{props.data.first_name+ ' '+props.data.last_name}}
                </td>
                <td class="own-capitalize">
                        {{props.data.role_name}}
                </td>
                <td class="own-capitalize">
                        {{props.data.permission_name}}
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" v-if="$root.$data.editPermission">
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-User')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'adminUserEdit', params:{id:props.data.id}}"v-if="$root.$data.editPermission">
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
                url:'/admin/admin-user',
                columns: [
                    {name: 'Name',nested:'contacts.first_name'},
                    {name: 'Role',nested:'roles.name'},
                    {name: 'Permission',nested:'permissions.name'},
                    {name: 'Status'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{
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
            }
        }

    }
</script>

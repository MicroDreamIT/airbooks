<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminRolePermissionCreate'"
                :tableHeadline="'Roles & Permissions'"
                :searchField="'name'"
                :addButton="false"
                :modelName="'roled'"
                :ajax="{
                        url: url
                    }"
        >
            <template slot="items" slot-scope="props">
                <td class="own-capitalize">
                        <template v-if="props.data.first_name">
                            {{props.data.first_name+' '+props.data.last_name }}
                        </template>
                </td>
                <td class="own-capitalize">
                        Sub-Admin
                </td>
                <td class="own-capitalize">
                        {{props.data.permission_name}}
                </td>
                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'adminRolePermissionEdit', params:{id:props.data.id}}" v-if="$root.$data.editPermission">
                            <i class="mdi mdi-edit"></i>
                        </router-link>
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
                url: '/role-permission',
                columns: [
                    {name: 'User Name',nested:'contacts.first_name'},
                    {name: 'Role'},
                    {name: 'Permissions',nested:'permissions.name'},
                    {name: 'Action'},
                ]
            }
        },

        methods: {

        }

    }
</script>

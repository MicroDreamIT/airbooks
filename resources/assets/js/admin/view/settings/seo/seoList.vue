<template>
    <div class="card card-table">
        <data-table
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addLink="'adminSeoCreate'"
                :tableHeadline="'Seo'"
                :searchField="'title'"
                :modelName="'seo'"
                :ajax="{
                        url: url
                    }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    {{props.data.model_type}}
                </td>
                <td >
                    {{props.data.title}}
                </td>
                <td>
                    {{props.data.description}}
                </td>
                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'adminSeoEdit', params:{id:props.data.id}}" v-if="$root.$data.editPermission">
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
                url: '/admin/setting/seo',
                columns: [
                    {name: 'Model Type'},
                    {name: 'Title'},
                    {name: 'Description'},
                    {name: 'Action'}
                ]
            }
        },

        methods: {

            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/setting/seo/' + id).then(response => {
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

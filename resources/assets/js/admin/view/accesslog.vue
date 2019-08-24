<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addButton="false"
                :tableHeadline="'Access log'"
                :searchField="'user'"
                :modelName="'accesslog'"
                :ajax="{
                        url: url
                    }"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <template>
                        {{ props.data.id }}
                    </template>
                </td>

                <td>
                    <template>
                        {{ props.data.first_name + ' ' + props.data.last_name }}
                    </template>

                </td>

                <td>
                    <div v-if="props.data.payload">
                    {{ props.data.payload.REMOTE_ADDR}}
                    </div>
                </td>
                <td>
                    <div v-if="props.data.payload">
                        {{ props.data.payload.REQUEST_METHOD}}
                    </div>
                </td>
                <td>
                    {{props.data.created_at | moment("DD/MM/YY, h:mm:ss a") }}
                </td>
            </template>
        </data-table-join>
    </div>
</template>

<script>
    export default {
        name: "adminAccesslogs",
        data() {
            return {
                url: 'ajax/accesslogs',
                columns: [
                    {name: 'User ID',nested:'id'},
                    {name: 'Name', nested:'first_name'},
                    {name: 'IP Address',nested:'accesslogs.payload'},
                    {name: 'Method',nested:'accesslogs.payload'},
                    {name:'Date',nested:'created_at'}
                ]
            }
        },
    }
</script>

<style scoped>

</style>
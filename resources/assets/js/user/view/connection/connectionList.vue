<template>
    <div class="card card-table">
        <data-table-user
                ref="dataTable"
                :search="true"
                :columns="columns"
                :tableHeadline="'Connection'"
                :searchField="'contacts.first_name'"
                :addButton="false"

                :ajax="{
                        url: url
                    }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <a href="" @click.prevent="goToContact(props.data.contact)" class="own-underline">
                        {{props.data.contact?props.data.contact.first_name+' '+props.data.contact.last_name:null}}
                    </a>
                </td>
                <td>
                    <div class="adjustAction">
                        <a @click.prevent="deleteMe(props.data.contact)" href="">
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
                url: '/ajax/connection',
                columns: [
                    {name: 'Name',nested:'first_name'},
                    {name: 'Action'},
                ]
            }
        },

        methods: {

            deleteMe(data) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/connection/' + data.id,{
                            data:data,
                        }).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },
            goToContact(data){
                window.open('/'+data.modelType+'/'+data.linkify, '_blank')
            }

        }

    }
</script>

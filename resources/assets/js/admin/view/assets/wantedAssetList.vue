<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addButton="false"
                :tableHeadline="'Wanted Assets'"
                :searchField="'wanteds.title,wanteds.terms'"
                :modelName="'wanted'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminWantedShow', params:{id:props.data.id}}">
                        {{props.data.title|filterTitle}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminWantedShow', params:{id:props.data.id}}">
                        {{props.data.type}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'adminWantedShow', params:{id:props.data.id}}">
                        {{props.data.terms}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Manufacturer')"
                        >
                        <span><label :for="props.data.id"></label></span>
                    </div>
                </td>
                <td>
                    <a @click.prevent="deleteMe(props.data.id)" href="" v-if="$root.$data.deletePermission">
                        <i class="mdi mdi-delete"></i>
                    </a>

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
                url: '/ajax/wanted',
                columns: [
                    {name: 'Title'},
                    {name: 'Wanted Term', nested:'wanteds.terms'},
                    {name: 'Status'},
                    {name: 'Action'}

                ]
            }
        },
        methods:{
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/wanted/' + id).then(response => {
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

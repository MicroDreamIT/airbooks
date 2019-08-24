<template>
    <div class="card card-table custom-title-adjust">
        <data-table-user
                ref="dataTable"
                :addLink="'userPartsCreate'"
                :search="true"
                :columns="columns"
                :searchField="'parts.title,parts.parts.part_number,parts.alternate_part_number,parts.isActiveStatus'"
                :tableHeadline="'Parts'"
                :userAddButton="true"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <router-link :to="{name:'userPartsShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.title.replace(/-/g, ' ')}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userPartsShow', params:{id:props.data.id}}">
                        {{props.data.part_number}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userPartsShow', params:{id:props.data.id}}">
                        {{props.data.alternate_part_number}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'userPartsShow', params:{id:props.data.id}}">
                        {{ props.data.quantity}}
                    </router-link>
                </td>

                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                name="swt1"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Part')"
                        >
                        <span>
                            <label :for="props.data.id"></label>
                        </span>
                    </div>
                </td>

                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'userPartsEdit', params:{id:props.data.id}}">
                            <i class="mdi mdi-edit"></i>
                        </router-link>

                        <a @click.prevent="deleteMe(props.data.id)" href="#">
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
                auth:{},
                url:'/ajax/part?fromSection=user',
                columns: [
                    {name: 'Title'},
                    {name: 'Part Number'},
                    {name: 'Alternate Part', nested:'parts.alternate_part_number'},
                    {name: 'Quantity'},
                    {name: 'Status'},
                    {name: 'Action'}
                ],

            }
        },

        created(){


        },

        methods:{

            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/part/' + id).then(response => {
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

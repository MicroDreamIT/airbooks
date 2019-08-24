<template>
    <div class="card card-table custom-title-adjust">
        <data-table-user
                ref="dataTable"
                :addLink="'userWantedCreate'"
                :search="true"
                :columns="columns"
                :searchField="'wanteds.title,wanteds.terms,wanteds.isActiveStatus'"
                :tableHeadline="'Wanted'"
                :userAddButton="true"
                :ajax="{url: url}"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <router-link :to="{name:'userWantedShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.title.replace(/-/g, ' ')}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'userWantedShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{ props.data.terms}}
                    </router-link>
                </td>

                <td>
                    {{ props.data.views}}
                </td>

                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                        <input
                                type="checkbox"
                                :checked="props.data.is_active"
                                :name="props.data.id"
                                :id="props.data.id"
                                @click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Wanted')"
                        >
                        <span>
                            <label :for="props.data.id"></label>
                        </span>
                    </div>
                </td>

                <td>
                    <div class="adjustAction">
                        <router-link :to="{name:'userWantedEdit', params:{id:props.data.id}}">
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
                url:'/ajax/wanted?fromSection=user',
                columns: [
                    {name: 'Title'},
                    {name: 'Wanted Term', nested:'wanteds.terms'},
                    {name: 'Views'},
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

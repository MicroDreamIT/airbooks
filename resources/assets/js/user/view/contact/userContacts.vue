<template>
    <div class="card card-table" v-if="loaded">
        <data-table-user
                ref="dataTable"
                :addLink="'userContactCreate'"
                :search="true"
                :columns="columns"
                :tableHeadline="'Contacts'"
                :searchField="'first_name,email,title,company'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'userContactShow', params:{id:props.data.id}}">
                        {{props.data.first_name +' '+props.data.last_name}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'userContactShow', params:{id:props.data.id}}">
                        {{props.data.job_title?props.data.job_title.name:null}}
                    </router-link>
                </td>

                <td>
                    <router-link :to="{name:'userContactShow', params:{id:props.data.id}}">
                        {{props.data.company?props.data.company.name:null}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:'userContactShow', params:{id:props.data.id}}">
                        {{props.data.email}}
                    </router-link>
                </td>
                <td>
                    <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
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
                        <router-link :to="{name:'userContactEdit', params:{id:props.data.id}}">
                            <i class="mdi mdi-edit"></i>
                        </router-link>


                        <a @click="deleteMe(props.data.id)" href="#" v-if="props.data.user==null">
                            <i class="mdi mdi-delete"></i>
                        </a>
                        <a v-else>
                            <i class="mdi mdi-delete text-danger"></i>
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
                url:'/contacts?email=true&creator_id=',
                columns: [
                    {name: 'Name',nested:'first_name'},
                    {name:'Job Title'},
                    {name: 'Company',nested:'companies.name'},
                    {name: 'Email',nested:'email'},
                    {name: 'Status',nested:'is_published'},
                    {name: 'Action'},
                ],

            }
        },
        computed:{
            loaded(){
                if(this.$root.$data.user.id){
                    this.url = this.url+this.$root.$data.user.id
                    return this.$root.$data.user.id?true:false
                }

            }
        },

        methods:{

            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/contact/' + id).then(response => {
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

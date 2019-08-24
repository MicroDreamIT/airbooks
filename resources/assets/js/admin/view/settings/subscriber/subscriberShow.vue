<template>
    <div>
        <admin-aside>
            <div slot="asideContent">
                <div class="aside_bar">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Subscribers
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <span class="pl-4 underline">FILTER</span>
                            <hr>
                            <a class="dropdown-item" @click.prevent="getList(1)" href="#">Active</a>
                            <a class="dropdown-item" @click.prevent="getList(0)" href="#">Inactive</a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <router-link class="btn btn-primary mr-1"
                                     :to="{name:'adminSubscriberCreate'}" v-if=" $root.$data.createPermission">
                            +Add
                        </router-link>
                        <div class="d-flex justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <span class="icon mdi mdi-menu"></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="#">
                                        Action
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="listContent"   v-if="subscribers.length">
                    <ul class="list-group">

                        <router-link v-for="subscriber in subscribers"
                                     class="list-group-item" :key="subscriber.id"
                                     :to="{name:'adminSubscriberShow', params:{id:subscriber.id}}"
                                     @click.native="show(subscriber.id)"
                                     tag="li"
                                     style="cursor:pointer"
                        >
                            {{subscriber.name|asideTitlify}}
                        </router-link>

                    </ul>
                </div>
                <div class="center-screen" v-else>
                    <atom-spinner :color="'#4285f4'"></atom-spinner>
                </div>
                <div class="paginationAdjustment"  v-if="total>10">
                    <div class="form-group col-md-12 mx-auto form-inline list-pagination">
                        <label> items &nbsp;</label>
                        <select class="form-control" @change="getList()" v-model="resultPerPage">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                            <option value="70">70</option>
                            <option value="80">80</option>
                            <option value="90">90</option>
                            <option value="100" >100</option>
                        </select>
                        <label for="">
                            &nbsp; page no. &nbsp;
                        </label>
                        <select name="" id="" v-model="page" class="form-control" @change="getList()">
                            <option :value="pa" v-for="pa in pageNumbers">{{pa}}</option>
                        </select>
                    </div>

                </div>
            </div>

            <div slot="asideMainContent">
                <div v-if="subscriber.id">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{subscriber.name}}</span>
                        <div v-if="subscriber.id">
                            <router-link :to="{name:'adminSubscriberEdit', params:{id:subscriber.id}}">
                                <i class="mdi mdi-edit"></i>
                            </router-link>
                            <a class="pl-2 pr-2 default-color" @click.prevent="deleteMe(subscriber.id)" href="">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body  card-header-contrast">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="cat_desc">
                                            <span>Name </span> <br>
                                            <strong>{{subscriber.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="subscriber.description">
                                            <span>Description  </span> <br>
                                            <strong>{{subscriber.description}}</strong>
                                        </p>
                                        <div class="cat_desc">
                                            <span>Status </span> <br>
                                            <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                                                <input
                                                        type="checkbox"
                                                        :checked="subscriber.is_active"
                                                        name="swt1"
                                                        :id="subscriber.id"
                                                        @click.prevent="$root.changeIsBooleanStatus(subscriber, 'is_active', 'App-Category')"
                                                >
                                                <span><label :for="subscriber.id"></label></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="center-screen" v-else>
                    <atom-spinner :color="'#4285f4'"></atom-spinner>
                </div>
            </div>
        </admin-aside>


    </div>
</template>

<script>
    export default {
        name: "adminSubscriberShow",
        data(){
            return {
                subscribers:[],
                subscriber:{},
                is_active:1,
                sortKey:null,
                sortOrder:'desc',
                lastPage:null,
                resultPerPage:10,
                page:1,
                total:null,
                pageNumbers:1

            }
        },

        created(){
            this.getList()

            this.show(this.$route.params.id)
        },

        methods:{
            getList(val){

                axios.get('/subscriber-list',{
                    params:{
                        is_active: val,
                        resultPerPage: this.resultPerPage,
                        page: this.page,
                    }
                }).then(response=>{
                    this.subscribers = response.data.data
                })
            },

            show(id){
                axios.get('/admin/setting/subscriber/'+id,{

                }).then(response=>{
                    this.subscriber = response.data
                })
            },
            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/setting/subscriber/' + id).then(response => {
                            this.$root.alertMessage(response.data.message)
                            this.$router.push({path:response.data.redirection})
                        });
                    }
                });
            }
        }

    }
</script>



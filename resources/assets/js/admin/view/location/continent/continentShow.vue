<template>
    <div>

        <admin-aside>

            <div slot="asideContent">
                <div class="aside_bar">
                    <div class="dropdown">

                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Continents
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <span class="pl-4 underline">FILTER</span>
                            <hr>
                            <a class="dropdown-item" @click.prevent="getList(1)" href="">Active</a>
                            <a class="dropdown-item" @click.prevent="getList(0)" href="">Inactive</a>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">

                        <router-link class="btn btn-primary mr-1"
                                     :to="{name:'adminContinentCreate'}" v-if=" $root.$data.createPermission">
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
                                        Export
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        Import
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="listContent" ref="listHeight" :style="" v-if="continents.length">
                    <ul class="list-group">

                        <router-link v-for="continent in continents"
                                     class="list-group-item" :key="continent.id"
                                     :to="{name:'adminContinentShow', params:{id:continent.id}}"
                                     @click.native="show(continent.id)"
                                     tag="li"
                                     style="cursor:pointer"
                        >
                            {{continent.name|asideTitlify}}
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
                <div v-if="continent.id">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{continent.name}}</span>
                        <div v-if="continent.id">
                            <router-link :to="{name:'adminContinentEdit', params:{id:continent.id}}">
                                <i class="mdi mdi-edit"></i>
                            </router-link>
                            <a class="pl-2 pr-2 default-color" @click.prevent="deleteMe(continent.id)" href="">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body  card-header-contrast">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="cat_desc" v-if="continent.name">
                                            <span>Name </span> <br>
                                            <strong>{{continent.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="continent.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{$root.parseDate(continent.created_at)}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="continent.updated_at">
                                            <span>Date Modified </span> <br>
                                            <strong>{{$root.parseDate(continent.updated_at)}}</strong>
                                        </p>
                                        <div class="cat_desc">
                                            <span>Status </span> <br>
                                            <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                                                <input
                                                        type="checkbox"
                                                        :checked="continent.is_active"
                                                        name="swt1"
                                                        :id="continent.id"
                                                        @click.prevent="$root.changeIsBooleanStatus(continent, 'is_active', 'App-Continent')"
                                                >
                                                <span><label :for="continent.id"></label></span>
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
        name: "adminContinentShow",
        data(){
            return {
                continents:[],
                continent:{},
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
        updated(){
            this.total<10?this.$refs.listHeight.style='height:100vh!important':null
        },

        methods:{
            getList(val){

                axios.get('/continent-list',{
                    params:{
                        is_active: val,
                        resultPerPage: this.resultPerPage,
                        page: this.page,
                    }
                }).then(response=>{
                    this.continents = response.data.data
                    this.lastPage = response.data.last_page
                    this.total = response.data.total
                    let nu = this.total / response.data.per_page
                    this.pageNumbers = Math.ceil(nu)
                })
            },

            show(id){
                axios.get('/admin/location/continent/'+id,{

                }).then(response=>{
                    this.continent = response.data
                })
            },
            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/location/continent/' + id).then(response => {
                            this.$root.alertMessage(response.data.message)
                            this.$router.push({path:response.data.redirection})
                        });
                    }
                });
            }
        }

    }
</script>


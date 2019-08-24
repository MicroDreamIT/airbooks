<template>
    <div>

        <admin-aside>

            <div slot="asideContent">
                <div class="aside_bar">
                    <div class="dropdown">

                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            APU Types
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
                                     :to="{name:'adminApuTypeCreate'}" v-if=" $root.$data.createPermission">
                            +Add
                        </router-link>

                        <div class="d-flex justify-content-end">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <span class="icon mdi mdi-menu"></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
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
                
                <div class="listContent"  v-if="typeList.length">
                    <ul class="list-group">
                        <router-link v-for="type in typeList"
                                     class="list-group-item" :key="type.id"
                                     :to="{name:'adminApuTypeShow', params:{id:type.id}}"
                                     @click.native="show(type.id)"
                                     tag="li"
                                     style="cursor:pointer"
                        >
                            {{type.name|asideTitlify}}
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
                <div v-if="typeData.id">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{typeData.name}}</span>
                        <div v-if="typeData.id">
                            <router-link :to="{name:'adminApuTypeEdit', params:{id:typeData.id}}">
                                <i class="mdi mdi-edit"></i>
                            </router-link>
                            <a href="" class="pl-2 default-color"  @click.prevent="deleteMe(typeData.id)">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body  card-header-contrast">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
    
                                        <p class="cat_desc" v-if="typeData.name">
                                            <span>Name  </span> <br>
                                            <strong>{{typeData.name}}</strong>
                                        </p>
                                        
                                        <p class="cat_desc" v-if="typeData.manufacturer.name">
                                            <span>Manufacturer  </span> <br>
                                            <strong>{{typeData.manufacturer.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="typeData.description">
                                            <span>Description  </span> <br>
                                            <strong>{{typeData.description}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="typeData.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{$root.parseDate(typeData.created_at)}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="typeData.updated_at">
                                            <span>Date Modified </span> <br>
                                            <strong>{{$root.parseDate(typeData.updated_at)}}</strong>
                                        </p>
                                        <div class="cat_desc">
                                            <span>Status </span> <br>
                                            <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                                                <input
                                                        type="checkbox"
                                                        :checked="typeData.is_active"
                                                        name="swt1"
                                                        :id="typeData.id"
                                                        @click.prevent="$root.changeIsBooleanStatus(typeData, 'is_active', 'App-Type')"
                                                >
                                                <span><label :for="typeData.id"></label></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="darea" role="alert">
                                    <div class="message" v-if="typeData.medias">
                                        <img :src="'/storage/'+typeData.medias.path+'/'+typeData.medias.original_file_name" class="img-fluid d-block mx-auto" >
                                    </div>
                                    <div class="message" v-else>
                                        <img :src="'/../../../images/dummy_image.svg'" width="70px" class="img-fluid d-block mx-auto" >
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
        name: "adminApuTypeShow",
        data(){
            return {
                typeList:[],
                typeData:{},
                is_active:1,
                sortKey:null,
                sortOrder:'asc',
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

        watch:{
            is_active(val){
                this.getList()
            },
            sortOrder(val){
                this.getList()
            }
        },

        methods:{
            getList(val){

                axios.get('/type-list',{
                    params:{
                        type:'apu',
                        is_active: val,
                        resultPerPage: this.resultPerPage,
                        page: this.page,
                    }
                }).then(response=>{
                    this.typeList = response.data.data
                    this.lastPage = response.data.last_page
                    this.total = response.data.total
                    let nu = this.total / response.data.per_page
                    this.pageNumbers = Math.ceil(nu)
                })
            },

            show(id){
                axios.get('/admin/type/'+id,{

                    params:{
                        type:'apu'
                    }
                }).then(response=>{
                    this.typeData = response.data
                })
            },
            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/type/' + id).then(response => {
                            this.$root.alertMessage(response.data.message)
                            this.$router.push({path:response.data.redirection})
                        });
                    }
                });
            }
        }

    }
</script>

<style scoped>

</style>

<template>
    <div>
        <admin-aside>
            <div slot="asideContent">
                <div class="aside_bar">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                             Manufacturer
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
                                     :to="{name:'adminAircraftManufacturerCreate'}" v-if=" $root.$data.createPermission">
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
               
                <div class="listContent" ref="listHeight" :style="" v-if="manufacturers.length">
                    <ul class="list-group">

                        <router-link v-for="manufacturer in manufacturers"
                                     class="list-group-item" :key="manufacturer.id"
                                     :to="{name:'adminAircraftManufacturerShow', params:{id:manufacturer.id}}"
                                     @click.native="show(manufacturer.id)"
                                     tag="li"
                                     style="cursor:pointer"
                        >
                            {{manufacturer.name|asideTitlify}}
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
                <div v-if="manufacturer.id">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{manufacturer.name}}</span>
                        <div v-if="manufacturer.id">
                            <router-link :to="{name:'adminAircraftManufacturerEdit', params:{id:manufacturer.id}}">
                                <i class="mdi mdi-edit"></i>
                            </router-link>
                            <a href="" class="pl-2 default-color" @click.prevent="deleteMe(manufacturer.id)">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body  card-header-contrast">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="cat_desc" v-if="manufacturer.name">
                                            <span>Name  </span> <br>
                                            <strong>{{manufacturer.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="manufacturer.categories">
                                            <span>Category  </span> <br>
                                            <template v-for="(category, index) in manufacturer.categories">
                                                <strong>{{category.name}}</strong>
                                                <strong v-if="index < manufacturer.categories.length-1 "> | </strong>
                                            </template>

                                        </p>
                                        <p class="cat_desc" v-if="manufacturer.established">
                                            <span>Established  </span> <br>
                                            <strong> {{manufacturer.established}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="manufacturer.country">
                                            <span>Country  </span> <br>
                                            <strong> {{manufacturer.country?manufacturer.country.name:''}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="manufacturer.description">
                                            <span>Description  </span> <br>
                                            <strong> {{manufacturer.description}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="manufacturer.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{$root.parseDate(manufacturer.created_at)}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="manufacturer.updated_at">
                                            <span>Date Modified </span> <br>
                                            <strong>{{$root.parseDate(manufacturer.updated_at)}}</strong>
                                        </p>
                                        <div class="cat_desc">
                                            <span>Status </span> <br>
                                            <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                                                <input
                                                        type="checkbox"
                                                        :checked="manufacturer.is_active"
                                                        name="swt1"
                                                        :id="manufacturer.id"
                                                        @click.prevent="$root.changeIsBooleanStatus(manufacturer, 'is_active', 'App-Manufacturer')"
                                                >
                                                <span><label :for="manufacturer.id"></label></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="darea" role="alert">
                                    <div class="message" v-if="manufacturer.medias">
                                        <img :src="'/storage/'+manufacturer.medias.path+'/'+manufacturer.medias.original_file_name" class="img-fluid d-block mx-auto" >
                                    </div>
                                    <div class="message" v-else>
                                        <img :src="'/../../../images/dummy_image.svg'" class="img-fluid d-block mx-auto" width="70px">
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
        name: "adminAircraftManufacturerShow",
        data(){
            return {
                manufacturers:[],
                manufacturer:{},
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
        updated(){

            this.total<10?this.$refs.listHeight.style='height:100vh!important':null
        },

        methods:{
            getList(val){
                axios.get('/manufacturer-list',{
                    params:{
                        type:'aircraft',
                        is_active: val,
                        resultPerPage: this.resultPerPage,
                        page: this.page,
                    }
                }).then(response=>{
                    this.manufacturers = response.data.data
                    this.lastPage = response.data.last_page
                    this.total = response.data.total
                    let nu = this.total / response.data.per_page
                    this.pageNumbers = Math.ceil(nu)
                })
            },
            show(id){
                axios.get('/admin/manufacturer/'+id,{
                    params:{
                        type:'aircraft'

                    }
                }).then(response=>{
                    this.manufacturer = response.data
                })
            },
            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/manufacturer/' + id).then(response => {
                            this.$root.alertMessage(response.data.message)
                            this.$router.push({path:response.data.redirection})
                        });
                    }
                });
            }
        }

    }
</script>


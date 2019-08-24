<template>
    <div>

        <admin-aside>

            <div slot="asideContent">
                <div class=" aside_bar" >
                    <div class="dropdown">

                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Company
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
                                     :to="{name:'adminCompanyCreate'}" v-if=" $root.$data.createPermission">
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
               
                <div class="listContent" ref="listHeight" :style="" v-if="companies.length">
                    <ul class="list-group">

                        <router-link v-for="company in companies"
                                     class="list-group-item" :key="company.id"
                                     :to="{name:'adminCompanyShow', params:{id:company.id}}"
                                     @click.native="show(company.id)"
                                     tag="li"
                                     style="cursor:pointer"
                        >
                            {{company.name|asideTitlify}}
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
                <div v-if="company.id">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{company.name}}</span>
                        <div v-if="company.id">
                            <router-link :to="{name:'adminCompanyEdit', params:{id:company.id}}">
                                <i class="mdi mdi-edit"></i>
                            </router-link>
                            <a href="" class="pl-2 default-color" @click.prevent="deleteMe(company.id)">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body  card-header-contrast">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="cat_desc" v-if="company.name">
                                            <span>Name  </span> <br>
                                            <strong>{{company.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.website">
                                            <span>Website  </span> <br>
                                            <strong> {{company.website}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.address">
                                            <span>Address  </span> <br>
                                            <strong> {{company.address}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.city">
                                            <span>City  </span> <br>
                                            <strong> {{company.city.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.state">
                                            <span>State  </span> <br>
                                            <strong> {{company.state.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.country">
                                            <span>Country  </span> <br>
                                            <strong> {{company.country.name}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.po_box">
                                            <span>P.O.Box  </span> <br>
                                            <strong> {{company.po_box}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.zip_code">
                                            <span>Zipcode/Postal Code  </span> <br>
                                            <strong> {{company.zip_code}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.rfq_email">
                                            <span>RFQ Email</span> <br>
                                            <strong> {{company.rfq_email}}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="company.aog_email">
                                            <span>AOG Email </span> <br>
                                            <strong> {{company.aog_email}}</strong>
                                        </p>
                                        <p class="cat_desc"  >
                                            <span>Specialties </span> <br>
                                            <template v-for="(speciality, index) in company.specialities">
                                                <strong>{{speciality.name}}</strong>
                                                <strong v-if="index < company.specialities.length-1 "> | </strong>
                                            </template>
                                        </p>
                                        <p class="cat_desc" v-if="company.business_phone">
                                            <span>Business Number  </span> <br>
                                            <strong> {{company.business_phone}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.profile">
                                            <span>Company Profile  </span> <br>
                                            <strong> {{company.profile}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{$root.parseDate(company.created_at)}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="company.updated_at">
                                            <span>Date Modified </span> <br>
                                            <strong>{{$root.parseDate(company.updated_at)}}</strong>
                                        </p>
                                        <div class="cat_desc">
                                            <span>Status </span> <br>
                                            <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                                                <input
                                                        type="checkbox"
                                                        :checked="company.is_active"
                                                        name="swt1"
                                                        :id="company.id"
                                                        @click.prevent="$root.changeIsBooleanStatus(company, 'is_active', 'App-Company')"
                                                >
                                                <span><label :for="company.id"></label></span>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="darea" role="alert">
                                    <div class="message" v-if="company.medias">
                                        <img :src="'/storage/'+company.medias.path+'/'+company.medias.original_file_name" class="img-fluid d-block mx-auto" >
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
        name: "adminCompanyShow",
        data(){
            return {
                companies:[],
                company:{},
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

                axios.get('/company-list',{
                    params:{
                        is_active: val,
                        resultPerPage: this.resultPerPage,
                        page: this.page,

                    }
                }).then(response=>{
                    this.companies = response.data.data
                    this.lastPage = response.data.last_page
                    this.total = response.data.total
                    let nu = this.total / response.data.per_page
                    this.pageNumbers = Math.ceil(nu)
                })
            },

            show(id){
                axios.get('/admin/company/'+id,{

                }).then(response=>{
                    this.company = response.data
                })
            },
            deleteMe(id){
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/company/' + id).then(response => {
                            this.$root.alertMessage(response.data.message)
                            this.$router.push({path:response.data.redirection})
                        });
                    }
                });
            }
        }

    }
</script>



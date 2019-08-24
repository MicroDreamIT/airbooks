<template>
    <div>
        <admin-aside>
            <div slot="asideContent">

                <div class="col-12 d-flex justify-content-between aside_bar">
                    <div class="dropdown">

                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            Contacts
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <span class="pl-4 underline">FILTER</span>
                            <hr>
                            <a class="dropdown-item"
                               @click="getList(1)"
                               href="#"
                            >
                                published
                            </a>
                            <a class="dropdown-item"
                               @click="getList(0)"
                               href="#">
                                not published
                            </a>
                        </div>

                    </div>
                    <div class="d-flex justify-content-end">

                        <router-link class="btn btn-primary mr-1"
                                     :to="{name:'adminContactsCreate'}" v-if=" $root.$data.createPermission">
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
                <div class="listContent"  v-if="contacts.length">
                    <ul class="list-group">
                        <router-link v-for="contact in contacts"
                                     class="list-group-item" :key="contact.id"
                                     :to="{name:'adminContactsShow', params:{id:contact.id}}"
                                     @click.native="show(contact.id)"
                                     tag="li"
                                     style="cursor:pointer"
                        >
                            {{contact.first_name}} {{contact.last_name}}
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
                        <label>
                            &nbsp; page number &nbsp;
                        </label>
                        <select v-model="page" class="form-control" @change="getList()">
                            <option :value="pa" v-for="pa in pageNumbers">{{pa}}</option>
                        </select>
                    </div>

                </div>

            </div>
            <div slot="asideMainContent">
                <div v-if="contact.id">
                    <div class="card-header d-flex justify-content-between flex-wrap">
                        <span>{{contact.first_name}} {{contact.last_name}}</span>
                        <div>
                            <router-link :to="{name:'adminContactsEdit', params:{id:contact.id}}">
                                <i class="mdi mdi-edit"></i>
                            </router-link>
                            <a class="pl-2 pr-2 default-color" @click.prevent="deleteMe()" href="#" v-if="$root.$data.user.contact.id!=$route.params.id">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body  card-header-contrast">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-4" v-if="contact.title">
                                            <p class="cat_desc" >
                                                <span>Name</span> <br>
                                                <strong>
                                                    {{contact.title}} {{contact.first_name}} {{contact.last_name}}
                                                </strong>
                                            </p>
                                        </div>
                                        <div class="col-md-4" v-if="contact.user">
                                            <p class="cat_desc">
                                                <span>Email</span> <br>
                                                <strong>
                                                    {{contact.email}}
                                                </strong>
                                            </p>

                                            <p class="cat_desc" v-if="contact.gender">
                                                <span>Gender</span> <br>
                                                <strong class="text-capitalize">
                                                    {{contact.gender}}
                                                </strong>
                                            </p>
                                        </div>
                                        <div class="col-md-4" v-if="contact.religion">
                                            <p class="cat_desc">
                                                <span>Religion</span> <br>
                                                <strong>
                                                    {{contact.religion}}
                                                </strong>
                                            </p>

                                            <p class="cat_desc" v-if="contact.birthday">
                                                <span>Birthday</span> <br>
                                                <strong>
                                                    {{contact.birthday}}
                                                </strong>
                                            </p>
                                        </div>
                                    </div>

                                    <hr>

                                   <section class="company_detail">
                                       <div class="row">
                                           <div class="col-md-4" v-if="contact.company">
                                               <p class="cat_desc">
                                                   <span>Company</span> <br>
                                                   <strong>
                                                       <router-link
                                                               :to="{name:'adminCompanyShow', params:{id:contact.company.id}}"
                                                               target= '_blank'>
                                                           {{contact.company.name}}
                                                       </router-link>

                                                   </strong>
                                               </p>
                                           </div>
                                           <div class="col-md-4" v-if="contact.job_title">
                                               <p class="cat_desc">
                                                   <span>Job Title</span> <br>
                                                   <strong>
                                                       {{contact.job_title.name}}
                                                   </strong>
                                               </p>
                                           </div>
                                           <div class="col-md-4" v-if="contact.department">
                                               <p class="cat_desc">
                                                   <span>Department</span> <br>
                                                   <strong>
                                                       {{contact.department.name}}
                                                   </strong>
                                               </p>
                                           </div>
                                       </div>
                                   </section>

                                    <hr>

                                    <section class="contact_detail">
                                        <div class="row">
                                            <div class="col-md-4" v-if="contact.mobile_phone">
                                                <p class="cat_desc">
                                                    <span>Mobile Phone</span> <br>
                                                    <strong>
                                                        {{contact.mobile_phone}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4" v-if="contact.business_phone">
                                                <p class="cat_desc">
                                                    <span>Business Phone</span> <br>
                                                    <strong>
                                                        {{contact.business_phone}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4" v-if="contact.skype">
                                                <p class="cat_desc">
                                                    <span>Skype</span> <br>
                                                    <strong>
                                                        {{contact.skype}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4" v-if="contact.linkedin">
                                                <p class="cat_desc">
                                                    <span>Linkedin</span> <br>
                                                    <strong>
                                                        {{contact.linkedin}}
                                                    </strong>
                                                </p>
                                            </div>

                                        </div>



                                    </section>


                                    <hr v-if="contact.mobile_phone || contact.business_phone||
                                     contact.skype||contact.linkedin">

                                    <section class="address">
                                        <div class="row">
                                            <div class="col-md-4" v-if="contact.address">
                                                <p class="cat_desc">
                                                    <span>Address</span> <br>
                                                    <strong>
                                                        {{contact.address}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4" v-if="contact.city">
                                                <p class="cat_desc">
                                                    <span>City</span> <br>
                                                    <strong>
                                                        {{contact.city.name}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4" v-if="contact.state">
                                                <p class="cat_desc">
                                                    <span>State</span> <br>
                                                    <strong>
                                                         {{contact.state.name}}
                                                    </strong>
                                                </p>
                                            </div>

                                            <div class="col-md-4" v-if="contact.country">
                                                <p class="cat_desc">
                                                    <span>Country</span> <br>
                                                    <strong>
                                                          {{contact.country.name}}
                                                    </strong>
                                                </p>
                                            </div>

                                        </div>
                                    </section>

                                    <hr>

                                    <section class="user_settings">
                                        <div class="row">
                                            <div class="col-md-4" v-if="contact.preferred_contact_method">
                                                <p class="cat_desc">
                                                    <span>Preferred contact method</span><br>
                                                    <strong>
                                                        {{contact.preferred_contact_method}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <!--<div class="col-md-4" v-if="contact.creator.id">-->
                                                <!--<p class="cat_desc">-->
                                                    <!--<span>Creator id</span><br>-->
                                                    <!--<strong>-->
                                                        <!--{{contact.creator.id}}-->
                                                    <!--</strong>-->
                                                <!--</p>-->
                                            <!--</div>-->
                                            <div class="col-md-4">
                                                <div class="cat_desc">
                                                    <span>Published status</span><br>
                                                <div class="switch-button switch-button-success switch-button-xs activeSwitch" >
                                                    <input
                                                            type="checkbox"
                                                            :checked="contact.is_published"
                                                            name="swt1"
                                                            :id="contact.id"
                                                            @click.prevent="$root.changeIsBooleanStatus(contact, 'is_published', 'App-Contact')"
                                                    >
                                                    <span><label :for="contact.id"></label></span>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4" v-if="contact.is_primary">
                                                <p class="cat_desc">
                                                    <span>Primary Status</span><br>
                                                    <strong>
                                                        {{contact.is_primary ? 'Yes' : 'No'}}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4" v-if="contact.is_public">
                                                <p class="cat_desc">
                                                    <span>Public Status</span><br>
                                                    <strong>
                                                        {{contact.is_public ? 'Yes' : 'No'}}
                                                    </strong>
                                                </p>
                                            </div>
                                            
                                        </div>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="cat_desc" v-if="contact.created_at">
                                                    <span>Date Created </span> <br>
                                                    <strong>{{$root.parseDate(contact.created_at)}}</strong>
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="cat_desc" v-if="contact.updated_at">
                                                    <span>Date Modified </span> <br>
                                                    <strong>{{$root.parseDate(contact.updated_at)}}</strong>
                                                </p>

                                            </div>
                                        </div>
                                    </section>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="darea" role="alert">
                                <div class="message" v-if="contact.medias">
                                    <img :src="'/storage/'+contact.medias.path+'/'+contact.medias.original_file_name"
                                         class="img-fluid d-block mx-auto" >
                                </div>
                                <div class="message" v-else>
                                    <img :src="'/../../../images/dummy_image.svg'" width="70px" class="img-fluid d-block mx-auto" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </admin-aside>
    </div>
</template>

<script>
    export default {
        name: "adminContactShow",
        data(){
            return {
                contacts:[],
                contact:{},
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
        methods:{

            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/contacts/' + this.$route.params.id).then(response => {
                            this.$router.push({path:'/admin/contacts'})
                            this.$root.alertMessage(
                                {
                                    type:'danger',
                                    message:'Contact has been deleted successfully'
                                })
                        })
                    }
                })
            },

            show(id){
                axios.get('/admin/contacts/'+id,{
                    params:{

                    }
                }).then(response=>{
                    this.contact = response.data
                })
            },
            getList(val){
                axios.get('/contacts',{
                    params:{
                        sortName:'id',
                        sortOrder:'desc',
                        paging:true,
                        page: this.page,
                        resultPerPage:this.resultPerPage,
                        is_published: val
                    }
                })
                    .then(response=>{
                        this.contacts = response.data.data
                        this.lastPage = response.data.last_page
                        this.total = response.data.total
                        let nu = this.total / response.data.per_page
                        this.pageNumbers = Math.ceil(nu)
                    }).catch(error=>{

                })
            }
        }
    }
</script>


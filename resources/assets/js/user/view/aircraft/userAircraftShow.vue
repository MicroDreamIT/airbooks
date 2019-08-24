<template>
    <div>
        <div class="card card-contrast custom_info">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <span>{{aircraft.title|filterTitle}}</span>
                <div>
                    <router-link :to="{name:'userAircraftEdit', params:{id:aircraft.id}}">
                        <i class="mdi mdi-edit"></i>
                    </router-link>
                    <a href="" class="pl-2 default-color" >
                        <i class="mdi mdi-delete"></i>
                    </a>
                </div>
            </div>
            <div class="card-body  card-header-contrast">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">

                                        <p class="cat_desc" v-if="aircraft.category">
                                            <span>Category </span> <br>
                                            <strong>{{aircraft.category.name }}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.manufacturer">
                                            <span>Manufacturer  </span> <br>
                                            <strong>{{aircraft.manufacturer.name }}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="aircraft.type">
                                            <span>Type  </span> <br>
                                            <strong>{{aircraft.type.name }}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.modeled">
                                            <span>Model  </span> <br>
                                            <strong>{{aircraft.modeled.name }}</strong>
                                        </p>

                                    </div>
                                    <div class="col-md-4">
                                        <p class="cat_desc" v-if="aircraft.MSN">
                                            <span>MSN</span> <br>
                                            <strong>{{aircraft.MSN}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.YOM">
                                            <span>YOM</span> <br>
                                            <strong>{{aircraft.YOM|moment('YYYY')}}  </strong>
                                        </p>

                                        <p class="cat_desc">
                                            <span>Seating</span> <br>
                                            <strong>
                                            <template v-if="aircraft.seating_economy">
                                                {{'Economy (Y) '}}{{aircraft.seating_economy?aircraft.seating_economy:0}}

                                            </template>
                                            <template v-if="aircraft.seating_business">
                                                {{','}}
                                                {{'Business (C) '}}{{aircraft.seating_business?aircraft.seating_business:0}}

                                            </template>
                                            <template v-if="aircraft.seating_first_class">
                                                {{','}}
                                                {{'First (F) '}}{{aircraft.seating_first_class?aircraft.seating_first_class:0}}

                                            </template>
                                            </strong>
                                        </p>

                                        <p class="cat_desc" v-if="aircraft.status">
                                            <span>Current Status</span> <br>
                                            <strong>{{aircraft.status}}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="aircraft.offer_for">
                                            <span> Offer For</span> <br>
                                            <strong>{{aircraft.offer_for}}  </strong>
                                        </p>

                                        <p class="cat_desc" v-if="aircraft.offer_for=='Sale'">
                                            <span> Price</span> <br>
                                            <strong>{{parseFloat(aircraft.price).toFixed(2)}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.offer_for=='ACMI'">
                                            <span> MGH</span> <br>
                                            <strong>{{aircraft.mgh}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="['Dry Lease','Wet Lease','Exchange'].includes(aircraft.offer_for)">
                                            <span class="capitalize"> {{aircraft.offer_for}}</span> <br>
                                            <strong>{{aircraft.terms}}  </strong>
                                        </p>

                                    </div>
                                    <div class="col-md-4">

                                        <p class="cat_desc" v-if="aircraft.tsn">
                                            <span>TSN</span> <br>
                                            <strong>{{aircraft.tsn}}  </strong>
                                        </p>

                                        <p class="cat_desc" v-if="aircraft.csn">
                                            <span>CSN</span> <br>
                                            <strong>{{aircraft.csn}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.mtow">
                                            <span>MTOW</span> <br>
                                            <strong>{{aircraft.mtow +' Kg'}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.mlgw">
                                            <span>MLGW</span> <br>
                                            <strong>{{aircraft.mlgw + 'Kg'}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.last_c_check">
                                            <span>Last C Check</span> <br>
                                            <strong>{{aircraft.last_c_check |moment("MMMM DD, YYYY")}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.compliance">
                                            <span>Compliance</span> <br>
                                            <strong>{{aircraft.compliance}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.registration_number">
                                            <span>Registration Number</span> <br>
                                            <strong>{{aircraft.registration_number}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.registered_in">
                                            <span>Registration Country</span> <br>
                                            <strong>{{aircraft.registered_in.name}}  </strong>
                                        </p>
                                        <!---->
                                        <p class="cat_desc" v-if="aircraft.availability">
                                            <span>Availability</span> <br>
                                            <strong>{{aircraft.availability | moment("DD/MM/YYYY")}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.current_location">
                                            <span>Current Location</span> <br>
                                            <strong>{{aircraft.current_location.name}}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="aircraft.primary_contact">
                                            <span>Primary Contact</span> <br>
                                            <strong>
                                                {{aircraft.primary_contact.first_name+' '+aircraft.primary_contact.last_name}}
                                            </strong>
                                        </p>

                                    </div>

                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-4">

                                        <p class="cat_desc" v-if="aircraft.owner">
                                            <span>Owner</span> <br>
                                            <strong>{{aircraft.owner.name }}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.seller">
                                            <span>Seller</span> <br>
                                            <strong>{{aircraft.seller.name }}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.thrust_rating">
                                            <span>Thrust Rating</span> <br>
                                            <strong>{{aircraft.thrust_rating}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.lsv_description">
                                            <span>Lsv Description</span> <br>
                                            <strong>{{aircraft.lsv_description}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.tso">
                                            <span>tso</span> <br>
                                            <strong>{{aircraft.tso}}</strong>
                                        </p>


                                    </div>
                                    <div class="col-md-4">
                                        <p class="cat_desc" v-if="aircraft.views">
                                            <span>Views</span> <br>
                                            <strong>{{aircraft.views}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.likes">
                                            <span>Likes</span> <br>
                                            <strong>{{aircraft.likes.length}} </strong>
                                        </p>
                                        <p class="cat_desc">
                                            <span>Promote Status</span> <br>
                                            <strong>{{aircraft.is_featured==1?'Yes':'No'}}</strong>
                                        </p>
                                        <p class="cat_desc">
                                            <span>Active Status</span> <br>
                                            <strong>{{aircraft.isActiveStatus}}</strong>
                                        </p>
                                        <p class="cat_desc">
                                            <span>Published Status</span> <br>
                                            <strong>{{aircraft.is_active_by_user==1?'Yes':'No'}}</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4">

                                        <p class="cat_desc" v-if="aircraft.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{aircraft.created_at | moment("DD/MM/YYYY") }}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="aircraft.updated_at">
                                            <span>Date Modified</span> <br>
                                            <strong>{{aircraft.updated_at | moment("DD/MM/YYYY") }}</strong>
                                        </p>

                                    </div>
                                </div>
                                <hr>
                                <div class="row" v-if="aircraft.description">
                                    <div class="col-md-12">
                                        <hr>
                                        <p class="cat_desc">
                                            <span>Description</span> <br>
                                            <strong>{{aircraft.description}}</strong>
                                        </p>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="" role="alert">
                            <div class="message" >
                                <img :src="media | globalMediaPath"
                                     class="img-fluid d-block mx-auto"
                                     v-for="media in aircraft.medias"
                                     :class="media.is_featured?'featured':'gallery'">
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "userAircraftShow",
        data(){
            return {
                aircraft:{
                    engine_type:{
                        name:''
                    },
                    engine_model:{
                        name:'',
                    },
                    configuration:{
                        name:''
                    },
                    seller:{
                        name:''
                    },
                    manager:{
                        name:'',
                    },
                    registered_in:{
                        name:'',
                    },
                    owner:{
                        name:'',
                    },
                    previous_operator:{
                        name:'',
                        status:'',
                        profile:'',
                        zip_code:'',
                        po_box:'',
                        business_phone:'',
                        address:'',
                        website:'',
                        is_active:'',
                        is_published:'',
                        created_at:'',
                        deleted_at:'',
                        updated_at:'',
                    },
                    current_operator:{
                        name:'',
                        status:'',
                        profile:'',
                        zip_code:'',
                        po_box:'',
                        business_phone:'',
                        address:'',
                        logo:'',
                        website:'',
                        is_active:'',
                        is_published:'',
                        deleted_at:'',
                        created_at:'',
                        updated_at:'',

                    },
                    user:{
                        contact:{
                            title:'',
                            first_name:'',
                            last_name:''
                        }
                    },
                    modeled:{
                        name:''
                    },
                    category:{
                        name:''
                    },
                    primary_contact:{
                        title:'',
                        first_name:'',
                        last_name:''
                    },
                    type:{
                        name:''
                    },
                    manufacturer:{
                        type:'',
                        name:'',
                        established:'',
                        description:'',
                        created_at:'',
                        updated_at:'',
                    }

                },
            }
        },
        created(){
            this.getAircraft(this.$route.params.id.split('-')[0])
        },

        methods:{
            getAircraft(id){
                axios.get('/user/ajax/aircraft/'+ id)
                    .then(res=>{
                        this.aircraft = res.data
                    })
            }
        }
    }
</script>


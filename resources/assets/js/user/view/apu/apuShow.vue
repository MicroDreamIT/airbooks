<template>
    <div>
          <div class="card card-contrast custom_info">
                <div class="card-header d-flex justify-content-between flex-wrap">
                      <span>{{apu.title|filterTitle}}</span>
                      <div>
                            <router-link :to="{name:'userApuEdit', params:{id:apu.id}}">
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

                                                    <p class="cat_desc" v-if="apu.category">
                                                        <span>Category </span> <br>
                                                        <strong>{{apu.category.name }}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.manufacturer">
                                                        <span>Manufacturer  </span> <br>
                                                        <strong>{{apu.manufacturer.name }}</strong>
                                                    </p>

                                                    <p class="cat_desc" v-if="apu.type">
                                                        <span>Type  </span> <br>
                                                        <strong>{{apu.type.name }}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.model">
                                                        <span>Model  </span> <br>
                                                        <strong>{{apu.model.name }}</strong>
                                                    </p>

                                                </div>
                                                <div class="col-md-4">
                                                    <p class="cat_desc" v-if="apu.sn">
                                                        <span>SN</span> <br>
                                                        <strong>{{apu.serial_number}}  </strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.cycle_remaining">
                                                        <span>Cycle Remaining</span> <br>
                                                        <strong>{{apu.cycle_remaining}}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.status">
                                                        <span>Current Status</span> <br>
                                                        <strong>{{apu.status}}</strong>
                                                    </p>

                                                    <p class="cat_desc" v-if="apu.offer_for">
                                                        <span> Offer For</span> <br>
                                                        <strong>{{apu.offer_for}}  </strong>
                                                    </p>

                                                    <p class="cat_desc" v-if="apu.offer_for=='Sale'">
                                                        <span> Price</span> <br>
                                                        <strong>{{parseFloat(apu.price).toFixed(2)}}  </strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.offer_for=='Lease'">
                                                        <span> Lease Terms</span> <br>
                                                        <strong>{{apu.lease_terms}}  </strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.offer_for=='Exchange'">
                                                        <span> Exchange Terms</span> <br>
                                                        <strong>{{apu.exchange_terms}}  </strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="cat_desc" v-if="apu.availability">
                                                        <span>Availability</span> <br>
                                                        <strong>{{apu.availability | moment("DD/MM/YYYY")}}  </strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.current_location">
                                                        <span>Current Location</span> <br>
                                                        <strong>{{apu.current_location.name}}</strong>
                                                    </p>

                                                    <p class="cat_desc" v-if="apu.contact">
                                                        <span>Primary Contact</span> <br>
                                                        <strong>
                                                            {{apu.contact.fullName}}
                                                        </strong>
                                                    </p>

                                                    <p class="cat_desc" v-if="apu.owner">
                                                        <span>Owner</span> <br>
                                                        <strong>{{apu.owner.name }}  </strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.seller">
                                                        <span>Seller</span> <br>
                                                        <strong>{{apu.seller.name }}  </strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p class="cat_desc" v-if="apu.thrust_rating">
                                                        <span>Thrust Rating</span> <br>
                                                        <strong>{{apu.thrust_rating}}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.lsv_description">
                                                        <span>Lsv Description</span> <br>
                                                        <strong>{{apu.lsv_description}}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.tso">
                                                        <span>tso</span> <br>
                                                        <strong>{{apu.tso}}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.views">
                                                        <span>Views</span> <br>
                                                        <strong>{{apu.views}} </strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.likes">
                                                        <span>Likes</span> <br>
                                                        <strong>{{apu.likes.length}} </strong>
                                                    </p>

                                                </div>
                                                <div class="col-md-4">
                                                    <p class="cat_desc">
                                                        <span>Promote Status</span> <br>
                                                        <strong>{{apu.is_featured==1?'Yes':'No'}}</strong>
                                                    </p>
                                                    <p class="cat_desc">
                                                        <span>Active Status</span> <br>
                                                        <strong>{{apu.isActiveStatus}}</strong>
                                                    </p>
                                                    <p class="cat_desc">
                                                        <span>Published Status</span> <br>
                                                        <strong>{{apu.is_active_by_user==1?'Yes':'No'}}</strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-4">

                                                    <p class="cat_desc" v-if="apu.created_at">
                                                        <span>Date Created </span> <br>
                                                        <strong>{{apu.created_at | moment("DD/MM/YYYY") }}</strong>
                                                    </p>
                                                    <p class="cat_desc" v-if="apu.updated_at">
                                                        <span>Date Modified</span> <br>
                                                        <strong>{{apu.updated_at | moment("DD/MM/YYYY") }}</strong>
                                                    </p>

                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row" v-if="apu.description">
                                                <div class="col-md-12">
                                                    <hr>
                                                    <p class="cat_desc">
                                                        <span>Description</span> <br>
                                                        <strong>{{apu.description}}</strong>
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
                                           v-for="media in apu.medias"
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
        name: "userApuShow",
        data(){
            return {
                apu:{}
            }
        },
        created(){
            this.get(this.$route.params.id.split('-')[0])
        },

        methods:{
            get(id){
                axios.get('/user/ajax/apu/'+ id)
                    .then(res=>{
                        this.apu = res.data
                    })
            }
        }
    }
</script>


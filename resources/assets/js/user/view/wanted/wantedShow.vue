<template>
    <div>
        <div class="card card-contrast custom_info">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <span>{{wanteds.title|filterTitle}}</span>
                <div>
                    <router-link :to="{name:'userWantedEdit', params:{id:wanteds.id}}">
                        <i class="mdi mdi-edit"></i>
                    </router-link>
                    <a href="" class="pl-2 default-color" >
                        <i class="mdi mdi-delete"></i>
                    </a>
                </div>
            </div>
            <div class="card-body  card-header-contrast">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="cat_desc" v-if="wanteds.type">
                                            <span>Wanted Type  </span> <br>
                                            <strong class='capitalize'>{{wanteds.type}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.manufacturer && wanteds.type!='part'">
                                            <span>Manufacturer  </span> <br>
                                            <strong>{{wanteds.manufacturer.name}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.typed && wanteds.type!='part'">
                                            <span>Type  </span> <br>
                                            <strong>{{wanteds.typed.name}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.modeled && wanteds.type!='part'">
                                            <span>Model  </span> <br>
                                            <strong>{{wanteds.modeled.name}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.part_number">
                                            <span> Part Number</span> <br>
                                            <strong>{{wanteds.part_number}}  </strong>
                                        </p>

                                    </div>
                                    <div class="col-md-3">

                                        <p class="cat_desc" v-if="wanteds.yom">
                                            <span>YOM</span> <br>
                                            <strong>{{wanteds.yom | moment('Y')}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.terms">
                                            <span>Terms</span> <br>
                                            <strong>{{wanteds.terms}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.wanted_by">
                                            <span>Wanted By</span> <br>
                                            <strong>{{$root.parseDate(wanteds.wanted_by)}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.country">
                                            <span>Location</span> <br>
                                            <strong>{{wanteds.country.name}}  </strong>
                                        </p>

                                    </div>
                                    <div class="col-md-3">
                                        <p class="cat_desc" v-if="wanteds.contact">
                                            <span>Primary Contact</span> <br>
                                            <strong>{{wanteds.contact.first_name+' '+wanteds.contact.last_name}}  </strong>
                                        </p>

                                        <p class="cat_desc" v-if="wanteds.views">
                                            <span>Views</span> <br>
                                            <strong>{{wanteds.views}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.likes">
                                            <span>Likes</span> <br>
                                            <strong>{{wanteds.likes.length}}  </strong>
                                        </p>

                                    </div>
                                    <div class="col-md-3">
                                        <p class="cat_desc">
                                            <span>Status</span> <br>
                                            <strong>{{wanteds.isActive==1?'Yes':'No'}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{wanteds.created_at | moment("DD/MM/YYYY")}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="wanteds.updated_at">
                                            <span>Date Modified</span> <br>
                                            <strong>{{wanteds.updated_at | moment("DD/MM/YYYY")}}  </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-12" v-if="wanteds.comments">
                                        <hr>
                                        <p class="cat_desc" >
                                            <span>Comments</span> <br>
                                            <strong>{{wanteds.comments}}  </strong>
                                        </p>

                                    </div>
                                  
                                </div>

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

        data() {
            return {
                wanteds:[]
            }
        },
        created(){
            this.getAircraft(this.$route.params.id.split('-')[0])
        },
        methods:{
            getAircraft(id){
                  axios.get('/user/ajax/wanted/'+ id)
                    .then(res=>{
                       this.wanteds = res.data.wanted
                })
            }
        }
        

    }
</script>

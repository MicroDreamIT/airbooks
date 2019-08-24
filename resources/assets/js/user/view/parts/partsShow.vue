<template>
    <div>
        <div class="card card-contrast custom_info">
            <div class="card-header d-flex justify-content-between flex-wrap">
                <span>{{parts.title|filterTitle}}</span>
                <div>
                    <router-link :to="{name:'userPartsEdit', params:{id:parts.id}}">
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
                                        <p class="cat_desc" v-if="parts.part_number">
                                            <span> Part Number</span> <br>
                                            <strong>{{parts.part_number}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.alternate_part_number">
                                            <span>Alternate Part Number</span> <br>
                                            <strong>{{parts.alternate_part_number}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.quantity">
                                            <span>Quantity</span> <br>
                                            <strong>{{parts.quantity}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.unit_measure">
                                            <span>Unit Measure</span> <br>
                                            <strong>{{parts.unit_measure}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.price">
                                            <span>Price</span> <br>
                                            <strong>{{parseFloat(parts.price).toFixed(2)}}  </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="cat_desc" v-if="parts.condition">
                                            <span>Condititon Name </span> <br>
                                            <strong>{{parts.condition.name}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.release">
                                            <span>Release</span> <br>
                                            <strong>{{parts.release.name}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.current_location">
                                            <span>Current Location </span> <br>
                                            <strong>{{parts.current_location.name}} </strong>
                                        </p>


                                    </div>
                                    <div class="col-md-3">
                                        <p class="cat_desc" v-if="parts.owner">
                                            <span>Owner</span> <br>
                                            <strong>{{parts.owner.name}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.seller">
                                            <span>Seller</span> <br>
                                            <strong>{{parts.seller.name}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.contact">
                                            <span>Contact</span> <br>
                                            <strong>{{parts.contact.first_name}} {{parts.contact.last_name}}</strong>
                                        </p>

                                    </div>
                                    <div class="col-md-3">
                                        <p class="cat_desc">
                                            <span>Status</span> <br>
                                            <strong>{{parts.is_active==1?'Yes':'No'}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.created_at">
                                            <span>Date Created</span> <br>
                                            <strong>{{parts.created_at | moment("DD/MM/YYYY")}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="parts.updated_at">
                                            <span>Date Modified</span> <br>
                                            <strong>{{parts.updated_at | moment("DD/MM/YYYY")}}  </strong>
                                        </p>

                                    </div>
                                    <div class="col-md-12" v-if="parts.description">
                                        <hr>
                                        <p class="cat_desc" >
                                            <span>Description</span> <br>
                                            <strong>{{parts.description}} </strong>
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
        name: "userPartsShow",
        data(){
            return {
                parts:''
            }
        },
        created(){
            this.get(this.$route.params.id)
        },


        methods:{
            get(id){
                axios.get('/user/ajax/part/'+ id)
                    .then(res=>{
                        this.parts = res.data
                    })
            }
        }
    }
</script>


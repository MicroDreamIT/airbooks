<template>
	<div>
		<div class="card card-contrast custom_info">
			<div class="card-header d-flex justify-content-between flex-wrap">
				<span>{{engine.title|filterTitle}}</span>
				<div>
					<a href="">
						<i class="mdi mdi-edit"></i>
					</a>
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

                                        <p class="cat_desc" v-if="engine.category">
                                            <span>Category </span> <br>
                                            <strong>{{engine.category.name }}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.manufacturer">
                                            <span>Manufacturer  </span> <br>
                                            <strong>{{engine.manufacturer.name }}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="engine.type">
                                            <span>Type  </span> <br>
                                            <strong>{{engine.type.name }}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.model">
                                            <span>Model  </span> <br>
                                            <strong>{{engine.model.name }}</strong>
                                        </p>

									</div>
									<div class="col-md-4">
                                        <p class="cat_desc" v-if="engine.esn">
                                            <span> ESN</span> <br>
                                            <strong>{{engine.esn}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.cycle_remaining">
                                            <span>Cycle Remaining</span> <br>
                                            <strong>{{engine.cycle_remaining}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.status">
                                            <span>Current Status</span> <br>
                                            <strong>{{engine.status}}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="engine.offer_for">
                                            <span> Offer For</span> <br>
                                            <strong>{{engine.offer_for}}  </strong>
                                        </p>

                                        <p class="cat_desc" v-if="engine.offer_for=='Sale'">
                                            <span> Price</span> <br>
                                            <strong>{{parseFloat(engine.price).toFixed(2)}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.offer_for=='Lease'">
                                            <span> Lease Terms</span> <br>
                                            <strong>{{engine.lease_terms}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.offer_for=='Exchange'">
                                            <span> Exchange Terms</span> <br>
                                            <strong>{{engine.exchange_terms}}  </strong>
                                        </p>
									</div>
									<div class="col-md-4">
                                        <p class="cat_desc" v-if="engine.availability">
                                            <span>Availability</span> <br>
                                            <strong>{{engine.availability | moment("DD/MM/YYYY")}}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.current_location">
                                            <span>Current Location</span> <br>
                                            <strong>{{engine.current_location.name}}</strong>
                                        </p>

                                        <p class="cat_desc" v-if="engine.contact">
                                            <span>Primary Contact</span> <br>
                                            <strong>
                                                {{engine.contact.fullName}}
                                            </strong>
                                        </p>

                                        <p class="cat_desc" v-if="engine.owner">
                                            <span>Owner</span> <br>
                                            <strong>{{engine.owner.name }}  </strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.seller">
                                            <span>Seller</span> <br>
                                            <strong>{{engine.seller.name }}  </strong>
                                        </p>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-4">
                                        <p class="cat_desc" v-if="engine.thrust_rating">
                                            <span>Thrust Rating</span> <br>
                                            <strong>{{engine.thrust_rating}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.lsv_description">
                                            <span>Lsv Description</span> <br>
                                            <strong>{{engine.lsv_description}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.tso">
                                            <span>tso</span> <br>
                                            <strong>{{engine.tso}}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.views">
                                            <span>Views</span> <br>
                                            <strong>{{engine.views}} </strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.likes">
                                            <span>Likes</span> <br>
                                            <strong>{{engine.likes.length}} </strong>
                                        </p>

									</div>
									<div class="col-md-4">
                                        <p class="cat_desc">
                                            <span>Promote Status</span> <br>
                                            <strong>{{engine.is_featured==1?'Yes':'No'}}</strong>
                                        </p>
                                        <p class="cat_desc">
                                            <span>Active Status</span> <br>
                                            <strong>{{engine.isActiveStatus}}</strong>
                                        </p>
                                        <p class="cat_desc">
                                            <span>Published Status</span> <br>
                                            <strong>{{engine.is_active_by_user==1?'Yes':'No'}}</strong>
                                        </p>
									</div>
									<div class="col-md-4">

                                        <p class="cat_desc" v-if="engine.created_at">
                                            <span>Date Created </span> <br>
                                            <strong>{{engine.created_at | moment("DD/MM/YYYY") }}</strong>
                                        </p>
                                        <p class="cat_desc" v-if="engine.updated_at">
                                            <span>Date Modified</span> <br>
                                            <strong>{{engine.updated_at | moment("DD/MM/YYYY") }}</strong>
                                        </p>

                                    </div>
								</div>
								<hr>
								<div class="row">

									<div class="col-md-12"v-if="engine.description">
                                        <hr>
										<p class="cat_desc" >
											<span>Description</span> <br>
											<strong>{{engine.description}}</strong>
										</p>
                                        <!--<div class="cat_desc">-->
                                        <!--<span>Status </span> <br>-->
                                        <!--<div class="switch-button switch-button-success switch-button-xs activeSwitch" >-->
                                        <!--<input type="checkbox" >-->
                                        <!--<span><label  ></label></span>-->
                                        <!--</div>-->
                                        <!--</div>-->

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
									 v-for="media in engine.medias"
									 :class="media.is_featured?'featured':'gallery'">
							</div>
						</div>
					</div>
				</div>
				<!--<div class="row">-->
				<!--<pre>{{$data}}</pre>-->
				<!--</div>-->
			</div>
		</div>


	</div>
</template>


<script>
    export default {
        name: "userEngineShow",
        data(){
            return {
                engine:{},
            }
        },
        created(){
            this.get(this.$route.params.id.split('-')[0])
        },


        methods:{
            get(id){
                axios.get('/user/ajax/engine/'+ id)
                    .then(res=>{
                        this.engine = res.data
                    })
            }
        }
    }
</script>



<template>
	<div>
		<admin-aside>
			<div slot="asideContent"></div>
				<div slot="asideMainContent">
					<div class="card-header d-flex justify-content-between flex-wrap">
						<span>Part Number - {{part.part_number}}</span>
					</div>
					<div class="card-body  card-header-contrast">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="cat_desc" v-if="part.part_number">
                                                    <span> Part Number</span> <br>
                                                    <strong>{{part.part_number}}  </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.alternate_part_number">
                                                    <span>Alternate Part Number</span> <br>
                                                    <strong>{{part.alternate_part_number}}  </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.quantity">
                                                    <span>Quantity</span> <br>
                                                    <strong>{{part.quantity}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.unit_measure">
                                                    <span>Unit Measure</span> <br>
                                                    <strong>{{part.unit_measure}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.price">
                                                    <span>Price</span> <br>
                                                    <strong>{{part.price}} </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="cat_desc" v-if="part.condition">
                                                    <span>Condititon Name </span> <br>
                                                    <strong>{{part.condition.name}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.release">
                                                    <span>Release</span> <br>
                                                    <strong>{{part.release.name}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.current_location">
                                                    <span>Current Location </span> <br>
                                                    <strong>{{part.current_location.name}} </strong>
                                                </p>


                                            </div>
                                            <div class="col-md-3">
                                                <p class="cat_desc" v-if="part.owner">
                                                    <span>Owner</span> <br>
                                                    <strong>{{part.owner.name}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.seller">
                                                    <span>Seller</span> <br>
                                                    <strong>{{part.seller.name}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.contact">
                                                    <span>Contact</span> <br>
                                                    <strong>{{part.contact.first_name}} {{part.contact.last_name}}</strong>
                                                </p>

                                            </div>
                                            <div class="col-md-3">
                                                <p class="cat_desc">
                                                    <span>Status</span> <br>
                                                    <strong>{{part.is_active==1?'Yes':'No'}} </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.created_at">
                                                    <span>Date Created</span> <br>
                                                    <strong>{{part.created_at | moment("DD/MM/YYYY")}}  </strong>
                                                </p>
                                                <p class="cat_desc" v-if="part.updated_at">
                                                    <span>Date Modified</span> <br>
                                                    <strong>{{part.updated_at | moment("DD/MM/YYYY")}}  </strong>
                                                </p>

                                            </div>
                                            <div class="col-md-12" v-if="part.description">
                                                <hr>
                                                <p class="cat_desc" >
                                                    <span>Description</span> <br>
                                                    <strong>{{part.description}} </strong>
                                                </p>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
						 
						</div>
					</div>
				<!--<pre>-->
						<!--{{part}}-->
				<!--</pre>-->
			</div>
		</admin-aside>
	
	</div>
</template>

<script>
    export default {
        name: "userApuShow",
        data(){
            return {
                part: {},
            }
        },
        created(){
            this.get(this.$route.params.id)
        },


        methods:{
            get(id){
                axios.get('/user/ajax/part/'+ id)
                    .then(res=>{
                        this.part = res.data
                    })
            }
        }
    }
</script>


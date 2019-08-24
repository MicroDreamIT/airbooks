<template>
	<div>
		<admin-aside>
			<div slot="asideContent"></div>
			<div slot="asideMainContent">
				<div class="card-header d-flex justify-content-between flex-wrap">
					<span>{{wanted.title|filterTitle}}</span>

				</div>
				<div class="card-body  card-header-contrast">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p class="cat_desc" v-if="wanted.type">
                                                <span>Wanted Type  </span> <br>
                                                <strong class='capitalize'>{{wanted.type}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.manufacturer && wanted.type!='part'">
                                                <span>Manufacturer  </span> <br>
                                                <strong>{{wanted.manufacturer.name}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.typed && wanted.type!='part'">
                                                <span>Type  </span> <br>
                                                <strong>{{wanted.typed.name}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.modeled && wanted.type!='part'">
                                                <span>Model  </span> <br>
                                                <strong>{{wanted.modeled.name}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.part_number">
                                                <span> Part Number</span> <br>
                                                <strong>{{wanted.part_number}}  </strong>
                                            </p>

                                        </div>
                                        <div class="col-md-3">

                                            <p class="cat_desc" v-if="wanted.yom">
                                                <span>YOM</span> <br>
                                                <strong>{{wanted.yom|moment('Y')}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.terms">
                                                <span>Terms</span> <br>
                                                <strong>{{wanted.terms}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.wanted_by">
                                                <span>Wanted By</span> <br>
                                                <strong>{{$root.parseDate(wanted.wanted_by)}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.country">
                                                <span>Location</span> <br>
                                                <strong>{{wanted.country.name}}  </strong>
                                            </p>

                                        </div>
                                        <div class="col-md-3">
                                            <p class="cat_desc" v-if="wanted.contact">
                                                <span>Primary Contact</span> <br>
                                                <strong>{{wanted.contact.first_name+' '+wanted.contact.last_name}}  </strong>
                                            </p>

                                            <p class="cat_desc" v-if="wanted.views">
                                                <span>Views</span> <br>
                                                <strong>{{wanted.views}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.likes">
                                                <span>Likes</span> <br>
                                                <strong>{{wanted.likes.length}}  </strong>
                                            </p>

                                        </div>
                                        <div class="col-md-3">
                                            <p class="cat_desc">
                                                <span>Status</span> <br>
                                                <strong>{{wanted.isActive==1?'Yes':'No'}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.created_at">
                                                <span>Date Created </span> <br>
                                                <strong>{{wanted.created_at | moment("DD/MM/YYYY")}}  </strong>
                                            </p>
                                            <p class="cat_desc" v-if="wanted.updated_at">
                                                <span>Date Modified</span> <br>
                                                <strong>{{wanted.updated_at | moment("DD/MM/YYYY")}}  </strong>
                                            </p>
                                        </div>
                                        <div class="col-md-12" v-if="wanted.comments">
                                            <hr>
                                            <p class="cat_desc" >
                                                <span>Comments</span> <br>
                                                <strong>{{wanted.comments}}  </strong>
                                            </p>

                                        </div>

                                    </div>
								</div>
							</div>
						</div>
					
					</div>
				</div>
				<!--<pre>-->
				   <!--{{wanted}}-->
				<!--</pre>-->
			</div>
		</admin-aside>
	
	</div>
</template>

<script>
    export default {
        name: "wantedAssetShow",
        data(){
            return {
                wanted: {},
            }
        },
        created(){
          this.get(this.$route.params.id)
        },


        methods:{
            get(id){
                axios.get('/user/ajax/wanted/'+ id)
                    .then(res=>{
                        this.wanted = res.data.wanted
                    })
            }
        }
    }
</script>



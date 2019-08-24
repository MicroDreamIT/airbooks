<template>
	<div v-if="checkMedia">
		<div class="card card-border-color card-border-color-primary">
			<div class="card-header card-header-divider">
				Account Setting
				<span class="float-right">
					<router-link :to="{name:'accountSettingEdit'}" >
                          <i class="mdi mdi-edit"></i>
                    </router-link>
			    </span>
				<span class="float-right">
					<router-link :to="{name:'resetAccountPassword'}" class="btn btn-sm btn-info text-white mr-2">Update Password</router-link>
				</span>
			</div>
			<div class="card-body">
				<form>
					<div class="controls">
						<div class="row">
							<div class="col-md-3">
								<div class="h-100 w-100 d-flex flex-column justify-content-start align-items-center">
									<br>
									<div class="user-profile"
                                         :style=" {'background': profile_photo?
                                                 'url(' + profile_photo + ')' :
                                                 'url(/siddiqueAssets/images/Airbook-User-Icon.svg)'} ">
									</div>
									<!--<p>-->
										<!--<input type="file" id="user-profile" name="profile_photo" class="d-none"> <label-->
											<!--for="user-profile" class="user-profile-button"> upload photo </label>-->
									<!--</p>-->
								</div>
							</div>
							<div class="col-md-9">
								<div class="card">
									<div class="card-body">
										 <div class="row">
											 <div class="col-md-4 w-100">
												 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.fullName')">
													 <span>Name</span> <br>
													 <strong class="own-capitalize">
                                                         {{$root.$data.user.contact.title+' '
                                                     +$root.$data.user.contact.fullName}} </strong>
												 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.gender')">
                                                     <span>Gender</span> <br>
                                                     <strong class="own-capitalize">
                                                         {{$root.$data.user.contact.gender}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.birthday')">
                                                     <span>Birthday</span> <br>
                                                     <strong>
                                                         {{$root.$data.user.contact.birthday}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.religion')">
                                                     <span>Religion </span> <br>
                                                     <strong class="own-capitalize">{{$root.$data.user.contact.religion}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.is_primary')">
                                                     <span>Primary Status </span> <br>
                                                     <strong>{{$root.$data.user.contact.is_primary==1?'Yes':'No'}}</strong>
                                                 </p>

												 
											 </div>
											 <div class="col-md-4 w-100">
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.company.name')">
                                                     <span>Company</span> <br>
                                                     <strong>
                                                         {{$root.$data.user.contact.company.name}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.job_title.name')">
                                                     <span>Job Title</span> <br>
                                                     <strong>
                                                         {{$root.$data.user.contact.job_title.name}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.department.name')">
                                                     <span>Department</span> <br>
                                                     <strong>
                                                         {{$root.$data.user.contact.department.name}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.mobile_phone')">
                                                     <span>Mobile Phone </span> <br>
                                                     <strong >
                                                         {{$root.$data.user.contact.mobile_phone}}
                                                     </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.business_phone')">
                                                     <span>Business Phone </span> <br>
                                                     <strong >
                                                         {{$root.$data.user.contact.business_phone}} </strong>
                                                 </p>
                                                 <p class="cat_desc"  v-if="_.has($root.$data.user,'contact.skype')">
                                                     <span>Skype </span> <br>
                                                     <strong>{{$root.$data.user.contact.skype}} </strong>
                                                 </p>
                                                 <p class="cat_desc"  v-if="_.has($root.$data.user,'contact.linkedin')">
                                                     <span>Linkedin </span> <br>
                                                     <strong>{{$root.$data.user.contact.linkedin}} </strong>
                                                 </p>


											 </div>
											 <div class="col-md-4 w-100">
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.country.name')">
                                                     <span>Country </span> <br>
                                                     <strong>{{$root.$data.user.contact.country.name}}</strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.city.name')">
                                                     <span>City </span> <br>
                                                     <strong>{{$root.$data.user.contact.city.name}} </strong>
                                                 </p>
                                                 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.state.name')">
                                                     <span>State </span> <br>
                                                     <strong>{{$root.$data.user.contact.state.name}} </strong>
                                                 </p>
												 <p class="cat_desc" v-if="_.has($root.$data.user,'contact.address')">
													 <span>Address </span> <br>
													 <strong>{{$root.$data.user.contact.address}}</strong>
												 </p>
                                                 <p class="cat_desc"  v-if="_.has($root.$data.user,'contact.preferred_contact_method')">
                                                     <span>Preferred Contact Method </span> <br>
                                                     <strong>{{$root.$data.user.contact.preferred_contact_method}} </strong>
                                                 </p>


											 </div>
										 </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        data(){
            return{
                profile_photo:''
            }
        },

        computed:{
            _(){
                return _;
            },
            checkMedia(){
                if(this.$root.$data.user.contact){
                    if(this.$root.$data.user.contact.medias){
                        let media=this.$root.$data.user.contact.medias
                        this.profile_photo= '/storage/'+media.path+'/'+media.original_file_name
                    }
                    return true
                }
            }
        },
        methods:{

        }
    }
</script>

<style scoped>

</style>

<template>
	<div v-if="checkContact">
		<div class="card card-border-color card-border-color-primary">
			<div class="card-header card-header-divider">Edit Account Settings </div>
			<div class="card-body">
				<form @submit.prevent="patchContact('contact')" data-vv-scope="contact">
					<div class="controls">
						<div class="row">
							 <div class="col-md-3">
								 <div class="h-100 w-100 d-flex flex-column justify-content-start align-items-center">
									 <br>
									     <div
											     class="user-profile"
                                                 :style=" {'background': profile_photo?
                                                 'url(' + profile_photo + ')' :
                                                 'url(/siddiqueAssets/images/Airbook-User-Icon.svg)'} ">
									     </div>
									 <p>
                                         <input type="file"
                                                class="d-none"
                                                id="user-profile"
                                                name="profile_photo"
                                                @change="insertImage">
										 <label for="user-profile"
										        class="user-profile-button"
										 > upload photo </label>
									 </p>
								 </div>
							 </div>
							 <div class="col-md-9">
								 <h4>Personal Information</h4>
								 <hr>
								 <div class="row">
									 <div class="col-md-4">
										 <div class="form-group">
											 <label>Title</label>
                                             <v-select
                                                     v-model="contact.title"
                                                     :options="['Mr','Mrs','Ms']"
                                                     name="title"
                                                     :class="{ 'is-danger': errors.has('contact.title') }"
                                             >
                                             </v-select>
										 </div>
                                         <!--<div class="form-group">-->
                                             <!--<label for="email">Email *</label>-->
                                             <!--<input id="email" v-model="contact.email" type="email" name="email"-->
                                                    <!--:class="{'form-control': true, 'is-danger': errors.has('contact.email') }"-->
                                                    <!--data-error="email is required."-->
                                                    <!--v-validate="'required|email'"-->
                                             <!--&gt;-->
                                             <!--<div-->
                                                     <!--v-show="errors.has('contact.email')"-->
                                                     <!--class="help is-danger">-->
                                                 <!--{{ errors.first('contact.email') }}-->
                                             <!--</div>-->
                                         <!--</div>-->
                                         <div class="form-group">
                                             <label>
                                                 Gender
                                             </label>
                                             <v-select
                                                     v-model="contact.gender"
                                                     :options="['Male','Female']"
                                                     name="gender"
                                                     :class="{'is-danger': errors.has('contact.title') }"
                                                     v-validate="'required'"
                                             >
                                             </v-select>
                                             <div v-show="errors.has('contact.gender')"
                                                  class="help is-danger">
                                                 {{ errors.first('contact.gender') }}
                                             </div>
                                         </div>
									 </div>
									 <div class="col-md-4">
                                         <div class="form-group">
                                             <label for="first_name">First Name *</label>
                                             <input id="first_name"
                                                    v-model="contact.first_name"
                                                    type="text"
                                                    name="first_name"
                                                    :class="{
                                               'form-control': true,
                                               'is-danger': errors.has('contact.first_name')
                                           }"
                                                    data-error="first name is required."
                                                    v-validate="'required'"
                                             >
                                             <div v-show="errors.has('contact.first_name')"
                                                  class="help is-danger">
                                                 {{ _.replace( _.replace(errors.first('contact.first_name'), '_', ' ') , '_', ' ') }}
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label>
                                                 Birthday
                                             </label>
                                             <input :class="{'form-control': true, 'is-danger':birthDayErrorMessage }"
                                                    type="text"
                                                    name="birthday"
                                                    v-mask="'99-99'"
                                                    id="birthday"
                                                    v-model="contact.birthday"
                                                    placeholder="DD/MM">

                                             <span class="help is-danger">{{birthdayValidation}}{{birthDayErrorMessage}}</span>
                                         </div>
									 </div>
									 <div class="col-md-4">
										 <div class="form-group">
                                             <label for="last_name">Last Name *</label>
                                             <input id="last_name"
                                                    v-model="contact.last_name"
                                                    type="text"
                                                    name="last_name"
                                                    :class="{'form-control': true, 'is-danger': errors.has('contact.last_name') }"
                                                    data-error="last name is required."
                                                    v-validate="'required'"
                                             >
                                             <div v-show="errors.has('contact.last_name')" class="help is-danger">
                                                 {{ _.replace(errors.first('contact.last_name'), '_', ' ') }}
                                             </div>
										 </div>

									 </div>
								 </div>
								 <h4>Company Info</h4>
								 <hr>
								 <div class="row">
                                     <div class="col-md-4">
                                         <div class="form-group">
                                             <label>
                                                 Job Title
                                             </label>
                                             <v-select
                                                     name="job_title"
                                                     v-model="contact.job_title"
                                                     :options="job_titles"
                                                     label="name"
                                             >
                                             </v-select>
                                         </div>
                                     </div>
									 <div class="col-md-4">
                                         <div class="form-group">
                                             <label>
                                                 Company Name
                                             </label>
                                             <v-select
                                                     label="name"
                                                     name="company"
                                                     v-model="contact.company"
                                                     :options="this.companies"
                                                     :class="{'is-danger': errors.has('contact.company') }"
                                             >
                                             </v-select>
                                         </div>

									 </div>
									 <div class="col-md-4">
                                         <div class="form-group">
                                             <label>
                                                 Department
                                             </label>
                                             <v-select
                                                     label="name"
                                                     name="department"
                                                     v-model="contact.department"
                                                     :options="departments"
                                             >
                                             </v-select>
                                         </div>
									 </div>
									 
								 </div>
							 </div>
						</div>
						<div class="col-md-12">
							<h4>Address Information</h4> <hr> <br>
							<div class="row">
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" v-model="contact.address" class="form-control"
                                               :class="{'form-control': true, 'is-danger': errors.has('contact.address') }"
                                               data-error="last name is required."
                                               name="address"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Business phone
                                        </label>
                                        <input type="number" class="form-control" v-model="contact.business_phone">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Linkedin
                                        </label>
                                        <input type="text" class="form-control" v-model="contact.linkedin">
                                    </div>
								</div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            Country*
                                        </label>
                                        <v-select
                                                label="name"
                                                v-model="contact.country"
                                                :options="this.countries"
                                                name="country"
                                                @input="getState()"
                                                :class="{'is-danger': errors.has('contact.country') }"
                                                v-validate="'required'">
                                        </v-select>
                                        <div v-show="errors.has('contact.country')"
                                             class="help is-danger">
                                            {{ errors.first('contact.country') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Mobile Phone
                                        </label>
                                        <input type="number" class="form-control" v-model="contact.mobile_phone">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Religion
                                        </label>
                                        <v-select
                                                name="religion"
                                                :options="[
                                                'Islam',
                                                'Judaism',
                                                'Christianity',
                                                'Hinduism',
                                                'Buddhism',
                                                'Sikhism',
                                                'Confucianism',
                                                'Shinto',
                                                'Taoism',
                                                'Other'
                                            ]"
                                                v-model="contact.religion"
                                                :class="{'is-danger': errors.has('contact.religion') }"
                                        >
                                        </v-select>
                                        <div v-show="errors.has('contact.religion')"
                                             class="help is-danger">
                                            {{ errors.first('contact.religion') }}
                                        </div>

                                    </div>
								</div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            State
                                        </label>
                                        <v-select
                                                label="name"
                                                v-model="contact.state"
                                                :options="this.states" name="state"
                                                @input="getCity()"
                                        >
                                        </v-select>

                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Preferred contact method
                                        </label>

                                        <v-select
                                                label="name"
                                                name="preferred_contact_method"
                                                v-model="contact.preferred_contact_method"
                                                :options="[
                                                'Email',
                                                'Phone',
                                                'Both'
                                            ]"

                                                :class="{'is-danger': errors.has('contact.preferred_contact_method') }"
                                        >
                                        </v-select>
                                        <div v-show="errors.has('contact.preferred_contact_method')"
                                             class="help is-danger">
                                            {{ errors.first('contact.preferred_contact_method') }}
                                        </div>
                                    </div>
								</div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label>
                                            City
                                        </label>
                                        <v-select
                                                label="name"
                                                v-model="contact.city"
                                                :options="this.cities"
                                                name="city"
                                                :class="{'is-danger': errors.has('contact.city') }"
                                        >
                                        </v-select>

                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Skype
                                        </label>
                                        <input type="text" class="form-control" v-model="contact.skype">
                                    </div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="col-md-6 row">
                                <div class="form-group">

                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input :class="contact.is_primary ?'custom-control-input is-valid': 'custom-control-input is-invalid'" type="checkbox" v-model="contact.is_primary" :checked="false">
                                        <span class="custom-control-label custom-control-color">Primary</span>
                                    </label>

                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input :class="contact.is_public ?'custom-control-input is-valid': 'custom-control-input is-invalid'" type="checkbox" v-model="contact.is_public" :checked="false">
                                        <span class="custom-control-label custom-control-color">Public</span>
                                    </label>

                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input :class="contact.is_published ?'custom-control-input is-valid': 'custom-control-input is-invalid'" type="checkbox" v-model="contact.is_published" :checked="false">
                                        <span class="custom-control-label custom-control-color">Published</span>
                                    </label>

                                </div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-lg-start">
                                    <button class="btn btn-space btn-primary "
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-save"></i>  Update
                                    </button>
                                    <button class="btn btn-space btn-danger "
                                            :disabled="buttonDisabled"
                                            @click.prevent="cancel"
                                    >
                                        <i class="icon mdi mdi-close"></i> Cancel
                                    </button>
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
    export  default {
        data(){
            return{
                contact:{
                    city:{
                        name:null,
                        state:{
                            name:null,
                            country:{
                                name:null
                            }
                        }
                    },
                },
                buttonDisabled:false,
                departments:[],
                job_titles:[],
                companies:[],
                countries:[],
                states:[],
                cities:[],
                selected:{},
                files: [],
                monthValue:0,
                dayValue:0,
                sCount:0,
                cCount:0,
                birthDayErrorMessage:'',
                profile_photo:'',


            }
        },
        computed:{
            checkContact(){
                if(this.$root.$data.user.id){
                    this.contact=this.$root.$data.user.contact
                    if(this.$root.$data.user.contact.medias){
                        let media=this.$root.$data.user.contact.medias
                        this.profile_photo= '/storage/'+media.path+'/'+media.original_file_name
                    }
                    return true
                }

            },
            _(){
                return _;
            },
            birthdayValidation(){

                if(this.contact.birthday){
                    this.dayValue = this.contact.birthday.replace('_','').slice(0,2).replace('-','')
                    this.monthValue = this.contact.birthday.replace('_','').slice(3,5).replace('-','')
                    if(this.monthValue>12 || this.dayValue>31){
                        this.birthDayErrorMessage='Day must be 1-31 and Month must be 1-12'
                    }else{
                        this.birthDayErrorMessage=''
                    }
                }


            },
        },

        created(){

            axios.get('/admin/contacts/create').then(res=>{
                this.departments=res.data.departments
                this.job_titles=res.data.titles
                this.companies = res.data.companies
            })

            axios.get('/countries').then(res=>{
                this.countries = res.data
            })
        },
        mounted(){

            this.contact.preferred_contact_method = 'Both'

        },
        methods:{
            cancel(){
                this.$router.push({path:'/admin/contacts'})
            },
            saveAndClose(){
                let val='redirect';
                this.postContact('contact',val)
            },
            addingEvent(file) {
                this.files.push(file)
            },

            removeFile(file, error, xhr) {
                this.files = this.files.filter(function (item) {
                    return item.name != file.name
                });
                if (file.manuallyAdded) {
                    file.requested=true
                    this.manualRemoveFiles.push(file)
                }
            },

            getState(){
                if(this.sCount>0){
                    this.contact.state = null
                    this.contact.city = null
                }
                if(this.contact.country){
                    axios.get('/getStateNameByCountry',{
                        params:{
                            country_id:this.contact.country.id
                        }
                    }).then(res=>{
                        this.states=res.data
                    })
                }
                this.sCount++
            },

            getCity(){
                if(this.contact.state){
                    if(this.cCount>0) {
                        this.contact.city = null
                    }
                    axios.get('/getCityNameByState',{
                        params:{
                            state_id:this.contact.state.id
                        }
                    }).then(res=>{
                        this.cities=res.data
                    })
                    this.cCount++
                }
            },
            cancel(){
                this.$router.push({path:'/admin/account-setting'})
            },
            insertImage(e){
                this.profile_photo = e.target.files[0]
                this.profile_photo = URL.createObjectURL(this.profile_photo)

            },

            patchContact(scope, val=null){
                this.$validator.validateAll(scope).then((result)=>{
                    if(result){
                        this.buttonDisabled=true
                        if(this.monthValue>12 || this.dayValue>31) {
                            return false
                        }
                        var data = new FormData()
                        var imagefile = document.querySelector('#user-profile')
                        data.append("file", imagefile.files[0])
                        data.append('contact',JSON.stringify(this.contact))

                        axios.post('/admin/account-setting',data,{
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(res=>{
                            this.$root.successMessage(res.data)
                            this.buttonDisabled=false
                            this.$validator.reset()
                            this.$router.push({path:'/admin/dashboard'})
                            window.location = window.location
                        }).catch(error=>{
                            this.buttonDisabled=false
                            if(error.response){
                                let err;
                                let errs = error.response.data.errors
                                for (err in errs){
                                    this.errors.add({
                                        'field':err,
                                        'msg':errs[err][0],
                                        'scope':'contact'
                                    })
                                }
                            }

                        })
                    }
                })
            }
        }
    }
</script>

<template>
	<div>
		<div class="row">
			<div class="col-md-12">
				<div class="card card-border-color card-border-color-primary">
					<div class="card-header card-header-divider">
						Update Password
					</div>
					<div class="card-body">
						<div class="col-md-7 mx-auto pt-3 pb-3">
							<form @submit.prevent="postReset">
								<div class="form-group">
									<label class="font-weight-bold">Current Password</label>
                                    <input
                                           v-model="current_password"
                                           type="password"
                                           name="current_password"
                                           :class="{'form-control': true, 'is-danger': errors.has('current_password') }"
                                           placeholder="Current password"
                                           v-validate="'required|min:6'"
                                    >
                                    <div v-show="errors.has('current_password')" class="help is-danger">
                                        {{ errors.first('current_password')|removeUnderScore }}
                                    </div>
								</div>
								<div class="form-group">
									<label class="font-weight-bold">New Password</label>
									<input type="password"
                                           v-model="new_password"
                                           name="new_password"
                                           :class="{'form-control': true, 'is-danger': errors.has('new_password') }"
                                           v-validate="'required|min:6'"
									       placeholder="New password">
                                    <div v-show="errors.has('new_password')" class="help is-danger">
                                        {{ errors.first('new_password')|removeUnderScore }}
                                    </div>
								</div>
								<button type="submit" class="btn btn-primary">Update</button>
                                <button type="submit" class="btn btn-danger" @click.prevent="cancel">Cancel</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    export default {

        data(){
            return{
                sError:{},
                new_password:null,
                current_password:null,
            }
        },
        methods:{

            postReset(){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        this.buttonDisabled=true
                        axios.post('/admin/update-password',{
                            new_password:this.new_password,
                            current_password:this.current_password,
                        }).then(response=>{
                            this.new_password = null
                            this.current_password = null
                            this.buttonDisabled=false
                            this.$validator.reset()
                            this.$root.successMessage(response.data)
                            if(response.data.type=='success'){
                                this.$router.push({path:'/admin/dashboard'})
                            }


                        }).catch(error=>{
                            this.buttonDisabled=false
                            if(error.response.status===413){
                                this.$root.successMessage({type:'danger', message:error.message})
                            }
                            let err
                            let errs = error.response.data.errors
                            for (err in errs){
                                this.errors.add({
                                    'field':err,
                                    'msg':errs[err][0]
                                })
                            }
                        })
                    }
                })
            },
            cancel(){
                this.$router.push({path:'/admin/account-setting'})
            }

        }
    }
</script>

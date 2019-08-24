<template>
    <div v-if="getUser">
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Account Setting</div>
            <div class="card-body">
                <form @submit.prevent="postAccountSetting">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                               <div class="h-100 w-100 d-flex flex-column justify-content-start align-items-center"><br>

                                   <div class="user-profile"
                                        :style=" {'background': profile_photo? 'url(' + profile_photo + ')' : 'url(/siddiqueAssets/images/Airbook-User-Icon.svg)'} ">
                                   
                                   </div>
                                   <p >
                                       <input type="file" class="d-none" id="user-profile" name="profile_photo" @change="insertImage">
                                       <label for="user-profile" class="user-profile-button"> upload photo </label>
                                   </p>
                                   
                               </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="frist_name">First Name </label>
                                            <input id="frist_name" v-model="setting.first_name" type="text" name="first_name"
                                                   :class="{'form-control': true, 'is-danger': errors.has('first_name') }"
                                                   v-validate="'required'"
                                            >
                                            <div v-show="errors.has('first_name')" class="help is-danger">
                                                {{ errors.first('first_name')|removeUnderScore }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name </label>
                                            <input id="last_name" v-model="setting.last_name" type="text" name="last_name"
                                                   :class="{'form-control': true, 'is-danger': errors.has('last_name') }"
                                                   v-validate="'required'"
                                            >
                                            <div v-show="errors.has('last_name')" class="help is-danger">
                                                {{ errors.first('last_name')|removeUnderScore}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email </label>
                                            <input id="email" v-model="setting.email" type="text" name="email"
                                                   :class="{'form-control': true, 'is-danger': errors.has('email') }"
                                                   disabled
                                                   v-validate="'required'"
                                            >
                                            <div v-show="errors.has('email')" class="help is-danger">
                                                {{ errors.first('email') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="current_password">Current Password </label>
                                            <input id="current_password" v-model="setting.current_password" type="password"
                                                   name="current_password"
                                                   :class="{'form-control': true, 'is-danger': errors.has('current_password') }"
                                                   v-validate="setting.new_password?'required|min:6':null"
                                            >
                                            <div v-show="errors.has('current_password')" class="help is-danger">
                                                {{ errors.first('current_password')|removeUnderScore }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="new_password">New Password </label>
                                            <input id="new_password" v-model="setting.new_password" type="password"
                                                   name="new_password"
                                                   :class="{'form-control': true, 'is-danger': errors.has('new_password') }"
                                                   v-validate="'min:6'"
                                            >
                                            <div v-show="errors.has('new_password')" class="help is-danger">
                                                {{ errors.first('new_password')|removeUnderScore }}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-start flex-wrap">
                                            <button class="btn btn-space btn-primary pl-4 pr-4"
                                                    type="submit"
                                                    :disabled="buttonDisabled"
                                            >
                                                <i class="icon mdi mdi-refresh-sync"></i>Update
                                            </button>
                                            <button class="btn btn-space btn-danger pl-4 pr-4"
                                                    :disabled="buttonDisabled"
                                                    @click.prevent="cancel"
                                            >
                                                <i class="icon mdi mdi-close"></i> Cancel
                                            </button>
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

        data() {
            return {
                sError: {},
                setting: {
                    email:'',
                    first_name:'',
                    last_name:'',
                },
                profile_photo:'',
                buttonDisabled: false,
            }
        },
        computed:{
            getUser(){
                if(this.$root.$data.user){
                    this.setting.email=this.$root.$data.user.email
                    if(this.$root.$data.user.contact){
                        this.setting.first_name=this.$root.$data.user.contact.first_name
                        this.setting.last_name=this.$root.$data.user.contact.last_name
                        if(this.$root.$data.user.contact.medias){
                            let media=this.$root.$data.user.contact.medias
                            this.profile_photo= '/storage/'+media.path+'/'+media.original_file_name
                        }

                    }
                }
                return true

            }
        },

        methods: {
            postAccountSetting(val) {
                this.$validator.validateAll().then((result) => {
                    this.buttonDisabled = true
                    if (result) {
                        var data = new FormData()
                        var imagefile = document.querySelector('#user-profile')
                        data.append("file", imagefile.files[0])
                        data.append('setting',JSON.stringify(this.setting))
                        axios.post('/user/ajax/profile-setting',data,{
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(response => {
                            this.setting.current_password=null,
                            this.setting.new_password=null,
                            this.$root.successMessage(response.data),
                            this.buttonDisabled = false
                            window.location = window.location
                            this.$validator.reset()
                        }).catch(error => {
                            let err
                            let errs = error.response.data.errors
                            for (err in errs) {
                                this.errors.add({
                                    'field': err,
                                    'msg': errs[err][0]
                                })
                            }
                        })
                    }
                })
            },
            insertImage(e){
                this.profile_photo = e.target.files[0]
                this.profile_photo = URL.createObjectURL(this.profile_photo)

            },
            cancel(){
                this.$router.push({name:'userDashboard'})
            }
        }
    }
</script>

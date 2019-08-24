<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Role & Permission</div>
            <div class="card-body">
                <form @submit.prevent="postRoleAndPermission">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub-Admins *</label>
                                    <v-select
                                            v-model="user"
                                            :options="users"
                                            :get-option-label="$root.getFullName"
                                            label="first_name"
                                            name="user"
                                            :class="{ 'is-danger': errors.has('user') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('user')" class="help is-danger">
                                        {{ errors.first('user') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group fixHeight">
                                    <label>Permission *</label>
                                    <v-select
                                            v-model="permission"
                                            :options="permissions"
                                            label="name"
                                            name="permission"
                                            :class="{ 'is-danger': errors.has('permission') }"
                                            v-validate="'required|min:2'"
                                            multiple
                                    >
                                    </v-select>
                                    <div v-show="errors.has('permission')" class="help is-danger">
                                        {{ errors.first('permission') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-start flex-wrap">
                                    <button class="btn btn-space btn-primary pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                            @click.prevent="saveAndClose"
                                    >
                                        <i class="icon mdi mdi-save"></i> Save & Close
                                    </button>
                                    <button class="btn btn-space btn-success pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-refresh-sync"></i> Save & New
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
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                sError:{},
                user:null,
                permission:null,
                users:[],
                permissions:[],
                buttonDisabled:false,
                image:[]
            }
        },
        created(){
          this.getData();
        },
        methods:{
            getData(){
              axios.get('/admin/role-permission/create').then(response=>{
                  this.users=response.data.users,
                      this.permissions=response.data.permissions
              })
            },
            postRoleAndPermission(val){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.post('/admin/role-permission',{
                            user:this.user,
                            permission:this.permission,
                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data)
                            this.user = null
                            this.permission = null
                            this.buttonDisabled=false
                            val==='redirect'?this.$router.push({path:'/admin/role-permission'}):''
                            this.$validator.reset()
                        }).catch(error=>{
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
            saveAndClose(){
                let val='redirect';
                this.postConfiguration(val)
            },
            cancel(){
                this.$router.push({path:'/admin/role-permission'})
            }
        }
    }
</script>

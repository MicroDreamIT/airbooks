<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Role & Permission</div>
            <div class="card-body">
                <form @submit.prevent="updateRoleAndPermission">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub-Admin *</label>
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
            this.getData(this.$route.params.id);
        },
        methods:{
            getData(id){
                axios.get('/admin/role-permission/'+id+'/edit').then(response=>{
                        this.permissions=response.data.permissions
                    this.user=response.data.users
                    this.permission=response.data.permission[0].id!=null?response.data.permission:[]
                })
            },
            updateRoleAndPermission(val){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.patch('/admin/role-permission/'+this.$route.params.id,{
                            user:this.user,
                            permission:this.permission,
                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data)
                            this.buttonDisabled=false
                            this.$router.push({path:'/admin/role-permission'})
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
            cancel(){
                this.$router.push({path:'/admin/role-permission'})
            }
        }
    }
</script>

<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Admin User</div>
            <div class="card-body">
                <form @submit.prevent="postAdminUser">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >First Name *</label>
                                    <input  v-model="adminUser.first_name" type="text" name="first_name"
                                           :class="{'form-control': true, 'is-danger': errors.has('first_name') }"
                                           data-error="Name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('first_name')" class="help is-danger">
                                        {{ errors.first('first_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name *</label>
                                    <input v-model="adminUser.last_name" type="text" name="last_name"
                                           :class="{'form-control': true, 'is-danger': errors.has('last_name') }"
                                           data-error="Name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('last_name')" class="help is-danger">
                                        {{ errors.first('last_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input v-model="adminUser.email" type="email" name="email"
                                           :class="{'form-control': true, 'is-danger': errors.has('email') }"
                                           data-error="Name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('email')" class="help is-danger">
                                        {{ errors.first('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Company *</label>
                                    <v-select
                                            v-model="adminUser.company"
                                            :options="companies"
                                            label="name"
                                            name="comapny"
                                            :class="{ 'is-danger': errors.has('company') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('company')" class="help is-danger">
                                        {{ errors.first('company') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Permission*</label>
                                    <v-select
                                            v-model="adminUser.permission"
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input v-model="adminUser.password" type="password" name="password"
                                           :class="{'form-control': true, 'is-danger': errors.has('password') }"
                                           data-error="Name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('password')" class="help is-danger">
                                        {{ errors.first('password') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-check mt-1">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="adminUser.is_active"
                                           name="is_active"
                                           :value="1">
                                    <span class="custom-control-label">
                                        Publish
                                    </span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="adminUser.is_active"
                                           name="is_active"
                                           :value="0">
                                    <span class="custom-control-label">
                                        Inactive
                                    </span>
                                </label>

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

        data() {
            return {
                sError: {},
                adminUser:{
                    is_active:1
                },
                permissions:[],
                companies:[],
                buttonDisabled: false,

            }
        },
        created(){
            axios.get('/admin/admin-user/create').then(response=>{
                this.permissions=response.data.permissions
                this.companies=response.data.companies
            })
        },
        methods: {

            postAdminUser(val) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.buttonDisabled = true
                        axios.post('/admin/admin-user', this.adminUser).then(response => {

                            this.$root.successMessage(response.data),
                               this.adminUser={
                                    is_active:1
                               }
                            this.buttonDisabled = false
                            this.$validator.reset()
                            val==='redirect'?this.$router.push({path:'/admin/admin-user'}):''
                        }).catch(error => {
                            this.buttonDisabled=false

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
            saveAndClose(){
                let val='redirect';
                this.postAdminUser(val)
            },
            cancel(){
                this.$router.push({path:'/admin/admin-user'})
            }
        }
    }
</script>

<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Configuration</div>
            <div class="card-body">
                <form @submit.prevent="postConfiguration">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input id="name" v-model="name" type="text" name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           data-error="name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-check mt-1">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="is_active"
                                           name="is_active"
                                           :value="1">
                                    <span class="custom-control-label">
                                        Publish
                                    </span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="is_active"
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

        data(){
            return{
                sError:{},
                name:null,
                is_active:1,
                buttonDisabled:false,
                image:[]
            }
        },
        methods:{

            postConfiguration(val){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.post('/admin/configuration',{
                            name:this.name,
                            is_active:this.is_active
                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data)
                            this.name = null
                            this.is_active = 1
                            this.buttonDisabled=false
                            val==='redirect'?this.$router.push({path:'/admin/aircraft/configuration'}):''
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
                this.$router.push({path:'/admin/aircraft/configuration'})
            }
        }
    }
</script>

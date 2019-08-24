<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Part Condition</div>
            <div class="card-body">
                <form @submit.prevent="updateCondition">
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
                                    >
                                        <i class="icon mdi mdi-save"></i> Update & Close
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
                typeList:null,
                is_active:true,
                buttonDisabled:false
            }
        },
        created(){
            this.show(this.$route.params.id)
        },
        methods:{
            show(id){

                axios.get('/admin/parts/condition/'+id+'/edit').then(response=>{
                    this.name = response.data.name
                    this.is_active = response.data.is_active
                })
            },
            cancel(){
                this.$router.push({path:'/admin/parts/condition'})
            },
            updateCondition(){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.patch('/admin/parts/condition/'+this.$route.params.id,{
                            name:this.name,
                            is_active:this.is_active
                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data.message)
                            this.buttonDisabled=false
                            this.$validator.reset()
                            this.$router.push({path:response.data.redirection})
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
            }
        }
    }
</script>

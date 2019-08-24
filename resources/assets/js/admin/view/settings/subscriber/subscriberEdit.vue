<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Subscriber</div>
            <div class="card-body">
                <form @submit.prevent="updateSubscriber">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input v-model="name" type="text" name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           data-error="Name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input  v-model="email" type="text" name="email"
                                            :class="{'form-control': true, 'is-danger': errors.has('email')}"
                                            v-validate="'required|email'"
                                    >
                                    <div v-show="errors.has('email')" class="help is-danger">
                                        {{ errors.first('email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Comments</label>
                                    <textarea class="form-control" v-model="comments" rows="6"></textarea>
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

        data() {
            return {
                sError: {},
                name:null,
                email:null,
                comments:null,
                is_active: 1,
                buttonDisabled: false,
            }
        },
        created(){
            this.edit(this.$route.params.id)
        },
        methods: {
            edit(id){
                axios.get('/admin/setting/subscriber/'+id+'/edit').then(response=>{
                    this.name=response.data.subscriber.name
                    this.email=response.data.subscriber.email
                    this.comments=response.data.subscriber.comments
                    this.is_active=response.data.subscriber.is_active
                })
            },
            updateSubscriber() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.patch('/admin/setting/subscriber/'+this.$route.params.id, {
                            name:this.name,
                            email:this.email,
                            coments:this.coments,
                            is_active: this.is_active
                        }).then(response => {
                            this.buttonDisabled = true
                            this.$root.successMessage(response.data.message),
                                this.buttonDisabled = false
                            this.$validator.reset()
                            this.$router.push({path:response.data.redirection})
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
            cancel(){
                this.$router.push({path:'/admin/setting/subscriber'})
            },
        }
    }
</script>

<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Subscriber</div>
            <div class="card-body">
                <form @submit.prevent="postSubscriber">
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
                                            type="submit"
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
                image: []
            }
        },
        methods: {

            postSubscriber(val) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/admin/setting/subscriber', {
                            name:this.name,
                            email:this.email,
                            comments:this.comments,
                            is_active: this.is_active
                        }).then(response => {
                            this.buttonDisabled = true
                            this.$root.successMessage(response.data),
                                this.name=null,
                                this.email=null,
                                this.comments=null,
                                this.is_active = 1
                            this.buttonDisabled = false
                            this.$validator.reset()
                            val==='redirect'?this.$router.push({path:'/admin/setting/subscriber'}):''
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
            saveAndClose(){
                let val='redirect';
                this.postSubscriber(val)
            },
            cancel(){
                this.$router.push({path:'/admin/setting/subscriber'})
            },
        }
    }
</script>

<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Canned Email</div>
            <div class="card-body">
                <form @submit.prevent="updateCanned">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="message_type">Message Type *</label>
                                    <select id="message_type" v-model="message_type" type="text" name="message_type"
                                            :class="{'form-control': true, 'is-danger': errors.has('message_type') }"
                                            data-error="message type is required."
                                            v-validate="'required'"
                                    >
                                        <option value="user-activation">User activation</option>
                                        <option value="contact-create">Contact create</option>
                                        <option value="asset-status">Asset status</option>
                                        <option value="user-registration">User registration</option>
                                        <option value="wanted-asset-publish">Wanted asset publish</option>
                                    </select>
                                    <div v-show="errors.has('message_type')" class="help is-danger">
                                        {{ errors.first('message_type')|removeUnderScore }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mail Subject *</label>
                                    <input v-model="subject" type="text" name="subject"
                                           :class="{'form-control': true, 'is-danger': errors.has('subject') }"
                                           data-error="subject is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('subject')" class="help is-danger">
                                        {{ errors.first('subject') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sending Email *</label>
                                    <input v-model="sending_email" type="text" name="sending_email"
                                           :class="{'form-control': true, 'is-danger': errors.has('sending_email') }"
                                           data-error="Sending Email is required."
                                           v-validate="'required|email'"
                                    >
                                    <div v-show="errors.has('sending_email')" class="help is-danger">
                                        {{ errors.first('sending_email')|removeUnderScore }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message</label>
                                    <vue-ckeditor
                                            v-model="message"
                                            :config="config"
                                    />
                                    <!--<textarea class="form-control" v-model="message" rows="6"></textarea>-->
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
                message_type: null,
                subject: null,
                sending_email: null,
                message: null,
                is_active: 1,
                buttonDisabled: false,
                image: [],
                config: {
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Preview',] },
                        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                            'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },

                        '/',
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike',
                            'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent',
                            'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                            'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'base64image'] },
                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    ],

                    height: 300
                }
            }
        },
        created(){
            this.edit(this.$route.params.id)
        },
        methods: {
            edit(id){
                axios.get('/admin/canned-email/'+id+'/edit',{


                }).then(response=>{
                    this.message_type=response.data.message_type
                    this.subject=response.data.subject
                    this.sending_email=response.data.sending_email
                    this.message=response.data.message
                    this.is_active=response.data.is_active
                })
            },
            updateCanned() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.patch('/admin/canned-email/'+this.$route.params.id, {
                            message_type: this.message_type,
                            subject: this.subject,
                            sending_email: this.sending_email,
                            message: this.message,
                            is_active: this.is_active
                        }).then(response => {
                            this.buttonDisabled = true
                            this.$root.successMessage(response.data.message),
                                this.message_type = null,
                                this.subject = null,
                                this.sending_email = null,
                                this.message = null,
                                this.is_active = 1
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
                this.$router.push({path:'/admin/canned-email'})
            },
        }
    }
</script>

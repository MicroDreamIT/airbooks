<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">CMS</div>
            <div class="card-body">
                <form @submit.prevent="cmsPost">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Page Url *</label>
                                    <input  v-model="url" type="text" name="url"
                                            :class="{'form-control': true, 'is-danger': errors.has('url')}"
                                            v-validate="'required'"
                                    >
                                    <div v-show="errors.has('url')" class="help is-danger">
                                        {{ errors.first('url') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input v-model="title" type="text" name="title"
                                           :class="{'form-control': true, 'is-danger': errors.has('title') }"
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub Title </label>
                                    <input v-model="sub_title" type="text" name="sub_title"
                                           :class="{'form-control': true, 'is-danger': errors.has('sub_title') }"
                                    >

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Section *</label>
                                    <v-select
                                            v-model="section"
                                            :options="['Section One','Section Two','Section Three','Section Four','Section Five','Section Six','Section Seven','Section Eight','Section Nine','Section Ten',]"
                                            name="section"
                                            :class="{ 'is-danger': errors.has('section') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('section')" class="help is-danger">
                                        {{ errors.first('section') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Custom Url </label>
                                    <input v-model="custom_url" type="text" name="custom_url"
                                           :class="{'form-control': true, 'is-danger': errors.has('custom_url') }"
                                    >

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content Body</label>
                                    <vue-ckeditor
                                            v-model="body"
                                            :config="config"
                                    />
                                    <!--<wysiwyg v-model="body" />-->
                                    <!--<textarea class="form-control" v-model="body" rows="6"></textarea>-->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <vue-dropzone
                                            ref="viewDropZone"
                                            id="dropzone"
                                            :options="dropzoneOptions"
                                            v-on:vdropzone-file-added="addingEvent"
                                            v-on:vdropzone-removed-file="removeFile"
                                    >

                                    </vue-dropzone>
                                    <div v-show="errors.has('image')" class="help is-danger">
                                        {{ errors.first('image') }}
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
                title:null,
                sub_title:null,
                section:null,
                url:null,
                body:null,
                custom_url:null,
                is_active: 1,
                buttonDisabled: false,
                files: [],
                manualRemoveFiles: [],
                dropzoneOptions: {
                    url: '/admin/category/file-upload',
                    autoProcessQueue: false,
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    addRemoveLinks: true,
                    uploadMultiple:false,
                    maxFiles:1
                },
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
        methods: {
            addingEvent(file) {

                this.files.push(file)

            },
            removeFile(file, error, xhr) {
                this.files = this.files.filter(function (item) {
                    return item.name != file.name
                });
                if (file.manuallyAdded) {
                    this.manualRemoveFiles.push(file)
                }
            },
            saveAndClose(){
                let val='redirect';
                this.cmsPost(val)
            },
            cancel(){
                this.$router.push({path:'/admin/cms'})
            },

            cmsPost(val) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/admin/cms', {
                            title:this.title,
                            sub_title:this.sub_title,
                            section:this.section,
                            url:this.url,
                            custom_url:this.custom_url,
                            body:this.body,
                            is_active: this.is_active,
                            file:this.files
                        }).then(response => {
                            this.buttonDisabled = true
                            this.$root.successMessage(response.data),
                                this.title=null,
                                this.sub_title=null,
                                this.url=null,
                                this.section=null,
                                this.body=null,
                                this.custom_url=null,
                                this.is_active = 1
                            this.$refs.viewDropZone.removeAllFiles()
                            this.buttonDisabled = false
                            this.$validator.reset()
                            val==='redirect'?this.$router.push({path:'/admin/cms'}):''
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
            }
        }
    }
</script>

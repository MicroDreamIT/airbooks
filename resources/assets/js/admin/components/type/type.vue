<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">{{typeName}} Type</div>
            <div class="card-body">
                <form @submit.prevent="postType">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input id="name" v-model="name" type="text" name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           data-error="name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Manufacturer*</label>
                                    <v-select
                                            v-model="manufacturer"
                                            :options="manufacturerList"
                                            label="name"
                                            name="manufacturer"
                                            :class="{ 'is-danger': errors.has('manufacturer') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>

                                    <div v-show="errors.has('manufacturer')" class="help is-danger">
                                        {{ errors.first('manufacturer') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" v-model="description" rows="6"></textarea>
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
                                    <input class="custom-control-input" type="radio" v-model="is_active"
                                           name="is_active" :value="true"><span
                                        class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active"
                                           name="is_active" :value="false"><span
                                        class="custom-control-label">Inactive</span>
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

        props: [
            'type', 'typeName'
        ],

        data() {
            return {
                sError: {},
                name: null,
                description: null,
                manufacturer: null,
                manufacturerList: [],
                is_active: true,
                buttonDisabled: false,
                image:[],
                files: [],
                manualRemoveFiles: [],
                dropzoneOptions: {
                    url: '/admin/type/file-upload',
                    autoProcessQueue: false,
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    addRemoveLinks: true,
                    uploadMultiple:false,
                    maxFiles:1
                },
            }
        },
        created() {
            axios.get('/admin/type/create/' + this.type).then(response => {
                this.manufacturerList = response.data.manufacturers
            })
        },
        methods: {
            addingEvent(file) {
                if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                    this.files.push(file)
                }
            },
            removeFile(file, error, xhr) {
                this.files = this.files.filter(function (item) {
                    return item.name != file.name
                });
                if (file.manuallyAdded) {
                    this.manualRemoveFiles.push(file)
                }
            },
            saveAndClose() {
                let val = 'redirect';
                this.postType(val)
            },
            cancel() {
                this.$router.push({path: '/admin/' + this.type + '/type'})
            },

            postType(val) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/admin/type', {
                            type: this.type,
                            name: this.name,
                            manufacturer_id: this.manufacturer.id,
                            description: this.description,
                            is_active: this.is_active,
                            file:this.files
                        }).then(response => {
                            this.buttonDisabled = true
                            this.$root.successMessage(response.data)
                            this.manufacturer = null
                            this.name = null
                            this.description = null
                            this.is_active = true
                            this.files=null,
                            this.$refs.viewDropZone.removeAllFiles()
                            this.$validator.reset()
                            val==='redirect'?this.$router.push({path:'/admin/'+this.type+'/type'}):''
                            this.buttonDisabled = false
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

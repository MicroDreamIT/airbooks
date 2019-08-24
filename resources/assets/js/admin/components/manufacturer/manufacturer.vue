<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">{{typeName}} Manufacturer</div>
            <div class="card-body">
                <form @submit.prevent="postManufacturer">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="form_name">Name *</label>
                                    <input id="form_name"
                                           v-model="name"
                                           type="text"
                                           name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           data-error="name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="form_establised">Established</label>
                                    <input id="form_establised"
                                           v-model="established"
                                           type="number"
                                           name="established"
                                           class="form-control">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <v-select
                                            v-model="country"
                                            :options="countryList"
                                            label="name"
                                            name="country"
                                            :class="{ 'is-danger': errors.has('country') }"
                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group fixHeight">
                                    <label>Category *</label>
                                    <v-select
                                            v-model="category"
                                            :options="categoryList"
                                            label="name"
                                            name="category"
                                            :class="{ 'is-danger': errors.has('category') }"
                                            v-validate="'required'"
                                            multiple
                                    >
                                    </v-select>
                                    <div v-show="errors.has('category')" class="help is-danger">
                                        {{ errors.first('category') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description </label>
                                    <textarea class="form-control" id="description" rows="6"
                                              v-model="description"></textarea>
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
                                    <input class="custom-control-input" type="radio" v-model="isActive" name="is_active"
                                           :value="true"><span class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="isActive" name="is_active"
                                           :value="false"><span class="custom-control-label">Inactive</span>
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
        props: ['type', 'typeName'],
        data() {
            return {
                name: null,
                established: null,
                category: null,
                country: null,
                description: null,
                isActive: true,
                buttonDisabled: false,
                countryList: [],
                categoryList: [],
                image:[],
                files: [],
                manualRemoveFiles: [],
                dropzoneOptions: {
                    url: '/admin/manufacturer/file-upload',
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
            axios.get('/admin/manufacturer/create/' + this.type).then(response => {
                this.countryList = response.data.countries
                this.categoryList = response.data.categories
            }).catch(error => {
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
                this.postManufacturer(val)
            },
            cancel() {
                this.$router.push({path: '/admin/' + this.type + '/manufacturer'})
            },

            postManufacturer(val) {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.post('/admin/manufacturer', {
                            type: this.type,
                            name: this.name,
                            established: this.established,
                            country_id: this.country?this.country.id:null,
                            categories: this.category,
                            description: this.description,
                            file:this.files,
                            is_active: this.isActive

                        }).then(response => {
                            this.buttonDisabled = true
                            this.$root.successMessage(response.data)
                            this.name = null
                            this.established = null
                            this.country = null
                            this.category = null
                            this.file=null
                            this.description = null
                            this.isActive = true
                            this.$refs.viewDropZone.removeAllFiles()
                            this.$validator.reset()
                            val==='redirect'?this.$router.push({path:'/admin/'+this.type+'/manufacturer'}):''
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

<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Country</div>
            <div class="card-body">
                <form @submit.prevent="updateCountry">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input id="name" v-model="name" type="text" name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           data-error="Name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Continent *</label>
                                    <v-select
                                            v-model="continent"
                                            :options="continents"
                                            label="name"
                                            name="continent"
                                            :class="{ 'is-danger': errors.has('continent') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('continent')" class="help is-danger">
                                        {{ errors.first('continent') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Region *</label>
                                    <v-select
                                            v-model="region"
                                            :options="regions"
                                            label="name"
                                            name="region"
                                            :class="{ 'is-danger': errors.has('region') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('region')" class="help is-danger">
                                        {{ errors.first('region') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Capital</label>
                                    <input v-model="capital" type="text" name="capital"
                                           :class="{'form-control': true, 'is-danger': errors.has('capital') }"
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Currency</label>
                                    <input v-model="currency" type="text" name="currency"
                                           :class="{'form-control': true, 'is-danger': errors.has('currency') }"
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ISO 3116 Alpha-2 Code</label>
                                    <input v-model="iso_3116_alpha_2" type="text" name="iso_3116_alpha_2"
                                           :class="{'form-control': true, 'is-danger': errors.has('iso_3116_alpha_2') }"
                                           v-validate="'min:2|max:2'"
                                    >
                                </div>
                                <div v-show="errors.has('iso_3116_alpha_2')" class="help is-danger">
                                    {{ errors.first('iso_3116_alpha_2') }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dialing Code</label>
                                    <input v-model="dialing_code" type="text" name="dialing_code"
                                           :class="{'form-control': true, 'is-danger': errors.has('dialing_code') }"
                                    >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Flag (SVG)</label>
                                    <vue-dropzone
                                            ref="viewDropZone"
                                            id="dropzone"
                                            :options="dropzoneOptions"
                                            v-on:vdropzone-file-added="addingEvent"
                                            v-on:vdropzone-removed-file="removeFile">

                                    </vue-dropzone>
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

        data() {
            return {
                sError: {},
                continents:[],
                regions:[],
                name:null,
                continent:null,
                region:null,
                capital:null,
                currency:null,
                iso_3116_alpha_2:null,
                dialing_code:null,
                is_active: 1,
                buttonDisabled: false,
                files: [],
                manualRemoveFiles: [],
                fileUpdateRequested: [],
                dropzoneOptions: {
                    url: '/admin/category/file-upload',
                    autoProcessQueue: false,
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    addRemoveLinks: true,
                    uploadMultiple:false,
                    maxFiles:1,
                    acceptedFiles:".jpg,.png"
                },
            }
        },
        created(){
            this.show(this.$route.params.id)
        },
        methods:{
            addingEvent(file) {
                this.files.push(file)
            },

            removeFile(file, error, xhr) {
                this.files = this.files.filter(function (item) {
                    return item.name != file.name
                });
                if (file.manuallyAdded) {
                    file.requested=true
                    this.manualRemoveFiles.push(file)
                }
            },
            show(id){

                axios.get('/admin/location/country/'+id+'/edit').then(response=>{

                    this.continents=response.data.continents
                    this.regions=response.data.regions
                    this.name = response.data.country.name
                    this.continent = response.data.country.continent
                    this.region = response.data.country.region
                    this.capital = response.data.country.capital
                    this.currency = response.data.country.currency
                    this.iso_3116_alpha_2 = response.data.country.iso_3116_alpha_2
                    this.dialing_code = response.data.country.dialing_code
                    this.is_active = response.data.country.is_active
                    let fil = response.data.country.medias
                    if(fil){
                        let image = {name: fil.original_file_name, contentId:fil.id}
                        this.$refs.viewDropZone.manuallyAddFile(image,'/storage/'+fil.path+'/'+fil.original_file_name)
                    }
                })
            },
            cancel(){
                this.$router.push({path:'/admin/location/country'})
            },
            updateCountry(){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.patch('/admin/location/country/'+this.$route.params.id,{
                            name:this.name,
                            continent_id:this.continent.id,
                            region_id:this.region.id,
                            capital:this.capital,
                            currency:this.currency,
                            iso_3116_alpha_2:this.iso_3116_alpha_2,
                            dialing_code:this.dialing_code,
                            is_active: this.is_active,
                            file:this.files,
                            removeFiles: this.manualRemoveFiles
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

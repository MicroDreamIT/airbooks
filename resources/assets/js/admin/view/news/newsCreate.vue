<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">News</div>
            <div class="card-body">
                <form @submit.prevent="postNews">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"> Title *</label>
                                    <input id="name" v-model="news.title" type="text" name="title"
                                           :class="{'form-control': true, 'is-danger': errors.has('title') }"
                                           data-error="title is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('title')" class="help is-danger">{{ errors.first('title') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date </label>
                                    <date-picker v-model="news.date"
                                                 :class="{'form-control': true, 'is-danger': errors.has('date') }"
                                                 :config="options">

                                    </date-picker>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Company</label>
                                    <v-select
                                            v-model="news.company"
                                            :options="this.companies"
                                            label="name"
                                            name="company"
                                            :class="{ 'is-danger': errors.has('company') }"
                                    >
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group fixHeight">
                                    <label>Category*</label>
                                    <v-select
                                            v-model="news.categories"
                                            :options="this.categoriesList"
                                            label="name"
                                            name="categories"
                                            :class="{ 'is-danger': errors.has('categories') }"
                                            v-validate="'required'"
                                            multiple
                                    >
                                    </v-select>

                                    <div v-show="errors.has('categories')" class="help is-danger">
                                        {{ errors.first('categories') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Continent *</label>
                                    <v-select
                                            v-model="news.continent"
                                            :options="this.continents"
                                            label="name"
                                            name="continent"
                                            @input="getRegion"
                                            :class="{ 'is-danger': errors.has('continent') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('continent')" class="help is-danger">{{ errors.first('continent') }}</div>

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Region *</label>
                                    <v-select
                                            v-model="news.region"
                                            :options="this.regions"
                                            label="name"
                                            name="region"
                                            @input="news.country = null, getCountry()"
                                            :class="{ 'is-danger': errors.has('region') }"
                                            v-validate="'required'"

                                    >
                                    </v-select>
                                    <div v-show="errors.has('region')" class="help is-danger">{{ errors.first('region') }}</div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
                                    <v-select
                                            v-model="news.country"
                                            :options="this.countries"
                                            label="name"
                                            name="country"
                                            :class="{ 'is-danger': errors.has('country') }"
                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Source</label>
                                    <input v-model="news.source" type="text" name="source"
                                           :class="{'form-control': true, 'is-danger': errors.has('source') }"
                                    >

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Details</label>
                                    <vue-ckeditor
                                            v-model="news.details"
                                            :config="config"
                                    />
                                    <!--<wysiwyg v-model="news.details" />-->
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
                                    <input class="custom-control-input" type="radio" v-model="news.is_active" name="is_active" :value="true"><span class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="news.is_active" name="is_active" :value="false"><span class="custom-control-label">Inactive</span>
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
                news:{is_active:true, date: new Date()},
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: true,
                },
                categoriesList:[],
                continents:[],
                regions:[],
                countries:[],
                companies:[],
                buttonDisabled:false,
                image:[],
                files: [],
                manualRemoveFiles: [],
                dropzoneOptions: {
                    url: '/admin/news/file-upload',
                    autoProcessQueue: false,
                    thumbnailWidth: 200,
                    maxFilesize: 2,
                    addRemoveLinks: true,
                    uploadMultiple:false,
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

        created(){
            axios.get('/admin/news/create').then(response => {
                    this.categoriesList=response.data.categories,
                    this.continents=response.data.continents,
                    this.companies=response.data.companies
            })
        },
        mounted(){

        },
        methods:{
            getCountry() {
                if(this.news.region){
                    axios.get('/getCountryNameByRegion', {
                        params: {
                            region_id: this.news.region.id
                        }
                    }).then(response => {
                        this.news.country = null
                        this.countries = response.data
                    })
                }

            },
            getRegion() {
                if(this.news.continent){
                    axios.get('/getRegionNameByContinent', {
                        params: {
                            continent_id: this.news.continent.id
                        }
                    }).then(response => {
                        this.news.country = null
                        this.countries=[]
                        this.news.region = null
                        this.regions = response.data
                    })
                }

            },
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
            postNews(val){
                this.$validator.validateAll().then((result)=>{
                    this.news['file']=this.files
                    if (result){
                        axios.post('/admin/news',this.news).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data)
                            this.news={is_active:true,date: new Date()}
                            this.$refs.viewDropZone.removeAllFiles()
                            this.buttonDisabled=false
                            this.$validator.reset()
                            val==='redirect'?this.$router.push({path:'/admin/news'}):''
                        }).catch(error=>{
                            let err
                            let errs = error.response.data.errors
                            for (err in errs){
                                this.errors.add({
                                    'field':err,
                                    'msg':errs[err][0],

                                })
                            }
                        })
                    }
                })
            },
            saveAndClose(){
                let val='redirect';
                this.postNews(val)
            },
            cancel(){
                this.$router.push({path:'/admin/news'})
            },
        }
    }
</script>

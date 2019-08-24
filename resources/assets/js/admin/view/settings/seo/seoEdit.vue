<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">seo edit</div>
            <div class="card-body">
                <form @submit.prevent="patchCategory()"
                      class="form-horizontal"
                >

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>
                                Page
                            </label>
                            <v-select v-model="page"
                                      name="page"
                                      :options="$store.state.pages"
                                      label="name"
                                      :class="{'is-danger': errors.has('page') }"
                                      v-validate="'required'"
                            ></v-select>
                            <div v-show="errors.has('page')" class="help is-danger">
                                {{ errors.first('page') }}
                            </div>
                        </div>
                        <div class="form-group col-md-10">
                            <label>
                                Title
                            </label>
                            <input type="text"
                                   v-model="title"
                                   name="title"
                                   v-validate="'required'"
                                   :class="{'form-control': true, 'is-danger': errors.has('name') }"
                            />
                            <div v-show="errors.has('title')" class="help is-danger">
                                {{ errors.first('title') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>
                                Description
                            </label>
                            <textarea name="description"
                                      id="description"
                                      class="form-control"
                                      v-validate="'required|max:165'"
                                      cols="30"
                                      v-model="description"
                                      rows="10"
                                      :class="{'form-control': true, 'is-danger': errors.has('description') }"
                            ></textarea>
                            <div v-show="errors.has('description')" class="help is-danger">
                                {{ errors.first('description') }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    export default {

        computed:{
            _(){
                return _;
            }
        },
        data(){
            return{
                page:{},
                sError:{},
                name:null,
                title:'',
                description:null,
                is_active:true,
                buttonDisabled:false,
                image:[],
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
                    maxFiles:1
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

            cancel(){
                this.$router.push({path:'/admin/'+this.type+'/category'})
            },
            show(id){
                let url ='/admin/setting/seo/'+id+ '/edit'
                axios.get(url).then(response=>{
                    this.title = response.data.title
                    this.description = response.data.description
                    this.is_active = response.data.is_active
                    this.page = this.$store.state.pages.filter(value=>{
                        return response.data.model_id === value.id
                    })[0]


                    let fil = response.data.medias
                    if(fil){
                        let image = {name: fil.original_file_name, contentId:fil.id}
                        this.$refs.viewDropZone.manuallyAddFile(image,'/storage/'+fil.path+'/'+fil.original_file_name)
                    }
                })
            },

            patchCategory(){
                this.$validator.validateAll().then((result)=>{
                    if (result){

                        axios.patch('/admin/setting/seo/' + this.$route.params.id ,{
                            model_id:this.page.id,
                            model_type:this.page.name,
                            method:this.page.method,
                            title:this.title,
                            description:this.description,
                            file:this.files,
                            page:this.page,
                            removeFiles: this.manualRemoveFiles
                        }).then(response=>{

                            this.$root.successMessage(response.data.message)

                            this.$refs.viewDropZone.removeAllFiles()
                            this.$validator.reset()
                            this.$router.push({name:'adminSeoList'})
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

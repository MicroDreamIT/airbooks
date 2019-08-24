
<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">{{typeName}} Category</div>
            <div class="card-body">
                <form @submit.prevent="patchCategory">
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
                                           value="1">
                                    <span class="custom-control-label">
                                        Publish
                                    </span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="is_active"
                                           name="is_active"
                                           value="0">
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

        props:[
            'type', 'typeName'
        ],
        computed:{
            _(){
                return _;
            }
        },
        data(){
            return{
                sError:{},
                name:null,
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
                if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                    this.files.push(file)
                }
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
                let url ='/admin/category/'+id
                axios.get(url,{
                    params:{
                        type:this.type
                    }
                }).then(response=>{

                    this.name = response.data.name
                    this.description = response.data.description
                    this.is_active = response.data.is_active
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

                        axios.patch('/admin/category/' + this.$route.params.id ,{
                            type:this.type,
                            name:this.name,
                            description:this.description,
                            is_active:this.is_active,
                            file:this.files,
                            removeFiles: this.manualRemoveFiles

                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data.message)
                            this.buttonDisabled=false
                            this.$refs.viewDropZone.removeAllFiles()
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

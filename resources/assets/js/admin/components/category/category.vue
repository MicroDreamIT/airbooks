<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">{{typeName}} Category</div>
            <div class="card-body">
                <form @submit.prevent="postCategory">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input id="name"
                                           v-model="name"
                                           type="text"
                                           name="name"
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

        props:['type', 'typeName'],
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
                is_active:1,
                buttonDisabled:false,
                image:[],
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
            }
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
                    this.manualRemoveFiles.push(file)
                }
            },
            saveAndClose(){
                let val='redirect';
                this.postCategory(val)
            },
            cancel(){
                this.$router.push({path:'/admin/'+this.type+'/category'})
            },
            postCategory(val){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.post('/admin/category',{
                            type:this.type,
                            name:this.name,
                            description:this.description,
                            is_active:this.is_active,
                            file:this.files
                        }).then(response=>{
                            // this.$refs.viewDropZone.processQueue()
                            this.buttonDisabled=true
                            this.name = null
                            this.description = null
                            this.is_active = 1
                            this.buttonDisabled=false
                            this.$refs.viewDropZone.removeAllFiles()
                            this.$validator.reset()
                            this.$root.successMessage(response.data)

                            val==='redirect'?this.$router.push({path:'/admin/'+this.type+'/category'}):''


                        }).catch(error=>{
                            if(error.response.status===413){
                                this.$root.successMessage({type:'danger', message:error.message})
                            }
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

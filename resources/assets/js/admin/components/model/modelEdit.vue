<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">{{typeName}} Model</div>
            <div class="card-body">
                <form @submit.prevent="updateModel">
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
                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type*</label>
                                    <v-select
                                            v-model="type_name"
                                            :options="typeList"
                                            label="name"
                                            name="type"
                                            :class="{ 'is-danger': errors.has('type') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('type')" class="help is-danger">
                                        {{ errors.first('type') }}
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
                                    <input class="custom-control-input" type="radio" v-model="is_active" name="is_active" :value="true"><span class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active" name="is_active" :value="false"><span class="custom-control-label">Inactive</span>
                                </label>

                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-lg-start">
                                    <button class="btn btn-space btn-primary "
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-save"></i>   Update
                                    </button>
                                    <button class="btn btn-space btn-danger"
                                            :disabled="buttonDisabled"
                                            @click.prevent="cancel"
                                    >
                                        <i class="icon mdi mdi-close"></i>   Cancel
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
            'type','typeName'
        ],

        data(){
            return{
                sError:{},
                name:null,
                description:null,
                type_name:null,
                typeList:[],
                is_active:true,
                buttonDisabled:false,
                image:[],
                files: [],
                manualRemoveFiles: [],
                dropzoneOptions: {
                    url: '/admin/model/file-upload',
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
            show(id){
                let url ='/admin/model/'+id+'/edit'
                axios.get(url,{
                    params:{
                        type:this.type
                    }
                }).then(response=>{
                    this.typeList=response.data.types
                    this.type_name = response.data.model.type
                    this.name = response.data.model.name
                    this.description = response.data.model.description
                    response.data.model.is_active==0? this.is_active = false : this.is_active = true
                    let fil = response.data.model.medias
                    if(fil){
                        let image = {name: fil.original_file_name, contentId:fil.id}
                        this.$refs.viewDropZone.manuallyAddFile(image,'/storage/'+fil.path+'/'+fil.original_file_name)
                    }
                })
            },
            cancel(){
                this.$router.push({path:'/admin/'+this.type+'/model'})
            },
            updateModel(){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.patch('/admin/model/'+ this.$route.params.id,{
                            type:this.type,
                            type_id:this.type_name.id,
                            name:this.name,
                            description:this.description,
                            is_active:this.is_active,
                            file:this.files,
                            removeFiles: this.manualRemoveFiles,
                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data.message)
                            this.$validator.reset()
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

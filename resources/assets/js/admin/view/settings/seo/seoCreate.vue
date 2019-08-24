<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Seo Create</div>
            <div class="card-body">
                <form @submit.prevent="post()"
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
                                   v-validate="'required|max:55'"
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

        data() {
            return {
                page:{},
                title:'',
                description:'',
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
            post(){

                this.$validator.validateAll().then((result)=>{
                    if(result){
                        axios.post('/admin/setting/seo', {
                            model_id:this.page.id,
                            model_type:this.page.name,
                            method:this.page.method,
                            page:this.page,
                            title:this.title,
                            description:this.description,
                            file: this.files
                        }).then(res=>{
                            this.page={}
                            this.title=''
                            this.description=''
                            this.files = []
                            this.$refs.viewDropZone.removeAllFiles()
                            this.$root.successMessage(res.data.message)
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
        }

    }
</script>

<template>
    <div  v-if="$root.$data.showMedia"
          style=" z-index: 100000; position: fixed; background: rgba(0,0,0,0.8); width: 100%; height: 100vh"
          @click="outsideDiv($event)" id="media_modal">
        <div class="media">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header card-header-divider">Media
                        <div class="tools">
                            <div class="icon mdi mdi-close" @click="$root.toggleMedia()"></div>
                        </div>
                    </div>
                    <div class="mediaBar">
                        <div>
                            <div :class="{'mediaButton':true, 'mediaActive':uploadFile}" @click="uploadFile=true">Upload</div>
                            <div :class="{'mediaButton':true, 'mediaActive':!uploadFile}" @click="uploadFile=!true">library</div>
                        </div>
                        <div>
                            <input type="text" class="mediaSearch" v-model="search" @keyup="filter" placeholder="search">
                        </div>
                    </div>
                    
                    <div class="card-body mt-4">
                        <div class="row" v-show="uploadFile">
                            <div class="col-md-12">
                                <input type="text" v-model="suffix" id="suffix" class="form-control" placeholder="add suffix" >
                                <br>
                                <vue-dropzone
                                        ref="myVueDropzone"
                                        id="dropzone"
                                        @vdropzone-success="vsuccess"
                                        @vdropzone-complete="afterComplete"
                                        @vdropzone-complete-multiple="completeMultiple"
                                        @vdropzone-queue-complete="vqueueComplete"
                                        @vdropzone-sending="sendingEvent"
                                        v-if="suffix"
                                        :options="dropzoneOptions">
                                </vue-dropzone>
                            </div>
                        </div>
                        <div class="row" v-show="!uploadFile">
                            <div class="col-md-9 br-1">
                                <div class="row">
                                    <vue-select-image :dataImages="files"
                                                      :is-multiple="true"
                                                      :selectedImages="initialSelected"
                                                      :useLabel="true"
                                                      @onselectmultipleimage="onSelectMultipleImage">
                                    </vue-select-image>
                                    <!--<img :src="file | globalMediaPath" alt="" v-for="file in files" class="col-md-3 img img-thumbnail">-->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex justify-content-end flex-column">
                                   <div class="mb-2 ">
                                       <label class="mb-1 strong">Sort By</label>
                                       <select v-model="filtering" @change="filter" class="mr-2 media-control">
                                           <option value="original_file_name">name</option>
                                           <option value="created_at">Time</option>
                                       </select>
                                   </div>
                                    <div class="">
                                        <label class="mb-1 strong">Sort By</label>
                                        <select v-model="ordering" @change="filter" class="media-control">
                                            <option value="asc">Ascending</option>
                                            <option value="desc">Descending</option>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="initialSelected.length>0" class="mt-3">
                                   <div class="imgInfo">
                                       <span>name:</span> {{ initialSelected[0].meta_name }}
                                   </div>
                                   <!--<div class="imgInfo">-->
                                       <!--<span>type:</span> {{initialSelected[0].type}}-->
                                   <!--</div>-->
                                   <!--<div class="imgInfo">-->
                                       <!--<span>id:</span> {{initialSelected[0].id}}-->
                                   <!--</div>-->
                                   <div class="imgInfo">
                                       <span>created at:</span> {{initialSelected[0].created_at}}
                                   </div>
                                   <button @click="del()" class="btn btn-sm btn-danger mt-3">Delete Photo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-danger"
                                @click="$root.toggleMedia()">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueSelectImage from 'vue-select-image'
    export default {
        name: "media",
        components: { VueSelectImage },
        data(){
            return {
                suffix:'',
                search:'',
                filtering:'',
                ordering:'',
                uploadFile:false,
                files:[],
                selectedFiles:[],
                file:{
                    original_file_name:'',
                    featured:''
                },
                initialSelected:[],
                dropzoneOptions:{
                    url: '/global-media/upload',
                    thumbnailWidth: 150,
                    maxFilesize: 5,
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val(),
                    },
                    acceptedFiles: ".jpeg,.jpg,.png,.gif"
                }
            }
        },

        watch:{
            uploadFile(val){
                if(!val){
                    // this.selectedFiles = []
                    this.$refs.myVueDropzone.removeAllFiles()
                    // console.log(this.selectedFiles)
                }
            }
        },

        created(){
            this.getFiles()
        },

        methods:{
            sendingEvent(file, xhr, formData){
                formData.append('suffix', this.suffix)
            },
            filter(){
                this.getFiles()
            },
            getFiles(){
                axios.get('/global-media/all-images',{params:{
                        filtering:this.filtering,
                        ordering:this.ordering,
                        search:this.search
                    }}).then(res=>{
                    let images = res.data
                    this.files = []
                    for(let i=0, count=images.length; i<count;i++){
                        images[i]['alt'] = images[i].original_file_name
                        images[i]['src']='/storage/' + images[i].path + '/' + images[i].original_file_name
                        this.files.push(images[i])
                    }
                    // this.onSelectMultipleImage([this.files[0]])
                })
            },
            vqueueComplete(){
                setTimeout(()=>{
                    this.uploadFile=!this.uploadFile
                }, 1000)
            },
            afterComplete(file){
                // console.log(file)
            },
            vsuccess(file, response){
                response.src = '/storage/' + response.path + '/' + response.original_file_name
                response.alt=response.original_file_name
                this.files.push(response)
                this.initialSelected.push(response)
                // console.log(this.initialSelected)
            },
            completeMultiple(file){
                // console.log('complete')
            },
            del(){
                axios.post('/global-media/delete', this.initialSelected)
                    .then(res=>{
                        this.initialSelected.filter(item=>{
                            let i = this.files.indexOf(item)
                            this.files.splice(i,1)
                            this.file={}
                        })
                    })
                    .catch(error=>{
                        console.log(error.response.data.message)
                    })
            },
            onSelectMultipleImage(data){
                console.log(data)
                this.initialSelected = data
            },
            outsideDiv(e){
                let targetEvent = e.target
                if(targetEvent.id=='media_modal'){
                  this.$root.toggleMedia()
                }
            }
        }
    }
</script>

<style lang="scss">

</style>

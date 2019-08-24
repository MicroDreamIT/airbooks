<template>
    <div  v-if="$root.$data.showMedia"
          style=" z-index: 100000; position: fixed; background: rgba(0,0,0,0.8); width: 100%; height: 100vh"
          @click="outsideDiv($event)" id="media_modal">
        <div class="media">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header card-header-divider">Media
                        <div class="tools" ><span class="icon mdi mdi-close" @click="$root.toggleMedia()"></span></div>
                    </div>
                    <div class="mediaBar">
                        <div>
                            <div @click="currentTab='upload'"
                                 :class="{'mediaButton':true,'mediaActive':currentTab=='upload'}">Upload</div>
                            <div @click="currentTab='user'"
                                 :class="{'mediaButton':true,'mediaActive':currentTab=='user'}">My library</div>
                            <div @click="currentTab='global'"
                                 :class="{'mediaButton':true,'mediaActive':currentTab=='global'}">Airbook Gallery</div>
                        </div>
                         <div>
                             <input type="text" v-model="userSearch" @keyup="filter" placeholder="search my library" class="mediaSearch" v-if="currentTab=='user'">
                             <input type="text" v-model="search" @keyup="globalFilter" placeholder="search global images"  class="mediaSearch" v-else-if="currentTab=='global'">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" v-show="currentTab=='upload'">
                            <div class="col-md-12">
                                <vue-dropzone
                                        ref="myVueDropzone"
                                        id="dropzone"
                                        @vdropzone-success="vsuccess"
                                        @vdropzone-complete="afterComplete"
                                        @vdropzone-complete-multiple="completeMultiple"
                                        @vdropzone-queue-complete="vqueueComplete"
                                        :options="dropzoneOptions">
                                </vue-dropzone>
                            </div>
                        </div>
                        <div class="row" v-show="currentTab=='user'">
                            <!--user library-->
                            <div class="col-md-9">
                                <div class="row">
                                    <vue-select-image :dataImages="userFiles"
                                                      ref="userImageSelect"
                                                      :is-multiple="true"
                                                      :selectedImages="initialSelected"
                                                      :useLabel="true"
                                                      @onselectmultipleimage="onSelectMultipleImage">
                                    </vue-select-image>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex justify-content-end flex-column">
                                    <div class="mb-2 ">
                                        <label class="mb-1 strong">Sort By</label>
                                        <select v-model="userFiltering" @change="filter"  class="mr-2 media-control">
                                            <option value="original_file_name">name</option>
                                            <option value="created_at">created at</option>
                                        </select>
                                        <label class="mb-1 strong">Sort By</label>
                                        <select v-model="userOrdering" @change="filter" class="media-control">
                                            <option value="asc">ascending</option>
                                            <option value="desc">descending</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div v-if="initialSelected.length>0 && currentTab==='user'">
                                    <div class="imgInfo">
                                        <span>name:</span> {{ initialSelected[0].meta_name}}
                                    </div>

                                    <div class="imgInfo">
                                        <span>created at:</span> {{initialSelected[0].created_at}}
                                    </div>
                                    <br>
                                    <button @click="del()" class="btn btn-sm btn-danger mt-3">Delete Photo</button>
                                </div>

                            </div>
                        </div>
                        <div class="row" v-show="currentTab=='global'">
                            <div class="col-md-9 br-1">
                               
                                <div class="row">
                                    <vue-select-image :dataImages="files"
                                                      :is-multiple="true"
                                                      :selectedImages="initialSelected"
                                                      :useLabel="true"
                                                      @onselectmultipleimage="onSelectGlobalMultipleImage">
                                    </vue-select-image>
                                </div>
                            </div>
                            <div class="col-md-3">
    
                                <div class="d-flex justify-content-end flex-column">
                                    <div class="mb-2 ">
                                        <label class="mb-1 strong">Sort By</label>
                                        <select v-model="filtering" @change="globalFilter" class="media-control">
                                            <option value="original_file_name">name</option>
                                            <option value="created_at">created at</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label class="mb-1 strong">Sort By</label>
                                        <select v-model="ordering" @change="globalFilter" class="media-control">
                                            <option value="asc">ascending</option>
                                            <option value="desc">descending</option>
                                        </select>
                                    </div>
                                    <div v-if="initialGlobalSelected.length>0 && currentTab==='global'">
                                        <div class="imgInfo">
                                            <span>name:</span> {{ initialGlobalSelected[0].meta_name}}
                                        </div>

                                        <div class="imgInfo">
                                            <span>created at:</span> {{initialGlobalSelected[0].created_at}}
                                        </div>
                                        <br>

                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="card-footer">
                        <button @click="insertImage()" v-if="currentTab=='user' || currentTab=='global'"
                                class="btn btn-primary  pb-1 pt-1">
                            Insert
                        </button>
                        <button class="btn btn-danger pb-1 pt-1"
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
        name: "user-media",
        components: { VueSelectImage },
        data(){
            return {
                userSearch:'',
                userFiltering:'',
                userOrdering:'',
                search:'',
                filtering:'',
                ordering:'',
                currentTab:'user',
                files:[],
                userFiles:[],
                selectedFiles:[],
                file:{
                    original_file_name:'',
                    featured:''
                },
                imageMultipleSelected: [],
                initialSelected:[],
                initialGlobalSelected:[],
                dropzoneOptions:{
                    url: '/global-media/user/upload',
                    thumbnailWidth: 150,
                    maxFilesize: 5,
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    acceptedFiles: ".jpeg,.jpg,.png,.gif"
                }
            }
        },

        watch:{
            currentTab(val){
                // console.log(val)
                if(val=='upload'){
                    // this.selectedFiles = []
                    this.$refs.myVueDropzone.removeAllFiles()
                    // console.log(this.selectedFiles)
                }
            }
        },

        created(){
            this.getFiles()
            this.getUserFiles()

        },

        mounted(){
            this.initialSelected=this.$root.$data.selectedImages
            // console.log(this.initialSelected)

            this.$refs.userImageSelect.setInitialSelection()
        },

        methods:{
            insertImage(){
                // console.log(this.initialGlobalSelected, this.initialSelected);

                let total = this.initialSelected.concat(this.initialGlobalSelected)

                this.$root.$data.selectedImages = total
                this.$root.toggleMedia()
            },
            getUserFiles(){
                axios.get('/global-media/user/all-images',{params:{
                        userFiltering:this.userFiltering,
                        userOrdering:this.userOrdering,
                        userSearch:this.userSearch
                    }})
                    .then(res=>{
                        this.userFiles = res.data.filter(item=>{
                            item.src = '/storage/' + item.path + '/' + item.original_file_name
                            item.alt = item.original_file_name
                            return item
                        })
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            },
            filter(){
                this.getUserFiles()
            },
            globalFilter(){
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
                    this.currentTab='user'
                    // console.log('completed')
                }, 1000)
                // console.log(this.currentTab)
            },
            afterComplete(file){
                // console.log(file)
            },
            vsuccess(file, response){

                response.src = '/storage/' + response.path + '/' + response.original_file_name
                response.alt=response.original_file_name
                this.userFiles.push(response)
                this.initialSelected.push(response)
                this.$refs.userImageSelect.setInitialSelection()

            },
            completeMultiple(file){
                // console.log('complete')
            },
            del(){
                axios.post('/global-media/user/delete', this.initialSelected)
                    .then(res=>{
                        this.initialSelected.filter(item=>{
                            let i = this.userFiles.indexOf(item)
                            this.userFiles.splice(i,1)
                            this.file={}
                        })
                    })
                    .catch(error=>{
                        console.log(error.response.data.message)
                    })
            },
            onSelectMultipleImage(data){

                this.initialSelected = data

            },

            onSelectGlobalMultipleImage(data){
                this.initialGlobalSelected = data
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
    .media{
        position: absolute;
        top: .5%;
        left: 0;           /* Left edge at left for now */
        right: 0;
        width: 72%;
        background: white;
        margin: auto;
        .br-1{
            border-right: 1px solid lightgray;
        }
        ul.vue-select-image__wrapper{
            display: flex !important;
            flex-wrap: wrap !important;
            li.vue-select-image__item{
                flex-basis: 20%;
            }
        }
    }
</style>

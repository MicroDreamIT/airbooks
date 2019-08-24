export default {

    data(){
        return{
            chartData1:[],

            apu:{
                likes:[]
            },
            galleryImagePath:null,
            favouriteActive:false,

        }
    },
    created(){
        this.$root.$data.isLoading = false
        this.getChart()

        this.getList()

    },
    computed:{
        _(){
            return _;
        },
        metas(){
            this.setupSeoForDetailPage(this.apu)
            return !!this.$store.state.seos.length
        },
        chartLoad(){
            if(this.chartData1){
                if(this.chartData1.hasOwnProperty('id')){
                    return true
                }
            }
        },
        getFeaturedApu(){
            let apu = this.$root.$data.featured.filter(data=> data.modelType=='apu'&& data.id!=this.$route.params.id.split('-')[0])
            apu.length>2?apu.length=2:null
            return apu
        }
    },
    methods:{
        setupSeoForDetailPage(data){

            let title = Vue.filter('removeHyphen')(data.title)

            title = title.replace(/  /g, ' ')

            let manufacturer = data.manufacturer? data.manufacturer.name + ' ' : ''

            let type = data.type? data.type.name + ' ' : ''
            //
            let offerFor =  data.offer_for + ' in '
            //
            let model = data.model? data.model.name + '' : ''
            //
            let pn = data.part_number ? 'PN ' + data.part_number + ', ' : ''
            //
            let cr = data.cycle_remaining ? 'CR ' + data.cycle_remaining + '' : ''
            //
            let status = data.status + ' condition, '
            //
            let description = manufacturer +  type + model + ' is available for ' + offerFor + status + pn + cr +'. Enquire online on Airbook'
            //
            description = description.replace(/  /g, ' ')
            //
            this.$root.changeMeta(title, description, this.$root.$data.baseUrl +this.$root.getFeaturedImage(data.medias))

        },
        getChart(){
            axios.get('/ajax/getChart', {params:{
                    model:'Apu',
                    id:this.$route.params.id.split('-')[0]
                }})
                .then(res=>{
                    this.chartData1 = res.data
                }).catch(err=>{})
        },
        postFavourite(modelId, modelPath){
            axios.post('/user/ajax/favourites',{id:modelId, path:modelPath})
                .then(res=>{

                    this.$root.alertMessage(res.data)
                    if(res.data.type=='success'){
                        this.favouriteActive=true
                    }
                })
                .catch(err=>{
                    if(err.response.status==401){
                        window.location.href='/login'
                    }
                })
        },
        postLike(modelId, modelPath){
            let featuredItems = this.$root.$data.featured.filter(item=> item.id == modelId && item.modelType=='apu')[0]
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                            let indexNo = this.apu.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            this.apu.likes.splice(indexNo, 1)

                            indexNo = featuredItems.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            featuredItems.likes.splice(indexNo, 1)
                        }

                        if(res.data.liked) {
                            if (res.data.liked.id !== undefined) {
                                this.apu.likes.push(res.data.liked)
                                featuredItems.likes.push(res.data.liked)
                            }
                        }
                    }
                })
                .catch(err=>{
                    if(err.response.status==401){
                        this.$root.errorMessage(err.response, 'Please Login first then try again')
                        window.location.href='/login'
                    }
                })
        },
        getList(){
            this.$root.$data.isLoading = true
            axios.get('/ajax/apu/'+this.$route.params.id.split('-')[0]).then(res=>{
                if(res.data.url=='404'){
                    this.$router.push({path:'/page-not-found'})
                }else{
                    this.apu=res.data
                    this.galleryImagePath=this.$root.getGalleryMainImagePath(res.data.medias)

                }
                this.$root.$data.isLoading = false

            })
        },
        changeGalleryImage(item,index){
            this.galleryImagePath=this.$options.filters.imagePathForStyle(item)
            for(var i=0;i<Object.keys(this.$refs).length; i++){
                i==index?
                    this.$refs['subImage'+i][0].className='demo-sub-image own-image-focus':
                    this.$refs['subImage'+i][0].className='demo-sub-image'
            }


        }


    }

}
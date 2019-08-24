export default {

    data(){
        return{
            engine:{
                likes:[]
            },
            favouriteActive:false,
            galleryImagePath:null,
            chartData1:[],

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
            this.setupSeoForDetailPage(this.engine)
            return !!this.$store.state.seos.length
        },
        chartLoad(){
            if(this.chartData1){
                if(this.chartData1.hasOwnProperty('id')){
                    return true
                }
            }
        },
        getFeaturedEngine(){
            let engine = this.$root.$data.featured.filter(data=> data.modelType=='engine' && data.id!=this.$route.params.id.split('-')[0])
            engine.length>2?engine.length=2:null
            return engine
        }
    },
    methods:{
        setupSeoForDetailPage(data){

            let title = Vue.filter('removeHyphen')(data.title)

            let manufacturer = data.manufacturer? data.manufacturer.name + ' ' : ''

            let type = data.type? data.type.name + ' is available for ' : ''
            //
            let offerFor =  data.offer_for + ' in '
            //
            let model = data.model? data.model.name + ' ' : ''
            //
            let tso = data.tso ? 'TSO ' + data.tso + ', ' : ''
            //
            let cr = data.cycle_remaining ? 'CR ' + data.cycle_remaining + '' : ''
            //
            let status = data.status + ' condition, '
            //
            let description = manufacturer + model + type + offerFor + status + tso + cr +'. Enquire online on Airbook'
            //
            description = description.replace(/  /g, ' ')
            //
            this.$root.changeMeta(title, description, this.$root.$data.baseUrl +this.$root.getFeaturedImage(data.medias))

        },
        getChart(){
            axios.get('/ajax/getChart', {params:{
                    model:'Engine',
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
            let featuredItems = this.$root.$data.featured.filter(item=> item.id == modelId && item.modelType=='engine')[0]

            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                            let indexNo = this.engine.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            this.engine.likes.splice(indexNo, 1)

                            indexNo = featuredItems.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            featuredItems.likes.splice(indexNo, 1)

                        }

                        if(res.data.liked) {
                            if (res.data.liked.id !== undefined) {
                                this.engine.likes.push(res.data.liked)
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
            axios.get('/ajax/engine/'+this.$route.params.id.split('-')[0]).then(res=>{

                if(res.data.url=='404'){
                    this.$router.push({path:'/page-not-found'})
                }else{
                    this.engine=res.data
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
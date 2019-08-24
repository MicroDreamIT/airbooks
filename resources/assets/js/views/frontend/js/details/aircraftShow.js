export default {

    data(){
        return{
            aircraft:{
                likes:[]
            },
            chartData1:[],
            favouriteActive:false,
            galleryImagePath:null,


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
            this.setupSeoForDetailPage(this.aircraft)
            return !!this.$store.state.seos.length
        },
        getFeaturedAircraft(){
            let aircraft = this.$root.$data.featured.filter(data=> data.modelType=='aircraft'&& data.id!=this.$route.params.id.split('-')[0])
            aircraft.length>2?aircraft.length=2:null
            return aircraft
        },
        chartLoad(){
            if(this.chartData1){
                if(this.chartData1.hasOwnProperty('id')){
                    return true
                }
            }
        },
    },

    methods:{
        setupSeoForDetailPage(data){

            let title = Vue.filter('removeHyphen')(data.title)

            let YOMYear = this.$moment(data.YOM).format('YYYY') + ' '

            let manufacturer = data.manufacturer? data.manufacturer.name + ' ' : ''

            let type = data.type? data.type.name + ' ' : ''

            let offerFor =  data.offer_for + ' with '

            let modeled = data.modeled? data.modeled.name:''
            //engine section

            let engineManufacturer  = data.engine_manufacturer ? ' ' + data.engine_manufacturer.name + ' ': ''
            let engineType = data.engine_type ? ' '+data.engine_type.name+' ' : ''
            let engineModel = data.engine_model ? ' '+data.engine_model.name+' ':''
            let engine = engineManufacturer + engineType + engineModel + ' engines, '


            let csn = data.csn ? 'CSN ' + data.csn + ', ' : ''

            let tsn = data.tsn ? 'TSN ' + data.tsn + ', ' : ''

            let status =  ' Status '+ data.status +'. Enquire online on Airbook'

            let description = YOMYear + manufacturer + type + modeled + ' is available for '+ offerFor + engine + csn + tsn + status

            description = description.replace(/  /g, ' ')

            this.$root.changeMeta(title, description, this.$root.$data.baseUrl + this.$root.getFeaturedImage(data.medias))

        },
        getChart(){

            axios.get('/ajax/getChart', {params:{
                    model:'Aircraft',
                    id:this.$route.params.id.split('-')[0]
                }})
                .then(res=>{
                    this.chartData1 = res.data
                }).catch(err=>{})
        },



        postFavourite(modelId, modelPath){
            axios.post('/user/ajax/favourites',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        this.$root.alertMessage(res.data)
                        if(res.data.type=='success'){
                            this.favouriteActive=true
                        }
                    }
                })
                .catch(err=>{
                    if(err.response.status==401){
                        window.location.href='/login'
                    }
                })
        },
        postLike(modelId, modelPath){
            let featuredItems = this.$root.$data.featured.filter(item=> item.id == modelId && item.modelType=='aircraft')[0]

            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){

                        if(res.data.unlike){
                            let indexNo = this.aircraft.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            this.aircraft.likes.splice(indexNo, 1)

                            indexNo = featuredItems.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            featuredItems.likes.splice(indexNo, 1)

                        }


                        if(res.data.liked) {
                            if (res.data.liked.id !== undefined) {
                                this.aircraft.likes.push(res.data.liked)
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
        getList(title=null){
            this.$root.$data.isLoading=true

            let url;
            if(title){
                url = title
            }else{
                url =this.$route.params.id.split('-')[0]
            }
            axios.get('/ajax/aircraft/'+url).then(res=>{
                if(res.data.url=='404'){
                    this.$router.push({path:'/page-not-found'})
                }else{
                    this.aircraft=res.data
                    this.galleryImagePath=this.$root.getGalleryMainImagePath(res.data.medias)
                }

                this.$root.$data.isLoading=false

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
    },

}

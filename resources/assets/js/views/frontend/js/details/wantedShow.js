export default {

    data(){
        return{
            chartData1:[],

            wanted:{
                likes:[]
            },
            wantedListData:[],
            favouriteActive:false

        }
    },
    created(){
        this.$root.$data.isLoading = false
        this.getChart()

        this.getList()

    },
    computed:{
        metas(){

            this.setupSeoForDetailPage(this.wanted)
            return !!this.$store.state.seos.length
        },
        chartLoad(){
            if(this.chartData1){
                if(this.chartData1.hasOwnProperty('id')){
                    return true
                }
            }
        },
        getWantedByManufacturerList(){
            if(this.wanted.id){
                axios.get('/ajax/wanted/search',{
                    params:{
                        is_active_by_user:1,
                        asset_type:[this.wanted.type]
                    }
                }).then(res=>{
                    let wantedList = res.data.data
                    wantedList=wantedList.filter(data=> data.id !=this.$route.params.id.split('-')[0])
                    wantedList.length>2?wantedList.length=2:null
                    this.wantedListData=wantedList

                })
                return true
            }

        }
    },
    methods:{
        setupSeoForDetailPage(data){

            let title = Vue.filter('removeHyphen')(data.title)

            let manufacturer = data.manufacturer? data.manufacturer.name + '' : ''

            let type = data.typed? data.typed.name + ' is wanted for ' : ''

            //
            let model = data.model? data.model.name + '' : ''

            //
            let terms = data.terms
            //
            let description = manufacturer + model + type + terms +'. Enquire online on Airbook'
            //
            description = description.replace(/  /g, ' ')
            //
            this.$root.changeMeta(title, description, this.$root.$data.baseUrl +this.$root.getFeaturedImage(data.medias))

        },
        getChart(){
            axios.get('/ajax/getChart', {params:{
                    model:'Wanted',
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
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){

                        if(res.data.unlike){
                            if(this.wanted.id==res.data.unlike){
                                let indexNo = this.wanted.likes.findIndex(item=>
                                    item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                                this.wanted.likes.splice(indexNo, 1)
                            }else{
                                let item = this.wantedListData.filter(data=> data.id==res.data.unlike)[0]
                                let indexNo = item.likes.findIndex(item=>
                                    item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                                item.likes.splice(indexNo, 1)
                            }

                        }

                        if(res.data.liked) {
                            if (res.data.liked.id !== undefined) {
                                if(this.wanted.id==res.data.liked.likable_id){
                                    this.wanted.likes.push(res.data.liked)
                                }else{
                                    let item = this.wantedListData.filter(data=> data.id==res.data.liked.likable_id)[0]
                                    item.likes.push(res.data.liked)
                                }

                            }
                        }else{
                            // this.$root.alertMessage(res.data)
                        }
                    }
                })
                .catch(err=>{
                    if(err.response){
                        if(err.response.status==401){
                            this.$root.errorMessage(err.response, 'Please Login first then try again')
                            window.location.href='/login'
                        }
                    }

                })
        },
        getList(){
            this.$root.$data.isLoading = true
            axios.get('/ajax/wanted/'+this.$route.params.id.split('-')[0]).then(res=>{
                if(res.data.url=='404'){
                    this.$router.push({path:'/page-not-found'})
                }else{
                    this.wanted=res.data.wanted

                }
                this.$root.$data.isLoading = false
            })
        },



    }

}
export default {

    data(){
        return{
            event:{
                likes:[]
            },
            eventListData:[],
            interestedData:[],
            likesActive:false,

        }
    },
    created(){

        this.getList()

    },
    computed:{
        metas(){
            this.setupSeoForDetailPage(this.event)
            return !!this.$store.state.seos.length
        },
        getEventByCategory(){
            if(this.event.id){
                let category= this.event.categories.map(data=>{
                    return data.id
                })
                axios.get('/ajax/event/search',{
                    params:{
                        is_active_by_user:1,
                        category:category
                    }
                }).then(res=>{
                    let eventList = res.data.data
                    eventList=eventList.filter(data=> data.id !=this.$route.params.id.split('-')[0])
                    eventList.length>2?eventList.length=2:null
                    this.eventListData=eventList
                })
                return true;
            }

        },
        getInterestedById(){
            if(this.event.id){
                axios.get('/ajax/event/interested/'+this.event.id).then(res=>{
                    this.interestedData=res.data
                })
                return true;
            }

        }

    },
    methods:{
        setupSeoForDetailPage(data){
            let title = Vue.filter('removeHyphen')(data.title)
            let startDate = data.start_date?' from '+this.$moment(data.start_date).format('MMM Do YYYY'):''
            let endDate = data.end_date?' to '+this.$moment(data.end_date).format('MMM Do YYYY'):''
            let city = data.city?' in '+data.city.name:''
            let country = data.country? ', '+data.country.name:''
            let description = title + startDate+endDate+city+country+'. Read more on Airbook'
            this.$root.changeMeta(title, description, this.$root.$data.baseUrl +Vue.filter('globalMediaPath')(data.medias))
        },
        postEventInterested(index, modelId, modelPath){
            axios.post('/user/ajax/favourites', {id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.favourite){
                            if(this.event.id == res.data.favourite.favouritable_id){
                                this.event.hasInterested = true

                            }else{
                                let item = this.eventListData.filter(data=> data.id==res.data.favourite.favouritable_id)[0]
                                item.hasInterested = true

                            }
                        }
                        if(res.data.unfavourite){
                            if(this.event.id==res.data.unfavourite){
                                this.event.hasInterested = false
                            }else{
                                let item = this.eventListData.filter(data=> data.id==res.data.unfavourite)[0]
                                item.hasInterested=false
                            }

                        }
                    }

                })

        },
        postLike(modelId, modelPath){
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                            if(this.event.id==res.data.unlike){
                                let index = _.findIndex(this.event.likes, {likable_id:res.data.unlike})
                                this.event.likes.splice(index, 1)
                                this.likesActive=false

                            }else{
                                let item = this.eventListData.filter(data=> data.id==res.data.unlike)[0]
                                item.likes--
                                item.hasLike=false
                            }
                        }

                        if(res.data.liked.id!==undefined){

                                if(this.event.id==res.data.liked.likable_id){
                                    this.event.likes.push(res.data)
                                    this.likesActive=true
                                }else{
                                    let item = this.eventListData.filter(data=> data.id==res.data.liked.likable_id)[0]
                                    item.likes++
                                    item.hasLike=true
                                }

                        }
                    }
                })
                .catch(err=>{
                    if(err.response){

                        if(err.response.status==401){
                            this.$root.errorMessage(err.response, 'you are unable to do it')
                            window.location.href='/login'
                        }
                    }
                })
        },
        getList(){

            axios.get('/ajax/event/'+this.$route.params.id.split('-')[0]).then(res=>{
                this.event=res.data
            })

        }


    }

}
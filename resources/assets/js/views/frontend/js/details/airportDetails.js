import AirportEdit from '../../airport/airportEdit.vue'
export default {
    components:{
        AirportEdit,
    },
    data(){
        return{
            airport:{
                likes:[]
            },
            airportListData:[],
            airportsModal:false,
            favouriteActive:false,
            likesActive:false
        }
    },
    created(){

        this.getData()

    },
    computed:{
        metas(){
            this.setupSeoForDetailPage(this.airport)
            return !!this.$store.state.seos.length
        },
        getAirportByCountryId(){
            if(this.airport.country_id){
                axios.get('/ajax/airport/search',{
                    params:{
                        is_active_by_user:1,
                        country:[this.airport.country_id]
                    }
                }).then(res=>{
                    let airportList = res.data.data
                    airportList=airportList.filter(data=> data.id!=this.$route.params.id.split('-')[0])
                    airportList.length>2?airportList.length=2:null
                    this.airportListData=airportList
                })
            }
            return true

        }
    },
    methods:{
        setupSeoForDetailPage(data){

            let title = Vue.filter('removeHyphen')(data.name)

            let description = jQuery(data.name).text()

            description = description.substring(0,150).replace(/(\r\n\t|\n|\r\t)/gm, "")

            //
            this.$root.changeMeta(title, description, this.$root.$data.baseUrl +Vue.filter('globalMediaPath')(data.medias))

        },
        getData(){
            axios.get('/ajax/airport/'+this.$route.params.id).then(res=>{
                this.airport=res.data
            })
        },
        airportsEdit(){
            this.airportsModal=true
        } ,
        closeAirportModal(){
            this.airportsModal=false
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
        postLike(modelId, modelPath,type=null){
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                            if(type=='Contact'){
                                let indexNo = this.airport.user.contact.likes.findIndex(item=>
                                    item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                                this.airport.user.contact.likes.splice(indexNo, 1)
                            }else{
                                if(this.airport.id==res.data.unlike){
                                    let indexNo = this.airport.likes.findIndex(item=>
                                        item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                                    this.airport.likes.splice(indexNo, 1)
                                }else{
                                    let item = this.airportListData.filter(data=> data.id==res.data.unlike)[0]
                                    item.likes--
                                    item.hasLike=false
                                }
                            }

                        }

                        if(res.data.liked) {

                            if (res.data.liked.id !== undefined) {
                                if(type=='Contact'){

                                    this.airport.user.contact.likes.push(res.data.liked)

                                }else{
                                    if(this.airport.id==res.data.liked.likable_id){
                                        this.airport.likes.push(res.data.liked)

                                    }else{
                                        let item = this.airportListData.filter(data=> data.id==res.data.liked.likable_id)[0]
                                        item.likes++
                                        item.hasLike=true
                                    }
                                }

                            }
                        }else{

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



    }

}
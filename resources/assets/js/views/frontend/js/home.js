export default {

    data(){

        return{
            subscriberName:null,
            subscriberEmail:null,
            news:[],
        events:[],
        apus:[],
        wanteds:[],
        aircrafts:[],
        engines:[],
        modalFeaturedItem:{}
    }
    },
    computed:{
        _(){
          return _;
        },
        chunkFeatured(){
            return _.chunk(this.$root.$data.featured, 4)
        },

        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Home')
            return !!this.$store.state.seos.length
        }

    },
    created(){

        this.getAircraft()
        this.getEngine()
        this.getApu()
        this.getWanted()
        this.getNews()
        this.getEvents()

        console.log('testing')
    },
    methods:{
        postEventInterested(index, modelId, modelPath){
            axios.post('/user/ajax/favourites', {id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.favourite){
                            this.events[index].hasInterested = 1
                        }
                        if(res.data.unfavourite){
                            this.events[index].hasInterested = 0
                        }
                    }

                })

        },
        postLike(index, modelId, modelPath){
            let jsDataType;

            if( modelPath == 'App\\News' ){
                jsDataType = modelPath.replace('App\\','').toLowerCase()
            }
            else{
                jsDataType = modelPath.replace('App\\','').toLowerCase() + 's'
            }
            let jsDataTypeWithoutS=modelPath.replace('App\\','').toLowerCase()

            let featuredItems = this.$root.$data.featured.filter(item=>
                item.id == modelId && item.modelType==jsDataTypeWithoutS)[0]


            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{

                    if(res.data.unlike){
                        if(modelPath == 'App\\News' || modelPath == 'App\\Event'){
                            this[jsDataType][index].likes--
                            this[jsDataType][index].hasLike = 0
                        }else{
                            let items=this[jsDataType][index]
                            let indexNo = items.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            this[jsDataType][index].likes.splice(indexNo, 1)

                            indexNo = featuredItems.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            featuredItems.likes.splice(indexNo, 1)

                        }
                    }
                    if(res.data.liked!==undefined) {

                        if(modelPath == 'App\\News' || modelPath == 'App\\Event'){
                            if (res.data.liked.id !== undefined) {
                                this[jsDataType][index].likes++
                                this[jsDataType][index].hasLike = 1
                            }
                        }else{
                            if (res.data.liked.id !== undefined) {
                                this[jsDataType][index]['likes'].push(res.data.liked)
                                featuredItems.likes.push(res.data.liked)


                            }
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
        getMsn_esn_sn(value){
            if(value.modelType=='aircraft'){
                return  value.MSN
            }
            if(value.modelType=='engine'){
                return value.esn
            }
            if(value.modelType=='apu')
                return value.serial_number
        },

        getFeaturedImage(arr){
            for(let i=0;i<arr.length;i++){
                if(arr[i].is_featured==1){
                    if(arr[i]){
                        return '/storage/' + arr[i].path + '/' + arr[i].original_file_name
                    }
                }

            }
            if(arr[0]){
                return '/storage/' + arr[0].path + '/' + arr[0].original_file_name
            }
        },

        postSubscriber(){
            axios.post('/setting/subscriber',{
                name:this.subscriberName,
                email:this.subscriberEmail,
                is_active:1
            }).then(res=>{
                this.subscriberName = null,
                    this.subscriberEmail=null
                this.$root.alertMessage(res.data)
            })
        },
        getEvents(){
            axios.get('/ajax/event?resultPerPage=4&paging=true&date_over=31-12-2080&sortOrder=desc&sortName=id&is_active=1').then(res=>{
                this.events=res.data.data
            })
        },
        getNews(){
            axios.get('/ajax/news?resultPerPage=4&paging=true&sortOrder=desc&sortName=id&is_active=1').then(res=>{
                this.news=res.data.data
            })
        },
        getApu(){
            axios.get('/ajax/apu?resultPerPage=4&sortOrder=desc&sortName=id&is_active_by_user=1&isActiveStatus=Approved&sortOrder=desc&paging=true').then(res=>{
                this.apus=res.data.data
            })
        },
        getWanted(){
            axios.get('/ajax/wanted?resultPerPage=4&sortOrder=desc&sortName=id&is_active=1&sortOrder=desc&paging=true').then(res=>{
                this.wanteds=res.data.data
            })
        },
        getAircraft(){
            this.$root.$data.isLoading=true
            axios.get('/ajax/aircrafts?resultPerPage=4&sortName=id&sortName=id&sortOrder=desc&is_active_by_user=1&isActiveStatus=Approved&paging=true').then(res=>{
                this.aircrafts=res.data.data
                this.$root.$data.isLoading=false
            })
        },
        getEngine(){
            axios.get('/ajax/engine?resultPerPage=4&sortOrder=desc&sortName=id&&is_active_by_user=1&isActiveStatus=Approved&sortOrder=desc&paging=true').then(res=>{
                this.engines=res.data.data
            })
        }

    }

}
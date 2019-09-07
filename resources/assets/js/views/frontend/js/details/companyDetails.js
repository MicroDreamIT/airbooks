export default {

    data(){
        return{
            company:{
                likes:[]
            },
            assetListData:[],
            peopleList:[],
            news:null,
            likesActive:false,
            favouriteActive:false

        }
    },
    created(){
        this.$root.$data.isLoading = false

        this.getList()
        this.getNews()
    },
    computed:{
        getPeopleByCompanyId(){
            if(this.company.id){
                axios.get('/ajax/contact/search',{
                    params:{
                        is_active_by_user:1,
                        company:this.company.id
                    }
                }).then(res=>{
                    let peopleList = res.data.data
                    peopleList=peopleList.filter(data=> data.id !=this.$route.params.id)
                    // peopleList.length>2?peopleList.length=2:null
                    this.peopleList=peopleList
                })
                return true;
            }

        },
        getAssetByCompanyId(){
            if(this.company.id){
                axios.get('/ajax/promomix-without-featured/user.contact.company/id/'+this.company.id).then(res=>{
                    let assetList = res.data
                    assetList.length>2?assetList.length=2:null
                    this.assetListData=assetList

                })
                return true;
            }

        }
    },
    methods:{
        postLikeC(modelId, modelPath){
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                            let indexNo = this.company.likes.findIndex(item=>
                                item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                            this.company.likes.splice(indexNo, 1)
                            this.likesActive=false
                        }

                        if(res.data.liked){
                            if(res.data.liked.id!==undefined){
                                this.company.likes.push(res.data.liked)
                                this.likesActive=false
                            }
                        }
                    }
                })
                .catch(err=>{
                    if(err.response.status==401){
                        this.$root.errorMessage(err.response, 'you are unable to do it')
                        window.location.href='/login'
                    }
                })
        },
        getList(){
            this.$root.$data.isLoading = true

            axios.get('/ajax/company/'+this.$route.params.id).then(res=>{
                this.company=res.data
                this.$root.$data.isLoading = false

            })
        },
        getNews(){
            axios.get('/ajax/news?resultPerPage=2&sortOrder=desc&sortName=id&is_active=1&paging=true').then(res=>{
                this.news=res.data.data
            })
        },
        postFavourite(modelId, modelPath){

            axios.post('/user/ajax/favourites',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        this.$root.alertMessage(res.data)
                        this.favouriteActive=true
                    }
                })
                .catch(err=>{
                    if(err.response){
                        if(err.response.status==401){
                            window.location.href='/login'
                        }
                    }
                })
        },

        postLike(index, modelId, modelPath){
            let jsDataType = modelPath.replace('App\\','').toLowerCase()
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                                let item = this.news.filter(data=> data.id==res.data.unlike)[0]
                                item.likes--
                                item.hasLike=false
                        }
                        if(res.data.liked.id!==undefined){
                            let item = this.news.filter(data=> data.id==res.data.liked.likable_id)[0]
                            item.likes++
                            item.hasLike=true
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


    }

}
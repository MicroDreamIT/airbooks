export default {

    data(){
        return{
            news:{
                likes:[]
            },
            newsListData:[],
            likesActive:false


    }
    },
    created(){
        this.$root.$data.isLoading = false

        this.getList()

    },
    computed:{
        metas(){
            this.setupSeoForDetailPage(this.news)
            return !!this.$store.state.seos.length
        },
        getNewsByList(){
            if(this.news.id){
                let category= this.news.categories.map(data=>{
                    return data.id
                })
                axios.get('/ajax/news/search',{
                    params:{
                        is_active_by_user:1,
                        category:category
                    }
                }).then(res=>{
                    let newsList = res.data.data
                    newsList=newsList.filter(data=> data.id !=this.$route.params.id.split('-')[0])
                    newsList.length>2?newsList.length=2:null
                    this.newsListData=newsList
                })
                return true;
            }

        }
    },
    methods:{
        setupSeoForDetailPage(data){

            let title = Vue.filter('removeHyphen')(data.title)

            let description = jQuery(data.details).text()

            description = description.substring(0,150).replace(/(\r\n\t|\n|\r\t)/gm, "")

            //
            this.$root.changeMeta(title, description, this.$root.$data.baseUrl +Vue.filter('globalMediaPath')(data.medias))

        },
        postLike(modelId, modelPath){
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){
                            if(this.news.id==res.data.unlike){
                                let index = _.findIndex(this.news.likes, {likable_id:res.data.unlike})
                                this.news.likes.splice(index, 1)
                                this.likesActive=false

                            }else{
                                let item = this.newsListData.filter(data=> data.id==res.data.unlike)[0]
                                item.likes--
                                item.hasLike=false
                            }
                        }
                        if(res.data.liked.id!==undefined){

                            if(this.news.id==res.data.liked.likable_id){
                                this.news.likes.push(res.data)
                                this.likesActive=true
                            }else{
                                let item = this.newsListData.filter(data=> data.id==res.data.liked.likable_id)[0]
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
            this.$root.$data.isLoading = true

            axios.get('/ajax/news/'+this.$route.params.id.split('-')[0]).then(res=>{
                this.news=res.data
                this.$root.$data.isLoading = false
            })
        },


    }

}
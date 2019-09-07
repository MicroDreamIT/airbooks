export default {

    data(){
        return{
            news:[],
            paginationData:{}
        }
    },
    created(){
        this.$root.$data.isLoading = false

        this.getData()

    },

    computed:{
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'News')
            return !!this.$store.state.seos.length
        },
    },

    methods:{
        postLike(index, modelId, modelPath){
            let jsDataType = modelPath.replace('App\\','').toLowerCase()
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if (res.data.unlike !== undefined) {
                            this[jsDataType][index].likes--
                            this[jsDataType][index].hasLike=0
                        }
                        if(res.data.liked) {
                            if (res.data.liked.id !== undefined) {
                                this[jsDataType][index].likes++
                                this[jsDataType][index].hasLike=1
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

        getData(current_page){
            this.$root.$data.isLoading = true

            axios.get('/ajax/news?page='+current_page+'&resultPerPage=20&sortOrder=desc&sortName=id&is_active=1&paging=true').then(res=>{
                this.paginationData=res.data
                this.news=res.data.data
                this.$root.$data.isLoading = false

            })
        },
        searchEmitData(value){
            this.paginationData=value
            this.news=value.data
        }


    }

}
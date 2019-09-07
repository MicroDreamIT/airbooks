export default {

    data(){
        return{
            events:[],
            paginationData:{}

        }
    },
    created(){
        this.$root.$data.isLoading = false

        this.getData()

    },
    computed:{
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Event')
            return !!this.$store.state.seos.length
        },
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
            let jsDataType = modelPath.replace('App\\','').toLowerCase()+ 's';

            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if (res.data.unlike !== undefined) {
                            this[jsDataType][index].likes--
                            this[jsDataType][index].hasLike = 0
                        }
                        if(res.data.liked) {
                            if (res.data.liked.id !== undefined) {
                                this[jsDataType][index].likes++
                                this[jsDataType][index].hasLike = 1
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

            axios.get('/ajax/event?page='+current_page+'&resultPerPage=20&sortOrder=ASC&sortName=end_date&date_over=31-12-2080&is_active=1&paging=true').then(res=>{
                this.paginationData=res.data
                this.events=res.data.data
                this.$root.$data.isLoading = false

            })
        },
        searchEmitData(value){
            this.paginationData=value
            this.events=value.data
        }


    }

}
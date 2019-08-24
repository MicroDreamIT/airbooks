export default {

    data(){
        return{
            wanteds:[],
            paginationData:{},
            title:''


        }
    },
    created(){
        this.$root.$data.isLoading = false
        this.getGlobalSearch()
        this.getData(1)

    },
    watch:{
        '$route'(queryValue){
            this.title = JSON.parse(JSON.stringify(queryValue.query['title']).trim())
            this.getData(1)
        }
    },
    methods:{
        postLike(index, modelId, modelPath){
            let jsDataType = modelPath.replace('App\\','').toLowerCase() + 's'
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data.unlike!==undefined){

                        let items=this[jsDataType][index]
                        let indexNo = items.likes.findIndex(item=>
                            item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                        this[jsDataType][index].likes.splice(indexNo, 1)

                    }

                    if(res.data.liked!==undefined) {

                        if (res.data.liked.id !== undefined) {
                            this[jsDataType][index]['likes'].push(res.data.liked)
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
        getGlobalSearch(){
            if( !_.isEmpty(this.$route.query) && !this.title){
                this.title = JSON.parse(JSON.stringify(this.$route.query['title']).trim())
            }
        },

        getData(current_page){
            this.$root.$data.isLoading = true
            axios.get('/ajax/wanted?page='+current_page+'&resultPerPage=20&sortOrder=desc&sortName=id&is_active=1&sortOrder=desc&paging=true&title='+this.title).then(res=>{
                this.paginationData=res.data
                this.wanteds=res.data.data
                this.$root.$data.isLoading = false
            })
            this.title = ''

        },
        searchEmitData(value){
            this.paginationData=value
            this.wanteds=value.data
        }



    },

    computed:{
        _(){
            return _;
        },
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Wanted')
            return !!this.$store.state.seos.length
        },
    }

}

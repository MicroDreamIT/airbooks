export default {

    data(){
        return{
            engines:[],
            title:'',
            paginationData:{}
        }
    },
    created(){
        this.$root.$data.isLoading = false
        this.getGlobalSearch()
        this.getData(1)
    },

    computed:{
        _(){
            return _;
        },
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Engine')
            return !!this.$store.state.seos.length
        },

        chunkFeatured(){

            let engines = this.$root.findObjectByKey_in_array_and_return_them_array(this.$root.$data.featured, 'modelType', 'engine')

            return _.chunk(_.take(engines, 3), 3)
        }
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
            let featuredItems = this.$root.$data.featured.filter(item=> item.id == modelId && item.modelType=='engine')[0]
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data.unlike){

                        let items=this[jsDataType][index]
                        let indexNo = items.likes.findIndex(item=>
                            item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                        this[jsDataType][index].likes.splice(indexNo, 1)
                        indexNo = featuredItems.likes.findIndex(item=>
                            item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                        featuredItems.likes.splice(indexNo, 1)

                    }

                    if(res.data.liked!==undefined) {

                        if (res.data.liked.id !== undefined) {
                            this[jsDataType][index]['likes'].push(res.data.liked)
                            featuredItems.likes.push(res.data.liked)
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
            axios.get('/ajax/engine?page='+current_page+'&resultPerPage=20&sortOrder=desc&sortName=id&is_active_by_user=1&isActiveStatus=Approved&sortOrder=desc&paging=true&title='+this.title).then(res=>{
                this.paginationData=res.data
                this.engines=res.data.data
                this.$root.$data.isLoading = false
            })
            this.title = ''
        },
        searchEmitData(value){
            this.paginationData=value
            this.engines=value.data
        }



    }

}
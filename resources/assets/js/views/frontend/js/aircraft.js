export default {

    data(){
        return{
            aircrafts:[ ],
            title:'',
            paginationData:{}
        }
    },

    computed:{
        _(){
            return _;
        },
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Aircraft')
            return !!this.$store.state.seos.length
        },

        chunkFeatured(){

            let aircrafts = this.$root.findObjectByKey_in_array_and_return_them_array(this.$root.$data.featured, 'modelType', 'aircraft')

            return _.chunk(_.take(aircrafts, 3), 3)
        }
    },
    watch:{
        '$route'(queryValue){
            this.title = JSON.parse(JSON.stringify(queryValue.query['title']).trim())
            this.getData(1)
        }
    },
    created(){
        this.$root.$data.isLoading = false
        this.getGlobalSearch()
        this.getData(1)

    },
    methods:{
        postLike(index, modelId, modelPath){
            let jsDataType = modelPath.replace('App\\','').toLowerCase() + 's'
            let featuredItems = this.$root.$data.featured.filter(item=> item.id == modelId && item.modelType=='aircraft')[0]
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
                    if(err.response){
                        if(err.response.status==401){
                            this.$root.errorMessage(err.response, 'Please Login first then try again')
                            window.location.href='/login'
                        }
                    }

                })
        },
        getGlobalSearch(){
            if( !_.isEmpty(this.$route.query) && !this.title){
                this.title = JSON.parse(JSON.stringify(this.$route.query['title']))
            }
        },
        getData(current_page){
            this.$root.$data.isLoading = true
            axios.get('/ajax/aircrafts?page='+current_page+'&resultPerPage=20&sortOrder=desc&sortName=id&is_active_by_user=1&isActiveStatus=Approved&sortOrder=desc&paging=true&title='+this.title).then(res=>{
                this.paginationData=res.data
                this.aircrafts=res.data.data
                this.$root.$data.isLoading = false
            })
            this.title = ''
        },
        searchEmitData(value){
            this.paginationData=value
            this.aircrafts=value.data
        },

    }

}

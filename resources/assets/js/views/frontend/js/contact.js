export default {

    data(){
        return{
            contacts:[],
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
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Contact')
            return !!this.$store.state.seos.length
        },
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

                        let likeIndex = _.findIndex(this[jsDataType][index].likes, {likable_id:res.data.unlike})
                        this[jsDataType][index].likes.splice(likeIndex, 1)
                        this.$root.alertMessage(res.data)

                    }

                    if(res.data.liked!==undefined) {

                        if (res.data.liked.id !== undefined) {
                            this[jsDataType][index]['likes'].push(res.data.liked)
                            this.$root.alertMessage(res.data)
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
            axios.get('/contacts?page='+current_page+'&resultPerPage=20&sortOrder=desc&only_user_based_contact=true' +
                '&sortName=id&is_published=1&paging=true&title='+this.title).then(res=>{
                this.paginationData=res.data
                this.contacts=res.data.data
                this.$root.$data.isLoading = false
            })
            this.title=''
        },
        searchEmitData(value){
            this.paginationData=value
            this.contacts=value.data
        }


    }

}
export default {

    data(){
        return{
            companies:[],
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
            this.$root.setupSeo(this.$store.state.seos, 'Company')
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

            let jsDataType = 'companies'

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
        getGlobalSearch(){
            if( !_.isEmpty(this.$route.query) && !this.title){
                this.title = JSON.parse(JSON.stringify(this.$route.query['title']).trim())
            }
        },

        getData(current_page){
            this.$root.$data.isLoading = true

            axios.get('/company?page='+current_page+'&resultPerPage=20&sortOrder=desc&sortName=id&is_active=1&paging=true&title='+this.title).then(res=>{
                this.paginationData=res.data
                this.companies=res.data.data
                this.$root.$data.isLoading = false

            })
            this.title = ''
        },
        searchEmitData(value){
            this.paginationData=value
            this.companies=value.data
        }


    }

}
import AirportEdit from '../airport/airportEdit.vue'
export default {
    components:{
      AirportEdit,
    },
    computed:{
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Airport')
            return !!this.$store.state.seos.length
        }
    },
    data(){
        return{
            airports:[],
            title:'',
            paginationData:{},
            editId:0,
            airportsModal:false
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
        airportsEdit(id){
            this.editId=id
         this.airportsModal=true
           let catchBody =  document.getElementsByTagName("body");
               catchBody[0].style.overflow = 'hidden';
        } ,
        closeAirportModal(){
            this.airportsModal=false
            let catchBody =  document.getElementsByTagName("body");
            catchBody[0].style.overflow = 'unset';
        },
        postLike(index, modelId, modelPath){
            let jsDataType = modelPath.replace('App\\','').toLowerCase()+'s'
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
        getGlobalSearch(){
            if( !_.isEmpty(this.$route.query) && !this.title){
                this.title = JSON.parse(JSON.stringify(this.$route.query['title']).trim())
            }
        },

        getData(current_page){
            this.$root.$data.isLoading = true

            axios.get('/airport?page='+current_page+'&resultPerPage=20&sortOrder=desc&sortName=id&is_active=1&paging=true&title='+this.title).then(res=>{
                this.paginationData=res.data
                this.airports=res.data.data
                this.$root.$data.isLoading = false

            })
            this.title = ''
        },
        searchEmitData(value){
            this.paginationData=value
            this.airports=value.data
        }

    }

}

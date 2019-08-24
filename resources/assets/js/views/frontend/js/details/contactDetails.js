export default {

    data(){
        return{
            contact:{
                likes:[]
            },
            assetListData:[],
        }
    },
    created(){
        this.$root.$data.isLoading = false
        this.getList()

    },
    computed:{
        getContactByCreatorId(){
            if(this.contact.id){
                axios.get('/ajax/aircraft/search',{
                    params:{
                        is_active_by_user:1,
                        user_id:this.contact.user_id
                    }
                }).then(res=>{
                    let contactList = res.data.data
                    contactList=contactList.filter(data=> data.id !=this.$route.params.id)
                    contactList.length>2?contactList.length=2:null
                    this.contactListData=contactList
                })
                return true;
            }

        },
        getAssetByUserId(){
            if(this.contact.id){
                axios.get('/ajax/promomix-without-featured/user/id/'+this.contact.user_id).then(res=>{
                    let assetList = res.data
                    assetList.length>2?assetList.length=2:null
                    this.assetListData=assetList
                })
                return true;
            }

        }
    },
    methods:{
        postLike(modelId, modelPath){
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data.unlike){
                        let indexNo = this.contact.likes.findIndex(item=>
                            item.likable_id == modelId && item.user_id == this.$root.$data.user.id)
                        this.contact.likes.splice(indexNo, 1)
                    }

                    if(res.data){
                        if(res.data.liked.id!==undefined){
                            this.contact.likes.push(res.data.liked)
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
            axios.get('/ajax/contact/'+this.$route.params.id).then(res=>{
                this.contact=res.data
                this.$root.$data.isLoading = false
            })
        },


    }

}
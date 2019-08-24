export default {

    data(){
        return{
            sectionOne:null,
            sectionTwo:null,
            sectionThree:null,
            name:'',
            email:'',
            message:''

        }
    },
    created(){
        this.getData()
    },
    computed:{
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Help_Support')
            return !!this.$store.state.seos.length
        },
    },
    methods:{

        sendEmail(){
            axios.post('/ajax/support-email',{name:this.name, email:this.email, body:this.message})
                .then(res=>{
                    this.name=''
                        this.email=''
                        this.message=''
                    this.$root.alertMessage({type:'success', message:'Message has been sent to admin'})

                })
                .catch(err=>{

                })

        },

        getData(){
            axios.get('/ajax/cms/supports').then(res=>{
                this.sectionOne=res.data.filter(data=> data.section=='Section One')[0]
                this.sectionTwo=res.data.filter(data=> data.section=='Section Two')[0]
                this.sectionThree=res.data.filter(data=> data.section=='Section Three')[0]
            })
        }
    }

}

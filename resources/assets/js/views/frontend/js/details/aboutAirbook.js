export default {

    data(){
        return{
            sectionOne:null,
            sectionTwo:null,
            sectionThree:null,

        }
    },
    created(){
        this.getData()
    },
    computed:{
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'About_Airbook')
            return !!this.$store.state.seos.length
        },
    },
    methods:{

        getData(){
            axios.get('/ajax/cms/about-airbook').then(res=>{
                this.sectionOne=res.data.filter(data=> data.section=='Section One')[0]
                this.sectionTwo=res.data.filter(data=> data.section=='Section Two')[0]
                this.sectionThree=res.data.filter(data=> data.section=='Section Three')[0]
            })
        }
    }

}
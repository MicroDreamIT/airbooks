export default {

    data(){
        return{
            sectionOne:{},
            sectionTwo:{},
            sectionThree:{},
            sectionFour:{},
            sectionFive:{},
            sectionSix:{},
            sectionSeven:{},

        }
    },
    created(){
        this.getData()
    },
    computed:{
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Airbook_features')
            return !!this.$store.state.seos.length
        },
    },
    methods:{

        getData(){
            axios.get('/ajax/cms/airbook-features').then(res=>{
                this.sectionOne=res.data.filter(data=> data.section=='Section One')[0]
                this.sectionTwo=res.data.filter(data=> data.section=='Section Two')[0]
                this.sectionThree=res.data.filter(data=> data.section=='Section Three')[0]
                this.sectionFour=res.data.filter(data=> data.section=='Section Four')[0]
                this.sectionFive=res.data.filter(data=> data.section=='Section Five')[0]
                this.sectionSix=res.data.filter(data=> data.section=='Section Six')[0]
                this.sectionSeven=res.data.filter(data=> data.section=='Section Seven')[0]

            })
        },

    }

}
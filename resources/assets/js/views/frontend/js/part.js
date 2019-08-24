export default {
    name: "frontParts",
    data(){
        return {
            numbers:'',
            showLayout:false,
            parts:[],
            paginationData:{},
            selectedItems:[]
        }
    },
    computed:{
        _(){
            return _;
        },
        metas(){
            this.$root.setupSeo(this.$store.state.seos, 'Part')
            return !!this.$store.state.seos.length
        },

        items(){

            let nums = this.numbers.replace(/\n/g, ",")

            nums = nums.trim().split(',')

            nums = nums.filter(data=> data.length>1)

            return nums.map(data=>{
                return data.trim()
            })

        }
    },
    methods:{

        getData(current_page){

            if(this.items.length){
                this.$root.$data.isLoading = true
                axios.get('/ajax/part', {
                    params:{
                        numbers:JSON.stringify(this.items),
                        sortName:'part_number',
                        sortOrder:'desc',
                        paging:true,
                        is_active:1,
                        resultPerPage:20,
                        page:current_page
                    }
                }).then(res=>{
                    this.$root.$data.isLoading = false
                    this.showLayout=true
                    this.paginationData=res.data
                    this.parts = _.groupBy(res.data.data, 'primary_contact')
                    this.$refs.sideBarRef.getSideBarData()
                    if(this.parts.length>=0){
                        this.$root.$data.isLoading = false
                    }

                })
                .catch(err=>{

                 })

            }

        },
        searchEmitData(value){
            this.showLayout=true
            this.paginationData=value
            this.parts =  _.groupBy(value.data, 'primary_contact')
        }
    }
}
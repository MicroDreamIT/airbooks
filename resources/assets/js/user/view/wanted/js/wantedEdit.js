export default {
    data() {
        return {
            requestField: {},
            showCustom: false,
            formLabel: null,
            countries:[],
            wanted: {
                yom: new Date(),
                custom: []
            },
            buttonDisabled: false,
            options: {
                format: 'DD-MM-YYYY',
                useCurrent: true,
            },

        }
    },
    created(){
        this.getData(this.$route.params.id)
    },
    methods: {
        getData(id){
            axios.get('/user/ajax/wanted/'+id+'/edit')
                .then(res=>{
                    this.countries=res.data.countries
                    this.wanted=res.data.wanted
                    this.wanted.wanted_by=this.$root.parseDate(res.data.wanted.wanted_by)
                    this.wanted.primary_contact=res.data.wanted.contact

                    if(this.wanted.type=='aircraft'){
                        this.wanted.aircraftManufacturer=this.wanted.manufacturer
                        this.wanted.aircraftType=this.wanted.typed
                        this.wanted.aircraftModel=this.wanted.modeled
                    }
                    if(this.wanted.type=='engine'){
                        this.wanted.engineManufacturer=this.wanted.manufacturer
                        this.wanted.engineType=this.wanted.typed
                        this.wanted.engineModel=this.wanted.modeled
                    }
                    if(this.wanted.type=='apu'){
                        this.wanted.apuManufacturer=this.wanted.manufacturer
                        this.wanted.apuType=this.wanted.typed
                        this.wanted.apuModel=this.wanted.modeled
                    }
                })
        },
        saveAndClose(){

        },
        addCustom() {
            if (this.formLabel) {
                this.wanted.custom.push({label:this.formLabel, type: 'text', name: this.formLabel})
                this.formName = null
                this.formLabel = null
            }
        },
        deleteForm(index){
            this.wanted.custom.splice(index, 1)
        },
        updateWanted(){
            this.$validator.validateAll().then((result)=>{
                if(result){
                    axios.patch('/user/ajax/wanted/'+this.$route.params.id, this.wanted).then(res=>{
                        this.buttonDisabled=false,
                            this.$validator.reset(),
                            this.$root.successMessage(res.data.message)
                        this.$router.push({name:'userWantedIndex'})

                    }).catch(error=>{
                        let err;
                        let errs = error.response.data.errors
                        for (err in errs){
                            this.errors.add({
                                'field':err,
                                'msg':errs[err][0].split('_').join(' '),
                                'scope':'wanted'
                            })
                        }
                    })
                }
            })
        },
        saveAndClose(){
            this.postWanted(null,'redirect')
        },
        cancel(){
            this.$router.push({path:'/user/wanted'})
        },


    }
}
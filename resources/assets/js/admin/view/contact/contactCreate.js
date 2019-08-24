export default {
    name: "adminContactCreate",
    computed:{
        _(){
            return _;
        },
        birthdayValidation(){

            if(this.contact.birthday){
                this.dayValue = this.contact.birthday.replace('_','').slice(0,2).replace('-','')
                this.monthValue = this.contact.birthday.replace('_','').slice(3,5).replace('-','')
                if(this.monthValue>12 || this.dayValue>31){
                    this.birthDayErrorMessage='Day must be 1-31 and Month must be 1-12'
                }else{
                    this.birthDayErrorMessage=''
                }
            }


        },

    },

    mounted(){

    },

    data(){
        return {
            contact:{
                gender:'Male'
            },
            buttonDisabled:false,
            departments:[],
            birthDayErrorMessage:'',
            job_titles:[],
            companies:[],
            countries:[],
            country:null,
            states:[],
            state:null,
            cities:[],
            city:null,
            files: [],
            monthValue:0,
            dayValue:0,
            manualRemoveFiles: [],
            fileUpdateRequested: [],
            dropzoneOptions: {
                url: '/admin/category/file-upload',
                autoProcessQueue: false,
                thumbnailWidth: 200,
                maxFilesize: 2,
                addRemoveLinks: true,
                uploadMultiple:false,
                maxFiles:1
            },
        }
    },
    created(){

        axios.get('/admin/contacts/create').then(res=>{
            this.departments=res.data.departments
            this.job_titles=res.data.titles
            this.companies = res.data.companies
        })

        axios.get('/countries').then(res=>{
          this.countries = res.data
        })

    },

    mounted(){
        this.contact.preferred_contact_method = 'Both'
    },


    methods:{
        cancel(){
            this.$router.push({path:'/admin/contacts'})
        },
        saveAndClose(){
            let val='redirect';
            this.postContact('contact',val)
        },
        addingEvent(file) {
            this.files.push(file)
        },

        removeFile(file, error, xhr) {
            this.files = this.files.filter(function (item) {
                return item.name != file.name
            });
            if (file.manuallyAdded) {
                file.requested=true
                this.manualRemoveFiles.push(file)
            }
        },

        getState(){
            this.contact.state=null
            this.states=[]
            this.cities=[]
            this.contact.city=null

            if(this.contact.country){
                axios.get('/getStateNameByCountry',{
                    params:{
                        country_id:this.contact.country.id
                    }
                }).then(res=>{
                    this.states=res.data
                })
            }

        },

        getCity(){
            this.cities=[]
            this.contact.city=null

            if(this.contact.state){
                axios.get('/getCityNameByState',{
                    params:{
                        state_id:this.contact.state.id
                    }
                }).then(res=>{
                    this.cities=res.data
                })
            }
        },


        postContact(scope, val=null){

            console.log(this.errors)
            console.log(this.$validator.validateAll(scope))
            this.$validator.validateAll(scope).then((result)=>{

                if(this.files.length>0){
                    this.contact.file=this.files
                }
                if(this.monthValue>12 || this.dayValue>31) {
                   return false
                }
                if(result){
                    axios.post('/admin/contacts',
                        this.contact
                    ).then(res=>{
                        this.$root.successMessage(res.data.message)
                        this.buttonDisabled=false
                        this.contact={}
                        this.$validator.reset()
                        this.$refs.viewDropZone.removeAllFiles()
                        val==='redirect'?this.$router.push({path:res.data.redirection}):''
                    }).catch(error=>{
                        let err;
                        let errs = error.response.data.errors
                        for (err in errs){
                            this.errors.add({
                                'field':err,
                                'msg':errs[err][0],
                                'scope':'contact'
                            })
                        }
                    })
                }
            })
        }
    }
}
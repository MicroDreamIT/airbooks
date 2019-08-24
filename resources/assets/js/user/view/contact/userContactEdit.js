export default {
    name: "userContactCreate",
    computed:{
        _(){
            return _;
        }
    },

    mounted(){

    },
    data(){
        return {
            sErrors:[],
            openPageActive:'',
            secondPageActive:'',
            thirdPageActive:'',
            fourPageActive:'',
            fivePageActive:'',
            sixPageActive:'',
            stepOne:'',
            stepTwo:'',
            stepThree:'',
            stepFour:'',
            stepFive:'',
            stepSix:'',
            count:1,
            showItems:{},

            contact:{
                gender:'Male',
            },
            buttonDisabled:false,
            departments:[],
            job_titles:[],
            companies:[],
            countries:[],
            country:null,
            states:[],
            state:null,
            cities:[],
            city:null,
            files: [],
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
        this.goPage(1)
        axios.get('/user/ajax/contact/'+this.$route.params.id+'/edit').then(res=>{
            this.departments=res.data.departments
            this.job_titles=res.data.titles
            this.companies = res.data.companies
            this.contact=res.data.contact
            this.contact.requestFrom='User'
            // this.contact.email=res.data.contact.user.email
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
            this.$router.push({path:'/user/contacts'})
        },
        saveAndClose(){
            let val='redirect';
            this.postContact(null,val)
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
            if(this.contact.country) {
                axios.get('/getStateNameByCountry', {
                    params: {
                        country_id: this.contact.country.id
                    }
                }).then(response => {
                    this.states = response.data

                })
            }
        },
        getCity(){
            if (this.contact.state) {
                axios.get('/getCityNameByState',{
                    params:{
                        state_id:this.contact.state.id
                    }
                }).then(response=>{
                    this.cities=response.data

                })
            }

        },


        updateContact(scope){
            this.$validator.validateAll(scope).then((result)=>{
                if(result){
                    console.log(this.contact)
                    axios.patch('/user/ajax/contact/'+this.$route.params.id, this.contact).then(res=>{
                        this.buttonDisabled=false,
                            this.$validator.reset(),
                            this.$root.successMessage(res.data.message)
                        this.$router.push({name:'userContacts'})

                    }).catch(error=>{
                        let err;
                        this.sErrors=error.response.data.errors
                        let errs = error.response.data.errors
                        for (err in errs){
                            this.errors.add({
                                'field':err,
                                'msg':errs[err][0].split('_').join(' '),
                                'scope':'staticForm'
                            })
                        }
                    })
                }
            })

        },
        goPage(val){
            val==1?[this.openPageActive='active',this.count=1]:this.openPageActive=''
            val==2?[this.secondPageActive='active',this.count=2]:this.secondPageActive=''
            val==3?[this.thirdPageActive='active',this.count=3]:this.thirdPageActive=''
            val==4?[this.fourPageActive='active',this.count=4]:this.fourPageActive=''
            val==5?[this.fivePageActive='active',this.count=5]:this.fivePageActive=''
            val==6?[this.sixPageActive='active',this.count=6]:this.sixPageActive=''
            this.stepOne=val==1?'active':'complete'
            this.stepTwo=val==2?'active':val>2?'complete':null
            this.stepThree=val==3?'active':val>3?'complete':null
            this.stepFour=val==4?'active':val>4?'complete':null
            this.stepFive=val==5?'active':val>5?'complete':null
            this.stepSix=val==6?'active':null
        },
        checkThisPage(scope,val){
            this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    this.goPage(val)
                }
            });
        },
    }
}

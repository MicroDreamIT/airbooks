export default {
    name: "adminContactEdit",
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
                city:{
                    name:null,
                    state:{
                        name:null,
                        country:{
                            name:null
                        }
                    }
                },
            },
            buttonDisabled:false,
            departments:[],
            job_titles:[],
            companies:[],
            countries:[],
            states:[],
            cities:[],
            selected:{},
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
            sCount:0,
            cCount:0,
            birthDayErrorMessage:''
        }
    },
    created(){

        this.show(this.$route.params.id)

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
            if(this.sCount>0){
                this.contact.state = null
                this.contact.city = null
            }
            if(this.contact.country){
                axios.get('/getStateNameByCountry',{
                    params:{
                        country_id:this.contact.country.id
                    }
                }).then(res=>{
                    this.states=res.data
                })
            }
            this.sCount++
        },

        getCity(){
            if(this.contact.state){
                if(this.cCount>0) {
                    this.contact.city = null
                }
                axios.get('/getCityNameByState',{
                    params:{
                        state_id:this.contact.state.id
                    }
                }).then(res=>{
                    this.cities=res.data
                })
                this.cCount++
            }
        },

        show(id){
            let url ='/admin/contacts/'+id + '/edit'
            axios.get(url,{
                params:{

                }
            }).then(response=>{
                this.contact=response.data.contact
                let fil = response.data.contact.medias
                if(fil){
                    let image = {name: fil.original_file_name, contentId:fil.id}
                    this.$refs.viewDropZone.manuallyAddFile(image,'/storage/'+fil.path+'/'+fil.original_file_name)
                }
            })
        },

        cancel(){
            this.$router.push({path:'/admin/contacts'})
        },

        patchContact(scope, val=null){
            this.$validator.validateAll(scope).then((result)=>{
                if(result){
                    if(this.files.length>0){
                        this.contact.file = this.files
                    }
                    if(this.manualRemoveFiles.length>0){
                        this.contact.removeFiles = this.manualRemoveFiles
                    }
                    if(this.monthValue>12 || this.dayValue>31) {
                        return false
                    }
                    axios.patch('/admin/contacts/' + this.$route.params.id, this.contact).then(res=>{
                        this.$root.successMessage(res.data.message)
                        this.buttonDisabled=false
                        this.$validator.reset()
                        this.contact={}
                        this.$refs.viewDropZone.removeAllFiles()
                        this.$router.push({path:res.data.redirection})
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
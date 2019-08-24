export default {

    data(){
        return{
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

            suggestModal:false,
            fixedLabel:[
                'thrust_rating',
                'lsv_description',


            ],
            fixedLabel2:[
                'owner',
                'seller',
            ],
            apu:{
                price:0,
                custom:[],
                custom2:[],
                promote_status:false,
                attaches:[]
            },
            buttonDisabled:false,
            options: {
                format: 'DD-MM-YYYY',
                useCurrent: true,
            },
            companies:[],
            countries:[],
            formName:null,
            formLabel:null,
            planStatus:false,
            manualRemoveFiles: [],
            dropzoneOptions: {
                url: '/user/ajax/attach?model=Apu',
                autoProcessQueue: true,
                thumbnailWidth: 200,
                maxFilesize: 10,
                addRemoveLinks: true,
                uploadMultiple:false,
                maxFiles:10,
                dictDefaultMessage: 'Drop a PDF file here, or click to select a file to upload.',
                acceptedFiles:".pdf",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
        }
    },
    created(){
        this.create()
        this.goPage(1)
    },
    methods:{
        vsuccess(file, response){
            if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                this.apu.attaches.push({name:file.name, response:response})
            }
        },
        addingEvent(file) {
            // this.staticForm.attaches.push(file)

        },
        removeFile(file, error, xhr) {
            this.apu.attaches = this.apu.attaches.filter(function (item) {
                return item.name != file.name
            });
            if (file.manuallyAdded) {
                this.manualRemoveFiles.push(file)
            }
        },
        create(){
            axios.get('/user/ajax/apu/create')
                .then(res=>{
                    this.companies=res.data.companies
                    this.countries=res.data.countries
                    this.apu.primary_contact=res.data.user
                })
        },
        postApu(scope,val){

            this.$validator.validateAll(scope).then((result)=>{
                if (result){
                    this.apu.images = this.$root.$data.selectedImages
                    axios.post('/user/ajax/apu',
                        this.apu
                    ).then(response=>{
                        this.apu={ price:0,custom:[],custom2:[], attaches:[]}
                            this.buttonDisabled=false
                            this.$refs.viewDropZone.removeAllFiles()
                            this.$root.$data.selectedImages=[]
                            this.$validator.reset()
                            this.$root.successMessage(response.data)
                        this.goPage(1)
                        val==='redirect'?this.$router.push({path:'/user/apu'}):''

                    }).catch(error=>{
                        let err
                        this.sErrors=error.response.data.errors
                        let errs = error.response.data.errors
                        for (err in errs){
                            this.errors.add({
                                'field':err,
                                'msg':errs[err][0]
                            })
                        }
                    })
                }
            })
        },

        addForms(){
            let type;
            let preventNextTick;
            preventNextTick = this.formName
            let options=[];
            let fn=this.formName
            if(this.formName =='seller' || this.formName == 'owner'){
                type='select'
                this.companies.forEach(data=>{
                    options.push(data)
                })
            }
            else{
                type='text'
            }

            if( fn == 'thrust_rating' || fn == 'lsv_description'){
                this.apu.custom.push({label:fn, type:  type , name:fn, options:options})
                this.fixedLabel.splice(this.fixedLabel.indexOf(fn), 1);
                fn=null

            }
            if(fn == 'owner' || fn == 'seller'){
                this.apu.custom2.push({label:fn, type:  type , name:fn,options:options})
                this.fixedLabel2.splice(this.fixedLabel2.indexOf(fn), 1);
                fn=null
            }
            if(this.apu.custom || this.apu.custom2){
                this.$nextTick(() => {
                    if(preventNextTick !='owner' || preventNextTick!='seller'){
                        let getExceptDateForms = this.$refs.forms;
                        let exceptDateFormIndexes = getExceptDateForms.length - 1
                        getExceptDateForms[exceptDateFormIndexes].focus()
                    }

                })
            }

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
        deleteForm(index){
            let frm = this.apu.custom[index]
            let name = frm.name
            this.fixedLabel.push(name)
            this.apu.custom.splice(index, 1)
        },
        deleteForm2(index){
            let frm = this.apu.custom2[index]
            let name = frm.name
            this.fixedLabel2.push(name)
            this.apu.custom2.splice(index, 1)
        },
        checkThisPage(scope,val){
            this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    this.goPage(val)
                }
            });
        },
        saveAndClose(){
            this.postApu(null,'redirect')
        },
        statusChange(data){
            this.planStatus=data.status
            this.apu.is_featured=data.promote
        }

    }
}

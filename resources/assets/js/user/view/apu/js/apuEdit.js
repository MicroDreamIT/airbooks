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
                attaches:[],
                medias:[]
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
            manuallyAddFile:[],
            dropzoneOptions: {
                url: '/user/ajax/attach?model=Apu',
                thumbnailWidth: 200,
                maxFilesize: 10,
                addRemoveLinks: true,
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
        this.getData(this.$route.params.id)
        this.goPage(1)
    },
    methods:{
        vsuccess(file, response){
            if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                this.apu.attaches.push({name:file.name, response:response})
            }
            // console.log(this.staticForm)
        },
        addingEvent(file) {
            // this.staticForm.attaches.push(file)

        },
        removeFile(file, error, xhr) {
            this.apu.attaches = this.apu.attaches.filter(function (item) {
                return item.name != file.name
            });
            if (file.manuallyAdded) {
                // console.log(file.manuallyAdded)
                this.manualRemoveFiles.push(file)
                // this.staticForm.removeFileList = this.manualRemoveFiles
            }
            // console.log(this.staticForm)
        },
        manuallyLoadFiles(file){
            let fill = {name: file.original_file_name, contentId:file.id, size:123}
            this.$refs.viewDropZone.manuallyAddFile(fill,'/storage/'+file.path+'/'+file.original_file_name)
        },
        getData(id){
            axios.get('/user/ajax/apu/'+id+'/edit')
                .then(response=>{
                    this.companies=response.data.companies
                    this.countries=response.data.countries
                    this.apu=response.data.apu
                    if(this.apu.price){
                        this.apu.price=parseFloat(this.apu.price).toFixed(2)
                    }
                    this.apu.availability=this.$root.parseDate(response.data.apu.availability)

                    this.apu.primary_contact=response.data.apu.contact
                    this.apu.manufacturer=response.data.apu.manufacturer
                    this.apu.type=response.data.apu.type
                    this.apu.model=response.data.apu.model
                    this.$root.$data.selectedImages=response.data.apu.medias
                    this.$root.$data.selectedImages.filter(item=>{
                        item.src = '/storage/' + item.path + '/' + item.original_file_name
                        item.alt = item.original_file_name
                    })

                    this.apu.attaches = response.data.apu.attaches
                    // console.log(this.staticForm.attaches)
                    let attaches = response.data.apu.attaches

                    if(attaches.length>0){
                        for (let i=0; i<attaches.length;i++){
                            this.$nextTick(()=>{
                                this.manuallyLoadFiles(attaches[i])
                            })
                        }
                    }

                    this.customFieldData()
                    this.custom2FieldData()

                    // this.engine.type=response.data.engine.type
                })
        },
        updateApu(scope){
            this.$validator.validateAll(scope).then((result)=>{
                if(result){
                    this.apu.images = this.$root.$data.selectedImages
                    this.apu.removeFileList = this.manualRemoveFiles
                    axios.patch('/user/ajax/apu/'+this.$route.params.id, this.apu).then(res=>{
                        this.buttonDisabled=false,
                            this.$validator.reset(),
                            this.$root.successMessage(res.data.message)
                        this.$router.push({name:'userApuList'})

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
            this.planStatus=data
        },
        customFieldData(){
            var newObject=[]
            var count=0
                this.apu.thrust_rating?
                    [newObject[count++]= {label: 'thrust_rating', type: 'text', name: 'thrust_rating',
                        value: this.apu.thrust_rating},this.fixedLabel.splice(this.fixedLabel.indexOf('thrust_rating'), 1)]:null,
                this.apu.lsv_description?
                    [newObject[count++]= {label:'lsv_description', type:'text' , name:'lsv_description',
                        value:this.apu.lsv_description},this.fixedLabel.splice(this.fixedLabel.indexOf('lsv_description'), 1)]:null,
                this.apu.custom=newObject
        },
        custom2FieldData(){
            var newObject=[]
            var count=0
            this.apu.owner_id?
                [newObject[count++]= {label: 'owner', type: 'select', name: 'owner',
                    value: this.apu.owner,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('owner'), 1)]:null,
                this.apu.seller_id?
                    [newObject[count++]= {label: 'seller', type: 'select', name: 'seller',
                        value: this.apu.seller,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('seller'), 1)]:null,
                this.apu.custom2=newObject
        },

    }
}

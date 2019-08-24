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
            manualRemoveFiles: [],
            dropzoneOptions: {
                url: '/user/ajax/attach?model=Engine',
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
            engine:{
                price:0,
                custom:[],
                custom2:[],
                removeFileList:[],
                attaches:[]
            },
            fixedLabel:[
                'tso',
                'thrust_rating',
                'lsv_description',
            ],
            fixedLabel2:[
                'owner',
                'seller',
            ],
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
        }
    },
    created(){
        this.getData(this.$route.params.id)
        this.goPage(1)
    },
    methods:{
        vsuccess(file, response){
            if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                this.engine.attaches.push({name:file.name, response:response})
            }
            // console.log(this.staticForm)
        },
        addingEvent(file) {
            // this.staticForm.attaches.push(file)

        },
        removeFile(file, error, xhr) {
            this.engine.attaches = this.engine.attaches.filter(function (item) {
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
            axios.get('/user/ajax/engine/'+id+'/edit')
                .then(response=>{
                    this.companies=response.data.companies
                    this.countries=response.data.countries
                    this.engine=response.data.engine
                    if(this.engine.price){
                        this.engine.price=parseFloat(this.engine.price).toFixed(2)
                    }
                    this.engine.availability=this.$root.parseDate(response.data.engine.availability)
                    this.engine.primary_contact=response.data.engine.contact
                    this.engine.manufacturer=response.data.engine.manufacturer
                    this.engine.type=response.data.engine.type
                    this.engine.model=response.data.engine.model
                    this.$root.$data.selectedImages=response.data.engine.medias
                    this.$root.$data.selectedImages.filter(item=>{
                        item.src = '/storage/' + item.path + '/' + item.original_file_name
                        item.alt = item.original_file_name
                    })
                    this.customFieldData()
                    this.custom2FieldData()

                    this.engine.attaches = response.data.engine.attaches
                    // console.log(this.staticForm.attaches)
                    let attaches = response.data.engine.attaches

                    if(attaches.length>0){
                        for (let i=0; i<attaches.length;i++){
                            this.$nextTick(()=>{
                                this.manuallyLoadFiles(attaches[i])
                            })
                        }
                    }

                    // this.engine.type=response.data.engine.type
                })
        },


        updateEngine(scope){
            this.$validator.validateAll(scope).then((result)=>{
                if(result){
                    this.engine.images = this.$root.$data.selectedImages

                    this.engine.removeFileList = this.manualRemoveFiles


                    axios.patch('/user/ajax/engine/'+this.$route.params.id, this.engine).then(res=>{
                        this.buttonDisabled=false,
                            this.$validator.reset(),
                            this.$root.successMessage(res.data.message)
                        this.$router.push({name:'userEngineList'})

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
            let fn=this.formName
            let options=[];
            if(fn =='seller' || fn == 'owner'){
                type='select'
                this.companies.forEach(data=>{
                    options.push(data)
                })
            }
            else{
                type='text'
            }

            if( fn =='tso' || fn == 'thrust_rating' || fn == 'lsv_description'){
                this.engine.custom.push({label:fn, type:type , name:fn, options:options})
                this.fixedLabel.splice(this.fixedLabel.indexOf(fn), 1);
                fn=null

            }
            if(fn == 'owner' || fn == 'seller'){
                this.engine.custom2.push({label:fn, type:  type , name:fn,options:options})
                this.fixedLabel2.splice(this.fixedLabel2.indexOf(fn), 1);
                fn=null
            }
            if(this.engine.custom||this.engine.custom2){
                this.$nextTick(() => {
                    if(preventNextTick !='owner' || preventNextTick!='seller'){
                        let getExceptDateForms = this.$refs.forms;
                        let exceptDateFormIndexes = getExceptDateForms.length - 1
                        getExceptDateForms[exceptDateFormIndexes].focus()
                    }

                })
            }

        },

        deleteForm(index){
            let frm = this.engine.custom[index]
            let name = frm.name
            this.fixedLabel.push(name)
            this.engine.custom.splice(index, 1)
        },
        deleteForm2(index){
            let frm = this.engine.custom2[index]
            let name = frm.name
            this.fixedLabel2.push(name)
            this.engine.custom2.splice(index, 1)
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
        saveAndClose(){
            this.postEngine(null,'redirect')
        },
        cancel(){
            this.$router.push({path:'/user/engine'})
        },
        statusChange(data){
            this.planStatus=data
        },
        customFieldData(){
            var newObject=[]
            var count=0
            this.engine.tso?
                [newObject[count++]= {label: 'tso', type: 'text', name: 'tso',
                    value: this.engine.tso},this.fixedLabel.splice(this.fixedLabel.indexOf('tso'), 1)]:null,
                this.engine.thrust_rating?
                    [newObject[count++]= {label: 'thrust_rating', type: 'text', name: 'thrust_rating',
                        value: this.engine.thrust_rating},this.fixedLabel.splice(this.fixedLabel.indexOf('thrust_rating'), 1)]:null,
                this.engine.lsv_description?
                    [newObject[count++]= {label:'lsv_description', type:'text' , name:'lsv_description',
                        value:this.engine.lsv_description},this.fixedLabel.splice(this.fixedLabel.indexOf('lsv_description'), 1)]:null,
                this.engine.custom=newObject
        },
        custom2FieldData(){
            var newObject=[]
            var count=0
            this.engine.owner_id?
                [newObject[count++]= {label: 'owner', type: 'select', name: 'owner',
                    value: this.engine.owner,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('owner'), 1)]:null,
                this.engine.seller_id?
                    [newObject[count++]= {label: 'seller', type: 'select', name: 'seller',
                        value: this.engine.seller,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('seller'), 1)]:null,
                this.engine.custom2=newObject
        },

    }
}

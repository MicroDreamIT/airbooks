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
            manualRemoveFiles: [],
            fieldDisable:false,
            suggestModal:false,
            aircraft:[],
            staticForm:{
                price:0,
                custom:[],
                custom2:[],
                removeFileList:[]
            },
            options: {
                format: 'DD-MM-YYYY',
                useCurrent: true,
            },
            companies:[],
            airports:[],
            total_time:null,
            countries:[],
            fixedLabel:[
                'tsn',
                'csn',
                'mtow',
                'mlgw',
                'last_c_check',
                'compliance',
                'registration_number',
                'registration_country'

            ],
            fixedLabel2:[
                'owner',
                'seller',
                'manager',
                'current_operator',
                'previous_operator',
            ],
            formName:null,
            formLabel:null,
            dropzoneOptions: {
                url: '/user/ajax/attach?model=Aircraft',
                thumbnailWidth: 200,
                maxFilesize: 2,
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
        this.goPage(1)
        this.getData(this.$route.params.id)
    },

    methods:{
        vsuccess(file, response){
            if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                this.staticForm.attaches.push({name:file.name, response:response})
            }
            // console.log(this.staticForm)
        },
        addingEvent(file) {
            // this.staticForm.attaches.push(file)

        },
        removeFile(file, error, xhr) {
            this.staticForm.attaches = this.staticForm.attaches.filter(function (item) {
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

            axios.get('/user/ajax/aircraft/'+id+'/edit')
                .then(res=>{
                    // this.aircraft=res.data.aircraft
                    this.companies=res.data.companies
                    this.airports=res.data.airports
                    this.countries=res.data.countries
                    this.staticForm=res.data.aircraft
                    if(this.staticForm.price){
                        this.staticForm.price=parseFloat(this.staticForm.price).toFixed(2)
                    }
                    this.staticForm.availability=this.$root.parseDate(res.data.aircraft.availability)

                    this.staticForm.aircraftManufacturer=res.data.aircraft.manufacturer
                    this.staticForm.aircraftType=res.data.aircraft.type
                    this.staticForm.aircraftModel=res.data.aircraft.modeled
                    if(res.data.aircraft.engine_manufacturer || res.data.aircraft.engine_type || res.data.aircraft.engine_model){
                        this.staticForm.engineManufacturer=res.data.aircraft.engine_manufacturer
                        this.staticForm.engineType=res.data.aircraft.engine_type
                        this.staticForm.engineModel=res.data.aircraft.engine_model
                    }else {
                        this.fieldDisable=true
                    }

                    this.$root.$data.selectedImages=res.data.aircraft.medias
                    this.$root.$data.selectedImages.filter(item=>{
                        item.src = '/storage/' + item.path + '/' + item.original_file_name
                        item.alt = item.original_file_name
                    })

                    this.staticForm.attaches = res.data.aircraft.attaches
                    // console.log(this.staticForm.attaches)
                    let attaches = res.data.aircraft.attaches

                    if(attaches.length>0){
                        for (let i=0; i<attaches.length;i++){
                             this.$nextTick(()=>{
                                this.manuallyLoadFiles(attaches[i])
                            })
                        }
                    }

                    this.customFieldData()
                    this.custom2FieldData()


                })
        },

        addForms(){
            let type;
            let preventNextTick;
            preventNextTick = this.formName
            let fn=this.formName
            let options=[];
            if(fn=='tsn' || fn=='csn' || fn=='mtow'){
                type='number'
            }
            else if(fn=='last_c_check'){
                type='date'
            }
            else if(fn=='registration_country' ){
                type='select'
                this.countries.forEach(data=>{
                    options.push(data)
                })
            }else if(fn=='owner'||fn=='previous_operator' || fn=='current_operator'|| fn=='manager'|| fn=='seller'){
                type='select'
                this.companies.forEach(data=>{
                    options.push(data)
                })
            }
            else if(fn=='compliance'){
                type='select'

                options=['EASA', 'FAA', 'TBA']

            }
            else{
                type='text'
            }



            if( fn && fn !='custom' && fn != 'owner' && fn != 'previous_operator' && fn != 'current_operator' && fn != 'manager'  && fn != 'seller'){
                this.staticForm.custom.push({label:fn, type:  type , name:fn,options:options})
                this.fixedLabel.splice(this.fixedLabel.indexOf(fn), 1);
                fn=null
            }
            if(fn == 'owner' || fn == 'previous_operator' || fn == 'current_operator' || fn == 'manager'  || fn == 'seller'){
                this.staticForm.custom2.push({label:fn, type:  type , name:fn,options:options})
                this.fixedLabel2.splice(this.fixedLabel2.indexOf(fn), 1);
                fn=null
            }



            if(this.staticForm.custom.length || fn != 'owner' || fn != 'previous_operator' || fn != 'current_operator' || fn != 'manager'  || fn != 'seller' ){
                this.$nextTick(() => {
                    if(preventNextTick=='last_c_check'){
                        // let datePicker = this.$refs.datePicker1
                        // let elItem = datePicker[0].$el
                        // console.log(datePicker)
                        // elItem.focus()
                    }else if(preventNextTick=='registration_country'){
                        let selectItem = this.$refs[preventNextTick]
                        let elItem = selectItem[0].$refs.search
                        elItem.focus()
                    }else{
                        if(this.$refs.forms){
                            let getExceptDateForms = this.$refs.forms
                            let exceptDateFormIndexes = getExceptDateForms.length - 1
                            getExceptDateForms[exceptDateFormIndexes].focus()
                        }


                    }
                })
            }

        },

        deleteForm(index){
            let frm = this.staticForm.custom[index]
            let name = frm.name
            this.fixedLabel.push(name)
            this.staticForm.custom.splice(index, 1)
        },
        deleteForm2(index){
            let frm = this.staticForm.custom2[index]
            let name = frm.name
            this.fixedLabel2.push(name)
            this.staticForm.custom2.splice(index, 1)
        },
        updateAircraft(scope){
            this.$validator.validateAll(scope).then((result)=>{
                if(result){
                    this.staticForm.availability=this.staticForm.availability.split("/").join("-")

                    this.staticForm.images = this.$root.$data.selectedImages

                    this.staticForm.removeFileList = this.manualRemoveFiles

                    axios.patch('/user/ajax/aircraft/'+this.$route.params.id, this.staticForm).then(res=>{
                        this.buttonDisabled=false,
                        this.$validator.reset(),
                        this.$root.successMessage(res.data.message)
                        this.$router.push({name:'userAircrafts'})

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
        saveAndClose(){
            this.postForm(null,'redirect')
        },
        checkThisPage(scope,val){
            this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    this.goPage(val)
                }
            });
        },
        getUppercase(){
            this.staticForm.MSN=this.staticForm.MSN.toUpperCase()

        },
        statusChange(data){
            this.planStatus=data
        },
        removeAllEngine(){
            this.staticForm.engineManufacturer=null
            this.staticForm.engineType=null
            this.staticForm.engineModel=null
            this.fieldDisable=!this.fieldDisable
        },
        customFieldData(){
            var newObject=[]
            var count=0
                this.staticForm.tsn?
                    [newObject[count++]= {label: 'tsn', type: 'number', name: 'tsn',
                        value: this.staticForm.tsn},this.fixedLabel.splice(this.fixedLabel.indexOf('tsn'), 1)]:null,
                this.staticForm.csn?
                    [newObject[count++]= {label: 'csn', type: 'number', name: 'csn',
                        value: this.staticForm.csn},this.fixedLabel.splice(this.fixedLabel.indexOf('csn'), 1)]:null,
                this.staticForm.mtow?
                    [newObject[count++]= {label:'mtow', type:'number' , name:'mtow',
                        value:this.staticForm.mtow},this.fixedLabel.splice(this.fixedLabel.indexOf('mtow'), 1)]:null,
                this.staticForm.mlgw?
                    [newObject[count++]= {label:'mlgw', type:'number' , name:'mlgw',
                        value:this.staticForm.mlgw},this.fixedLabel.splice(this.fixedLabel.indexOf('mlgw'), 1)]:null,
                this.staticForm.last_c_check?
                    [newObject[count++] = {label:'last_c_check', type:'date' , name:'last_c_check',
                        value:this.parseDate(this.staticForm.last_c_check)},this.fixedLabel.splice(this.fixedLabel.indexOf('last_c_check'), 1)]:null,
                this.staticForm.compliance?
                    [newObject[count++]= {label:'compliance', type:'select' , name:'compliance',
                        value:this.staticForm.compliance,options:['EASA', 'FAA', 'TBA']},this.fixedLabel.splice(this.fixedLabel.indexOf('compliance'), 1)]:null,
                this.staticForm.registration_number?
                    [newObject[count++]= {label:'registration_number', type:'text' , name:'registration_number',
                        value:this.staticForm.registration_number},this.fixedLabel.splice(this.fixedLabel.indexOf('registration_number'), 1)]:null,
                this.staticForm.registration_country?
                    [newObject[count++]= {label:'registration_country', type:'select' , name:'registration_country',
                        value:this.staticForm.registered_in,options:this.countries},this.fixedLabel.splice(this.fixedLabel.indexOf('registration_country'), 1)]:null,
                this.staticForm.custom=newObject
        },
        custom2FieldData(){
            var newObject=[]
            var count=0
            this.staticForm.owner_id?
                [newObject[count++]= {label: 'owner', type: 'select', name: 'owner',
                    value: this.staticForm.owner,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('owner'), 1)]:null,
                this.staticForm.seller_id?
                    [newObject[count++]= {label: 'seller', type: 'select', name: 'seller',
                        value: this.staticForm.seller,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('seller'), 1)]:null,
                this.staticForm.manager_id?
                    [newObject[count++]= {label:'manager', type:'select' , name:'manager',
                        value:this.staticForm.manager,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('manager'), 1)]:null,
                this.staticForm.current_operator?
                    [newObject[count++]= {label:'current_operator', type:'select' , name:'current_operator',
                        value:this.staticForm.current_operator,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('current_operator'), 1)]:null,
                this.staticForm.previous_operator?
                    [newObject[count++]= {label:'previous_operator', type:'select' , name:'previous_operator',
                        value:this.staticForm.previous_operator,options:this.companies},this.fixedLabel2.splice(this.fixedLabel2.indexOf('previous_operator'), 1)]:null,
                this.staticForm.custom2=newObject
        },
        parseDate(val){
            if(val){
                var spliceDate = val.slice(0,10)
                const [year, month, day] =spliceDate.split('-');
                return month+'/'+day+'/'+year
            }

        },

    },
}

export default {

    data(){
        return{
            parts:{
                custom:[]
            },
            buttonDisabled:false,
            options: {
                format: 'DD-MM-YYYY',
                useCurrent: true,
            },
            altPartNumbers:[],
            conditions:[],
            releases:[],
            countries:[],
            fixedLabel:[
                'release',
                'unit_measure',
                'price',
                'location',
                'owner',
                'seller',
            ],
            formName:null,
            formLabel:null,
        }
    },
    created(){
        this.getData(this.$route.params.id)
    },
    methods:{
        getData(id){
            axios.get('/user/ajax/part/'+id+'/edit')
                .then(res=>{
                    this.companies=res.data.companies
                    this.countries=res.data.countries
                    this.conditions=res.data.conditions
                    this.releases=res.data.releases
                    this.parts=res.data.part
                    this.parts.primary_contact=res.data.part.contact
                    this.customFieldData()
                })
        },
        updateParts(){
            this.$validator.validateAll().then((result)=>{
                if(result){
                    axios.patch('/user/ajax/part/'+this.$route.params.id, this.parts).then(res=>{
                        this.buttonDisabled=false,
                            this.$validator.reset(),
                            this.$root.successMessage(res.data.message)
                        this.$router.push({name:'userPartsList'})

                    }).catch(error=>{
                        let err;
                        let errs = error.response.data.errors
                        for (err in errs){
                            this.errors.add({
                                'field':err,
                                'msg':errs[err][0].split('_').join(' '),
                                'scope':'parts'
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
            if(this.formName == 'price'){

                type='number'
            }
            else{
                type='select'
                if(this.formName=='release'){
                    this.releases.forEach(data=>{
                        options.push(data)
                    })

                }else if(this.formName=='unit_measure'){
                    options=['EA', 'KG','LBS','MM','CM','inch','foot','liter','gallon']
                }else if(this.formName=='location'){
                    this.countries.forEach(data=>{
                        options.push(data)
                    })
                }else{
                    this.companies.forEach(data=>{
                        options.push(data)
                    })
                }

            }

            if( this.formName && this.formName !='custom' && this.formLabel==null){
                this.parts.custom.push({label:this.formName, type:  type , name:this.formName, options:options})
                this.fixedLabel.splice(this.fixedLabel.indexOf(this.formName), 1);
                this.formName=null
            }

        },

        deleteForm(index){
            let frm = this.parts.custom[index]
            let name = frm.name
            this.fixedLabel.push(name)
            this.parts.custom.splice(index, 1)
        },

        saveAndClose(){
            this.postParts('redirect')
        },

        cancel(){
            this.$router.push({path:'/user/parts'})
        },
        customFieldData(){
            var newObject=[]
            var count=0
            this.parts.unit_measure?
                [newObject[count++]= {label: 'unit_measure', type: 'select', name: 'unit_measure',
                    value: this.parts.unit_measure,options:['EA', 'KG','LBS','MM','CM','inch','foot','liter','gallon']},this.fixedLabel.splice(this.fixedLabel.indexOf('unit_measure'), 1)]:null,
                this.parts.price?
                    [newObject[count++]= {label: 'price', type: 'number', name: 'price',
                        value: this.parts.price},this.fixedLabel.splice(this.fixedLabel.indexOf('price'), 1)]:null,
                this.parts.location?
                    [newObject[count++]= {label:'location', type:'select' , name:'location',
                        value:this.parts.current_location, options:this.countries},this.fixedLabel.splice(this.fixedLabel.indexOf('location'), 1)]:null,
                this.parts.owner?
                    [newObject[count++]= {label:'owner', type:'select' , name:'owner',
                        value:this.parts.owner, options:this.companies},this.fixedLabel.splice(this.fixedLabel.indexOf('owner'), 1)]:null,
                this.parts.seller?
                    [newObject[count++]= {label:'seller', type:'select' , name:'seller',
                        value:this.parts.seller, options:this.companies},this.fixedLabel.splice(this.fixedLabel.indexOf('seller'), 1)]:null,
                this.parts.release?
                    [newObject[count++]= {label:'release', type:'select' , name:'release',
                        value:this.parts.release, options:this.releases},this.fixedLabel.splice(this.fixedLabel.indexOf('release'), 1)]:null,
                this.parts.custom=newObject
        },


    }
}
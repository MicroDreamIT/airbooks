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
            primarContact:null
        }
    },
    created(){
        this.create()
    },
    methods:{
        create(){
            axios.get('/user/ajax/part/create')
                .then(res=>{
                    this.companies=res.data.companies
                    this.countries=res.data.countries
                    this.conditions=res.data.conditions
                    this.releases=res.data.releases
                    this.primarContact=res.data.user
                    this.parts.primary_contact=this.primarContact
                })
        },
        postParts(val){
            this.$validator.validateAll().then((result)=>{
                if (result){
                    axios.post('/user/ajax/part',
                        this.parts
                    ).then(response=>{
                        this.parts={custom:[]},
                            this.parts.primary_contact=this.primarContact
                            this.buttonDisabled=false,
                            this.$validator.reset(),
                            this.$root.successMessage(response.data),
                        val==='redirect'?this.$router.push({path:'/user/parts'}):''

                    }).catch(error=>{
                        let err
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
            // if(this.formName == 'custom' && this.formLabel){
            //     this.parts.custom.push({label:this.formLabel, type:'text', name:this.formLabel})
            //     this.formName=null
            //     this.formLabel=null
            //
            // }

            // if(this.parts.custom.length){
            //     this.$nextTick(() => {
            //         if(preventNextTick=='owner' || preventNextTick=='seller'){
            //
            //         }
            //         else{
            //             let getExceptDateForms = this.$refs.forms;
            //             let exceptDateFormIndexes = getExceptDateForms.length - 1
            //             getExceptDateForms[exceptDateFormIndexes].focus()
            //         }
            //     })
            // }

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
            }

    }
}
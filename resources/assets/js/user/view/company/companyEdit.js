export default {
    data() {
        return {
            name: null,
            website: null,
            city: null,
            state:null,
            country:null,
            poBox: null,
            address: null,
            zipcode: null,
            aog_email:null,
            rfq_email:null,
            speciality: null,
            businessNumber: null,
            profile: null,
            is_active: 1,
            buttonDisabled: false,
            cities: [],
            specialities: [],
            countries:[],
            states:[],
            company:{},
            files: [],
            company_id:'',
            manualRemoveFiles: [],
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
        this.edit(this.$route.params.id)
    },
    methods: {
        addingEvent(file) {

            this.files.push(file)

        },
        removeFile(file, error, xhr) {
            this.files = this.files.filter(function (item) {
                return item.name != file.name
            });
            if (file.manuallyAdded) {
                this.manualRemoveFiles.push(file)
            }
        },
        edit(id){
            axios.get('/user/ajax/company/edit').then(response=>{
                this.countries=response.data.countries
                this.state=response.data.states
                this.city=response.data.cities
                this.specialities= response.data.specialities
                this.company=response.data.company
                this.name = response.data.company.name
                this.website = response.data.company.website,
                    this.country = response.data.company.country
                this.state = response.data.company.state
                this.city = response.data.company.city
                this.poBox = response.data.company.po_box
                this.address = response.data.company.address
                this.zipcode = response.data.company.zip_code
                this.aog_email=response.data.company.aog_email,
                    this.rfq_email=response.data.company.rfq_email,
                    this.speciality = response.data.company.specialities
                this.profile = response.data.company.profile
                this.businessNumber = response.data.company.business_phone
                this.is_active = response.data.company.is_active
                this.company_id=response.data.company.id
                let fil = response.data.company.medias
                if(fil){
                    let image = {name: fil.original_file_name, contentId:fil.id}
                    this.$refs.viewDropZone.manuallyAddFile(image,'/storage/'+fil.path+'/'+fil.original_file_name)
                }
            })
        },
        updateCompany(){
            this.$validator.validateAll().then((result)=>{
                if (result){
                    axios.patch('/user/ajax/company/update/'+ this.company_id,{
                        name: this.name,
                        website: this.website,
                        city_id: this.city?this.city.id:null,
                        state_id: this.state?this.state.id:null,
                        country_id: this.country?this.country.id:null,
                        po_box: this.poBox,
                        address: this.address,
                        zip_code: this.zipcode,
                        aog_email:this.aog_email,
                        rfq_email:this.rfq_email,
                        speciality_id: this.speciality,
                        business_phone: this.businessNumber,
                        profile: this.profile,
                        is_active: this.is_active,
                        file:this.files,
                        removeFiles: this.manualRemoveFiles
                    }).then(response=>{
                        this.buttonDisabled=true
                        this.$root.successMessage(response.data.message)
                        this.buttonDisabled=false
                        this.$validator.reset()
                        this.$router.push({path:'/user/dashboard'})
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
        cancel(){
            this.$router.push({path:'/admin/company'})
        },
        getState(){
            if(this.country) {
                axios.get('/getStateNameByCountry', {
                    params: {
                        country_id: this.country.id
                    }
                }).then(response => {
                    this.states = response.data
                    this.company.country.id == this.country.id ?
                        this.state = this.company.state :
                        this.state = null
                })
            }
        },
        getCity(){
            if (this.state) {
                axios.get('/getCityNameByState',{
                    params:{
                        state_id:this.state.id
                    }
                }).then(response=>{
                    this.cities=response.data
                    this.company.state.id==this.state.id?
                        this.city = this.company.city:
                        this.city=null
                })
            }

        }
    }

}
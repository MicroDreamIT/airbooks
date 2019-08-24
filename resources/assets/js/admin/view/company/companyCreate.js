export default {
    data() {
        return {
            name: null,
            website: null,
            city: null,
            state: null,
            country: null,
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
            countries: [],
            states: [],
            files: [],
            manualRemoveFiles: [],
            dropzoneOptions: {
                url: '/admin/category/file-upload',
                autoProcessQueue: false,
                thumbnailWidth: 200,
                maxFilesize: 2,
                addRemoveLinks: true,
                uploadMultiple: false,
                maxFiles: 1
            },
        }
    },
    created() {
        axios.get('/admin/company/create').then(response => {
            this.countries = response.data.countries
            this.specialities = response.data.specialities
        }).catch(error => {
        })
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
        postCompany(val) {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    axios.post('/admin/company', {

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
                        file: this.files

                    }).then(response => {
                        this.buttonDisabled = true
                        this.$root.successMessage(response.data)
                        this.name = null
                        this.website = null,
                         this.city = null
                        this.state = null
                        this.country = null
                        this.poBox = null
                        this.address = null
                        this.zipcode = null
                        this.aog_email=null,
                        this.rfq_email=null,
                        this.speciality = null
                        this.profile = null
                        this.businessNumber = null
                        this.is_active = 1
                        this.$validator.reset()
                        this.$refs.viewDropZone.removeAllFiles()
                        this.buttonDisabled = false
                        val === 'redirect' ? this.$router.push({path: '/admin/company'}) : ''
                    }).catch(error => {
                        let err
                        let errs = error.response.data.errors
                        for (err in errs) {
                            this.errors.add({
                                'field': err,
                                'msg': errs[err][0]
                            })
                        }
                    })
                }
            })
        },
        saveAndClose() {
            let val = 'redirect';
            this.postCompany(val)
        },
        cancel() {
            this.$router.push({path: '/admin/company'})
        },
        getState() {
            if(this.country){
                axios.get('/getStateNameByCountry', {
                    params: {
                        country_id: this.country.id
                    }
                }).then(response => {
                    this.state = null
                    this.states = response.data
                })
            }

        },
        getCity() {
            if (this.state) {
                axios.get('/getCityNameByState', {
                    params: {
                        state_id: this.state.id
                    }
                }).then(response => {
                    this.city = null
                    this.cities = response.data
                })
            }
        }
    }

}
export default new Vue({
    el: '#register',
    data: {
        registerStep1: true,
        country: null,
        state: null,
        states: [],
        city: null,
        cities: [],
        profile_photo: '',
        first_name: '',
        last_name: '',
        company: null,
        job_title: null,
        companyErrorMessage: '',
        companies: []
    },
    methods: {
        step1Validation() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.registerStep1 = false
                }
            })
        },
        step2Validation() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    if (this.company) {
                        let form = document.getElementById('register')
                        form.submit();
                    } else {
                        this.companyErrorMessage = 'The company field is required'
                    }


                }
            })

        },
        cancelValidation() {
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.registerStep1 = true
                }
            })
        },
        onFileChange(e) {
            this.profile_photo = e.target.files[0]
            this.profile_photo = URL.createObjectURL(this.profile_photo)
        },
        getCity() {
            this.city = null
            if (this.state) {
                axios.get('/getCityNameByState', {
                    params: {state_id: this.state ? this.state.id : null}
                })
                    .then(res => {
                        this.cities = res.data
                        $('#city').focus()
                    })
            }

        },
        getState() {
            this.state = null
            if (this.country) {
                axios.get('/getStateNameByCountry', {
                    params: {
                        country_id: this.country ? this.country.id : null
                    }
                }).then(res => {
                        this.states = res.data
                        $('#state').focus()
                    })
            }

        },
        onSearch() {
            let val =document.getElementById('company').getElementsByTagName('input')[0].value
            axios.get('company?resultPerPage=10&sortOrder=desc&sortName=id&is_active=1&searchKey=companies.name&&searchValue='+val+'&sortOrder=desc&paging=true', {

            }).then(res => {
                this.companies=res.data.data
             })
        }
    }
})
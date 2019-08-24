export default {

    data() {
        return {
            sErrors: [],
            openPageActive: '',
            secondPageActive: '',
            thirdPageActive: '',
            fourPageActive: '',
            fivePageActive: '',
            sixPageActive: '',
            stepOne: '',
            stepTwo: '',
            stepThree: '',
            stepFour: '',
            stepFive: '',
            stepSix: '',
            count: 1,
            options: {
                format: 'DD-MM-YYYY',
                useCurrent: true,
            },
            fieldDisable: false,
            suggestModal: false,
            manualRemoveFiles: [],
            dropzoneOptions: {
                url: '/user/ajax/attach?model=Aircraft',
                autoProcessQueue: true,
                thumbnailWidth: 200,
                maxFilesize:2,
                addRemoveLinks: true,
                uploadMultiple: false,
                maxFiles: 10,
                dictDefaultMessage: 'Drop a PDF file here, or click to select a file to upload.',
                acceptedFiles: ".pdf",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            staticForm: {
                price: 0,
                custom: [],
                custom2: [],
                promote_status: false,
                attaches: []
            },
            companies: [],
            airports: [],
            total_time: null,
            countries: [],
            fixedLabel: [
                'tsn',
                'csn',
                'mtow',
                'mlgw',
                'last_c_check',
                'compliance',
                'registration_number',
                'registration_country'

            ],
            fixedLabel2: [
                'owner',
                'seller',
                'manager',
                'current_operator',
                'previous_operator',


            ],
            formName: null,
            formLabel: null,
            planStatus: false,

        }

    },
    created() {
        this.goPage(1)
        this.create()
    },
    methods: {
        vsuccess(file, response) {
            if(this.dropzoneOptions.maxFilesize >= file.size/(1024*1024)){
                this.staticForm.attaches.push({name: file.name, response: response})
            }
        },
        addingEvent(file) {
            // this.staticForm.attaches.push(file)

        },
        removeFile(file, error, xhr) {
            this.staticForm.attaches = this.staticForm.attaches.filter(function (item) {
                return item.name != file.name
            });
            if (file.manuallyAdded) {
                this.manualRemoveFiles.push(file)
            }
        },
        create() {


            axios.get('/user/ajax/aircraft/create')
                .then(res => {
                    this.companies = res.data.companies
                    this.airports = res.data.airports
                    this.countries = res.data.countries
                    this.staticForm.primary_contact = res.data.user
                })
        },
        getCompanies() {

        },
        addForms() {
            let type;
            let preventNextTick;
            preventNextTick = this.formName
            let fn = this.formName
            let options = [];


            if (fn == 'tsn' || fn == 'csn' || fn == 'mtow') {
                type = 'number'
            }
            else if (fn == 'last_c_check') {
                type = 'date'
            }
            else if (fn == 'registration_country') {
                type = 'select'
                this.countries.forEach(data => {
                    options.push(data)
                })
            } else if (fn == 'owner' || fn == 'previous_operator' || fn == 'current_operator' || fn == 'manager' || fn == 'seller') {
                type = 'select'
                this.companies.forEach(data => {
                    options.push(data)
                })
            }
            else if (fn == 'compliance') {
                type = 'select'

                options = ['EASA', 'FAA', 'TBA']

            }
            else {
                type = 'text'
            }


            if (fn && fn != 'custom' && fn != 'owner' && fn != 'previous_operator' && fn != 'current_operator' && fn != 'manager' && fn != 'seller') {
                this.staticForm.custom.push({label: fn, type: type, name: fn, options: options})
                this.fixedLabel.splice(this.fixedLabel.indexOf(fn), 1);
                fn = null
            }
            if (fn == 'owner' || fn == 'previous_operator' || fn == 'current_operator' || fn == 'manager' || fn == 'seller') {
                this.staticForm.custom2.push({label: fn, type: type, name: fn, options: options})
                this.fixedLabel2.splice(this.fixedLabel2.indexOf(fn), 1);
                fn = null
            }


            if (this.staticForm.custom.length || fn != 'owner' || fn != 'previous_operator' || fn != 'current_operator' || fn != 'manager' || fn != 'seller') {
                this.$nextTick(() => {
                    if (preventNextTick == 'last_c_check') {
                        // let datePicker = this.$refs.datePicker1
                        // let elItem = datePicker[0].$el
                        // console.log(datePicker)
                        // elItem.focus()
                    } else if (preventNextTick == 'registration_country') {
                        let selectItem = this.$refs[preventNextTick]
                        let elItem = selectItem[0].$refs.search
                        elItem.focus()
                    } else {
                        if (this.$refs.forms) {
                            let getExceptDateForms = this.$refs.forms
                            let exceptDateFormIndexes = getExceptDateForms.length - 1
                            getExceptDateForms[exceptDateFormIndexes].focus()
                        }


                    }
                })
            }

        },

        deleteForm(index) {
            let frm = this.staticForm.custom[index]
            let name = frm.name
            this.fixedLabel.push(name)
            this.staticForm.custom.splice(index, 1)
        },
        deleteForm2(index) {
            let frm = this.staticForm.custom2[index]
            let name = frm.name
            this.fixedLabel2.push(name)
            this.staticForm.custom2.splice(index, 1)
        },
        postForm(scope, val) {
            this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    this.staticForm.images = this.$root.$data.selectedImages
                    axios.post('/user/ajax/aircraft', this.staticForm).then(res => {
                        this.staticForm = {
                            price: 0,
                            custom: [],
                            custom2: [],
                            attaches: []
                        }
                        this.buttonDisabled = false
                        this.$validator.reset()
                        this.$refs.viewDropZone.removeAllFiles()
                        this.$root.$data.selectedImages = []
                        this.goPage(1)
                        this.$root.successMessage(res.data)
                        val === 'redirect' ? this.$router.push({path: '/user/aircraft'}) : ''
                    }).catch(error => {
                        let err
                        this.sErrors = error.response.data.errors
                        let errs = error.response.data.errors
                        for (err in errs) {
                            this.errors.add({
                                'field': err,
                                'msg': errs[err][0].split('_').join(' '),
                                'scope': 'staticForm'
                            })
                        }
                    })
                }
            })
        },
        goPage(val) {
            val == 1 ? [this.openPageActive = 'active', this.count = 1] : this.openPageActive = ''
            val == 2 ? [this.secondPageActive = 'active', this.count = 2] : this.secondPageActive = ''
            val == 3 ? [this.thirdPageActive = 'active', this.count = 3] : this.thirdPageActive = ''
            val == 4 ? [this.fourPageActive = 'active', this.count = 4] : this.fourPageActive = ''
            val == 5 ? [this.fivePageActive = 'active', this.count = 5] : this.fivePageActive = ''
            val == 6 ? [this.sixPageActive = 'active', this.count = 6] : this.sixPageActive = ''
            this.stepOne = val == 1 ? 'active' : 'complete'
            this.stepTwo = val == 2 ? 'active' : val > 2 ? 'complete' : null
            this.stepThree = val == 3 ? 'active' : val > 3 ? 'complete' : null
            this.stepFour = val == 4 ? 'active' : val > 4 ? 'complete' : null
            this.stepFive = val == 5 ? 'active' : val > 5 ? 'complete' : null
            this.stepSix = val == 6 ? 'active' : null
        },
        saveAndClose() {
            this.postForm(null, 'redirect')
        },
        checkThisPage(scope, val) {
            this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    this.goPage(val)
                }
            });
        },
        getUppercase() {
            this.staticForm.MSN = this.staticForm.MSN.toUpperCase()

        },
        statusChange(data) {
            this.planStatus = data.status
            this.staticForm.is_featured = data.promote
        },
        removeAllEngine(){
            this.staticForm.engineManufacturer=null
            this.staticForm.engineType=null
            this.staticForm.engineModel=null
            this.fieldDisable=!this.fieldDisable
        }

    },
}

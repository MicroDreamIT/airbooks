export default {

    data(){
        return{
            sError:{},
            title:null,
            address:null,
            continent:null,
            region:null,
            country:null,
            state:null,
            city:null,
            website:null,
            category:null,
            location:null,
            details:null,
            is_active:true,
            cities:[],
            categories:[],
            continents:[],
            regions:[],
            countries:[],
            states:[],

            buttonDisabled:false,

            start_date: new Date(),
            options: {
                format: 'DD/MM/YYYY',
                useCurrent: true,
            },
            end_date: new Date(),

            image:[],
            files: [],
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
            config: {
                toolbar: [
                    { name: 'document', items: [ 'Source', '-', 'Preview',] },
                    { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                        'Undo', 'Redo' ] },
                    { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },

                    '/',
                    { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike',
                        'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                    { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent',
                        'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                        'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                    { name: 'insert', items: [ 'base64image'] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                ],

                height: 300
            }

        }
    },

    created(){
        axios.get('/admin/event/create').then(response => {
            this.cities=response.data.cities,
                this.continents=response.data.continents,
                this.regions=response.data.regions,
                this.categories=response.data.categories
        })
    },
    methods:{
        getCity() {
            if(this.state){
                axios.get('/getCityNameByState', {
                    params: {
                        state_id: this.state.id
                    }
                }).then(response => {
                    this.city = null
                    this.cities = response.data
                })
            }

        },
        getState() {
            if(this.country){
                axios.get('/getStateNameByCountry', {
                    params: {
                        country_id: this.country.id
                    }
                }).then(response => {
                    this.city = null
                    this.cities=[]
                    this.state = null
                    this.states = response.data
                })
            }

        },
        getCountry() {
            if(this.region){
                axios.get('/getCountryNameByRegion', {
                    params: {
                        region_id: this.region.id
                    }
                }).then(response => {
                    this.city = null
                    this.cities=[]
                    this.state = null
                    this.states = []
                    this.country = null
                    this.countries = response.data
                })
            }

        },
        getRegion() {
            if(this.continent){
                axios.get('/getRegionNameByContinent', {
                    params: {
                        continent_id: this.continent.id
                    }
                }).then(response => {
                    this.city = null
                    this.cities=[]
                    this.state = null
                    this.states = []
                    this.country = null
                    this.countries=[]
                    this.region = null
                    this.regions = response.data
                })
            }

        },

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
        saveAndClose(){
            let val='redirect';
            this.postEvent(val)
        },
        cancel(){
            this.$router.push({path:'/admin/event'})
        },
        postEvent(val){
            this.$validator.validateAll().then((result)=>{
                if (result){
                    axios.post('/admin/event',{
                        title:this.title,
                        start_date:this.start_date,
                        end_date:this.end_date,
                        address:this.address,
                        continent_id:this.continent?this.continent.id:null,
                        region_id:this.region?this.region.id:null,
                        country_id:this.country?this.country.id:null,
                        state_id:this.state?this.state.id:null,
                        city_id:this.city?this.city.id:null,
                        website:this.website,
                        categories:this.category,
                        location:this.location,
                        details:this.details,
                        is_active:this.is_active,
                        file:this.files
                    }).then(response=>{
                        this.buttonDisabled=true
                        this.$root.successMessage(response.data)
                        this.title =null
                        this.start_date=new Date()
                        this.end_date=new Date()
                        this.address=null
                        this.continent=null
                        this.region=null
                        this.country=null
                        this.state=null
                        this.city=null
                        this.website=null
                        this.category=null
                        this.location=null
                        this.details=null
                        this.is_active=true
                        this.$refs.viewDropZone.removeAllFiles()
                        this.$validator.reset()
                        val==='redirect'?this.$router.push({path:'/admin/event'}):''
                        this.buttonDisabled=false
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
        }
    }
}
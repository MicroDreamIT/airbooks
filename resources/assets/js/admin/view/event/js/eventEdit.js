export default {

    data(){
        return{
            sError:{},
            event:[],
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

            start_date: null,
            options: {
                format: 'DD/MM/YYYY',
                useCurrent: true,
            },
            end_date: null,

            image:[],
            files: [],
            manualRemoveFiles: [],
            fileUpdateRequested: [],
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
        this.edit(this.$route.params.id)
    },
    methods:{
        getCity() {
            if(this.state){
                axios.get('/getCityNameByState', {
                    params: {
                        state_id: this.state.id
                    }
                }).then(response => {
                    this.cities = response.data
                    this.event.state.id == this.state.id ?
                        this.city = this.event.city:
                        this.city = null
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
                    this.states = response.data
                    this.event.country.id == this.country.id ?
                        this.state = this.event.state:
                        [this.state = null,
                            this.city = null,
                            this.cities = []]
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
                    this.countries = response.data
                    this.event.region.id == this.region.id ?
                        this.country = this.event.country:
                        [this.country = null,
                            this.city = null,
                            this.cities = [],
                            this.state = null,
                            this.states = []]
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
                    this.regions = response.data
                    this.event.continent.id == this.continent.id ?
                        this.region = this.event.region:
                        [this.region = null,
                        this.city = null,
                        this.cities = [],
                        this.state = null,
                        this.states = [],
                        this.countries = [],
                        this.country = null]
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
                file.requested=true
                this.manualRemoveFiles.push(file)
            }
        },
        edit(id){
            axios.get('/admin/event/'+id+'/edit').then(response=>{
                this.event= response.data.event
                this.continents=response.data.continents
                this.regions=response.data.regions
                this.countries=response.data.countries
                this.states=response.data.states
                this.cities=response.data.cities
                this.categories=response.data.categories
                this.visitors=response.data.visitors
                this.title=response.data.event.title
                this.start_date=this.event.start_date?this.$root.parseDate(this.event.start_date):null
                this.end_date=this.event.end_date?this.$root.parseDate(this.event.end_date):null
                this.address=response.data.event.address
                this.continent=response.data.event.continent
                this.region=response.data.event.region
                this.country=response.data.event.country
                this.state=response.data.event.state
                this.city=response.data.event.city
                this.website=response.data.event.website
                this.visitor=response.data.event.contact
                this.category=response.data.event.categories
                this.location=response.data.event.location
                this.details=response.data.event.details
                response.data.event.is_active==0? this.is_active = false : this.is_active = true
                let fil = response.data.event.medias
                if(fil){
                    let image = {name: fil.original_file_name, contentId:fil.id}
                    this.$refs.viewDropZone.manuallyAddFile(image,'/storage/'+fil.path+'/'+fil.original_file_name)
                }

            })
        },
        updateEvent(){
            this.$validator.validateAll().then((result)=>{
                if (result){
                    axios.patch('/admin/event/' + this.$route.params.id ,{
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
                        file:this.files,
                        removeFiles: this.manualRemoveFiles
                    }).then(response=>{
                        this.buttonDisabled=true
                        this.$root.successMessage(response.data.message)
                        this.buttonDisabled=false
                        this.$validator.reset()
                        this.$router.push({path:response.data.redirection})
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
            this.$router.push({path:'/admin/event'})
        },
    }
}
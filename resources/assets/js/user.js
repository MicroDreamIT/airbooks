

require('./adminBootstrap')


window.Vue = require('vue')

import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'
import Vuex from 'vuex'
import datePicker from 'vue-bootstrap-datetimepicker'
// all the route import files
import {default as userRoute} from './routes/user'
import vSelect from 'vue-select'
const VueInputMask = require('vue-inputmask').default
import vue2Dropzone from 'vue2-dropzone';
import Vue2Filters from 'vue2-filters'

Vue.use(VueRouter)
Vue.use(VeeValidate)
Vue.use(Vuex)
Vue.use(VueInputMask)
Vue.use(datePicker)
Vue.use(require('vue-moment'));
Vue.use(Vue2Filters)

let rout = []
const routes = rout.concat(
    // all the vue routes route list
    userRoute
)

const router = new VueRouter({
    routes,
    linkActiveClass: 'is-active',
    linkExactActiveClass: "active",
    mode: 'history',
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
})
Vue.filter('fullName', value=>{
    return `${value.first_name} ${value.last_name}`
})

Vue.filter('imagePathForStyle', value=>{
    if(value){
        let urlParam =  '/storage/'+value.path+'/'+value.original_file_name
        let attributeValue = 'url("'+ urlParam + '")'
        return {'background-image': attributeValue}
    }
})

Vue.filter('removeUnderScore', (value) => {
    if(!value) return ''
    return value.replace('_', ' ')
})

Vue.filter('filterTitle', value=>{
    if(value){
        let withFor = value.replace(/[-_.]/g,' ')
        let whereIsForIndex
        if(withFor.includes('wanted for')){
            whereIsForIndex = withFor.indexOf('wanted')
        }else if(withFor.includes('available for')){
            whereIsForIndex = withFor.indexOf('available')
        }
        return withFor.substring(0,whereIsForIndex)
    }

})
Vue.filter('removeFileExtension', value=>{
    return value.split('.').slice(0, -1).join('.')
})

Vue.filter('removeACharacter',(value, indentifier)=>{
    // console.log(value);
    return value.split(indentifier).join(' ')
})
Vue.filter('globalMediaPath', value=>{
    return '/storage/' + value.path + '/' + value.original_file_name
})
Vue.component('fingerprint-spinner', require('epic-spinners/src/components/lib/FingerprintSpinner'))
Vue.component('vueDropzone', vue2Dropzone)
Vue.component('user-media', require('./components/media/user-media'))
Vue.component('v-select', vSelect)
Vue.component('vueDropzone', vue2Dropzone)
Vue.component('alert', require('./components/global/alert'))
Vue.component('user-layout', require('./components/layouts/userLayout.vue'))
Vue.component('user-aside', require('./components/layouts/userLayoutPartial/aside.vue'))
Vue.component('category-create', require('./admin/components/category/category'))
Vue.component('category-edit', require('./admin/components/category/categoryEdit'))
Vue.component('manufacturer-create', require('./admin/components/manufacturer/manufacturer.vue'));
Vue.component('manufacturer-edit', require('./admin/components/manufacturer/manufacturerEdit.vue'));
Vue.component('type-create', require('./admin/components/type/type.vue'))
Vue.component('type-edit', require('./admin/components/type/typeEdit.vue'))
Vue.component('model-create', require('./admin/components/model/model.vue'))
Vue.component('model-edit', require('./admin/components/model/modelEdit.vue'))
Vue.component('data-table-user', require('./components/global/dataTableUser.vue'))
Vue.component('atom-spinner', require('epic-spinners/src/components/lib/atomSpinner'))
Vue.component('suggest-modal', require('./components/global/suggest-modal'))
Vue.component('select-promote-modal', require('./components/global/select-promote.vue'))
//make component by emu for Dashboard layout
Vue.component('cardInformation', require('./components/user/CardInformation'))

new Vue({
    el: '#app',
    router,
    data:{
        selectedImages:[],
        showMedia:false,
        totalLoading:false,
        categories:[],
        aircraftCategories:[],
        engineCategories:[],
        apuCategories:[],
        partsCategories:[],
        user:{
            contact:{
                medias:{}
            },
        },
        aircraftManufacturers:[],
        engineManufacturers:[],
        apuManufacturers:[],
        partsManufacturers:[],

        aircraftTypes:[],
        engineTypes:[],
        apuTypes:[],
        partsTypes:[],

        aircraftModeleds:[],
        engineModeleds:[],
        apuModeleds:[],
        partsModeleds:[],

        countries:[],
        contacts:[],
        navTogglar:null,
        alert:{
            type:null,
            message:null
        },
        configurations:[],

    },

    watch:{
        '$route': 'watchData'
    },

    created(){
        axios.get('/country-list').then(res=>{this.countries=res.data}).catch(err=>console.log(err))
        axios.get('/user/ajax/all-categories').then(res=>{
            this.categories=res.data
            this.aircraftCategories=this.itemFilter(this.categories, 'type', 'aircraft')
            this.engineCategories=this.itemFilter(this.categories, 'type', 'engine')
            this.apuCategories=this.itemFilter(this.categories, 'type', 'apu')
            this.partsCategories=this.itemFilter(this.categories, 'type', 'parts')
        })
        this.getAircraftConfiguration()
        this.findManufacturers('engine', null)
        this.getContacts()
        this.getLoggedInUser()
    },
    methods:{
        getMediaPathFromObject(value){
            return '/storage/' + value.path + '/' + value.original_file_name
        },
        makeImageFeatured(id){
            for(let i=0; i<this.selectedImages.length;i++){
                this.selectedImages[i].is_featured = this.selectedImages[i].id == id ? 1 : 0;
            }
        },
        watchData(){
            this.selectedImages = []

        },
        getLoggedInUser(){
            axios.get('/user/ajax/user').then(res=>{
                this.user = res.data
            })
        },
        changeIsBooleanStatus(data, field, model){
            this.confirmationStatus().then(val => {
                if (val) {
                    axios.patch('/user/ajax/' + field +'/'+ model +'/'  + data.id+'/edit', {
                        status: data[field] == 1 ? 0 : 1
                    }).then(response=>{
                        if(response.data.type=='success'){
                            data[field] = data[field] == 1 ? 0 : 1
                        }
                        this.successMessage(response.data)
                    }).catch(error=>{

                    })
                }
            })

        },
        alertMessage(data){
            this.alert.type=data.type
            this.alert.message=data.message
            setTimeout(()=>{
                this.alert.type=null
                this.alert.message=null
            }, 2000)
        },
        confirmationDelete(){
            return new Promise((resolve, reject)=>{
                swal({
                    title: 'Confirm?',
                    // text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#c60005',
                    cancelButtonColor: 'green',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    animation: false
                }).then((result) => {
                    if (result.value) {
                        resolve(result.value)
                    }
                })
            })
        },
        confirmationStatus(){
            return new Promise((resolve, reject)=>{
                swal({
                    title: 'Confirm?',
                    showCancelButton: true,
                    confirmButtonColor: '#c60005',
                    cancelButtonColor: 'green',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    animation: false
                }).then((result) => {
                    if (result.value) {
                        resolve(result.value)
                    }
                })
            })
        },

        getAircraftConfiguration(){
            axios.get('/configurations')
                .then(res=>{
                    this.configurations = res.data
                })
        },

        itemFilter(datas,filterItem, filterValue){
            return datas.filter(data=>{
                return data[filterItem]==filterValue
            })
        },


        findType(type, manufacturer){
            axios.get('/type',
                {params:{
                    type:type,
                    manufacturer_id:manufacturer?manufacturer.id:null,
                        sortName:'name',
                        is_active: 1
                    }
                })
                .then(
                    res=>{
                        if(type=='aircraft'){
                            this.aircraftTypes=res.data
                        }
                        if(type=='engine'){
                            this.engineTypes=res.data
                        }
                        if(type=='apu'){
                            this.apuTypes = res.data
                        }
                        if(type=='parts'){
                            this.partsTypes = res.data
                        }
                    }
                )
        },

        findModel(type, aircraftType){
            axios.get('/model', {params:
                    {
                        type:type,
                        type_id:aircraftType?aircraftType.id:null,
                        sortName:'name',
                        is_active: 1
                    }
                
            })
                .then(res=>{
                    if(type=='aircraft'){
                        this.aircraftModeleds=res.data
                    }
                    if(type=='engine'){
                        this.engineModeleds=res.data
                    }
                    if(type=='apu'){
                        this.apuModeleds = res.data
                    }
                    if(type=='parts'){
                        this.partsModeleds = res.data
                    }
                })
        },

        findManufacturers(type, category){
            axios.get('/manufacturer',
                {params:
                    {
                        type:type,
                        category_id:category?category.id:null,
                        sortName:'name',
                        sortKey:'desc',
                        is_active:1
                    }
            }).then(
                res=>{
                    if(type=='aircraft'){
                        this.aircraftManufacturers = res.data
                    }
                    if(type=='engine'){
                        this.engineManufacturers=res.data
                    }
                    if(type=='apu'){
                        this.apuManufacturers = res.data

                    }
                    if(type=='parts'){
                        this.partsManufacturers = res.data
                    }
                    // if(type=='engine'){
                    //     this.engineManufacturers = res.data
                    // }
                }
            )
        },
        getContacts(){

            axios.get('/contacts',
                {params:
                    {
                        auth:true,
                        sortName:'first_name',
                        sortKey:'desc'
                    }
                }).then(
                res=>{
                    this.contacts=res.data
                }
            )
        },
        parseDate(val){
            if(val){
                var spliceDate = val.slice(0,10)
                const [year, month, day] =spliceDate.split('-');
                return day+'/'+month+'/'+year
            }

        },
        getFullName(option) {
            return `${option.first_name} ${option.last_name}`
        },
        toggleMedia(){
            this.showMedia=!this.showMedia
        },

        successMessage(data){
            this.alert.type=data.type
            this.alert.message=data.message
            setTimeout(()=>{
                this.alert.type=null
                this.alert.message=null
            }, 2000)
        },


    }
})

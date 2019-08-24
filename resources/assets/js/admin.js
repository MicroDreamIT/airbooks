
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./adminBootstrap')
// require('summernote')

window.Vue = require('vue')


import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate'
import Vuex from 'vuex'
import datePicker from 'vue-bootstrap-datetimepicker'
import wysiwyg from "vue-wysiwyg";
// all the route import files
import {default as adminRoute} from './routes/admin'
import vSelect from 'vue-select'
import vue2Dropzone from 'vue2-dropzone';
import VueCkeditor from 'vue-ckeditor2';

import store from './vuexAmin/store'
import VModal from 'vue-js-modal'
// require('../vendor/MediaManager/js/manager')
const VueInputMask = require('vue-inputmask').default

Vue.use(VueRouter)
Vue.use(VeeValidate)
Vue.use(Vuex)
Vue.use(VueInputMask)
Vue.use(datePicker)
Vue.use(require('vue-moment'))
Vue.use(VModal)
Vue.use(wysiwyg, {hideModules: { "justifyCenter": true, "justifyLeft": true,"justifyRight": true}});
let rout = []
const routes = rout.concat(
    // all the vue routes route list
    adminRoute
)

const router = new VueRouter({
    routes,
    linkActiveClass: 'is-active',
    linkExactActiveClass: "active",
    mode: 'history'
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.filter('removeUnderScore', (value) => {
    if(!value) return ''
    return value.replace('_', ' ')
})

Vue.filter('globalMediaPath', value=>{
    return '/storage/' + value.path + '/' + value.original_file_name
})

Vue.filter('asideTitlify', value=>{
    if(value){
        if(value.length<20){
            return value
        }else{
            return value.substring(0,20)+' ...'
        }
    }

})

Vue.filter('fullName', value=>{
    return `${value.first_name} ${value.last_name}`
})

Vue.filter('removeFileExtension', value=>{
    return value.split('.').slice(0, -1).join('.')
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


Vue.component('global-media', require('./components/media/global-media'))
Vue.component('vueDropzone', vue2Dropzone)
// Vue.component('pagination', require('laravel-vue-pagination'))
Vue.component('v-select', vSelect)
Vue.component('VueCkeditor', VueCkeditor)
Vue.component('alert', require('./components/global/alert'))
Vue.component('sendmail', require('./components/global/sendemailModal'))
Vue.component('admin-layout', require('./components/layouts/adminLayout.vue'))
Vue.component('admin-aside', require('./components/layouts/adminLayoutPartial/aside.vue'))
// Vue.component('admin-layout-sidepage', require('./components/layouts/adminLayoutSidePage.vue'));
Vue.component('category-create', require('./admin/components/category/category'))
Vue.component('category-edit', require('./admin/components/category/categoryEdit'))
Vue.component('manufacturer-create', require('./admin/components/manufacturer/manufacturer.vue'));
Vue.component('manufacturer-edit', require('./admin/components/manufacturer/manufacturerEdit.vue'));
Vue.component('type-create', require('./admin/components/type/type.vue'))
Vue.component('type-edit', require('./admin/components/type/typeEdit.vue'))
Vue.component('model-create', require('./admin/components/model/model.vue'))
Vue.component('model-edit', require('./admin/components/model/modelEdit.vue'))
Vue.component('data-table', require('./components/global/DataTable.vue'))
Vue.component('data-table-join', require('./components/global/DataTableJoin.vue'))
Vue.component('atom-spinner', require('epic-spinners/src/components/lib/atomSpinner'))

//make component by emu for Dashboard layout


new Vue({
    el: '#app',
    router,store,
    data:{
        showMedia:false,
        navTogglar:null,
        role:null,
        createPermission:false,
        showPermission:false,
        editPermission:false,
        deletePermission:false,
        alert:{
            type:null,
            message:null
        },
        user:{
            contact:{
                medias:{}
            },
        },
    },
    mounted(){

        // this.successMessage({type:'info', message:'message'})

    },
    created(){
        this.getPermission()
        this.getLoggedInUser()
    },

    methods:{
        changeIsBooleanStatus(data, field, model){
            this.confirmationStatus().then(val => {
                if (val) {

                    axios.patch('/admin/ajax/' + field +'/'+ model +'/'  + data.id+'/edit', {
                        status: data[field] == 1 ? 0 : 1
                    }).then(response=>{
                        data[field] = data[field] == 1 ? 0 : 1
                        this.successMessage(response.data)
                    }).catch(error=>{

                    })
                }
            })

        },
        getLoggedInUser(){
            axios.get('/admin/user').then(res=>{
                this.user = res.data
            })
        },
        getMediaPathFromObject(value){
            return '/storage/' + value.path + '/' + value.original_file_name
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


        alertMessage(data,modelType=null){
            this.alert.type=data.type
            if(modelType=='company'){
                this.alert.message=data.message
            }else{
                this.alert.message='The record has been deleted.'
            }

            setTimeout(()=>{
                this.alert.type=null
                this.alert.message=null
            }, 2000)
        },

        successMessage(data){
            this.alert.type=data.type
            this.alert.message=data.message
            setTimeout(()=>{
                this.alert.type=null
                this.alert.message=null
            }, 2000)
        },


        toggleMedia(){
            this.showMedia=!this.showMedia
        },
        parseDate(val){
            var spliceDate = val.slice(0,10)
            const [year, month, day] =spliceDate.split('-');
            return day+'/'+month+'/'+year
        },
        getPermission(){
            axios.get('/admin/getUserWithPermission').then(response=>{
                this.role=response.data[0];
                var permission=response.data[1]
               if(this.role=='admin'){
                      this.createPermission=true
                     this.showPermission=true
                       this.editPermission=true
                       this.deletePermission=true

               }else if(this.role=='sub-admin'){
                   permission.includes('create')?this.createPermission=true:null;
                   permission.includes('details')?this.showPermission=true:null;
                   permission.includes('edit')?this.editPermission=true:null;
                   permission.includes('delete')?this.deletePermission=true:null;

               }

            })

        },
        getFullName(option) {
            return `${option.first_name} ${option.last_name}`
        },


    }
})

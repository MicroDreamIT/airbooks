// please computer check status code 401
// if 403
// alert('please reduce your ass size')
require('./bootstrap');
window.Vue = require('vue');
window.Event = new Vue();
import store from './store.js'
import VeeValidate from 'vee-validate'
import VueRouter from 'vue-router'
import DatePicker from 'vue2-datepicker'
import VModal from 'vue-js-modal'
import vSelect from 'vue-select'
import VueContentPlaceholders from 'vue-content-placeholders'

Vue.use(VueRouter);
Vue.use(require('vue-moment'));
Vue.use(VeeValidate)
Vue.use(VModal)
Vue.use(VeeValidate)
Vue.use(VueContentPlaceholders)
const base_url = 'https://airbook.aero'
// all the route import files
import {default as fontendRoute} from './routes/frontend'
let rout = []
const routes = rout.concat(
    // all the vue routes route list
    fontendRoute
)

const router = new VueRouter({
    routes,
    linkActiveClass: 'is-active',
    mode: 'history',
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }

})

require('./filter.js')

Vue.component('example-component', require('./components/ExampleComponent.vue'))
Vue.component('alert', require('./components/global/alert'))
Vue.component('sidebar-search-layout', require('./components/frontend/sidebarSearchLayout.vue'))
Vue.component('sendmail', require('./components/frontend/sendmail.vue'))
Vue.component('share-this', require('./components/frontend/sharethis.vue'))
Vue.component('search-layout', require('./components/frontend/searchLayout.vue'))
Vue.component('search-layout-top', require('./components/frontend/searchLayoutTop.vue'))
Vue.component('atom-spinner', require('epic-spinners/src/components/lib/atomSpinner'))
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('date-picker', DatePicker);
Vue.component('own-pagination', require('./components/global/own-pagination.vue'));
Vue.component('combo-chart', require('./components/charts/ComboChartComponent.vue'));
Vue.component('single-chart', require('./components/charts/sinleChartComponent.vue'));
Vue.component('v-select', vSelect)


new Vue({
    el: '#app',
    router, store,
    data:{
        baseUrl:'https://airbook.aero',
        isLoading:false,
        showModal:false,
        user:null,
        alert:{
            type:null,
            message:null
        },
        featured:[],
        mailModalData:{},
        seos:[],
        heads:'',
    },
    created(){
        this.getLoggedInUser()
        this.getFeatured()
        window.addEventListener('scroll', this.handleScroll)
        store.dispatch('seoLoad')
    },

    methods:{
        changeMeta(title, description, image){
            $('meta[property="og:title"]').remove();
            $('meta[property="og:description"]').remove();
            $('meta[property="og:image"]').remove();
            $('meta[name="twitter:card"]').remove();
            $('meta[name="description"]').remove();

            document.title = title

            $('head').append('<meta property="og:title" content="'+title +'"/>')

            $('head').append('<meta name="description" content="'+description +'"/>')

            $('head').append('<meta property="og:description" content="'+description +'" />')

            $('head').append('<meta property="og:image" content="'+image+'" />')

            $('head').append('<meta name="twitter:card" content="'+title +'" />')
        },
        setupSeo(data, params){
            if(data.length){
                let metas =  _.find(data, (d)=>{
                    if(d.model_type){
                        return d.model_type===params
                    }
                })

                if(metas){
                    document.title = metas.title

                    $('meta[property="og:title"]').remove();
                    $('meta[property="og:description"]').remove();
                    $('meta[property="og:image"]').remove();
                    $('meta[name="twitter:card"]').remove();
                    $('meta[name="description"]').remove();


                        $('head').append('<meta property="og:title" content="'+metas.title +'"/>')

                        $('head').append('<meta name="description" content="'+metas.description +'"/>')

                        $('head').append('<meta property="og:description" content="'+metas.description +'" />')
                        if(metas.medias){
                            $('head').append('<meta property="og:image" content="'+'/storage/'+metas.medias.path+'/'+metas.medias.original_file_name +'" />')
                        }


                        $('head').append('<meta name="twitter:card" content="'+metas.description +'" />')

                }
            }
        },
        mailModalShow (data) {
            this.mailModalData=data
            this.$modal.show('sendMail');
        },
        mailModalhide () {
            this.$modal.hide('sendMail');
        },

        linkify(value){
            return value.replace(/\s+/g, '-').toLowerCase()
        },
        capitalize(val){
            return _.startCase(_.camelCase(val))
        },

        postFavourite(modelType, modelId, modelPath){

            axios.post('/user/ajax/favourites',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        this.alertMessage(res.data)
                    }
                })
                .catch(err=>{
                    if(err.response){
                        if(err.response.status==401){
                            window.location.href='/login'
                        }
                    }
                })
        },

        postLike(modelType,modelId, modelPath){
            axios.post('/user/ajax/likes',{id:modelId, path:modelPath})
                .then(res=>{
                    if(res.data){
                        if(res.data.unlike){

                            let items = this.featured.filter(item=> item.id == modelId && item.modelType==modelType)[0]
                            let index = items.likes.findIndex(item=> item.likable_id == modelId && item.user_id == this.user.id)
                            items.likes.splice(index, 1)
                        }
                        if(res.data.liked){
                            if(res.data.liked.id!==undefined){
                                this.featured.filter(item=>{
                                    if(item.id == modelId && item.modelType==modelType){
                                        item.likes.push(res.data.liked)

                                    }
                                })
                            }
                        }

                    }
                })
                .catch(err=>{
                    if(err.response){
                        if(err.response.status==401){
                            this.errorMessage(err.response, 'Please Login first then try again')
                            window.location.href='/login'
                        }
                    }
                })
        },
        checkObject_key_value(arr, matchKey, obj, checkKey){
            if(obj){
                if(arr){
                    let hasLike = arr.filter(data=> data[matchKey]==obj[checkKey])[0]
                    if(hasLike){
                        return true
                    }else{
                        return false
                    }
                }

            }else{

                return false
            }


        },

        findObjectByKey_in_array_and_return_them_array(items, keyName, keyValue){
            return items.filter(item=>{
                if(item[keyName]==keyValue){
                    return item
                }
            })

        },

        getFeaturedImage(arr){
            if(!arr) return null
            for(let i=0;i<arr.length;i++){
                if(arr[i].is_featured==1){
                    if(arr[i]){
                        return '/storage/' + arr[i].path + '/' + arr[i].original_file_name
                    }
                }
            }
            if(arr[0]){
                return '/storage/' + arr[0].path + '/' + arr[0].original_file_name
            }
        },

        getFeatured(){
            axios.get('/ajax/promomix')
                .then(res=>{
                    this.featured = res.data

                    // $(document).ready(function(){
                    //     $(".dot-block").click(function(){
                    //            $(this).parent().parent().children().toggleClass('w--open')
                    //     });
                    // });
                })
                .catch(err=>{})
        },
        alertMessage(data, message=null){

            this.alert.type=data.type
            if(message){
                this.alert.message = message
            }else{
                this.alert.message=data.message
            }
            setTimeout(()=>{
                this.alert.type=null
                this.alert.message=null
            }, 2000)
        },
        errorMessage(data, message=null){
            this.alert.type='danger'
            if(message){
                this.alert.message = message
            }else{
                this.alert.message=data.message
            }
            setTimeout(()=>{
                this.alert.type=null
                this.alert.message=null
            }, 2000)
        },
        getLoggedInUser(){
            axios.get('/user/ajax/user').then(res=>{
                if(Object.keys(res.data).length > 0){
                    this.user = res.data
                }


            })
        },
        getGalleryMainImagePath(data){
            var galleryImagePath=null
            if(data){
                data.forEach(value=>{
                    if(value.is_featured==1){
                        galleryImagePath=this.$options.filters.imagePathForStyle(value)
                    }
                })
            }

            if(galleryImagePath==null){
                galleryImagePath=this.$options.filters.imagePathForStyle(data[0])
            }
            return galleryImagePath;
        },

        toggle(event){
            let recentDivParent=event.target.parentElement
            recentDivParent.parentElement.classList.toggle('w--open')
            recentDivParent.nextElementSibling.classList.toggle('w--open')

            $(".asset-label-block,.asset-wrapper").mouseleave(function(){
                setTimeout(function(){
                    $(".dot-block").parent().parent().children().removeClass('w--open');
                }, 350);
            });

        },
        handleScroll(){
            window.addEventListener("scroll", function (event) {
                var scrollYAmount = this.scrollY;
                if(scrollYAmount>350){
                    var search = document.getElementById('searchBar');
                    if(search){
                        search.style="opacity:1;transform: translateX(0px) translateY(0px) translateZ(0px);display: block;transform-style: preserve-3d;transition: opacity 300ms ease 0s, transform 500ms ease 0s;";
                    }

                }else{
                    var search = document.getElementById('searchBar');
                    if(search){
                        search.style="opacity: 0; transform: translateX(0px) translateY(-64px) translateZ(0px); display: block; transform-style: preserve-3d; transition: opacity 500ms ease 0s, transform 300ms ease 0s;";
                    }

                }
            });
        },
        disapperMenu(event){
            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            if(width<=768){
                let recentDiv = event.target.parentElement
                let menu=['CONNECT','INFO','Contact','Companies','Airports','About Airbook','Airbook Features','Help & Supports']
                if(menu.includes(event.target.innerText)){
                    event.target.innerText=='CONNECT' || event.target.innerText=='INFO'?null:
                        recentDiv.parentElement.parentElement.parentElement.style.display='none'
                }else{
                    recentDiv.parentElement.style.display='none'

                }
            }

        },
        callFilter(event){
            let targetClass  = document.getElementsByClassName('filter-wrapper');
             targetClass[0].style='display: block!important; opacity: 1; transition: opacity 300ms ease 0s;'
        },
        closeFilter(){
            let targetClass  = document.getElementsByClassName('filter-wrapper');
            targetClass[0].style='display: none!important;opacity: 0; transition: opacity 300ms ease 0s;'

        },
        callFocus(){
            document.getElementById("Message-2").focus()
        },
        jsUcfirst(string)
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },




    }
});

require('./register')

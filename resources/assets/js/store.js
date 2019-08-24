import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state:{
        seos:[],
        pages:[
            {id:1,      name:'Home',        method:'index'},
            {id:2,      name:'Aircraft',    method:'index'},
            {id:3,      name:'Engine',      method:'index'},
            {id:4,      name:'Apu',         method:'index'},
            {id:5,      name:'Wanted',      method:'index'},
            {id:6,      name:'Airport',     method:'index'},
            {id:7,      name:'News',        method:'index'},
            {id:8,      name:'Event',       method:'index'},
            {id:9,      name:'Contact',     method:'index'},
            {id:10,     name:'Company',     method:'index'},
            {id:10,     name:'Part',     method:'index'},
        ],
    },

    mutations: {
        SET_SEO(state, seos){
            if(seos.length){
                state.seos = seos
            }
        },
        SET_META(params){
            console.log(params, state.seos)
        }
    },
    actions: {
        seoLoad({commit}){
            axios.get('/seolist')
                .then(res=>{
                    commit('SET_SEO', res.data)
                })
        }
    }
})
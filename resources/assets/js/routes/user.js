module.exports = [

    {
        path:'/user/settings',
        name:'userSettings',
        component:require('../user/view/settings.vue')
    },
    {
        path:'/user/contacts/create',
        name:'userContactCreate',
        component:require('../user/view/contact/userContactCreate.vue')
    },
    {
        path:'/user/contacts',
        name:'userContacts',
        component:require('../user/view/contact/userContacts.vue')
    },
    {
        path:'/user/contacts/:id/edit',
        name:'userContactEdit',
        component:require('../user/view/contact/userContactEdit.vue')
    },

    {
        path:'/user/contacts/:id',
        name:'userContactShow',
        component:require('../user/view/contact/userContactShow.vue')
    },
    {
        path: '/user/dashboard',
        name: 'userDashboard',
        component: require('../user/view/dashboard.vue')
    },
    {
        path: '/user/aircraft/create',
        name: 'userAircraftCreate',
        component: require('../user/view/aircraft/userAircraftCreate.vue')
    },
    {
        path: '/user/aircraft/:id/edit',
        name: 'userAircraftEdit',
        component: require('../user/view/aircraft/userAircraftEdit.vue')
    },
    {
        path: '/user/aircraft/:id',
        name: 'userAircraftShow',
        component: require('../user/view/aircraft/userAircraftShow.vue')
    },

    {
        path:'/user/aircraft',
        name:'userAircrafts',
        component: require('../user/view/aircraft/userAircrafts.vue')
    },

    //Engine
    {
        path: '/user/engine/create',
        name: 'userEngineCreate',
        component: require('../user/view/engine/engineCreate.vue')
    },
    {
        path: '/user/engine',
        name: 'userEngineList',
        component: require('../user/view/engine/engineList.vue')
    },
    {
        path: '/user/engine/:id',
        name: 'userEngineShow',
        component: require('../user/view/engine/engineShow.vue')
    },
    {
        path: '/user/engine/:id/edit',
        name: 'userEngineEdit',
        component: require('../user/view/engine/engineEdit.vue')
    },

    //APU
    {
        path: '/user/apu/create',
        name: 'userApuCreate',
        component: require('../user/view/apu/apuCreate.vue')
    },
    {
        path: '/user/apu',
        name: 'userApuList',
        component: require('../user/view/apu/apuList.vue')
    },
    {
        path: '/user/apu/:id',
        name: 'userApuShow',
        component: require('../user/view/apu/apuShow.vue')
    },
    {
        path: '/user/apu/:id/edit',
        name: 'userApuEdit',
        component: require('../user/view/apu/apuEdit.vue')
    },

    //Parts
    {
        path: '/user/parts/create',
        name: 'userPartsCreate',
        component: require('../user/view/parts/partsCreate.vue')
    },
    {
        path: '/user/parts',
        name: 'userPartsList',
        component: require('../user/view/parts/partsList.vue')
    },
    {
        path: '/user/parts/:id',
        name: 'userPartsShow',
        component: require('../user/view/parts/partsShow.vue')
    },
    {
        path: '/user/parts/:id/edit',
        name: 'userPartsEdit',
        component: require('../user/view/parts/partsEdit.vue')
    },

    //Wanted
    {
        path:'/user/wanted',
        name:'userWantedIndex',
        component: require('../user/view/wanted/userWantedIndex.vue')
    },
    {
        path:'/user/wanted/create',
        name:'userWantedCreate',
        component: require('../user/view/wanted/userWantedCreate.vue')
    },
    {
        path: '/user/wanted/:id',
        name: 'userWantedShow',
        component: require('../user/view/wanted/wantedShow.vue')
    },
    {
        path: '/user/wanted/:id/edit',
        name: 'userWantedEdit',
        component: require('../user/view/wanted/wantedEdit.vue')
    },

    //Favourite

    {
        path: '/user/favourite',
        name: 'userFavouriteList',
        component: require('../user/view/favourite/favouriteList.vue')
    },
    //Connection

    {
        path: '/user/connection',
        name: 'userConnectionList',
        component: require('../user/view/connection/connectionList.vue')
    },
    {
        path: '/user/lead',
        name: 'userLeadList',
        component: require('../user/view/lead/leadList.vue')
    },
    {
        path: '/user/promote',
        name: 'userPromoteList',
        component: require('../user/view/promote/promoteList.vue')
    },
    {
        path: '/user/company/edit',
        name: 'userCompanyEdit',
        component: require('../user/view/company/userCompanyEdit.vue')
    },
    {
        path: '/user/payment-history',
        name: 'userPaymentHistory',
        component: require('../user/view/promote/paymentHistory.vue')
    },


]

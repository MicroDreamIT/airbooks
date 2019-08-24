module.exports = [
    {
        path:'/',
        name:'home',
        component: require('../views/frontend/home.vue'),

    },
    //Aircraft
    {
        path:'/aircraft',
        name:'frontAircraft',
        component: require('../views/frontend/aircraft.vue')
    },
    {
        path:'/aircraft/:id',
        name:'frontAircraftShow',
        component: require('../views/frontend/show/aircraftShow.vue')
    },
    // ENGINES
    {
        path:'/engine',
        name:'frontEngine',
        component: require('../views/frontend/engine.vue')
    },
    {
        path:'/engine/:id',
        name:'frontEngineShow',
        component: require('../views/frontend/show/engineShow.vue')
    },
    // APU
    {
        path:'/apu',
        name:'frontApu',
        component: require('../views/frontend/apu.vue')
    },
    {
        path:'/apu/:id',
        name:'frontApuShow',
        component: require('../views/frontend/show/apuShow.vue')
    },
    // PARTS
    {
        path:'/parts',
        name:'frontPart',
        component: require('../views/frontend/parts.vue')
    },
    // {
    //     path:'/apu/:id',
    //     name:'frontApuShow',
    //     component: require('../views/frontend/show/apuShow.vue')
    // },
    // WANTED
    {
        path:'/wanted',
        name:'frontWanted',
        component: require('../views/frontend/wanted.vue')
    },
    {
        path:'/wanted/:id',
        name:'frontWantedShow',
        component: require('../views/frontend/show/wantedShow.vue')
    },
    // NEWS
    {
        path:'/news',
        name:'frontNews',
        component: require('../views/frontend/news.vue')
    },
    {
        path:'/news/:id',
        name:'newsDetails',
        component: require('../views/frontend/show/newsDetails.vue')
    },

    // EVENTS
    {
        path:'/event',
        name:'frontEvent',
        component: require('../views/frontend/events.vue')
    },
    {
        path:'/event/:id',
        name:'eventDetails',
        component: require('../views/frontend/show/eventDetails.vue')
    },

    // CONTANT
    {
        path:'/contact',
        name:'frontContact',
        component: require('../views/frontend/contact.vue')
    },
    {
        path:'/contact/:id',
        name:'contactDetails',
        component: require('../views/frontend/show/contactDetails.vue')
    },

    // COMPANIES
    {
        path:'/company',
        name:'companies',
        component: require('../views/frontend/companies.vue')
    },
    {
        path:'/company/:id',
        name:'companyDetails',
        component: require('../views/frontend/show/companyDetails.vue')
    },
    // ABOUT-AIRBOOK
    {
        path:'/about-airbook',
        name:'aboutAirbook',
        component: require('../views/frontend/aboutAirbook.vue')
    },
    // AIRBOOK-FEATURES
    {
        path:'/airbook-features',
        name:'airbookFeatures',
        component: require('../views/frontend/airbookFeatures.vue')
    },
    // AIRBOOK-SUPPORTS
    {
        path:'/support',
        name:'supports',
        component: require('../views/frontend/helpAndSupport.vue')
    },
    // AIRPORTS
    {
        path:'/airport',
        name:'airports',
        component: require('../views/frontend/airports.vue')
    },
    {
        path:'/airport/:id',
        name:'aircraftDetails',
        component: require('../views/frontend/show/airportDeatils.vue')
    },



//    TERMS AND SERVICE
    {
        path:'/terms',
        name:'terms',
        component: require('../views/frontend/terms.vue')
    },
    //    PRIVACY POLICY
    {
        path:'/policy',
        name:'policy',
        component: require('../views/frontend/policy.vue')
    },

    {
        path:'*',
        name:'404Page',
        component: require('../views/frontend/404.vue')
    },

]

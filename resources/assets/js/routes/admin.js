module.exports = [
    {
        path: '/admin/dashboard',
        name: 'adminHome',
        component: require('../admin/view/home.vue')
    },
    {
        path: '/admin/under-construction',
        name: 'adminUnderConstruction',
        component: require('../admin/view/underConstruction.vue')
    },
    //Aircraft Routes
    //Category
    {
        path: '/admin/aircraft/category',
        name: 'adminAircraftCategoryList',
        component: require('../admin/view/aircraft/category/categoryList.vue')
    },
    {
        path: '/admin/aircraft/category/create',
        name: 'adminAircraftCategoryCreate',
        component: require('../admin/view/aircraft/category/categoryCreate.vue')
    },

    {
        path: '/admin/aircraft/category/:id/edit',
        name: 'adminAircraftCategoryEdit',
        component: require('../admin/view/aircraft/category/categoryEdit.vue'),
    },
    {
        path: '/admin/aircraft/category/:id',
        name: 'adminAircraftCategoryShow',
        component: require('../admin/view/aircraft/category/categoryShow.vue')
    },

    //Manufacturer
    {
        path: '/admin/aircraft/manufacturer',
        name: 'adminAircraftManufacturerList',
        component: require('../admin/view/aircraft/manufacturer/manufacturerList.vue')
    },
    {
        path: '/admin/aircraft/manufacturer/create',
        name: 'adminAircraftManufacturerCreate',
        component: require('../admin/view/aircraft/manufacturer/manufacturerCreate.vue')
    },
    {
        path: '/admin/aircraft/manufacturer/:id/edit',
        name: 'adminAircraftManufacturerEdit',
        component: require('../admin/view/aircraft/manufacturer/manufacturerEdit.vue'),
    },
    {
        path: '/admin/aircraft/manufacturer/:id',
        name: 'adminAircraftManufacturerShow',
        component: require('../admin/view/aircraft/manufacturer/manufacturerShow.vue')
    },

    //Type
    {
        path: '/admin/aircraft/type',
        name: 'adminAircraftTypeList',
        component: require('../admin/view/aircraft/type/typeList.vue')
    },
    {
        path: '/admin/aircraft/type/create',
        name: 'adminAircraftTypeCreate',
        component: require('../admin/view/aircraft/type/typeCreate.vue')
    },
    {
        path: '/admin/aircraft/type/:id/edit',
        name: 'adminAircraftTypeEdit',
        component: require('../admin/view/aircraft/type/typeEdit.vue'),
    },
    {
        path: '/admin/aircraft/type/:id',
        name: 'adminAircraftTypeShow',
        component: require('../admin/view/aircraft/type/typeShow.vue')
    },
    //Model
    {
        path: '/admin/aircraft/model',
        name: 'adminAircraftModelList',
        component: require('../admin/view/aircraft/model/modelList.vue')
    },
    {
        path: '/admin/aircraft/model/create',
        name: 'adminAircraftModelCreate',
        component: require('../admin/view/aircraft/model/modelCreate.vue')
    },
    {
        path: '/admin/aircraft/model/:id/edit',
        name: 'adminAircraftModelEdit',
        component: require('../admin/view/aircraft/model/modelEdit.vue'),
    },
    {
        path: '/admin/aircraft/model/:id',
        name: 'adminAircraftModelShow',
        component: require('../admin/view/aircraft/model/modelShow.vue')
    },
    //Engine Routes
    //Category
    {
        path: '/admin/engine/category',
        name: 'adminEngineCategoryList',
        component: require('../admin/view/engine/category/categoryList.vue')
    },
    {
        path: '/admin/engine/category/create',
        name: 'adminEngineCategoryCreate',
        component: require('../admin/view/engine/category/categoryCreate.vue')
    },
    {
        path: '/admin/engine/category/:id/edit',
        name: 'adminEngineCategoryEdit',
        component: require('../admin/view/engine/category/categoryEdit.vue'),
    },
    {
        path: '/admin/engine/category/:id',
        name: 'adminEngineCategoryShow',
        component: require('../admin/view/engine/category/categoryShow.vue')
    },
    //Manufacturer
    {
        path: '/admin/engine/manufacturer',
        name: 'adminEngineManufacturerList',
        component: require('../admin/view/engine/manufacturer/manufacturerList.vue')
    },
    {
        path: '/admin/engine/manufacturer/create',
        name: 'adminEngineManufacturerCreate',
        component: require('../admin/view/engine/manufacturer/manufacturerCreate.vue')
    },
    {
        path: '/admin/engine/manufacturer/:id/edit',
        name: 'adminEngineManufacturerEdit',
        component: require('../admin/view/engine/manufacturer/manufacturerEdit.vue'),
    },
    {
        path: '/admin/engine/manufacturer/:id',
        name: 'adminEngineManufacturerShow',
        component: require('../admin/view/engine/manufacturer/manufacturerShow.vue')
    },

    //type
    {
        path: '/admin/engine/type',
        name: 'adminEngineTypeList',
        component: require('../admin/view/engine/type/typeList.vue')
    },
    {
        path: '/admin/engine/type/create',
        name: 'adminEngineTypeCreate',
        component: require('../admin/view/engine/type/typeCreate.vue')
    },
    {
        path: '/admin/engine/type/:id/edit',
        name: 'adminEngineTypeEdit',
        component: require('../admin/view/engine/type/typeEdit.vue'),
    },
    {
        path: '/admin/engine/type/:id',
        name: 'adminEngineTypeShow',
        component: require('../admin/view/engine/type/typeShow.vue')
    },
    //Model
    {
        path: '/admin/engine/model',
        name: 'adminEngineModelList',
        component: require('../admin/view/engine/model/modelList.vue')
    },
    {
        path: '/admin/engine/model/create',
        name: 'adminEngineModelCreate',
        component: require('../admin/view/engine/model/modelCreate.vue')
    },
    {
        path: '/admin/engine/model/:id/edit',
        name: 'adminEngineModelEdit',
        component: require('../admin/view/engine/model/modelEdit.vue'),
    },
    {
        path: '/admin/engine/model/:id',
        name: 'adminEngineModelShow',
        component: require('../admin/view/engine/model/modelShow.vue')
    },
    //Apu Routes
    //Category
    {
        path: '/admin/apu/category',
        name: 'adminApuCategoryList',
        component: require('../admin/view/apu/category/categoryList.vue')
    },
    {
        path: '/admin/apu/category/create',
        name: 'adminApuCategoryCreate',
        component: require('../admin/view/apu/category/categoryCreate.vue')
    },
    {
        path: '/admin/apu/category/:id/edit',
        name: 'adminApuCategoryEdit',
        component: require('../admin/view/apu/category/categoryEdit.vue'),
    },
    {
        path: '/admin/apu/category/:id',
        name: 'adminApuCategoryShow',
        component: require('../admin/view/apu/category/categoryShow.vue')
    },
    //Manufacturer
    {
        path: '/admin/apu/manufacturer',
        name: 'adminApuManufacturerList',
        component: require('../admin/view/apu/manufacturer/manufacturerList.vue')
    },
    {
        path: '/admin/apu/manufacturer/create',
        name: 'adminApuManufacturerCreate',
        component: require('../admin/view/apu/manufacturer/manufacturerCreate.vue')
    },
    {
        path: '/admin/apu/manufacturer/:id/edit',
        name: 'adminApuManufacturerEdit',
        component: require('../admin/view/apu/manufacturer/manufacturerEdit.vue'),
    },
    {
        path: '/admin/apu/manufacturer/:id',
        name: 'adminApuManufacturerShow',
        component: require('../admin/view/apu/manufacturer/manufacturerShow.vue')
    },
    //Type
    {
        path: '/admin/apu/type',
        name: 'adminApuTypeList',
        component: require('../admin/view/apu/type/typeList.vue')
    },
    {
        path: '/admin/apu/type/create',
        name: 'adminApuTypeCreate',
        component: require('../admin/view/apu/type/typeCreate.vue')
    },
    {
        path: '/admin/apu/type/:id/edit',
        name: 'adminApuTypeEdit',
        component: require('../admin/view/apu/type/typeEdit.vue'),
    },
    {
        path: '/admin/apu/type/:id',
        name: 'adminApuTypeShow',
        component: require('../admin/view/apu/type/typeShow.vue')
    },
    //Model
    {
        path: '/admin/apu/model',
        name: 'adminApuModelList',
        component: require('../admin/view/apu/model/modelList.vue')
    },
    {
        path: '/admin/apu/model/create',
        name: 'adminApuModelCreate',
        component: require('../admin/view/apu/model/modelCreate.vue')
    },
    {
        path: '/admin/apu/model/:id/edit',
        name: 'adminApuModelEdit',
        component: require('../admin/view/apu/model/modelEdit.vue'),
    },
    {
        path: '/admin/apu/model/:id',
        name: 'adminApuModelShow',
        component: require('../admin/view/apu/model/modelShow.vue')
    },

    //Contacts

    {
        path: '/admin/contacts',
        name: 'adminContacts',
        component: require('../admin/view/contact/contacts.vue')
    },

    {
        path: '/admin/contacts/create',
        name: 'adminContactsCreate',
        component: require('../admin/view/contact/contactCreate.vue')
    },

    {
        path: '/admin/contacts/:id',
        name: 'adminContactsShow',
        component: require('../admin/view/contact/contactShow.vue')
    },

    {
        path: '/admin/contacts/:id/edit',
        name: 'adminContactsEdit',
        component: require('../admin/view/contact/contactEdit.vue')
    },

    //Companies

    //speciality

    {
        path: '/admin/company/speciality',
        name: 'adminSpecialityList',
        component: require('../admin/view/company/speciality/specialityList.vue')
    },
    {
        path: '/admin/company/speciality/create',
        name: 'adminSpecialityCreate',
        component: require('../admin/view/company/speciality/specialityCreate.vue')
    },
    {
        path: '/admin/company/speciality/:id/edit',
        name: 'adminSpecialityEdit',
        component: require('../admin/view/company/speciality/specialityEdit.vue'),
    },
    {
        path: '/admin/company/speciality/:id',
        name: 'adminSpecialityShow',
        component: require('../admin/view/company/speciality/specialityShow.vue')
    },
    //Title
    {
        path: '/admin/company/title',
        name: 'adminTitleList',
        component: require('../admin/view/company/title/titleList.vue')
    },
    {
        path: '/admin/company/title/create',
        name: 'adminTitleCreate',
        component: require('../admin/view/company/title/titleCreate.vue')
    },
    {
        path: '/admin/company/title/:id/edit',
        name: 'adminTitleEdit',
        component: require('../admin/view/company/title/titleEdit.vue'),
    },
    {
        path: '/admin/company/title/:id',
        name: 'adminTitleShow',
        component: require('../admin/view/company/title/titleShow.vue')
    },

    //Company
    {
        path: '/admin/company',
        name: 'adminCompanyList',
        component: require('../admin/view/company/companyList.vue')
    },
    {
        path: '/admin/company/create',
        name: 'adminCompanyCreate',
        component: require('../admin/view/company/companyCreate.vue')
    },
    {
        path: '/admin/company/:id/edit',
        name: 'adminCompanyEdit',
        component: require('../admin/view/company/companyEdit.vue'),
    },
    {
        path: '/admin/company/:id',
        name: 'adminCompanyShow',
        component: require('../admin/view/company/companyShow.vue')
    },

    //News
        //news category
    {
        path: '/admin/news/category',
        name: 'adminNewsCategoryList',
        component: require('../admin/view/news/category/categoryList.vue')
    },
    {
        path: '/admin/news/category/create',
        name: 'adminNewsCategoryCreate',
        component: require('../admin/view/news/category/categoryCreate.vue')
    },
    {
        path: '/admin/news/category/:id/edit',
        name: 'adminNewsCategoryEdit',
        component: require('../admin/view/news/category/categoryEdit.vue'),
    },
    {
        path: '/admin/news/category/:id',
        name: 'adminNewsCategoryShow',
        component: require('../admin/view/news/category/categoryShow.vue')
    },

            // news route

    {
        path: '/admin/news',
        name: 'adminNewsList',
        component: require('../admin/view/news/newsList.vue')
    },
    {
        path: '/admin/news/create',
        name: 'adminNewsCreate',
        component: require('../admin/view/news/newsCreate.vue')
    },
    {
        path: '/admin/news/:id/edit',
        name: 'adminNewsEdit',
        component: require('../admin/view/news/newsEdit.vue'),
    },
    {
        path: '/admin/news/:id',
        name: 'adminNewsShow',
        component: require('../admin/view/news/newsShow.vue')
    },


    //Event
        //category
    {
        path: '/admin/event/category',
        name: 'adminEventCategoryList',
        component: require('../admin/view/event/category/categoryList.vue')
    },
    {
        path: '/admin/event/category/create',
        name: 'adminEventCategoryCreate',
        component: require('../admin/view/event/category/categoryCreate.vue')
    },
    {
        path: '/admin/event/category/:id/edit',
        name: 'adminEventCategoryEdit',
        component: require('../admin/view/event/category/categoryEdit.vue'),
    },
    {
        path: '/admin/event/category/:id',
        name: 'adminEventCategoryShow',
        component: require('../admin/view/event/category/categoryShow.vue')
    },
        //event
    {
        path: '/admin/event',
        name: 'adminEventList',
        component: require('../admin/view/event/eventList.vue')
    },
    {
        path: '/admin/event/create',
        name: 'adminEventCreate',
        component: require('../admin/view/event/eventCreate.vue')
    },
    {
        path: '/admin/event/:id/edit',
        name: 'adminEventEdit',
        component: require('../admin/view/event/eventEdit.vue'),
    },
    {
        path: '/admin/event/:id',
        name: 'adminEventShow',
        component: require('../admin/view/event/eventShow.vue')
    },
    //Airfield Type
    {
        path: '/admin/airport/airfield',
        name: 'adminAirfieldList',
        component: require('../admin/view/airport/airfield/airfieldList.vue')
    },
    {
        path: '/admin/airport/airfield/create',
        name: 'adminAirfieldCreate',
        component: require('../admin/view/airport/airfield/airfieldCreate.vue')
    },
    {
        path: '/admin/airport/airfield/:id/edit',
        name: 'adminAirfieldEdit',
        component: require('../admin/view/airport/airfield/airfieldEdit.vue'),
    },
    {
        path: '/admin/airport/airfield/:id',
        name: 'adminAirfieldShow',
        component: require('../admin/view/airport/airfield/airfieldShow.vue')
    },

    //Airport
    {
        path: '/admin/airport',
        name: 'adminAirportList',
        component: require('../admin/view/airport/airportList.vue')
    },
    {
        path: '/admin/airport/create',
        name: 'adminAirportCreate',
        component: require('../admin/view/airport/airportCreate.vue')
    },
    {
        path: '/admin/airport/:id/edit',
        name: 'adminAirportEdit',
        component: require('../admin/view/airport/airportEdit.vue'),
    },
    {
        path: '/admin/airport/:id',
        name: 'adminAirportShow',
        component: require('../admin/view/airport/airportShow.vue')
    },

    //Canned Email
    {
        path: '/admin/canned-email',
        name: 'adminCannedEmailList',
        component: require('../admin/view/cannedEmail/cannedEmailList.vue')
    },
    {
        path: '/admin/canned-email/create',
        name: 'adminCannedEmailCreate',
        component: require('../admin/view/cannedEmail/cannedEmailCreate.vue')
    },
    {
        path: '/admin/canned-email/:id/edit',
        name: 'adminCannedEmailEdit',
        component: require('../admin/view/cannedEmail/cannedEmailEdit.vue'),
    },
    {
        path: '/admin/canned-email/:id',
        name: 'adminCannedEmailShow',
        component: require('../admin/view/cannedEmail/cannedEmailShow.vue')
    },

    //Continents
    {
        path: '/admin/location/continent',
        name: 'adminContinentList',
        component: require('../admin/view/location/continent/continentList.vue')
    },
    {
        path: '/admin/location/continent/create',
        name: 'adminContinentCreate',
        component: require('../admin/view/location/continent/continentCreate.vue')
    },
    {
        path: '/admin/location/continent/:id/edit',
        name: 'adminContinentEdit',
        component: require('../admin/view/location/continent/continentEdit.vue'),
    },
    {
        path: '/admin/location/continent/:id',
        name: 'adminContinentShow',
        component: require('../admin/view/location/continent/continentShow.vue')
    },
    //Region
    {
        path: '/admin/location/region',
        name: 'adminRegionList',
        component: require('../admin/view/location/region/regionList.vue')
    },
    {
        path: '/admin/location/region/create',
        name: 'adminRegionCreate',
        component: require('../admin/view/location/region/regionCreate.vue')
    },
    {
        path: '/admin/location/region/:id/edit',
        name: 'adminRegionEdit',
        component: require('../admin/view/location/region/regionEdit.vue'),
    },
    {
        path: '/admin/location/region/:id',
        name: 'adminRegionShow',
        component: require('../admin/view/location/region/regionShow.vue')
    },
    //State
    {
        path: '/admin/location/state',
        name: 'adminStateList',
        component: require('../admin/view/location/state/stateList.vue')
    },
    {
        path: '/admin/location/state/create',
        name: 'adminStateCreate',
        component: require('../admin/view/location/state/stateCreate.vue')
    },
    {
        path: '/admin/location/state/:id/edit',
        name: 'adminStateEdit',
        component: require('../admin/view/location/state/stateEdit.vue'),
    },
    {
        path: '/admin/location/state/:id',
        name: 'adminStateShow',
        component: require('../admin/view/location/state/stateShow.vue')
    },
    //City
    {
        path: '/admin/location/city',
        name: 'adminCityList',
        component: require('../admin/view/location/city/cityList.vue')
    },
    {
        path: '/admin/location/city/create',
        name: 'adminCityCreate',
        component: require('../admin/view/location/city/cityCreate.vue')
    },
    {
        path: '/admin/location/city/:id/edit',
        name: 'adminCityEdit',
        component: require('../admin/view/location/city/cityEdit.vue'),
    },
    {
        path: '/admin/location/city/:id',
        name: 'adminCityShow',
        component: require('../admin/view/location/city/cityShow.vue')
    },
    //Country
    {
        path: '/admin/location/country',
        name: 'adminCountryList',
        component: require('../admin/view/location/country/countryList.vue')
    },
    {
        path: '/admin/location/country/create',
        name: 'adminCountryCreate',
        component: require('../admin/view/location/country/countryCreate.vue')
    },
    {
        path: '/admin/location/country/:id/edit',
        name: 'adminCountryEdit',
        component: require('../admin/view/location/country/countryEdit.vue'),
    },
    {
        path: '/admin/location/country/:id',
        name: 'adminCountryShow',
        component: require('../admin/view/location/country/countryShow.vue')
    },
    //Subscriber
    {
        path: '/admin/setting/subscriber',
        name: 'adminSubscriberList',
        component: require('../admin/view/settings/subscriber/subscriberList.vue')
    },
    {
        path: '/admin/setting/subscriber/create',
        name: 'adminSubscriberCreate',
        component: require('../admin/view/settings/subscriber/subscriberCreate.vue')
    },
    {
        path: '/admin/setting/subscriber/:id/edit',
        name: 'adminSubscriberEdit',
        component: require('../admin/view/settings/subscriber/subscriberEdit.vue'),
    },
    {
        path: '/admin/setting/subscriber/:id',
        name: 'adminSubscriberShow',
        component: require('../admin/view/settings/subscriber/subscriberShow.vue')
    },
    //Seo
    {
        path: '/admin/setting/seo',
        name: 'adminSeoList',
        component: require('../admin/view/settings/seo/seoList.vue')
    },
    {
        path: '/admin/setting/seo/create',
        name: 'adminSeoCreate',
        component: require('../admin/view/settings/seo/seoCreate.vue')
    },
    {
        path: '/admin/setting/seo/:id/edit',
        name: 'adminSeoEdit',
        component: require('../admin/view/settings/seo/seoEdit.vue'),
    },
    {
        path: '/admin/setting/seo/:id',
        name: 'adminSeoShow',
        component: require('../admin/view/settings/seo/seoShow.vue')
    },
    //CMS
    {
        path: '/admin/cms',
        name: 'adminCmsList',
        component: require('../admin/view/cms/cmsList.vue')
    },
    {
        path: '/admin/cms/create',
        name: 'adminCmsCreate',
        component: require('../admin/view/cms/cmsCreate.vue')
    },
    {
        path: '/admin/cms/:id/edit',
        name: 'adminCmsEdit',
        component: require('../admin/view/cms/cmsEdit.vue'),
    },
    {
        path: '/admin/cms/:id',
        name: 'adminCmsShow',
        component: require('../admin/view/cms/cmsShow.vue')
    },
    //Parts
        //Condition
    {
        path: '/admin/parts/condition',
        name: 'adminConditionList',
        component: require('../admin/view/parts/condition/conditionList.vue')
    },
    {
        path: '/admin/parts/condition/create',
        name: 'adminConditionCreate',
        component: require('../admin/view/parts/condition/conditionCreate.vue')
    },
    {
        path: '/admin/parts/condition/:id/edit',
        name: 'adminConditionEdit',
        component: require('../admin/view/parts/condition/conditionEdit.vue'),
    },
    {
        path: '/admin/parts/condition/:id',
        name: 'adminConditionShow',
        component: require('../admin/view/parts/condition/conditionShow.vue')
    },

    //Parts
        //Release
    {
        path: '/admin/parts/release',
        name: 'adminReleaseList',
        component: require('../admin/view/parts/release/releaseList.vue')
    },
    {
        path: '/admin/parts/release/create',
        name: 'adminReleaseCreate',
        component: require('../admin/view/parts/release/releaseCreate.vue')
    },
    {
        path: '/admin/parts/release/:id/edit',
        name: 'adminReleaseEdit',
        component: require('../admin/view/parts/release/releaseEdit.vue'),
    },
    {
        path: '/admin/parts/release/:id',
        name: 'adminReleaseShow',
        component: require('../admin/view/parts/release/releaseShow.vue')
    },

    //Commercial
        //Plan
    {
        path: '/admin/commercial/plan',
        name: 'adminPlanList',
        component: require('../admin/view/commercial/plan/planList.vue')
    },
    {
        path: '/admin/commercial/plan/create',
        name: 'adminPlanCreate',
        component: require('../admin/view/commercial/plan/planCreate.vue')
    },
    {
        path: '/admin/commercial/plan/:id/edit',
        name: 'adminPlanEdit',
        component: require('../admin/view/commercial/plan/planEdit.vue'),
    },
    {
        path: '/admin/commercial/plan/:id',
        name: 'adminPlanShow',
        component: require('../admin/view/commercial/plan/planShow.vue')
    },

    //Configuration
    {
        path: '/admin/aircraft/configuration',
        name: 'adminConfigurationList',
        component: require('../admin/view/configuration/configurationList.vue')
    },
    {
        path: '/admin/aircraft/configuration/create',
        name: 'adminConfigurationCreate',
        component: require('../admin/view/configuration/configurationCreate.vue')
    },
    {
        path: '/admin/aircraft/configuration/:id/edit',
        name: 'adminConfigurationEdit',
        component: require('../admin/view/configuration/configurationEdit.vue'),
    },
    {
        path: '/admin/aircraft/configuration/:id',
        name: 'adminConfigurationShow',
        component: require('../admin/view/configuration/configurationShow.vue')
    },
    //Asset Routes
    {
        path: '/admin/aircraft/asset/:id',
        name: 'adminAircraftShow',
        component: require('../admin/view/aircraft/adminAircraftShow.vue')
    },
    {
        path: '/admin/aircraft/asset',
        name: 'adminAircraftAssetList',
        component: require('../admin/view/assets/aircraftAssetList.vue')
    },
    {
        path: '/admin/engine/asset',
        name: 'adminEngineAssetList',
        component: require('../admin/view/engine/engineAssetList.vue')
    },
    {
        path: '/admin/engine/asset/:id',
        name: 'adminEngineShow',
        component: require('../admin/view/engine/adminEngineShow.vue')
    },
    {
        path: '/admin/apu/asset',
        name: 'adminApuAssetList',
        component: require('../admin/view/assets/apuAssetList.vue')
    },
    {
        path: '/admin/apu/asset/:id',
        name: 'adminApuShow',
        component: require('../admin/view/apu/adminApuShow.vue')
    },
    {
        path: '/admin/part/asset/:id',
        name: 'adminPartShow',
        component: require('../admin/view/parts/adminPartShow.vue')
    },
    {
        path: '/admin/part/asset',
        name: 'adminPartAssetList',
        component: require('../admin/view/assets/partAssetList.vue')
    },
    {
        path: '/admin/wanted/asset',
        name: 'adminWantedAssetList',
        component: require('../admin/view/assets/wantedAssetList.vue')
    },
    {
        path: '/admin/wanted/asset/:id',
        name: 'adminWantedShow',
        component: require('../admin/view/assets/wantedAssetShow.vue')
    },
    //Role-permission
    {
        path: '/admin/role-permission',
        name: 'adminRolePermissionList',
        component: require('../admin/view/rolePermission/rolePermissionList.vue')
    },
    {
        path: '/admin/role-permission/create',
        name: 'adminRolePermissionCreate',
        component: require('../admin/view/rolePermission/rolePermissionCreate.vue')
    },
    {
        path: '/admin/role-permission/:id/edit',
        name: 'adminRolePermissionEdit',
        component: require('../admin/view/rolePermission/rolePermissionEdit.vue'),
    },
    {
        path: '/admin/role-permission/:id',
        name: 'adminRolePermissionShow',
        component: require('../admin/view/rolePermission/rolePermissionShow.vue')
    },
    {
        path:'/admin/accesslogs',
        name:'adminAccesslog',
        component:require('../admin/view/accesslog.vue')
    },
    {
        path: '/admin/lead',
        name: 'adminLeadList',
        component: require('../admin/view/lead/leadList.vue')
    },
    {
        path: '/admin/airbookers',
        name: 'adminAirbookerList',
        component: require('../admin/view/user/airbooker.vue')
    },
        //Admin User
    {
        path: '/admin/admin-user',
        name: 'adminUserList',
        component: require('../admin/view/user/adminUserList.vue')
    },
    {
        path: '/admin/admin-user/create',
        name: 'adminUserCreate',
        component: require('../admin/view/user/adminUserCreate.vue')
    },
    {
        path: '/admin/admin-user/:id/edit',
        name: 'adminUserEdit',
        component: require('../admin/view/user/adminUserEdit.vue'),
    },
    {
        path: '/admin/admin-user/:id',
        name: 'adminUserShow',
        component: require('../admin/view/user/adminUserShow.vue')
    },
    // account-setting
    {
        path: '/admin/account-setting',
        name: 'accountSetting',
        component: require('../admin/view/user/accountSetting.vue')
    },
    {
        path: '/admin/account-setting-update',
        name: 'accountSettingEdit',
        component: require('../admin/view/user/accountSettingEdit.vue')
    },

    // user-reset-password
    {
        path: '/admin/update-account-password',
        name: 'resetAccountPassword',
        component: require('../admin/view/user/passwordReset.vue')
    },


]

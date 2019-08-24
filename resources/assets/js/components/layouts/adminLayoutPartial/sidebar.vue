<template>
    <div>
        <div class="be-left-sidebar" id="leftSidebar">
            <div class="left-sidebar-wrapper">
                <a class="left-sidebar-toggle" href="#">Dashboard</a>
                <div class="left-sidebar-spacer">
                    <div class="left-sidebar-scroll">
                        <div class="left-sidebar-content" id="sideBarVue">
                            <ul class="sidebar-elements">
                                <li class="scrollable">
                                    <router-link :to="{name:'adminHome'}" data-placement="right"
                                                    data-original-title="Dashboard">
                                        <i class="icon mdi mdi-home"></i>
                                        <span>Dashboard</span>
                                    </router-link>
                                </li>
                                <li class="parent">
                                    <a  data-placement="right" title=""
                                       data-original-title="Aircraft" @click="toogleNav">
                                        <i class="icon mdi mdi-airplane pointer"></i>
                                       <span class="pointer">Aircraft</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Aircraft</li>
                                        <li>
                                            <router-link :to="{name:'adminAircraftCategoryList'}" >
                                                Categories
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminAircraftManufacturerList'}" >
                                                Manufacturers
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminAircraftTypeList'}" >
                                                Types
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminAircraftModelList'}" >
                                                Models
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminConfigurationList'}" >
                                                Configurations
                                            </router-link>
                                        </li>

                                    </ul>
                                </li>
                                <li class="parent">
                                    <a  data-placement="right" title=""
                                       data-original-title="Engine" @click="toogleNav">
                                        <i class="icon fab fa-empire pointer" style="font-size: 14px;"></i>
                                        <span class="pointer">Engines</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Engines</li>
                                        <li>
                                            <router-link :to="{name:'adminEngineCategoryList'}" >
                                                Categories
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminEngineManufacturerList'}" >
                                                Manufacturers
                                            </router-link>
                                        </li>

                                        <li>
                                            <router-link :to="{name:'adminEngineTypeList'}" >
                                               Types
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminEngineModelList'}" >
                                                Models
                                            </router-link>
                                        </li>


                                    </ul>
                                </li>
                                <li class="parent">
                                    <a   data-placement="right" title=""
                                       data-original-title="APU" @click="toogleNav">
                                        <i class="icon mdi mdi-battery-charging pointer"></i>
                                       <span class="pointer">APU</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">APU</li>
                                        <li>
                                            <router-link :to="{name:'adminApuCategoryList'}" >
                                                Categories
                                            </router-link>
                                        </li>

                                        <li>
                                            <router-link :to="{name:'adminApuManufacturerList'}" >
                                                Manufacturers
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminApuTypeList'}" >
                                                Types
                                            </router-link>
                                        </li>

                                        <li>
                                            <router-link :to="{name:'adminApuModelList'}" >
                                                Models
                                            </router-link>
                                        </li>


                                    </ul>
                                </li>
                                <li class="parent">
                                    <a   data-placement="right" title=""
                                        data-original-title="Parts" @click="toogleNav">
                                        <i class="icon fas fa-cogs pointer" style="font-size: 14px;"></i>
                                        <span class="pointer">Parts</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Parts</li>
                                        <li>
                                            <router-link :to="{name:'adminConditionList'}" >
                                                Conditions
                                            </router-link>
                                        </li>

                                        <li>
                                            <router-link :to="{name:'adminReleaseList'}" >
                                                Releases
                                            </router-link>
                                        </li>



                                    </ul>
                                </li>
                                <li class="parent">
                                    <a data-placement="right" title=""
                                        data-original-title="New & Events" @click="toogleNav">
                                        <i class="icon mdi mdi-calendar-check"></i>
                                        <span class="pointer">News & Events</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">News & Events</li>
                                        <li>
                                            <router-link :to="{name:'adminNewsList'}" >
                                                News
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminEventList'}" >
                                                Events
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminNewsCategoryList'}" >
                                                News Category
                                            </router-link>
                                        </li>

                                        <li>
                                            <router-link :to="{name:'adminEventCategoryList'}" >
                                                Events Category
                                            </router-link>
                                        </li>



                                    </ul>
                                </li>

                                <li  class="scrollable">
                                    <router-link :to="{name:'adminContacts'}"   data-placement="right"
                                                 title="" data-original-title="contact">
                                        <i class="icon mdi mdi-account"></i>
                                        <span>Contacts</span>
                                    </router-link>

                                </li>
                                <li class="parent">
                                    <a data-placement="right" title=""
                                        data-original-title="Companies" @click="toogleNav">
                                        <i class="icon fas fa-building pointer" style="font-size: 14px;"></i>
                                        <span class="pointer">Companies</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Companies</li>
                                        <li>
                                            <router-link :to="{name:'adminCompanyList'}" >
                                                Manage
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminTitleList'}" >
                                                Job Title
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminSpecialityList'}" >
                                               Specialties
                                            </router-link>
                                        </li>



                                    </ul>
                                </li>
                                <li class="parent">
                                    <a data-placement="right" title=""
                                        data-original-title="Locations" @click="toogleNav">
                                        <i class="icon mdi mdi-pin pointer"></i>
                                        <span class="pointer">Locations</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Locations</li>
                                        <li>
                                            <router-link :to="{name:'adminContinentList'}" >
                                                Continents
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminRegionList'}" >
                                                Regions
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminCountryList'}" >
                                                Countries
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminStateList'}" >
                                                States
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminCityList'}" >
                                                Cities
                                            </router-link>
                                        </li>


                                    </ul>
                                </li>
                                <li class="parent">
                                    <a data-placement="right" title=""
                                        data-original-title="Airports" @click="toogleNav">
                                        <i class="icon mdi mdi-flight-land pointer"></i>
                                        <span class="pointer">Airports</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Airports</li>
                                        <li>
                                            <router-link :to="{name:'adminAirportList'}" >
                                                Airports
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminAirfieldList'}" >
                                                Airfield Type
                                            </router-link>
                                        </li>



                                    </ul>
                                </li>
                                <li class="parent">
                                    <a data-placement="right" title=""
                                        data-original-title="Assets" @click="toogleNav">
                                        <i class="icon mdi mdi-ticket-star pointer"></i>
                                        <span class="pointer">Assets</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Assets</li>
                                        <li>
                                            <router-link :to="{name:'adminAircraftAssetList'}" >
                                                Aircraft
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminEngineAssetList'}" >
                                                Engines
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminApuAssetList'}" >
                                                APU
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminPartAssetList'}" >
                                                Parts
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminWantedAssetList'}" >
                                                Wanted
                                            </router-link>
                                        </li>



                                    </ul>
                                </li>
                                <li class="parent">
                                    <a  data-placement="right" title=""
                                        data-original-title="Commercial" @click="toogleNav">
                                        <i class="icon mdi mdi-card-travel pointer"></i>
                                        <span class="pointer">Commercial</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Commercial</li>
                                        <li>
                                            <router-link :to="{name:'adminPlanList'}" >
                                                Airbook Plans
                                            </router-link>
                                        </li>
                                        <!--<li>-->
                                            <!--<router-link :to="{name:'adminUnderConstruction'}" >-->
                                               <!--Invoices-->
                                            <!--</router-link>-->
                                        <!--</li>-->
                                        <!--<li>-->
                                            <!--<router-link :to="{name:'adminUnderConstruction'}" >-->
                                                <!--Gateway Settings-->
                                            <!--</router-link>-->
                                        <!--</li>-->



                                    </ul>
                                </li>
                                <li class="scrollable">
                                    <router-link :to="{name:'adminLeadList'}"   data-placement="right"
                                                 title="" data-original-title="Leads">
                                        <i class="icon fas fa-dollar-sign"></i>
                                        <span>Leads</span>
                                    </router-link>
                                </li>
                                <li class="scrollable">
                                    <router-link :to="{name:'adminCannedEmailList'}"   data-placement="right"
                                                 title="" data-original-title="Canned Emails">
                                        <i class="icon mdi mdi-email-open pointer"></i>
                                        <span>Canned Emails</span>
                                    </router-link>
                                </li>
                                <li class="parent">
                                    <a data-placement="right" title=""
                                        data-original-title="Security" @click="toogleNav">
                                        <i class="icon mdi mdi-shield-security pointer"></i>
                                        <span class="pointer">Security</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">Security</li>
                                        <li>
                                            <router-link :to="{name:'adminAirbookerList'}" >
                                                Airbookers
                                            </router-link>
                                        </li>
                                        <li v-if="$root.$data.role=='admin'">
                                            <router-link :to="{name:'adminUserList'}" >
                                                Admin Users
                                            </router-link>
                                        </li>
                                        <li v-if="$root.$data.role=='admin'">
                                            <router-link :to="{name:'adminRolePermissionList'}" >
                                                Role & Permission
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminAccesslog'}" >
                                                Access Logs
                                            </router-link>
                                        </li>



                                    </ul>
                                </li>
                                <li class="parent">
                                    <a  data-placement="right" title=""
                                        data-original-title="CMS" @click="toogleNav">
                                        <i class="icon mdi mdi-email"></i>
                                        <span class="pointer">CMS</span>
                                    </a>

                                    <ul class="sub-menu">
                                        <li class="title">CMS</li>

                                        <li>
                                            <router-link :to="{name:'adminCmsList'}" >
                                                Pages
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminSeoList'}" >
                                                SEO
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{name:'adminSubscriberList'}" >
                                                Subscriber
                                            </router-link>
                                        </li>


                                    </ul>
                                </li>

                                <!--<li class="parent">-->
                                    <!--<a  data-placement="right" title=""-->
                                        <!--data-original-title="Newsletter" @click="toogleNav">-->
                                        <!--<i class="icon mdi mdi-email"></i>-->
                                        <!--<span class="pointer">Newsletter</span>-->
                                    <!--</a>-->

                                    <!--<ul class="sub-menu">-->
                                        <!--<li class="title">Newsletter</li>-->

                                        <!--<li>-->
                                            <!--<router-link :to="{name:'adminUnderConstruction'}" >-->
                                                <!--Templates-->
                                            <!--</router-link>-->
                                        <!--</li>-->
                                        <!--<li>-->
                                            <!--<router-link :to="{name:'adminUnderConstruction'}" >-->
                                                <!--Generate Newsletter-->
                                            <!--</router-link>-->
                                        <!--</li>-->



                                    <!--</ul>-->
                                <!--</li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="progress-widget">
                    <div class="progress-data d-flex justify-content-center flex-wrap">
                        <span class="name"> Copyright &nbsp; </span>
                        <span> © {{date.getFullYear()}} Airbook</span><br>
                        <span>V:1.0.2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
              date:new Date(),
          }
        },
        name: "admin-sidebar",
        methods: {
            toogleNav(e) {
                let target = e.target
                let parentElm = target.parentElement
                let parentElmClassList = parentElm.classList
                if(_.includes(parentElmClassList, 'parent')){
                    if (_.includes(parentElmClassList, 'open')) {
                        parentElmClassList.remove('open')
                    } else {
                        this.removeOpenClass()
                        parentElmClassList.add('open')
                    }
                }
            },

            removeOpenClass() {
                let elm = document.getElementsByClassName('parent');
                for (let i = 0; i < elm.length; i++) {
                    elm[i].classList.remove('open')
                }
            }
        }
    }
</script>


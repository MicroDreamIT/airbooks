<template>
    <div v-if="metas">
        <search-layout></search-layout>
        <div class="asset-details-section">
            <div class="container w-container">
                <div class="details-page-h1-block">
                    <h1 class="details-page-h1-title own-upper" v-if="aircraft.title">
                        {{aircraft.title|filterDetailsPageTitle}}
                    </h1>
                    <div class="details-page-date"><span class="asset-details-clock-icon"></span>
                        Published {{aircraft.created_at | moment("MMM DD, YYYY")}}- Updated {{aircraft.updated_at | moment("MMM DD, YYYY")}}
                    </div>
                </div>
                <div class="asset-page-flex tablet-mode">
                    <div class="asset-page-left-block left-tablet-mode">
                        <div class="asset-details-main-widget-wrapper">
                            <div class="asset-details-main-widget-block first-widget">
                                <div class="main-widget-label">MSN</div>
                                <h2 class="main-widget-data-label" v-if="$root.$data.user">{{aircraft.MSN}}</h2>
                                <div class="lock-block" v-if="!$root.$data.user">
                                    <span class="lock"></span> Login
                                </div>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">YOM</div>
                                <h2 class="main-widget-data-label">
                                    {{aircraft.YOM| moment("YYYY")}}
                                </h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">For</div>
                                <h2 class="main-widget-data-label">
                                    {{aircraft.offer_for}}
                                </h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">Available</div>
                                <h2 class="main-widget-data-label">{{aircraft.availability|moment("MMM, YYYY")}}</h2>
                            </div>
                        </div>
                        <div class="asset-image-gallery-wrapper" >
                            <template v-if="aircraft.medias">
                                <div class="demo-gallery-image" :style="galleryImagePath"></div>
                            </template>
                            <div class="demo-gallery-image" v-else></div>


                            <div class="asset-sub-images ">
                                <div  v-for="(item,index) in aircraft.medias"
                                     class="demo-sub-image"
                                     :ref="'subImage'+index"
                                     :style="item|imagePathForStyle"
                                     @click="changeGalleryImage(item,index)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--like favorite-->
                    <div class="asset-page-right-block right-tablet-mode">
                        <div class="asset-details-widget-block">
                            <div class="asset-details-widget">
                                <div class="asset-details-widget-icon" ></div>
                                <div class="asset-details-widget-data">
                                    {{aircraft.views}}
                                </div>
                            </div>
                            <a href="#"
                               :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(aircraft.likes,'user_id', $root.$data.user, 'id')}"
                               @click="postLike(aircraft.id, 'App\\Aircraft')">
                                <div class="asset-details-widget-icon">
                                    
                                </div>
                                <div  :class="{'asset-details-widget-data':true}" >
                                    {{aircraft.likes.length>0 ? aircraft.likes.length : 0}}
                                </div>
                            </a>
                            <a href="#" :class="{'asset-details-widget':true, 'w-inline-block':true, 'active': $root.checkObject_key_value(aircraft.favourites,'user_id', $root.$data.user, 'id') || favouriteActive}"
                               @click="postFavourite(aircraft.id, 'App\\Aircraft')">
                                <div class="asset-details-widget-icon "></div>
                                <div class="asset-details-widget-data">
                                    Favorite
                                </div>
                            </a>
                            <a href="" class="asset-details-widget w-inline-block" @click.prevent="$root.callFocus()">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data" >Email</div>
                            </a>
                            <a href="#Asset-Share" class="asset-details-widget w-inline-block">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Share</div>
                            </a>
                        </div>
                        <div class="general-divider"></div>
                   <template v-if="aircraft.user">

                       <router-link :to="'#'" class="asset-details-page-side-block w-inline-block" v-if="!$root.$data.user">
                           <div class="user-default-image"></div>
                           <div class="asset-details-contact-info-block">
                               <div class="lock-block" v-if="!$root.$data.user">
                                   <span class="lock"></span> Login to view contact
                               </div>

                           </div>
                       </router-link>

                       <router-link :to="{name:'contactDetails',params:{id:aircraft.user.contact.linkify}}" class="asset-details-page-side-block w-inline-block" v-else>
                           <div class="user-default-image" :style="aircraft.user.contact.medias|imagePathForStyle"></div>
                           <div class="asset-details-contact-info-block">
                               <h4 class="asset-details-contact-name" v-if="aircraft.user && $root.$data.user">
                                   <template v-if="_.has(aircraft,'user.contact.fullName')">
                                       {{aircraft.user.contact.fullName}}
                                   </template>

                               </h4>
                               <div class="lock-block" v-if="!$root.$data.user">
                                   <span class="lock"></span> Login to view contact
                               </div>
                               <div class="asset-details-contact-title" v-if="aircraft.user && $root.$data.user">
                                   <template v-if="_.has(aircraft,'user.contact.job_title.name')">
                                           {{aircraft.user.contact.job_title.name}}
                                   </template>
                               </div>
                           </div>
                       </router-link>



                       <router-link :to="'#'"  class="asset-details-page-side-block w-inline-block" v-if="!$root.$data.user">
                           <div class="company-default-image"></div>
                           <div class="asset-details-contact-info-block">

                               <div class="lock-block" v-if="!$root.$data.user">
                                   <span class="lock"></span> Login to view company
                               </div>
                           </div>
                       </router-link>



                        <router-link :to="{name:'companyDetails',params:{id:aircraft.user.contact.company.linkify}}"
                                     class="asset-details-page-side-block w-inline-block" v-else>
                            <div class="company-default-image" :style="aircraft.user.contact.company.medias|imagePathForStyle"></div>
                            <div class="asset-details-contact-info-block">
                                <h4 class="asset-details-contact-name" v-if="aircraft.user && $root.$data.user">
                                    {{aircraft.user.contact.company.name}}
                                </h4>
                                <div class="lock-block" v-if="!$root.$data.user">
                                    <span class="lock"></span> Login to view company
                                </div>

                                <template v-if="aircraft.user.contact.company.specialities">
                                    <template v-for="(speciality, index) in aircraft.user.contact.company.specialities">
                                        <div class="asset-details-contact-title">{{speciality.name }}</div>
                                        <div class="asset-details-contact-title"  v-if="index < aircraft.user.contact.company.specialities.length-1 "> {{' | '}}</div>
                                    </template>
                                </template>
                            </div>
                        </router-link>
                   </template>
                        <div class="asset-details-contact-block">
                            <sendmail :model="aircraft"></sendmail>
                        </div>
                    </div>
                </div>
                <div class="asset-page-flex">
                    <div class="asset-page-left-block">
                        <div class="heading-block asset-details-page">
                            <h3 class="home-section-title">Asset Details</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.category">
                            <div class="asset-details-data-label">Aircraft Category</div>
                            <div class="asset-details-data">{{aircraft.category.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.manufacturer">
                            <div class="asset-details-data-label">Manufacturer</div>
                            <div class="asset-details-data">{{aircraft.manufacturer.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.type">
                            <div class="asset-details-data-label">Type</div>
                            <div class="asset-details-data">{{aircraft.type.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.modeled">
                            <div class="asset-details-data-label">Model</div>
                            <div class="asset-details-data">{{aircraft.modeled.name}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">MSN</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.MSN}}</div>
                            <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.YOM">
                            <div class="asset-details-data-label">Year of Manufacture (YOM)</div>
                            <div class="asset-details-data">{{aircraft.YOM|moment("YYYY")}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.configuration">
                            <div class="asset-details-data-label">Configuration</div>
                            <div class="asset-details-data">{{aircraft.configuration.name}}</div>
                        </div>

                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">Seating</div>
                            <div class="asset-details-data">
                                <template v-if="aircraft.seating_economy">
                                    {{'Economy (Y) '}}{{aircraft.seating_economy?aircraft.seating_economy:0}}

                                </template>
                                <template v-if="aircraft.seating_business">
                                    {{','}}
                                    {{'Business (C) '}}{{aircraft.seating_business?aircraft.seating_business:0}}

                                </template>
                                <template v-if="aircraft.seating_first_class">
                                    {{','}}
                                    {{'First (F) '}}{{aircraft.seating_first_class?aircraft.seating_first_class:0}}

                                </template>
                                </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.status">
                            <div class="asset-details-data-label">Status</div>
                            <div class="asset-details-data">{{aircraft.status}}</div>
                        </div>

                        <div class="asset-details-data-block" v-if="aircraft.tsn">
                            <div class="asset-details-data-label">TSN</div>
                            <div class="asset-details-data">{{aircraft.tsn}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.csn">
                            <div class="asset-details-data-label">CSN</div>
                            <div class="asset-details-data">{{aircraft.csn}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.mtow">
                            <div class="asset-details-data-label">MTOW</div>
                            <div class="asset-details-data">{{aircraft.mtow}}{{' KG'}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.mlgw">
                            <div class="asset-details-data-label">MLGW</div>
                            <div class="asset-details-data">{{aircraft.mlgw}}{{' KG'}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.last_c_check">
                            <div class="asset-details-data-label">Last C Check</div>
                            <div class="asset-details-data">{{aircraft.last_c_check|moment("MMMM DD, YYYY")}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.compliance">
                            <div class="asset-details-data-label">Compliance</div>
                            <div class="asset-details-data">{{aircraft.compliance}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.registration_number">
                            <div class="asset-details-data-label">Registration Number</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.registration_number}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.registered_in">
                            <div class="asset-details-data-label">Registration Country</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.registered_in.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>

                        <!--Engine-->

                            <div class="general-divider"></div>
                            <div class="asset-details-data-block">
                                <div class="asset-details-data-label">Engines</div>
                                <div class="asset-details-data"
                                     v-if="aircraft.engine_model || aircraft.engine_type|| aircraft.engine_manufacturer">

                                    {{aircraft.engine_manufacturer?aircraft.engine_manufacturer.name:null+' '+
                                        aircraft.engine_type?aircraft.engine_type.name:null+' '+
                                        aircraft.engine_model?aircraft.engine_model.name:null }}
                                </div>
                                <div class="asset-details-data" v-else>Airframe Only</div>
                            </div>


                        <div class="general-divider"></div>
                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">Offered for</div>
                            <div class="asset-details-data">{{aircraft.offer_for}}</div>
                        </div>

                        <div class="asset-details-data-block" v-if="aircraft.offer_for=='ACMI'">
                            <div class="asset-details-data-label">MGH</div>
                            <div class="asset-details-data">{{aircraft.mgh}}/month</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.offer_for=='Sale' && aircraft.price>0">
                            <div class="asset-details-data-label">Price (US$)</div>
                            <div class="asset-details-data">{{parseFloat(aircraft.price).toFixed(2)}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="['Dry Lease','Wet Lease','Exchange','Charter','Lease Purchase'].includes(aircraft.offer_for)">
                            <div class="asset-details-data-label own-uppercase">{{aircraft.offer_for}}</div>
                            <div class="asset-details-data">{{aircraft.terms}}</div>
                        </div>



                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">Availability</div>
                            <div class="asset-details-data availability">{{aircraft.availability|moment("MMMM DD, YYYY")}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.current_location">
                            <div class="asset-details-data-label">Current Location</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.current_location.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.owner">
                            <div class="asset-details-data-label">Owner</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.owner.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.seller">
                            <div class="asset-details-data-label">Seller</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.seller.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.manager">
                            <div class="asset-details-data-label">Manager</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.manager.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>

                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.current_operator">
                            <div class="asset-details-data-label">Current Operator</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.current_operator.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="aircraft.previous_operator">
                            <div class="asset-details-data-label">Previous Operator</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{aircraft.previous_operator.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>

                        <template v-if="aircraft.description">
                            <div class="general-divider"></div>
                            <div class="asset-details-data-block">
                                <div class="asset-details-data-label">Description</div>
                                <div class="asset-details-data description">{{aircraft.description}}</div>
                            </div>
                        </template>

                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="aircraft.attaches">
                            <div class="asset-details-data-label">File Attachments</div>
                            <template v-if="!aircraft.attaches.length && $root.$data.user">
                                {{'No attachment'}}
                            </template>
                            <template v-else>
                                <a :href="'/storage/'+attach.path" target="_blank" class="file-link" v-for="attach in aircraft.attaches" v-if="$root.$data.user">
                                    <span class="attach-span"></span>
                                    {{attach.original_file_name}}
                                </a>

                            </template>
                            <div class="lock-block" v-if="!$root.$data.user">
                                <span class="lock"></span>
                                Login to view
                            </div>

                        </div>
                        <div class="general-divider"></div>
                        <div class="heading-block asset-details-page">
                            <h3 class="home-section-title">Analytics</h3>

                            <div class="line-block">

                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <h4 class="chart-title">This Aircraft</h4>
                            <combo-chart
                                    :label="['likes', 'views']"
                                    :data1="chartData1['id']['likes']"
                                    :data2="chartData1['id']['views']"
                                    :id="'chart1'"
                                    :labels="chartData1['id']['label']"
                                    v-if="chartLoad"
                            ></combo-chart>
                        </div>
                        <div class="general-divider"></div>
                        <div class="chart-wrapper">
                            <h4 class="chart-title" v-if="aircraft.type">{{aircraft.manufacturer?aircraft.manufacturer.name:''}}&nbsp;{{aircraft.type?aircraft.type.name:''}}&nbsp;{{aircraft.modeled?aircraft.modeled.name:''}}</h4>
                            <combo-chart
                                    :label="['likes', 'views']"
                                    :data1="chartData1['type']['likes']"
                                    :data2="chartData1['type']['views']"
                                    :id="'chart2'"
                                    :labels="chartData1['type']['label']"
                                    v-if="chartLoad"
                            ></combo-chart>
                        </div>
                    </div>
                    <div id="Asset-Share" class="asset-page-right-block">
                        <div class="general-divider details-sidebar"></div>
                        <div class="asset-details-share-wrapper demo-xyz">
                            <div class="send-message-label-2"><span class="message-icon"></span> Share this asset</div>

                                <share-this></share-this>

                        </div>
                        <div class="general-divider"></div>
                        <div class="heading-block related-sidebar">
                            <h3 class="home-section-title">Promoted Aircraft</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="sidebar-promoted-asset-block" v-for="(item,index) in getFeaturedAircraft">
                            <div class="sidebar-promoted-asset">
                                <div class="asset-main-wrapper">
                                    <router-link :to=" item.linkify" class="asset-link w-inline-block" @click.native="getList()">
                                        <div class="asset-image" :style="$root.getGalleryMainImagePath(item.medias)"></div>
                                        <div class="asset-name-block">
                                            <h2 class="asset-title-h2">{{ item.title | filterTitle | titlify }}</h2>
                                        </div>
                                        <div class="asset-list-main-data-block">
                                            <div class="asset-list-data-block">
                                                <div class="asset-list-data yom">{{item.yom| moment("YYYY")}}</div>
                                                <!--<div class="dot-spacer"></div>-->

                                                <div class="asset-list-data-block" v-if="!$root.$data.user">
                                                    <div class="asset-list-data sn">MSN</div>
                                                    <div class="lock-block">
                                                        <span class="lock"></span> Login
                                                    </div>
                                                </div>
                                                <div class="asset-list-data-block" v-if="$root.$data.user">
                                                    <div class="asset-list-data sn">MSN {{item.MSN}}</div>
                                                </div>
                                            </div>
                                            <div class="asset-list-data-block">
                                                <div class="asset-list-data">TSN {{item.tsn}}</div>
                                                <div class="dot-spacer"></div>
                                                <div class="asset-list-data">CSN {{item.csn}}</div>
                                            </div>
                                            <div class="asset-list-data-block" v-if="$root.$data.user">
                                                <div class="asset-list-data">
                                                    <template v-if="_.has(item,'user.contact.first_name')">
                                                        {{item.user.contact.first_name}}
                                                    </template>
                                                </div>
                                                <template v-if="_.has(item,'user.contact.company.name')">
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data">
                                                        {{item.user.contact.company.name}}
                                                    </div>
                                                </template>

                                            </div>
                                            <div class="asset-list-data-block" v-else>
                                                <div class="asset-list-data">

                                                    <span class="lock"></span> Login to view Contact

                                                </div>
                                            </div>
                                        </div>
                                    </router-link>

                                    <div class="asset-label-block">
                                        <div :class="{'business-tag':true,
                                            'acmi':item.offer_for=='ACMI',
                                                    'charter':item.offer_for=='Charter',
                                                    'lease':item.offer_for=='Dry Lease' || item.offer_for=='Wet Lease'||
                                                                item.offer_for=='Lease'|| item.offer_for=='Lease Purchase',
                                                    'outright':item.offer_for=='Outright Purchase',
                                                    'exchange':item.offer_for=='Exchange',
                                                    'partOut':item.offer_for=='Part out',
                                                    'sale':item.offer_for=='Sale'}"

                                        >{{item.offer_for}}</div>
                                        <div class="asset-likes-premium">
                                            <div class="airbook-likes">
                                                <a href="#"
                                                   :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                                   @click="$root.postLike(item.modelType, item.id, 'App\\'+ $root.capitalize(item.modelType))"
                                                ></a>{{item.likes.length}}
                                            </div>
                                            <div data-delay="0" class="asset-menu w-dropdown">
                                                <div class="asset-dropdown-toggle w-dropdown-toggle"  @click.prevent="$root.toggle" >
                                                    <div class="dot-block" >
                                                        <div class="dot"></div>
                                                        <div class="dot"></div>
                                                        <div class="dot"></div>
                                                    </div>
                                                </div>
                                                <nav class="asset-dropdown-list w-dropdown-list">
                                                    <a href="#" class="asset-menu-link w-dropdown-link"
                                                       @click="$root.mailModalShow(item)">Send Message</a>
                                                    <a href="#" class="asset-menu-link w-dropdown-link"  @click.prevent="$root.postFavourite(item.modelType,item.id, 'App\\'+ $root.capitalize(item.modelType) )">
                                                        Add to favorite
                                                    </a>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="sendMail" height="auto" >
            <sendmail :model="$root.$data.mailModalData" :fromModal="true"></sendmail>
        </modal>

    </div>
</template>

<script src="../js/details/aircraftShow.js"></script>

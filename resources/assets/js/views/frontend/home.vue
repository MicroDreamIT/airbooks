<template>

        <div v-if="metas">

            <!--keyword with front banner-->
            <div class="hero-section" data-ix="show-float-search">
                <div class="social-media-icons"><a href="https://www.facebook.com/airbook.aero" target="_blank" class="social-link"></a><a href="https://twitter.com/airbookaero" target="_blank" class="social-link"></a><a href="https://www.linkedin.com/company/airbook" target="_blank" class="social-link"></a><a href="https://www.instagram.com/airbook.aero/" target="_blank" class="social-link"></a></div>
                <div class="container hero-container w-container">
                    <div class="hero-block-wrapper">
                        <h2 class="home-hero-title">the all-in-one <br>aviation asset re-marketing platform</h2>
                        <div class="hero-search-block">
                            <div class="home-seach-form-block w-form">
                                <search-layout style="width: 100%"
                                ></search-layout>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--PROMOTED ASSETS-->
            <div v-if="$root.$data.featured.length>0" id="Promoted-Assets" class="section promoted">
                <div class="container w-container">
                    <div class="heading-block">
                        <h3 class="home-section-title">Promoted Assets</h3>
                        <div class="line-block">
                            <div class="blueline"></div>
                            <div class="redline"></div>
                        </div>
                    </div>

                    <div class="home-promoted-assets-wrapper">
                        <div class="home-promoted-asset-row w-row" v-for="(chunk,index) in chunkFeatured" v-if="index<2">
                            <div class="home-promoted-asset-column w-col w-col-3 w-col-medium-6 w-col-small-6" v-for="featuredItem in chunk">
                                <div class="asset-main-wrapper">
                                    <router-link :to=" featuredItem.modelType + '/' + featuredItem.id+'-'+featuredItem.title | linkify" class="asset-link-wrapper w-inline-block">
                                        <!--{ 'background-image': 'url(/storage/' +item.path+'/'+ item.original_file_name + ')' }-->
                                        <div class="asset-image"
                                             :style="$root.getGalleryMainImagePath(featuredItem.medias)"></div>
                                        <div class="asset-name-block">
                                            <h2 class="asset-title-h2">{{ featuredItem.title | filterTitle | titlify }}</h2>
                                        </div>
                                        <div class="asset-list-main-data-block">
                                            <div class="asset-list-data-block">
                                                <div class="asset-list-data yom" v-if="featuredItem.modelType=='aircraft'">
                                                    {{featuredItem.YOM | moment("YYYY") }}

                                                </div>
                                                <div class="dot-spacer" v-if="featuredItem.modelType=='aircraft'"></div>

                                                <div class="asset-list-data sn" v-if="featuredItem.modelType=='aircraft'">MSN
                                                    <template v-if="$root.$data.user">{{getMsn_esn_sn(featuredItem)}}</template>
                                                </div>
                                                <div class="asset-list-data sn" v-if="featuredItem.modelType=='engine'">ESN
                                                    <template v-if="$root.$data.user">{{getMsn_esn_sn(featuredItem)}}</template>
                                                </div>
                                                <div class="asset-list-data sn" v-if="featuredItem.modelType=='apu'">SN
                                                    <template v-if="$root.$data.user">{{getMsn_esn_sn(featuredItem)}}</template>
                                                </div>

                                                <div class="lock-block" v-if="!$root.$data.user">

                                                    <span class="lock"></span> Login

                                                </div>
                                                <!--<div class="asset-list-data sn" v-else>-->
                                                <!--{{getMsn_esn_sn(featuredItem) }}-->
                                                <!--</div>-->

                                            </div>
                                            <div class="asset-list-data-block">

                                                <template v-if="featuredItem.modelType=='aircraft'">
                                                    <div class="asset-list-data" v-if="featuredItem.tsn">TSN {{featuredItem.tsn}}</div>
                                                    <div class="dot-spacer" v-if="featuredItem.csn && featuredItem.tsn"></div>
                                                    <div class="asset-list-data" v-if="featuredItem.csn">CSN {{featuredItem.csn}}</div>
                                                </template>

                                                <template v-if="featuredItem.modelType =='engine' || featuredItem.modelType =='apu' ">
                                                    <div class="asset-list-data own-uppercase" v-if="featuredItem.status" > {{featuredItem.status}}</div>
                                                    <div class="dot-spacer" v-if="featuredItem.status && featuredItem.cycle_remaining"></div>
                                                    <div class="asset-list-data" v-if="featuredItem.cycle_remaining">CR {{featuredItem.cycle_remaining}}</div>
                                                </template>

                                            </div>
                                            <div class="asset-list-data-block" v-if="$root.$data.user">
                                                <div class="asset-list-data">
                                                    <template v-if="_.has(featuredItem,'user.contact.first_name')">
                                                        {{featuredItem.user.contact.first_name}}
                                                    </template>
                                                </div>
                                                <template v-if="_.has(featuredItem,'user.contact.company.name')">
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data">
                                                        {{featuredItem.user.contact.company.name|namify}}

                                                    </div>
                                                </template>

                                            </div>
                                            <div class="asset-list-data-block" v-else>
                                                <div class="asset-list-data">
                                                    <span class="lock" style="color:#888888"></span> Login to view Contact

                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                    <div class="asset-label-block">

                                        <div :class="{'business-tag':true,
                                            'acmi':featuredItem.offer_for=='ACMI',
                                                    'charter':featuredItem.offer_for=='Charter',
                                                    'lease':featuredItem.offer_for=='Dry Lease' || featuredItem.offer_for=='Wet Lease'||
                                                                featuredItem.offer_for=='Lease'|| featuredItem.offer_for=='Lease Purchase',
                                                    'outright':featuredItem.offer_for=='Outright Purchase',
                                                    'exchange':featuredItem.offer_for=='Exchange',
                                                    'partOut':featuredItem.offer_for=='Part out',
                                                    'cash':featuredItem.offer_for=='cash',
                                                    'sale':featuredItem.offer_for=='Sale'}"

                                        >{{featuredItem.offer_for}}</div>

                                        <div class="asset-likes-premium">
                                            <div class="airbook-likes">
                                                <a href="#"
                                                   :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(featuredItem.likes,'user_id', $root.$data.user, 'id')}"
                                                   @click="$root.postLike(featuredItem.modelType,featuredItem.id, 'App\\'+ $root.capitalize(featuredItem.modelType) )">
                                                    
                                                </a>
                                                {{featuredItem.likes.length}}
                                            </div>
                                            <div data-delay="0" class="asset-menu w-dropdown">

                                                <div class="asset-dropdown-toggle w-dropdown-toggle" @click.prevent="$root.toggle" >
                                                    <div class="dot-block">
                                                        <div class="dot"></div>
                                                        <div class="dot"></div>
                                                        <div class="dot"></div>
                                                    </div>
                                                </div>

                                                <nav class="asset-dropdown-list w-dropdown-list">
                                                    <a href="#" class="asset-menu-link w-dropdown-link" @click="$root.mailModalShow(featuredItem)">
                                                        Send Message
                                                    </a>
                                                    <a href="#" class="asset-menu-link w-dropdown-link"
                                                       @click="$root.postFavourite(featuredItem.modelType,featuredItem.id, 'App\\'+ $root.capitalize(featuredItem.modelType) )">
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
            <div class="center-screen" v-else>
                <atom-spinner color="#2173b9"></atom-spinner>
            </div>
            <!--WHY AIRBOOK-->
            <div class="section why-airbook">
                <div class="container w-container">
                    <div class="heading-block">
                        <h3 class="home-section-title">Why Airbook</h3>
                        <div class="line-block">
                            <div class="blueline"></div>
                            <div class="redline"></div>
                        </div>
                        <h1 class="home-h1-title">
                            On Airbook you can market your aviation assets for free, connect to the aviation professionals,
                            explore aviation companies e.g. airlines &amp; MRO's and contribute to improve the available information.
                        </h1>
                    </div>
                    <div class="home-why-ab-wrapper">
                        <div class="home-row w-row">
                            <div class="home-column w-col w-col-4 w-col-small-small-stack">
                                <div class="home-widget-wrapper">
                                    <div class="multi-icons">
                                        <div class="home-widget-icon passenger-jet"></div>
                                        <div class="home-widget-icon propeller"></div>
                                        <div class="home-widget-icon helicopter"></div>
                                    </div>
                                    <h2 class="home-widget-title">Aircraft &amp; Helicopters</h2>
                                    <!--<a href="aircraft.html" class=""></a>-->
                                    <router-link :to="{name:'frontAircraft'}" class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-2 w-col-small-small-stack">
                                <div class="home-widget-wrapper">
                                    <div class="multi-icons">
                                        <div class="home-widget-icon jet-engine" data-ix="rotate" style="transform: rotateZ(359deg); transition: transform 3000ms linear 0s;"></div>
                                        <div class="home-widget-icon propeller-engine" data-ix="rotate" style="transform: rotateZ(359deg); transition: transform 3000ms linear 0s;"></div>
                                    </div>
                                    <h2 class="home-widget-title">Engines</h2>
                                    <router-link :to="{name:'frontEngine'}" class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-2 w-col-small-small-stack">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon apu"></div>
                                    <h2 class="home-widget-title">APU's</h2>
                                    <router-link :to="{name:'frontApu'}"  class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-2 w-col-small-small-stack">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon parts" data-ix="rotate" style="transform: rotateZ(359deg); transition: transform 3000ms linear 0s;"></div>
                                    <h2 class="home-widget-title">Parts</h2>
                                    <router-link :to="{name:'frontPart'}"  class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-2 w-col-small-small-stack">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon wanted"></div>
                                    <h2 class="home-widget-title">Wanted</h2>
                                    <router-link :to="{name:'frontWanted'}"  class="button w-button">Browse</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="home-row w-row">
                            <div class="home-column w-col w-col-2">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon airports"></div>
                                    <h2 class="home-widget-title">Airports</h2>
                                    <router-link :to="{name:'airports'}"  class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-4">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon people"></div>
                                    <h2 class="home-widget-title">Contacts</h2>
                                    <router-link :to="{name:'frontContact'}"  class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-2">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon companies"></div>
                                    <h2 class="home-widget-title">Companies</h2>
                                    <router-link :to="{name:'companies'}"  class="button w-button">Browse</router-link>
                                </div>
                            </div>
                            <div class="home-column w-col w-col-2">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon news"></div>
                                    <h2 class="home-widget-title">Aviation News</h2>
                                    <router-link :to="{name:'frontNews'}" class="button w-button" > Browse</router-link>

                                </div>
                            </div>
                            <div class="home-column w-col w-col-2">
                                <div class="home-widget-wrapper">
                                    <div class="home-widget-icon events"></div>
                                    <h2 class="home-widget-title">Aviation Events</h2>
                                    <router-link :to="{name:'frontEvent'}"class="button w-button" >Browse</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--LATEST PUBLISHED ASSETS-->
            <div class="section home-assets">
                <div class="container w-container">
                    <div class="heading-block">
                        <h3 class="home-section-title">Latest Published Assets</h3>
                        <div class="line-block">
                            <div class="blueline"></div>
                            <div class="redline"></div>
                        </div>
                        <h3 class="home-sub-headline">Available and wanted assets published in last one week</h3>
                    </div>
                    <div class="home-asset-wrapper">
                        <div class="latest-asset-row w-row">
                            <div class="latest-asset-column w-col w-col-6">
                                <div class="home-asset-block">
                                    <div class="heading-block left-side">
                                        <h2 class="home-section-title home-sub-section-title">aircraft</h2>
                                        <div class="line-block">
                                            <div class="blueline home-asset-blue-line"></div>
                                            <div class="redline home-asset-red-line"></div>
                                        </div>
                                    </div>
                                    <div class="asset-wrapper" v-for="(item, index) in aircrafts">
                                        <router-link :to="{name:'frontAircraftShow',params:{id:item.linkify}}" class="asset-link-block w-inline-block">
                                            <h2 class="asset-title-h2 own-upper">
                                                {{item.title|filterTitle| titlify }}
                                            </h2>

                                            <div class="asset-list-data-block" v-if="!$root.$data.user">
                                                <div class="asset-list-data sn">MSN</div>
                                                <div class="lock-block">
                                                    <span class="lock"></span> Login
                                                </div>
                                            </div>
                                            <div class="asset-list-data-block" v-if="$root.$data.user">
                                                <div class="asset-list-data sn">MSN {{item.MSN}}</div>
                                            </div>

                                            <div class="asset-list-data-block">
                                                <div class="asset-list-data yom" v-if="item.YOM">{{item.YOM | moment("YYYY")}}</div>
                                                <template v-if="item.tsn">
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data">TSN {{item.tsn}}</div>
                                                </template>
                                                <template v-if="item.csn">
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data">CSN {{item.csn}}</div>
                                                </template>

                                            </div>
                                            <div class="asset-list-data-block">
                                                <div :class="{'business-tag':true,
                                            'acmi':item.offer_for=='ACMI',
                                                    'charter':item.offer_for=='Charter',
                                                    'lease':item.offer_for=='Dry Lease' || item.offer_for=='Wet Lease'||
                                                                item.offer_for=='Lease'|| item.offer_for=='Lease Purchase',
                                                    'outright':item.offer_for=='Outright Purchase',
                                                    'exchange':item.offer_for=='Exchange',
                                                    'partOut':item.offer_for=='Part out',
                                                    'cash':item.offer_for=='cash',
                                                    'sale':item.offer_for=='Sale'}"

                                                >{{item.offer_for}}</div>

                                                <div class="dot-spacer"></div>
                                                <div class="lock-block" v-if="!$root.$data.user">
                                                    <span class="lock"></span> Login to view contact</div>

                                                <template v-if="$root.$data.user && item.user">

                                                    <div class="asset-list-data">
                                                        <template v-if="_.has(item,'user.contact.first_name')">
                                                            {{item.user.contact.first_name}}
                                                        </template>
                                                    </div>

                                                    <template v-if="_.has(item,'user.contact.company.name')">
                                                        <div class="dot-spacer"></div>
                                                        <div class="asset-list-data">{{item.user.contact.company.name|namify}}</div>
                                                    </template>

                                                </template>
                                            </div>
                                        </router-link>
                                        <div class="airbook-likes">

                                            <a href="#"
                                               :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                               @click="postLike(index,item.id,'App\\Aircraft')" ></a>{{item.likes.length}}
                                        </div>
                                    </div>

                                    <!--<a href="aircraft.html" class="home-view-more-link">View More</a>-->
                                    <router-link  :to="{name:'frontAircraft'}" class="home-view-more-link">View More</router-link>
                                </div>
                            </div>
                            <div class="latest-asset-column w-col w-col-6">
                                <div class="home-asset-block">
                                    <div class="heading-block left-side">
                                        <h2 class="home-section-title home-sub-section-title">Engines</h2>
                                        <div class="line-block">
                                            <div class="blueline home-asset-blue-line"></div>
                                            <div class="redline home-asset-red-line"></div>
                                        </div>
                                    </div>
                                    <div class="asset-wrapper" v-for="(item,index) in engines">
                                        <router-link :to="{name:'frontEngineShow',params:{id:item.linkify}}" class="asset-link-block w-inline-block">
                                            <h2 class="asset-title-h2 own-upper">
                                                {{item.title|filterTitle|titlify }}
                                            </h2>

                                            <div class="asset-list-data-block" v-if="!$root.$data.user">
                                                <div class="asset-list-data sn">ESN</div>
                                                <div class="lock-block">
                                                    <span class="lock"></span> Login
                                                </div>
                                            </div>
                                            <div class="asset-list-data-block" v-if="$root.$data.user">
                                                <div class="asset-list-data sn">ESN {{item.esn}}</div>
                                            </div>

                                            <div class="asset-list-data-block">
                                                <div class="asset-list-data">Serviceable</div>
                                                <template v-if="item.cycle_remaining">
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data">CR {{item.cycle_remaining}}</div>
                                                </template>

                                                <template v-if="item.tso">
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data">TSO {{item.tso}}</div>
                                                </template>

                                            </div>
                                            <div class="asset-list-data-block">
                                                <div :class="{'business-tag':true,
                                            'acmi':item.offer_for=='ACMI',
                                                    'charter':item.offer_for=='Charter',
                                                    'lease':item.offer_for=='Dry Lease' || item.offer_for=='Wet Lease'||
                                                                item.offer_for=='Lease'|| item.offer_for=='Lease Purchase',
                                                    'outright':item.offer_for=='Outright Purchase',
                                                    'exchange':item.offer_for=='Exchange',
                                                    'partOut':item.offer_for=='Part out',
                                                     'cash':item.offer_for=='cash',
                                                    'sale':item.offer_for=='Sale'}"

                                                >{{item.offer_for}}</div>

                                                <div class="dot-spacer"></div>
                                                <div class="lock-block" v-if="!$root.$data.user">
                                                    <span class="lock"></span> Login to view contact</div>

                                                <template v-if="$root.$data.user && item.user">

                                                    <div class="asset-list-data">
                                                        <template v-if="_.has(item,'user.contact.first_name')">
                                                            {{item.user.contact.first_name}}
                                                        </template>
                                                    </div>
                                                    <template v-if="_.has(item,'user.contact.company.name')">
                                                        <div class="dot-spacer"></div>
                                                        <div class="asset-list-data">{{item.user.contact.company.name|namify}}</div>
                                                    </template>

                                                </template>
                                            </div>
                                        </router-link>
                                        <div class="airbook-likes">
                                            <a href="#" class="airbook-like-button" :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                               @click="postLike(index,item.id, 'App\\Engine')"></a>{{item.likes.length}}
                                        </div>
                                    </div>
                                    <router-link :to="{name:'frontEngine'}" class="home-view-more-link">View More</router-link>
                                </div>
                            </div>
                        </div>
                        <div class="latest-asset-row apu-and-wanted w-row">
                            <div class="latest-asset-column w-col w-col-6">
                                <div class="home-asset-block">
                                    <div class="heading-block left-side">
                                        <h2 class="home-section-title home-sub-section-title">APU's</h2>
                                        <div class="line-block">
                                            <div class="blueline home-asset-blue-line"></div>
                                            <div class="redline home-asset-red-line"></div>
                                        </div>
                                    </div>
                                    <div class="asset-wrapper" v-for="(item,index) in apus">
                                        <router-link :to="{name:'frontApuShow',params:{id:item.linkify}}"  class="asset-link-block w-inline-block">
                                            <h2 class="asset-title-h2 own-upper">
                                                {{item.title|filterTitle| titlify }}
                                            </h2>
                                            <div class="asset-list-data-block" v-if="!$root.$data.user">
                                                <div class="asset-list-data sn">SN</div>
                                                <div class="lock-block">
                                                    <span class="lock"></span> Login
                                                </div>
                                            </div>
                                            <div class="asset-list-data-block" v-if="$root.$data.user">
                                                <div class="asset-list-data sn">SN {{item.serial_number}}</div>
                                            </div>

                                            <div class="asset-list-data-block">
                                                <div :class="{'business-tag':true,
                                            'acmi':item.offer_for=='ACMI',
                                                    'charter':item.offer_for=='Charter',
                                                    'lease':item.offer_for=='Dry Lease' || item.offer_for=='Wet Lease'||
                                                                item.offer_for=='Lease'|| item.offer_for=='Lease Purchase',
                                                    'outright':item.offer_for=='Outright Purchase',
                                                    'exchange':item.offer_for=='Exchange',
                                                    'partOut':item.offer_for=='Part out',
                                                     'cash':item.offer_for=='cash',
                                                    'sale':item.offer_for=='Sale'}"

                                                >{{item.offer_for}}</div>

                                                <div class="dot-spacer"></div>

                                                <div class="lock-block" v-if="!$root.$data.user">
                                                    <span class="lock"></span> Login to view contact
                                                </div>

                                                <template v-if="$root.$data.user && item.user">

                                                    <div class="asset-list-data">
                                                        <template v-if="_.has(item,'user.contact.first_name')">
                                                            {{item.user.contact.first_name}}
                                                        </template>
                                                    </div>
                                                    <template v-if="_.has(item,'user.contact.company.name')">
                                                        <div class="dot-spacer"></div>
                                                        <div class="asset-list-data">{{item.user.contact.company.name|namify}}</div>
                                                    </template>

                                                </template>
                                            </div>
                                        </router-link>
                                        <div class="airbook-likes">
                                            <a href="#"  :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                               @click="postLike(index,item.id,'App\\Apu')"></a>{{item.likes.length}}
                                        </div>
                                    </div>
                                    <router-link  :to="{name:'frontApu'}"class="home-view-more-link">View More</router-link></div>
                            </div>
                            <div class="latest-asset-column w-col w-col-6">
                                <div class="home-asset-block">
                                    <div class="heading-block left-side">
                                        <h2 class="home-section-title home-sub-section-title">Wanted</h2>
                                        <div class="line-block">
                                            <div class="blueline home-asset-blue-line"></div>
                                            <div class="redline home-asset-red-line"></div>
                                        </div>
                                    </div>
                                    <div class="asset-wrapper" v-for="(item,index) in wanteds">

                                        <router-link :to="{name:'frontWantedShow',params:{id:item.linkify}}" class="asset-link-block w-inline-block">
                                            <h2 class="asset-title-h2 own-upper">
                                                {{item.title|filterTitle| titlify }}
                                            </h2>

                                            <div class="asset-list-data yom" v-if="item.type='aircraft'">{{item.yom| moment("YYYY")}}</div>
                                            <div class="asset-list-data-block">
                                                <div :class="{'business-tag':true,
                                            'acmi':item.terms=='ACMI',
                                                    'charter':item.terms=='Charter',
                                                    'lease':item.terms=='Dry Lease' || item.terms=='Wet Lease'||
                                                                item.terms=='Lease'|| item.terms=='Lease Purchase',
                                                    'outright':item.terms=='Outright Purchase',
                                                    'exchange':item.terms=='Exchange',
                                                    'partOut':item.terms=='Part out',
                                                     'cash':item.terms=='cash',
                                                    'sale':item.terms=='Sale'}"

                                                >{{item.terms}}</div>



                                                <div class="dot-spacer"></div>

                                                <div class="lock-block" v-if="!$root.$data.user">
                                                    <span class="lock"></span> Login to view contact
                                                </div>


                                                <template v-if="$root.$data.user && item.user">

                                                    <div class="asset-list-data">
                                                        <template v-if="_.has(item,'user.contact.first_name')">
                                                            {{item.user.contact.first_name}}
                                                        </template>
                                                    </div>
                                                    <template v-if="_.has(item,'user.contact.company.name')">
                                                        <div class="dot-spacer"></div>
                                                        <div class="asset-list-data">{{item.user.contact.company.name|namify}}</div>
                                                    </template>

                                                </template>

                                            </div>
                                        </router-link>
                                        <div class="airbook-likes">
                                            <a href="#"
                                               :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                               @click="postLike(index,item.id,'App\\Wanted')"></a>{{item.likes.length}}
                                        </div>
                                    </div>

                                    <router-link :to="{name:'frontWanted'}" class="home-view-more-link">View More</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--NEWS & EVENTS-->
            <div class="section home-news-events">
                <div class="container w-container">
                    <div class="heading-block">
                        <h2 class="home-section-title">News &amp; Events</h2>
                        <div class="line-block">
                            <div class="blueline"></div>
                            <div class="redline"></div>
                        </div>
                        <h3 class="home-sub-headline">Latest aviation news and events around the world</h3>
                    </div>
                    <div class="home-news-events-wrapper">
                        <div class="home-news-events-row w-row">
                            <div class="home-news-events-column w-col w-col-6 w-col-stack">
                                <div class="news-events-block">
                                    <div class="heading-block left-side">
                                        <h2 class="home-section-title home-sub-section-title">Aviation News</h2>
                                        <div class="line-block">
                                            <div class="blueline home-asset-blue-line"></div>
                                            <div class="redline home-asset-red-line"></div>
                                        </div>
                                    </div>
                                    <div class="ne-block" v-for="(item,index) in news">

                                        <router-link :to="{name:'newsDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="ne-image home-page w-inline-block" :style="item|imagePathForStyle"></router-link>
                                        <div class="home-news-event-info">
                                            <router-link :to="{name:'newsDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}"  class="home-news-events-headline own-upper" > {{item.title| titlify }}</router-link>
                                            <div class="news-events-info-wrapper-div">
                                                <div class="news-events-date-location"><span class="clock-icon-span"></span>{{item.date | moment("MMM DD, YYYY")}}</div>
                                                <div class="dot-spacer likes-next"></div>
                                                <div class="airbook-likes">
                                                    <a href="#"
                                                       :class="{'airbook-like-button':true, 'active': item.hasLike}"
                                                       @click="postLike( index, item.id, 'App\\News' )"
                                                    ></a>
                                                    {{item.likes}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <router-link to="news" class="home-view-more-link" style="max-width: 1170px;">View More </router-link>

                                </div>
                            </div>
                            <div class="home-news-events-column w-col w-col-6 w-col-stack">
                                <div class="news-events-block">
                                    <div class="heading-block left-side">
                                        <h2 class="home-section-title home-sub-section-title">Aviation Events</h2>
                                        <div class="line-block">
                                            <div class="blueline home-asset-blue-line"></div>
                                            <div class="redline home-asset-red-line"></div>
                                        </div>
                                    </div>
                                    <div class="ne-block" v-for="(item,index) in events">

                                        <router-link :to="{name:'eventDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="ne-image home-page w-inline-block" :style="item| imagePathForStyle"></router-link>

                                        <div class="home-news-event-info">
                                            <router-link :to="{name:'eventDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="home-news-events-headline own-upper"> {{item.title| titlify }}</router-link>

                                            <div class="news-events-info-wrapper-div">
                                                <div class="news-events-date-location"><span class="clock-icon-span"></span>{{item.start_date | moment("MMM DD, YYYY")}}</div>
                                                <div class="dot-spacer events-dot"></div>
                                                <div class="news-events-date-location"><span class="clock-icon-span"></span>{{item.end_date | moment("MMM DD, YYYY")}}</div>
                                            </div>
                                            <div class="news-events-date-location" v-if="item.name">
                                                <span class="clock-icon-span"></span>{{item.name}}
                                            </div>
                                            <div class="news-events-info-wrapper-div">
                                                <div class="airbook-likes">
                                                    <a href="#"
                                                       :class="{'airbook-like-button':true, 'active': item.hasLike }"
                                                       @click="postLike(index,item.id, 'App\\Event')"
                                                    ></a>
                                                    {{item.likes}}
                                                </div>
                                                <div class="event-interest own-left-margin">
                                                    <a href="#" :class="{'like-icon-span':true, 'active': item.hasInterested}"
                                                       @click="postEventInterested(index, item.id, 'App\\Event')">
                                                        
                                                    </a>
                                                    Interested
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <router-link :to="{name:'frontEvent'}" class="home-view-more-link" style="max-width: 1170px;">View More </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Subscribe to the latest asset availability alerts-->
            <div class="subscription-section">
                <div class="container w-container">
                    <div class="subscription-wrapper">
                        <h6 class="subscription-headline">Subscribe to the latest asset availability alerts</h6>
                        <div class="form-block w-form">
                            <form id="wf-form-Subscription-Form" name="wf-form-Subscription-Form" data-name="Subscription Form" class="subscription-form" @submit.prevent="postSubscriber">

                                <input type="text"
                                       v-model="subscriberName"
                                       class="subscription-form-field w-input"
                                       maxlength="256"
                                       name="Subscriber-Name-2"
                                       data-name="Subscriber Name 2"
                                       placeholder="Name"
                                       id="Subscriber-Name-2"
                                       required="">

                                <input type="email"
                                       v-model="subscriberEmail"
                                       class="subscription-form-field w-input"
                                       maxlength="256"
                                       name="Subscriber-Email-2"
                                       data-name="Subscriber Email 2"
                                       placeholder="Email"
                                       id="Subscriber-Email-2" required=""
                                >

                                <input type="submit" value="Subscribe" data-wait="Please wait..." class="subscription-button w-button">
                            </form>
                            <div class="subscribe-success w-form-done">
                                <div>Thank you! Your are subscribed successfully.</div>
                            </div>
                            <div class="subscribe-error-message w-form-fail">
                                <div>Oops! Please try again!</div>
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

<script src="./js/home.js"></script>

<style scoped>
    .frontModal{
        background: rgba(0, 0, 0, 0.62);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1000000;
    }
    .frontModal .modal-content{
        width: 50%;
        background: white;
        min-height: 350px;
        margin: 50px auto;
    }
    .center-screen{
        display: flex;
        justify-content: center;
        height: 20vh;
        align-items: center;
    }
</style>

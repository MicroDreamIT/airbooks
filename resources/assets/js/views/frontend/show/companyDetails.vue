<template>
    <div>
        <search-layout></search-layout>
        <div class="asset-details-section">
            <div class="container w-container">
                <div class="module-details-row w-row">
                    <div class="module-details-column right-borderline w-col w-col-5">
                        <div class="company-profile-logo"  :style="company.medias|imagePathForStyle"></div>
                    </div>
                    <div class="module-details-column left-borderline w-col w-col-7">
                        <div class="asset-details-widget-block">
                            <div class="asset-details-widget">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">
                                    {{company.views}}
                                </div>
                            </div>
                            <a href="#"
                               :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(company.likes,'user_id', $root.$data.user, 'id')||likesActive}"
                               @click="postLikeC(company.id, 'App\\Company')">
                                <div class="asset-details-widget-icon">
                                    
                                </div>
                                <div class="asset-details-widget-data">
                                    {{company.likes.length}}
                                </div>
                            </a>
                            <a href="#" :class="{'asset-details-widget w-inline-block':true,
                            'active': $root.checkObject_key_value(company.favourites,'user_id', $root.$data.user, 'id')||favouriteActive}"
                               @click="postFavourite(company.id, 'App\\Company')">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data" >
                                    Save
                                </div>
                            </a>
                            <a href="#share" class="asset-details-widget w-inline-block">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Share</div>
                            </a>
                        </div>
                        <div class="general-divider"></div>
                        <h1 class="details-page-h1-title" v-if="company.id">
                            {{company.name}}
                        </h1>
                        <div class="details-page-date">
                            <span class="asset-details-clock-icon"></span>
                            Published {{company.created_at | moment("MMM DD, YYYY")}}
                        </div>

                        <div class="asset-details-data-block profile-page-title"
                             v-if="company.specialities">
                            <h2 class="company-specialty-label">
                            <template v-for="(speciality, index) in company.specialities" v-if="company.specialities">
                                {{speciality.name}}
                                <strong v-if="index < company.specialities.length-1 "> | </strong>
                            </template>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="module-details-row w-row">
                    <div class="module-details-column right-borderline w-col w-col-5">
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="company.business_phone">
                            <div class="asset-details-data-label">Office Phone</div><a href="#" class="call-link">{{company.business_phone}}</a></div>

                        <!--<div class="asset-details-data-block">-->
                            <!--<div class="asset-details-data-label">Fax</div><a href="tel:+97141234567" class="call-link">+971 4 1234567</a></div>-->

                        <div class="asset-details-data-block" v-if="company.website">
                            <div class="asset-details-data-label">Website</div><a :href="'//'+company.website" target="_blank" class="call-link">{{company.website}}</a></div>
                        <div class="asset-details-data-block" v-if="company.po_box">
                            <div class="asset-details-data-label">P.O Box</div>
                            <div class="asset-details-data">{{company.po_box}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="company.zip_code">
                            <div class="asset-details-data-label">ZIP</div>
                            <div class="asset-details-data">{{company.zip_code}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="company.address">
                            <div class="asset-details-data-label">Address</div>
                            <div class="asset-details-data">{{company.address}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="company.city">
                            <div class="asset-details-data-label">City</div>
                            <div class="asset-details-data">{{company.city.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="company.state">
                            <div class="asset-details-data-label">State</div>
                            <div class="asset-details-data">{{company.state.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="company.country">
                            <div class="asset-details-data-label">Country</div>
                            <div class="asset-details-data">{{company.country.name}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="company.profile">
                            <div class="asset-details-data-label">About</div>
                            <div class="asset-details-data description">{{company.profile}}</div>
                        </div>
                        <div class="general-divider"></div>
                    </div>
                    <div class="module-details-column left-borderline w-col w-col-7">
                        <div id="ShareProfile" class="heading-block profile-page">
                            <h3 class="home-section-title profile-connect-title">People on Airbook</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <template v-if="getPeopleByCompanyId">
                            <template v-for="item in peopleList" v-if="$root.$data.user">
                                <router-link :to="{name:'contactDetails',params:{id:item.id+'-'+ $root.linkify(item.first_name+' '+item.last_name)}}"class="asset-details-page-side-block w-inline-block">
                                    <div class="user-default-image"></div>
                                    <div class="asset-details-contact-info-block">
                                        <h4 class="asset-details-contact-name">{{item|fullName}}</h4>
                                        <div class="asset-details-contact-title" v-if="item.job_title">{{item.job_title.name}}</div>
                                    </div>
                                </router-link>
                            </template>
                        </template>

                        <template v-if="!$root.$data.user">
                            <div class="asset-list-data-block">
                                <div class="asset-list-data yom"></div>
                                <div class="asset-list-data-block">
                                    <div class="lock-block">
                                        <span class="lock"></span> Login to view
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div class="general-divider"></div>
                        <div class="profile-related-info-wrapper" v-if="getAssetByCompanyId">
                            <div class="heading-block profile-page">
                                <h3 class="home-section-title profile-connect-title">Assets On Airbook</h3>
                                <div class="line-block">
                                    <div class="blueline"></div>
                                    <div class="redline"></div>
                                </div>
                            </div>
                            <template v-if="$root.$data.user">
                                <template v-for="item in assetListData">
                                    <router-link :to=" '/' +item.modelType + '/' + item.id+'-'+item.title | linkify" class="profile-asset-block w-inline-block" >
                                        <h2 class="asset-title-h2">{{item.title| filterTitle | titlify }} </h2>
                                        <div class="asset-list-data-block">
                                            <div class="asset-list-data yom" v-if="item.YOM"> {{item.YOM | moment("YYYY") }}</div>
                                            <div class="dot-spacer" v-if="item.YOM"></div>
                                            <div class="asset-list-data-block" v-if="!$root.$data.user">
                                                <div class="asset-list-data sn" v-if="item.modelType=='aircraft'">MSN</div>
                                                <div class="asset-list-data sn" v-else-if="item.modelType=='engine'">ESN</div>
                                                <div class="asset-list-data sn" v-else-if="item.modelType=='apu'">SN</div>
                                                <div class="lock-block">
                                                    <span class="lock"></span> Login
                                                </div>
                                            </div>
                                            <div class="asset-list-data-block">
                                                <div class="asset-list-data sn" v-if="item.modelType=='aircraft'">MSN
                                                    <template v-if="$root.$data.user">
                                                        {{item.MSN}}

                                                    </template>
                                                    <div class="lock-block" v-else>
                                                        <span class="lock"></span> Login to view
                                                    </div>
                                                </div>
                                                <div class="asset-list-data sn" v-else-if="item.modelType=='engine'">ESN
                                                    <template v-if="$root.$data.user">
                                                        {{item.ESN}}
                                                    </template>
                                                    <div class="lock-block" v-else>
                                                        <span class="lock"></span> Login to view
                                                    </div>

                                                </div>
                                                <div class="asset-list-data sn"  v-else-if="item.modelType=='apu'">SN
                                                    <template v-if="$root.$data.user">
                                                        {{item.serial_number}}

                                                    </template>
                                                    <div class="lock-block" v-else>
                                                        <span class="lock"></span> Login to view
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="asset-list-data-block">
                                            <template v-if="item.modelType!='wanted'">
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
                                            </template>
                                            <template v-else="">
                                                <div :class="{'business-tag':true,
                                            'acmi':item.terms=='ACMI',
                                                    'charter':item.terms=='Charter',
                                                    'lease':item.terms=='Dry Lease' || item.terms=='Wet Lease'||
                                                                item.terms=='Lease'|| item.terms=='Lease Purchase',
                                                    'outright':item.terms=='Outright Purchase',
                                                    'exchange':item.terms=='Exchange',
                                                    'partOut':item.terms=='Part out',
                                                    'sale':item.terms=='Sale'}"

                                                >{{item.terms}}</div>
                                            </template>

                                            <div class="dot-spacer"></div>
                                            <div class="asset-list-data yom">in <span class="own-uppercase">{{item.modelType}}</span></div>
                                        </div>

                                    </router-link>
                                </template>
                            </template>

                            <!--<template  v-for="item in assetListData" v-if="$root.$data.user">-->
                                <!--<router-link :to=" '/' +item.modelType + '/' + item.id+'-'+item.title | linkify"class="profile-asset-block w-inline-block">-->
                                    <!--<h2 class="asset-title-h2">{{item.title| filterTitle | titlify }} </h2>-->
                                    <!--<div class="asset-list-data-block">-->
                                        <!--<div class="asset-list-data yom"> {{item.YOM | moment("YYYY") }}</div>-->
                                        <!--<div class="dot-spacer" v-if="item.YOM"></div>-->
                                        <!--<div class="asset-list-data-block" v-if="!$root.$data.user">-->
                                            <!--<div class="asset-list-data sn" v-if="item.modelType=='aircraft'">MSN</div>-->
                                            <!--<div class="asset-list-data sn" v-else-if="item.modelType=='engine'">ESN</div>-->
                                            <!--<div class="asset-list-data sn" v-else>SN</div>-->
                                            <!--<div class="lock-block">-->
                                                <!--<span class="lock"></span> Login-->
                                            <!--</div>-->
                                        <!--</div>-->
                                        <!--<div class="asset-list-data-block" v-if="$root.$data.user">-->
                                            <!--<div class="asset-list-data sn" v-if="item.modelType=='aircraft'">MSN {{item.MSN}}</div>-->
                                            <!--<div class="asset-list-data sn" v-else-if="item.modelType=='engine'">ESN {{item.esn}}</div>-->
                                            <!--<div class="asset-list-data sn" v-else>SN {{item.serial_number}}</div>-->
                                        <!--</div>-->
                                    <!--</div>-->

                                    <!--<div class="asset-list-data-block">-->
                                        <!--<div :class="{'business-tag':true,'acmi':item.offer_for=='ACMI',-->
                                                    <!--'charter':item.offer_for=='Charter',-->
                                                    <!--'lease':item.offer_for=='Dry Lease' || item.offer_for=='Lease'|| item.offer_for=='Lease Purchase',-->
                                                    <!--'outright':item.offer_for=='Outright Purchase',-->
                                                    <!--'exchange':item.offer_for=='Exchange',-->
                                                    <!--'partOut':item.offer_for=='Part out',-->
                                                    <!--'sale':item.offer_for=='Sale'}"-->

                                        <!--&gt;{{item.offer_for}}</div>-->
                                        <!--<div class="dot-spacer"></div>-->
                                        <!--<div class="asset-list-data yom">in <span class="own-uppercase">{{item.modelType}}</span></div>-->
                                    <!--</div>-->

                                <!--</router-link>-->
                            <!--</template>-->

                            <template v-if="!$root.$data.user">
                                <div class="asset-list-data-block">
                                    <div class="asset-list-data yom"></div>
                                    <div class="asset-list-data-block">
                                        <div class="lock-block">
                                            <span class="lock"></span> Login to view
                                        </div>
                                    </div>
                                </div>
                            </template>

                        </div>
                        <div class="general-divider"></div>
                        <div class="heading-block profile-page">
                            <h3 class="home-section-title profile-connect-title">News on Airbook</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="ne-block" v-for="(item,index) in news">
                            <router-link :to="{name:'newsDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="ne-image w-inline-block w--current" :style="item|imagePathForStyle"></router-link>
                            <div class="home-news-event-info">
                                <router-link :to="{name:'newsDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="home-news-events-headline">{{item.title}}</router-link>
                                <div class="news-events-date-location">
                                    <span class="clock-icon-span"></span>{{item.category_name+' in '+item.region_name}}</div>
                                <div class="news-events-info-wrapper-div">
                                    <div class="news-events-date-location">
                                        <span class="clock-icon-span"></span>
                                        {{item.date | moment("MMM DD, YYYY")}}
                                    </div>
                                    <div class="dot-spacer likes-next"></div>
                                    <div class="airbook-likes" @click="postLike(index, item.id, 'App\\News')">
                                        <a href="#"  :class="{'airbook-like-button':true, 'active': item.hasLike}" ></a>
                                        {{item.likes}}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="general-divider"></div>
                        <div id="share" class="asset-details-share-wrapper">
                            <div class="send-message-label">
                                <span class="message-icon"></span>
                                Share Profile
                            </div>
                            <share-this></share-this>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script src="../js/details/companyDetails.js"></script>



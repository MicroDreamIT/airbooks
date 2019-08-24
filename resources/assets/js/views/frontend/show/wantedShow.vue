<template>
    <div v-if="metas">
        <search-layout></search-layout>
        <div class="asset-details-section">
            <div class="container w-container">
                <div class="details-page-h1-block">
                    <h1 class="details-page-h1-title own-upper" v-if="wanted.title">{{wanted.title|filterDetailsPageTitle}}</h1>
                    <div class="details-page-date"><span class="asset-details-clock-icon"></span> Published {{wanted.created_at | moment("MMM DD, YYYY")}}- Updated {{wanted.updated_at | moment("MMM DD, YYYY")}}</div>
                </div>
                <div class="module-details-row w-row">
                    <div class="module-details-column right-borderline w-col w-col-7">
                        <div class="asset-details-main-widget-wrapper">
                            <div class="asset-details-main-widget-block first-widget">
                                <div class="main-widget-label">Wanted Asset</div>
                                <h2 class="main-widget-data-label own-upper">{{wanted.type}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">Term</div>
                                <h2 class="main-widget-data-label own-upper">{{wanted.terms}}</h2>
                            </div>
                        </div>
                        <div class="heading-block asset-details-page">
                            <h3 class="home-section-title">Wanted Asset Details</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="wanted.manufacturer">
                            <div class="asset-details-data-label">Manufacturer</div>
                            <div class="asset-details-data own-upper">{{wanted.manufacturer.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="wanted.typed">
                            <div class="asset-details-data-label">Type</div>
                            <div class="asset-details-data own-upper">{{wanted.typed.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="wanted.modeled">
                            <div class="asset-details-data-label">Model</div>
                            <div class="asset-details-data own-upper">{{wanted.modeled.name}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="wanted.terms">
                            <div class="asset-details-data-label">Wanted Terms</div>
                            <div class="asset-details-data own-upper">{{wanted.terms}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="wanted.wanted_by">
                            <div class="asset-details-data-label">Wanted by</div>
                            <div class="asset-details-data availability">{{wanted.wanted_by|moment("MMMM DD, YYYY")}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="wanted.country">
                            <div class="asset-details-data-label">Wanted Location</div>
                            <div class="asset-details-data">{{wanted.country.name}}</div>
                        </div>
                        <div class="general-divider" v-if="wanted.comments"></div>
                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">Description</div>
                            <div class="asset-details-data description own-upper">{{wanted.comments}}</div>
                        </div>
                        <div class="general-divider"></div>
                    </div>
                    <div class="module-details-column left-borderline w-col w-col-5">
                        <div class="asset-details-widget-block">
                            <div class="asset-details-widget">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">{{wanted.views}}</div>
                            </div>
                            <a href="#" class="asset-details-widget w-inline-block"
                               :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(wanted.likes,'user_id', $root.$data.user, 'id')}"
                               @click="postLike(wanted.id, 'App\\Wanted')">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">{{wanted.likes.length}}</div>
                            </a>
                            <a href="#" :class="{'asset-details-widget':true, 'w-inline-block':true, 'active': $root.checkObject_key_value(wanted.favourites,'user_id', $root.$data.user, 'id') || favouriteActive}"
                               @click="postFavourite(wanted.id, 'App\\Wanted')">
                                <div class="asset-details-widget-icon "></div>
                                <div class="asset-details-widget-data">
                                    Favorite
                                </div>
                            </a>
                            <a href="#Write" class="asset-details-widget w-inline-block"  @click.prevent="$root.callFocus()">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Email</div>
                            </a>
                            <a href="#Share" class="asset-details-widget w-inline-block">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Share</div>
                            </a>
                        </div>
                        <div class="general-divider"></div>
                        <template v-if="wanted.user">

                            <router-link :to="'#'" class="asset-details-page-side-block w-inline-block" v-if="!$root.$data.user">
                                <div class="user-default-image"></div>
                                <div class="asset-details-contact-info-block">
                                    <div class="lock-block" v-if="!$root.$data.user">
                                        <span class="lock"></span> Login to view contact
                                    </div>

                                </div>
                            </router-link>

                            <router-link :to="{name:'contactDetails',params:{id:wanted.user.contact.linkify}}"  class="asset-details-page-side-block w-inline-block" v-else>
                                <div class="user-default-image" :style="wanted.user.contact.medias|imagePathForStyle"></div>
                                <div class="asset-details-contact-info-block">
                                    <h4 class="asset-details-contact-name" v-if="wanted.user.contact">{{wanted.user.contact.first_name+' '+wanted.user.contact.last_name}}</h4>
                                    <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view contact</div>
                                    <div class="asset-details-contact-title" v-if="wanted.user.contact">
                                        <template v-if="wanted.user.contact.job_title">
                                            {{wanted.user.contact.job_title.name}}
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


                            <router-link :to="{name:'companyDetails',params:{id:wanted.user.contact.company.linkify}}"class="asset-details-page-side-block w-inline-block" v-else>
                                <div class="company-default-image" :style="wanted.user.contact.company.medias|imagePathForStyle"></div>
                                <div class="asset-details-contact-info-block">
                                    <h4 class="asset-details-contact-name" v-if="wanted.user.contact && $root.$data.user">{{wanted.user.contact.company.name}}</h4>
                                    <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view company</div>

                                    <template v-if="wanted.user.contact">
                                        <template v-for="(speciality, index) in wanted.user.contact.company.specialities">
                                            <div class="asset-details-contact-title">{{speciality.name }}</div>
                                            <div class="asset-details-contact-title"  v-if="index < wanted.user.contact.company.specialities.length-1 "> {{' | '}}</div>
                                        </template>
                                    </template>
                                </div>
                            </router-link>
                            <div class="asset-details-contact-block">
                                <sendmail :model="wanted"></sendmail>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="module-details-row w-row">
                    <div class="module-details-column right-borderline w-col w-col-7">
                        <div class="heading-block top-margin">
                            <h3 class="home-section-title">Analytics</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <h4 class="chart-title">Current wanted asset</h4>
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
                            <h4 class="chart-title" v-if="wanted.typed">
                                {{wanted.manufacturer? wanted.manufacturer.name :'' }}&nbsp;{{ wanted.typed? wanted.typed.name: ''}}&nbsp;{{wanted.modeled?wanted.modeled.name:''}}
                            </h4>
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
                    <div id="Share" class="module-details-column left-borderline w-col w-col-5">
                        <div class="general-divider"></div>
                        <div class="asset-details-share-wrapper">
                            <div class="send-message-label-2"><span class="message-icon"></span> Share this Asset</div>
                            <share-this></share-this>
                        </div>
                        <div class="general-divider"></div>
                        <div class="heading-block related-sidebar">
                            <h3 class="home-section-title">Related Wanted</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>

                        <div class="sidebar-promoted-asset-block promoted-apu" v-if="getWantedByManufacturerList">

                            <div class="asset-wrapper" v-for="item in wantedListData">
                                <router-link :to="item.linkify" class="asset-link-block w-inline-block" @click.native="getList()">
                                    <h2 class="asset-title-h2">{{item.title| filterTitle | titlify}}</h2>
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
                                    </div>
                                    <div class="asset-list-data-block" v-if="$root.$data.user">
                                        <div class="asset-list-data">{{item.user.contact.first_name}}</div>
                                        <div class="dot-spacer"></div>
                                        <div class="asset-list-data" v-if="item.user.contact.company">{{item.user.contact.company.name}}</div>
                                    </div>
                                    <div class="asset-list-data-block" v-else>
                                        <div class="asset-list-data">
                                            <span class="lock"></span> Login to view Contact
                                        </div>
                                    </div>
                                </router-link>
                                <div class="asset-likes-premium">
                                    <div class="airbook-likes">
                                        <a href="#"
                                           :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                           @click="postLike(item.id, 'App\\'+ $root.capitalize(item.modelType))"
                                        ></a>{{item.likes.length}}
                                    </div>
                                    <div data-delay="0" class="asset-menu w-dropdown">
                                        <div class="asset-dropdown-toggle w-dropdown-toggle" @click.prevent="$root.toggle">
                                            <div class="dot-block">
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                            </div>
                                        </div>
                                        <nav class="asset-dropdown-list w-dropdown-list">
                                            <a href="#" class="asset-menu-link w-dropdown-link"
                                               @click="$root.mailModalShow(item)">Send Message</a>
                                            <a href="#" class="asset-menu-link w-dropdown-link" @click.prevent="$root.postFavourite(item.modelType,item.id, 'App\\'+ $root.capitalize(item.modelType) )">Add to favorite</a>
                                        </nav>
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

<script src="../js/details/wantedShow.js"></script>

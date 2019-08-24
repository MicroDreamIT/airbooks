<template>
    <div v-if="metas">
        <search-layout></search-layout>
        <div class="asset-details-section">
            <div class="container w-container">
                <div class="details-page-h1-block">
                    <h1 class="details-page-h1-title" v-if="apu.title">{{apu.title|filterDetailsPageTitle}}</h1>
                    <div class="details-page-date">
                        <span class="asset-details-clock-icon"></span>
                        Published {{apu.created_at | moment("MMM DD, YYYY")}}- Updated {{apu.updated_at | moment("MMM DD, YYYY")}}
                    </div>
                </div>
                <div class="asset-page-flex tablet-mode">
                    <div class="asset-page-left-block left-tablet-mode">
                        <div class="asset-details-main-widget-wrapper">
                            <div class="asset-details-main-widget-block first-widget">
                                <div class="main-widget-label">PN</div>
                                <h2 class="main-widget-data-label">{{apu.part_number}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">FOR</div>
                                <h2 class="main-widget-data-label own-upper">{{apu.offer_for}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">Condition</div>
                                <h2 class="main-widget-data-label own-uppercase">{{apu.status}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">Available</div>
                                <h2 class="main-widget-data-label">{{apu.availability|moment("MMM, YYYY")}}</h2>
                            </div>
                        </div>
                        <div class="asset-image-gallery-wrapper" >
                            <template v-if="apu.medias">
                                <div class="demo-gallery-image" :style="galleryImagePath"></div>
                            </template>
                            <div class="demo-gallery-image" v-else></div>


                            <div class="asset-sub-images">
                                <div v-for="(item,index) in apu.medias" class="demo-sub-image" :ref="'subImage'+index" :style="item|imagePathForStyle" @click="changeGalleryImage(item,index)"></div>
                            </div>
                        </div>
                    </div>
                    <div class="asset-page-right-block right-tablet-mode">
                        <div class="asset-details-widget-block">
                            <div class="asset-details-widget">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">{{apu.views}}</div>
                            </div>
                            <a href="#"
                               :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(apu.likes,'user_id', $root.$data.user, 'id')}"
                               @click="postLike(apu.id, 'App\\Apu')">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">
                                    {{apu.likes.length>0 ? apu.likes.length : 0}}
                                </div>
                            </a>
                            <a href="#" :class="{'asset-details-widget':true, 'w-inline-block':true, 'active': $root.checkObject_key_value(apu.favourites,'user_id', $root.$data.user, 'id') || favouriteActive}"
                               @click="postFavourite(apu.id, 'App\\Apu')">
                                <div class="asset-details-widget-icon "></div>
                                <div class="asset-details-widget-data">
                                    Favorite
                                </div>
                            </a>
                            <a href="#Write" class="asset-details-widget w-inline-block"  @click.prevent="$root.callFocus()">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Email</div>
                            </a>
                            <a href="#Asset-Share" class="asset-details-widget w-inline-block">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Share</div>
                            </a>
                        </div>
                        <div class="general-divider"></div>
                    <template v-if="apu.user">

                        <router-link :to="'#'" class="asset-details-page-side-block w-inline-block" v-if="!$root.$data.user">
                            <div class="user-default-image"></div>
                            <div class="asset-details-contact-info-block">
                                <div class="lock-block" v-if="!$root.$data.user">
                                    <span class="lock"></span> Login to view contact
                                </div>

                            </div>
                        </router-link>

                        <router-link :to="{name:'contactDetails',params:{id:apu.user.contact.linkify}}"  class="asset-details-page-side-block w-inline-block" v-else>
                            <div class="user-default-image" :style="apu.user.contact.medias|imagePathForStyle"></div>
                            <div class="asset-details-contact-info-block">
                                <h4 class="asset-details-contact-name" v-if="apu.user.contact">{{apu.user.contact.first_name+' '+apu.user.contact.last_name}}</h4>
                                <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view contact</div>
                                <div class="asset-details-contact-title" v-if="apu.user && $root.$data.user">
                                    <template v-if="_.has(apu,'user.contact.job_title.name')">
                                        {{apu.user.contact.job_title.name}}
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


                        <router-link :to="{name:'companyDetails',params:{id:apu.user.contact.company.linkify}}"class="asset-details-page-side-block w-inline-block" v-else>
                            <div class="company-default-image" :style="apu.user.contact.company.medias|imagePathForStyle"></div>
                            <div class="asset-details-contact-info-block">
                                <h4 class="asset-details-contact-name" v-if="apu.user.contact && $root.$data.user">{{apu.user.contact.company.name}}</h4>
                                <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view company</div>

                                <template v-if="apu.user.contact">
                                    <template v-for="(speciality, index) in apu.user.contact.company.specialities">
                                        <div class="asset-details-contact-title">{{speciality.name }}</div>
                                        <div class="asset-details-contact-title"  v-if="index < apu.user.contact.company.specialities.length-1 "> {{' | '}}</div>
                                    </template>
                                </template>
                            </div>
                        </router-link>
                        <div class="asset-details-contact-block">
                            <sendmail :model="apu"></sendmail>
                        </div>
                    </template>
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
                        <div class="asset-details-data-block" v-if="apu.category">
                            <div class="asset-details-data-label">APU Category</div>
                            <div class="asset-details-data">{{apu.category.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.manufacturer">
                            <div class="asset-details-data-label">Manufacturer</div>
                            <div class="asset-details-data">{{apu.manufacturer.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.type">
                            <div class="asset-details-data-label">Type</div>
                            <div class="asset-details-data">{{apu.type.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.model">
                            <div class="asset-details-data-label">Model</div>
                            <div class="asset-details-data">{{apu.model.name}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="apu.serial_number">
                            <div class="asset-details-data-label">SN</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{apu.serial_number}}</div>
                            <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.part_number">
                            <div class="asset-details-data-label">Part Number</div>
                            <div class="asset-details-data">{{apu.part_number}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.cycle_remaining">
                            <div class="asset-details-data-label">Cycle Remaining (CR)</div>
                            <div class="asset-details-data">{{apu.cycle_remaining}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.status">
                            <div class="asset-details-data-label">Condition</div>
                            <div class="asset-details-data">{{apu.status}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.thrust_rating">
                            <div class="asset-details-data-label">Thrust Rating</div>
                            <div class="asset-details-data">{{apu.thrust_rating}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.lsv_description">
                            <div class="asset-details-data-label">LSV Description</div>
                            <div class="asset-details-data">{{apu.lsv_description}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="apu.offer_for">
                            <div class="asset-details-data-label">Offered for</div>
                            <div class="asset-details-data">{{apu.offer_for}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.offer_for=='Sale' && apu.price>0">
                            <div class="asset-details-data-label">Price (US$)</div>
                            <div class="asset-details-data">{{parseFloat(apu.price).toFixed(2)}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.offer_for=='Lease' || apu.offer_for=='Lease Purchase'">
                            <div class="asset-details-data-label own-uppercase">{{apu.offer_for}} Terms</div>
                            <div class="asset-details-data">{{apu.lease_terms}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.offer_for=='Exchange'">
                            <div class="asset-details-data-label">Exchange Terms</div>
                            <div class="asset-details-data">{{apu.exchange_terms}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.availability">
                            <div class="asset-details-data-label">Availability</div>
                            <div class="asset-details-data availability">{{apu.availability|moment("MMMM DD, YYYY")}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.current_location">
                            <div class="asset-details-data-label">Current Location</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{apu.current_location.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>

                        <div class="asset-details-data-block" v-if="apu.owner">
                            <div class="asset-details-data-label">Owner</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{apu.owner.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="apu.seller">
                            <div class="asset-details-data-label">Seller</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{apu.seller.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="apu.description">
                            <div class="asset-details-data-label">Description</div>
                            <div class="asset-details-data description">{{apu.description}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="apu.attaches">
                            <div class="asset-details-data-label">
                                File Attachments
                            </div>
                            <template v-if="!apu.attaches.length && $root.$data.user">
                                {{'No attachment'}}
                            </template>

                            <template v-else>
                                <a :href="'/storage/'+attach.path" target="_blank" class="file-link" v-for="attach in apu.attaches" v-if="$root.$data.user">
                                    <span class="attach-span"></span>
                                    <template>
                                        {{attach.original_file_name}}
                                    </template>
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
                            <h4 class="chart-title">This APU</h4>
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
                            <h4 class="chart-title">
                                {{apu.manufacturer? apu.manufacturer.name :'' }}&nbsp;{{ apu.type? apu.type.name: ''}}&nbsp;{{apu.model?apu.model.name:''}}
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
                    <div id="Asset-Share" class="asset-page-right-block">
                        <div class="general-divider details-sidebar"></div>
                        <div class="asset-details-share-wrapper demo-xyz">
                            <div class="send-message-label-2"><span class="message-icon"></span> Share this asset</div>
                            <share-this></share-this>
                        </div>
                        <div class="general-divider"></div>
                        <div class="heading-block related-sidebar">
                            <h3 class="home-section-title">Promoted APU's</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="sidebar-promoted-asset-block">
                            <div class="sidebar-promoted-asset" v-for="item in getFeaturedApu">
                                <div class="asset-main-wrapper">
                                    <router-link :to="item.linkify" class="asset-link w-inline-block" @click.native="getList()">
                                        <div class="asset-image" :style="$root.getGalleryMainImagePath(item.medias)"></div>
                                        <div class="asset-name-block">
                                            <h2 class="asset-title-h2">{{ item.title | filterTitle | titlify }}</h2>
                                        </div>
                                        <div class="asset-list-main-data-block">
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
                                                <div class="asset-list-data own-uppercase">{{item.status}}</div>
                                                <div class="dot-spacer"></div>
                                                <div class="asset-list-data">CR {{item.cycle_remaining}}</div>
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

<script src="../js/details/apuShow.js"></script>

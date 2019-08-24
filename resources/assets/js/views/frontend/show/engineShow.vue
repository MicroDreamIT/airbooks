<template>
    <div v-if="metas">
        <search-layout></search-layout>
        <div class="asset-details-section">
            <div class="container w-container">
                <div class="details-page-h1-block">
                    <h1 class="details-page-h1-title own-upper" v-if="engine.title">{{engine.title|filterDetailsPageTitle}}</h1>
                    <div class="details-page-date">
                        <span class="asset-details-clock-icon"></span>
                        Published {{engine.created_at | moment("MMM DD, YYYY")}}- Updated {{engine.updated_at | moment("MMM DD, YYYY")}}
                    </div>
                </div>
                <div class="asset-page-flex tablet-mode">
                    <div class="asset-page-left-block left-tablet-mode">
                        <div class="asset-details-main-widget-wrapper">
                            <div class="asset-details-main-widget-block first-widget">
                                <div class="main-widget-label">ESN</div>
                                <h2 class="main-widget-data-label" v-if="$root.$data.user">{{engine.esn}}</h2>
                                <div class="lock-block" v-if="!$root.$data.user">
                                    <span class="lock"></span> Login
                                </div>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">FOR</div>
                                <h2 class="main-widget-data-label">{{engine.offer_for}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">Status</div>
                                <h2 class="main-widget-data-label own-uppercase">{{engine.status}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block">
                                <div class="main-widget-label">Available</div>
                                <h2 class="main-widget-data-label">{{engine.availability|moment("MMM, YYYY")}}</h2>
                            </div>
                        </div>
                        <div class="asset-image-gallery-wrapper" >
                            <template v-if="engine.medias">
                                <div class="demo-gallery-image" :style="galleryImagePath"></div>
                            </template>
                            <div class="demo-gallery-image" v-else></div>


                            <div class="asset-sub-images">
                                <div v-for="(item,index) in engine.medias" class="demo-sub-image"
                                     :ref="'subImage'+index" :style="item|imagePathForStyle" @click="changeGalleryImage(item,index)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="asset-page-right-block right-tablet-mode">
                        <div class="asset-details-widget-block">
                            <div class="asset-details-widget">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">{{engine.views}}</div>
                            </div>
                            <a href="#" :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(engine.likes,'user_id', $root.$data.user, 'id')}"
                               @click="postLike(engine.id, 'App\\Engine')">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">
                                    {{engine.likes.length>0 ? engine.likes.length: 0}}
                                </div>
                            </a>
                            <a href="#" :class="{'asset-details-widget':true, 'w-inline-block':true, 'active': $root.checkObject_key_value(engine.favourites,'user_id', $root.$data.user, 'id') || favouriteActive}"
                               @click="postFavourite(engine.id, 'App\\Engine')">
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

                     <template v-if="engine.user">
                         <router-link :to="'#'" class="asset-details-page-side-block w-inline-block" v-if="!$root.$data.user">
                             <div class="user-default-image"></div>
                             <div class="asset-details-contact-info-block">
                                 <div class="lock-block" v-if="!$root.$data.user">
                                     <span class="lock"></span> Login to view contact
                                 </div>

                             </div>
                         </router-link>
                        <template v-if="_.has(engine,'user.contact.linkify')">
                            <router-link :to="{name:'contactDetails',params:{id:engine.user.contact.linkify}}"
                                         class="asset-details-page-side-block w-inline-block" v-if="$root.$data.user">
                                <div class="user-default-image" :style="engine.user.contact.medias|imagePathForStyle"></div>
                                <div class="asset-details-contact-info-block">
                                    <h4 class="asset-details-contact-name" v-if="_.has(engine,'user.contact.fullName')">
                                        <template v-if="_.has(engine,'user.contact.fullName')">
                                            {{engine.user.contact.fullName}}
                                        </template>

                                    </h4>
                                    <div class="lock-block" v-if="!$root.$data.user">
                                        <span class="lock"></span> Login to view contact
                                    </div>
                                    <div class="asset-details-contact-title" v-if="engine.user && $root.$data.user">
                                        <template v-if="_.has(engine,'user.contact.job_title.name')">
                                            {{engine.user.contact.job_title.name}}
                                        </template>
                                    </div>
                                </div>
                            </router-link>
                        </template>


                         <router-link :to="'#'"  class="asset-details-page-side-block w-inline-block" v-if="!$root.$data.user">
                             <div class="company-default-image"></div>
                             <div class="asset-details-contact-info-block">

                                 <div class="lock-block" v-if="!$root.$data.user">
                                     <span class="lock"></span> Login to view company
                                 </div>
                             </div>
                         </router-link>



                         <router-link :to="{name:'companyDetails',params:{id:engine.user.contact.company.linkify}}" class="asset-details-page-side-block w-inline-block" v-else>
                            <div class="company-default-image" :style="engine.user.contact.company.medias|imagePathForStyle"></div>
                            <div class="asset-details-contact-info-block">
                                <h4 class="asset-details-contact-name" v-if="engine.user.contact">
                                    {{engine.user.contact.company.name}}</h4>
                                <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view company</div>

                                <template v-if="engine.user.contact">
                                    <template v-for="(speciality, index) in engine.user.contact.company.specialities">
                                        <div class="asset-details-contact-title">{{speciality.name }}</div>
                                        <div class="asset-details-contact-title"  v-if="index < engine.user.contact.company.specialities.length-1 "> {{' | '}}</div>
                                    </template>
                                </template>
                            </div>
                        </router-link>
                        <div class="asset-details-contact-block">
                            <sendmail :model="engine"></sendmail>
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
                        <div class="asset-details-data-block" v-if="engine.category">
                            <div class="asset-details-data-label">Engine Category</div>
                            <div class="asset-details-data">{{engine.category.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.manufacturer">
                            <div class="asset-details-data-label">Manufacturer</div>
                            <div class="asset-details-data">{{engine.manufacturer.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.type">
                            <div class="asset-details-data-label">Type</div>
                            <div class="asset-details-data">{{engine.type.name}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.model">
                            <div class="asset-details-data-label">Model</div>
                            <div class="asset-details-data">{{engine.model.name}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">ESN</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{engine.esn}}</div>
                            <div class="lock-block" v-if="!$root.$data.user"><span class="lock"></span> Login to view</div>
                        </div>
                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">Cycle Remaining (CR)</div>
                            <div class="asset-details-data">{{engine.cycle_remaining}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.status">
                            <div class="asset-details-data-label">Current Status</div>
                            <div class="asset-details-data">{{engine.status}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.tso">
                            <div class="asset-details-data-label">TSO</div>
                            <div class="asset-details-data">{{engine.tso}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.thrust_rating">
                            <div class="asset-details-data-label">Thrust Rating</div>
                            <div class="asset-details-data">{{engine.thrust_rating}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.lsv_description">
                            <div class="asset-details-data-label">LSV Description</div>
                            <div class="asset-details-data">{{engine.lsv_description}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="engine.offer_for">
                            <div class="asset-details-data-label">Offered for</div>
                            <div class="asset-details-data">{{engine.offer_for}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.offer_for=='Sale' && engine.price>0">
                            <div class="asset-details-data-label">Price (US$)</div>
                            <div class="asset-details-data">{{parseFloat(engine.price).toFixed(2)}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.offer_for=='Lease' || engine.offer_for=='Lease Purchase'">
                            <div class="asset-details-data-label own-uppercase">{{engine.offer_for}} Terms</div>
                            <div class="asset-details-data">{{engine.lease_terms}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.offer_for=='Exchange'">
                            <div class="asset-details-data-label">Exchange Terms</div>
                            <div class="asset-details-data">{{engine.exchange_terms}}</div>
                        </div>

                        <div class="asset-details-data-block" v-if="engine.terms">
                            <div class="asset-details-data-label">Terms</div>
                            <div class="asset-details-data">{{engine.terms}}</div>
                        </div>

                        <div class="asset-details-data-block" v-if="engine.availability">
                            <div class="asset-details-data-label">Availability</div>
                            <div class="asset-details-data availability">{{engine.availability|moment("MMMM DD, YYYY")}}</div>
                        </div>

                        <div class="asset-details-data-block" v-if="engine.current_location">
                            <div class="asset-details-data-label">Current Location</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{engine.current_location.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>

                        <div class="asset-details-data-block" v-if="engine.owner">
                            <div class="asset-details-data-label">Owner</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{engine.owner.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="engine.seller">
                            <div class="asset-details-data-label">Seller</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{engine.seller.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>

                        <template v-if="engine.description">
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block">
                            <div class="asset-details-data-label">Description</div>
                            <div class="asset-details-data description">{{engine.description}}</div>
                        </div>
                        </template>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="engine.attaches">
                            <div class="asset-details-data-label">
                                File Attachments
                            </div>
                            <template v-if="!engine.attaches.length && $root.$data.user">
                                {{'No attachment'}}
                            </template>
                            <template v-else>
                                <a :href="'/storage/'+attach.path" target="_blank" class="file-link" v-for="attach in engine.attaches" v-if="$root.$data.user">
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
                            <h4 class="chart-title">This Engine</h4>
                            <combo-chart
                                    :label="['likes', 'view']"
                                    :data1="chartData1['id']['likes']"
                                    :data2="chartData1['id']['views']"
                                    :id="'chart1'"
                                    :labels="chartData1['id']['label']"
                                    v-if="chartLoad"></combo-chart>
                        </div>
                        <div class="general-divider"></div>
                        <div class="chart-wrapper">
                            <h4 class="chart-title" v-if="engine.type">
                                {{engine.manufacturer? engine.manufacturer.name :'' }}&nbsp;{{ engine.type? engine.type.name: ''}}&nbsp;{{engine.model?engine.model.name:''}}
                            </h4>
                            <combo-chart
                                    :label="['likes', 'view']"
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
                            <h3 class="home-section-title">Promoted Engines</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="sidebar-promoted-asset-block">
                            <div class="sidebar-promoted-asset">
                                <div class="asset-main-wrapper" v-for="item in getFeaturedEngine">
                                    <router-link :to="item.linkify" class="asset-link w-inline-block" @click.native="getList()">
                                        <div class="asset-image" :style="$root.getGalleryMainImagePath(item.medias)"></div>
                                        <div class="asset-name-block">
                                            <h2 class="asset-title-h2">{{ item.title | filterTitle | titlify }}</h2>
                                        </div>
                                        <div class="asset-list-main-data-block">
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
                                                <div class="asset-list-data">{{item.status}}</div>
                                                <div class="dot-spacer"></div>
                                                <div class="asset-list-data">CR {{item.cycle_remaining}}</div>
                                            </div>
                                            <div class="asset-list-data-block" v-if="$root.$data.user">
                                                <div class="asset-list-data" v-if="_.has(item,'user.contact.first_name')">
                                                    {{item.user.contact.first_name}}
                                                </div>
                                                <div class="dot-spacer"></div>
                                                <div class="asset-list-data" v-if="_.has(item,'user.contact.company.name')">
                                                    {{item.user.contact.company.name}}</div>
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

<script src="../js/details/engineShow.js"></script>

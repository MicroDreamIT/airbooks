<template>
    <div v-if="metas">
        <!--aircraft keyword content-->
	       <search-layout></search-layout>
        <!--aircraft body content-->
        <div class="asset-page-section">
            <div class="container w-container">
                <div class="asset-page-wrapper">
                    <sidebar-search-layout  ref="sideBarRef" @searchDataList="searchEmitData"></sidebar-search-layout>
                    <div class="list-wrapper">
                        <div class="preloader-block"></div>
                        <div class="list-page-h1-block">
                            <h1 class="list-page-h1">
                                <span class="h1-span-1">Aircraft</span>
                                availability listing for charter, ACMI, lease and sale.
                            </h1>
                        </div>
                        <div class="premium-asset-list">
                            <div class="home-promoted-asset-row w-row" v-for="chunk in chunkFeatured">
                                <div class="home-promoted-asset-column w-col w-col-4 w-col-small-4" v-for="featuredItem in chunk">
                                    <div class="asset-main-wrapper">
                                        <router-link :to=" featuredItem.modelType + '/' + featuredItem.id+'-'+featuredItem.title " class="asset-link-wrapper w-inline-block">
                                            <div class="asset-image" :style="$root.getGalleryMainImagePath(featuredItem.medias)"></div>
                                            <div class="asset-name-block">
                                                <h2 class="asset-title-h2">{{ featuredItem.title | filterTitle | titlify }}</h2>
                                            </div>
                                            <div class="asset-list-main-data-block">
                                                <div class="asset-list-data-block">
                                                    <div class="asset-list-data yom" v-if="featuredItem.modelType=='aircraft'">
                                                        {{featuredItem.YOM | moment("YYYY") }}
                                                    </div>
                                                    <div class="dot-spacer"></div>
                                                    <div class="asset-list-data sn">MSN</div>
                                                    <div class="lock-block" v-if="!$root.$data.user">

                                                        <span class="lock"></span> Login

                                                    </div>
                                                    <div class="asset-list-data sn" v-else>
                                                        {{ featuredItem.MSN }}
                                                    </div>
                                                </div>
                                                <div class="asset-list-data-block" v-if="$root.$data.user">
                                                    <div class="asset-list-data" v-if="featuredItem.tsn">{{'TSN '}}{{featuredItem.tsn}}</div>
                                                    <div class="dot-spacer" v-if="featuredItem.tsn && featuredItem.csn"></div>
                                                    <div class="asset-list-data" v-if="featuredItem.csn">{{'CSN '}}{{featuredItem.csn}}</div>
                                                </div>

                                                <div class="asset-list-data-block">
                                                    <template v-if="$root.$data.user && featuredItem.user">
                                                        <div class="asset-list-data own-uppercase">
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
                                                    </template>
                                                    <template v-else>
                                                        <div class="lock-block">
                                                            <span class="lock"></span> Login to view contact
                                                        </div>
                                                    </template>
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
                                                       @click="$root.postLike(featuredItem.modelType, featuredItem.id, 'App\\'+ $root.capitalize(featuredItem.modelType))"
                                                    ></a>{{featuredItem.likes.length}}
                                                </div>
                                                <div data-delay="0" class="asset-menu w-dropdown">
                                                    <div class="asset-dropdown-toggle w-dropdown-toggle"  @click.prevent="$root.toggle" >
                                                        <div class="dot-block">
                                                            <div class="dot"></div>
                                                            <div class="dot"></div>
                                                            <div class="dot"></div>
                                                        </div>
                                                    </div>
                                                    <nav class="asset-dropdown-list w-dropdown-list">
                                                        <a href="#" class="asset-menu-link w-dropdown-link"
                                                           @click="$root.mailModalShow(featuredItem)">Send Message</a>
                                                        <a href="#" class="asset-menu-link w-dropdown-link" @click.prevent="$root.postFavourite(featuredItem.modelType,featuredItem.id, 'App\\'+ $root.capitalize(featuredItem.modelType) )">Add to favorite</a>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div >
                            </div>
                        </div>
                        <div class="asset-list">
                            <div class="asset-wrapper" v-for="(item, index) in aircrafts">
                                <router-link :to="{name:'frontAircraftShow',params:{id:item.id+'-'+item.title}}"
                                             class="asset-link-block w-inline-block">
                                    <h2 class="asset-title-h2">
                                        {{item.title|filterTitle}}
                                    </h2>

                                    <div class="asset-list-data-block" v-if="!$root.$data.user">
                                        <div class="asset-list-data sn">MSN</div>
                                        <div class="lock-block">
                                            <span class="lock"></span> Login
                                        </div>
                                    </div>
                                    <div class="asset-list-data-block" v-if="$root.$data.user">
                                        <div class="asset-list-data sn">
                                            MSN {{item.MSN}}
                                        </div>
                                    </div>

                                    <div class="asset-list-data-block">
                                        <div class="asset-list-data yom">{{item.YOM | moment("YYYY") }}</div>
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
                                            <span class="lock"></span>
                                            Login to view contact
                                        </div>
                                        <template v-if="$root.$data.user && item.user">

                                            <div class="asset-list-data" v-if="_.has(item,'user.contact.first_name')">
                                                {{item.user.contact.first_name}}
                                            </div>
                                            <template v-if="_.has(item,'user.contact.company.name')">
                                                <div class="dot-spacer"></div>
                                                <div class="asset-list-data">{{item.user.contact.company.name|namify}}</div>
                                            </template>

                                        </template>
                                    </div>
                                </router-link>
                                <div class="airbook-likes">
                                    <a href="#" :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                                               @click="postLike(index, item.id, 'App\\Aircraft')"></a>{{item.likes.length}}
                                </div>
                            </div>

                        </div>

                        <own-pagination ref="pagination" :pagination-data="paginationData"></own-pagination>

                    </div>
                </div>
            </div>
        </div>
        <modal name="sendMail" height="auto">
            <sendmail :model="$root.$data.mailModalData" :fromModal="true"></sendmail>
        </modal>
        <div class="device-filter-button" data-ix="show-filter" @click="$root.callFilter()"></div>
    </div>
</template>

<script src="./js/aircraft.js"></script>

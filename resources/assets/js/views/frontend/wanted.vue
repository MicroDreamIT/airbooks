<template>
    <div v-if="metas">
     <search-layout></search-layout>

        <div class="asset-page-section">
            <div class="container w-container">
                <div class="asset-page-wrapper">

                    <sidebar-search-layout ref="sideBarRef" @searchDataList="searchEmitData"></sidebar-search-layout>

                    <div class="list-wrapper">
                        <div class="preloader-block"></div>
                        <div class="list-page-h1-block">
                            <h1 class="list-page-h1"><span class="h1-span-1">WANTED</span> assets in the commercial aviation industry</h1>
                        </div>
                        <div class="asset-list">
                            <div class="asset-wrapper" v-for="(item, index) in wanteds">
                                <router-link :to="{name:'frontWantedShow',params:{id:item.linkify}}" class="asset-link-block w-inline-block">
                                    <h2 class="asset-title-h2">
                                        {{item.title|filterTitle}}
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
                                <div class="asset-likes-premium">
                                    <div class="airbook-likes" >
                                        <a href="#"
                                           :class="{'airbook-like-button':true, 'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}"
                                           @click="postLike(index, item.id, 'App\\Wanted')" ></a>{{item.likes.length}}
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
                                            <a href="#" class="asset-menu-link w-dropdown-link" @click="$root.mailModalShow(item)">Send Message</a>
	                                        <a href="#" class="asset-menu-link w-dropdown-link" @click.prevent="$root.postFavourite('wanted',item.id, 'App\\Wanted')">Add to favorite</a>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <own-pagination ref="pagination" :pagination-data="paginationData"></own-pagination>
                    </div>
                </div>
            </div>
        </div>
        <modal name="sendMail" height="auto" >
            <sendmail :model="$root.$data.mailModalData" :fromModal="true"></sendmail>
        </modal>
        <div class="device-filter-button" data-ix="show-filter" @click="$root.callFilter()"></div>
    </div>
</template>

<script src="./js/wanted.js"></script>



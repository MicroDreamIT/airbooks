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
                            <h1 class="list-page-h1"><span class="h1-span-1">Global Aviation News</span></h1>
                        </div>
                        <div class="asset-list news-events-list">
                            <div class="news-events-wrapper" v-for="(item, index) in news">
                                <router-link :to="{name:'newsDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="ne-list-image w-inline-block" :style="item|imagePathForStyle"></router-link>
                                <div class="ne-data-block">
                                    <router-link :to="{name:'newsDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}" class="ne-heading-block w-inline-block">
                                        <h2 class="news-events-heading">{{item.title}}</h2>
                                    </router-link>
                                    <div class="news-events-date-location"><span class="clock-icon-span"></span>{{item.category_name+' in '+item.region_name}}</div>
                                    <div class="news-events-info-wrapper-div">
                                        <div class="news-events-date-location"><span class="clock-icon-span"></span>{{item.date | moment("MMM DD, YYYY")}}</div>
                                        <div class="dot-spacer likes-next"></div>
                                        <div class="airbook-likes" @click="postLike(index, item.id, 'App\\News')">
                                            <a href="#" :class="{'airbook-like-button':true, 'active': item.hasLike}" ></a>
                                            {{item.likes}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <own-pagination ref="pagination" :pagination-data="paginationData"></own-pagination>
                    </div>
                </div>
            </div>
        </div>
        <div class="device-filter-button" data-ix="show-filter" @click="$root.callFilter()"></div>
    </div>
</template>
<script src="./js/news.js"></script>

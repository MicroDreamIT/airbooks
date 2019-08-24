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
                            <h1 class="list-page-h1"><span class="h1-span-1">Global Aviation Events</span></h1>
                        </div>
                        <div class="asset-list news-events-list">
                            <div class="news-events-wrapper" v-for="(item, index) in events">
                                <router-link :to="{name:'eventDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}"
                                             class="ne-list-image w-inline-block" :style="item|imagePathForStyle"
                                ></router-link>
                                <div class="ne-data-block">
                                    <router-link :to="{name:'eventDetails',params:{id:item.id +'-'+ $root.linkify(item.title)}}"
                                                 class="ne-heading-block events-link-block w-inline-block">
                                        <h2 class="news-events-heading"> {{item.title}}</h2>
                                        <div class="news-events-info-wrapper-div">
                                            <div class="news-events-date-location">
                                                <span class="clock-icon-span"></span>
                                                {{item.start_date | moment("MMM DD, YYYY")}}
                                            </div>
                                            <div class="dot-spacer events-dot"></div>
                                            <div class="news-events-date-location">
                                                <span class="clock-icon-span"></span>
                                                {{item.end_date | moment("MMM DD, YYYY")}}
                                            </div>
                                        </div>

                                        <div class="news-events-date-location" v-if="item.name">
                                            <span class="clock-icon-span"></span>{{item.name}}
                                        </div>

                                    </router-link>
                                    <div class="news-events-info-wrapper-div">
                                        <div class="airbook-likes" @click="postLike(index, item.id, 'App\\Event')">
                                            <a href="#"  :class="{'airbook-like-button':true, 'active': item.hasLike}"></a>
                                            {{item.likes}}
                                        </div>
                                        <div class="dot-spacer likes-next"></div>
                                        <div class="event-interest" @click="postEventInterested(index, item.id, 'App\\Event')">
                                            <a href="#" :class="{'like-icon-span':true, 'active': item.hasInterested}"></a>
                                            Interested
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

<script src="./js/event.js"></script>


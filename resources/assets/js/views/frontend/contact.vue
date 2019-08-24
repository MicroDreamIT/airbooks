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
                            <h1 class="list-page-h1">
                                <span class="h1-span-1">CONTACTS</span>
                                search and connect to the aviation industry people
                            </h1>
                        </div>
                        <div class="asset-list">
                            <div class="cc-list-block" v-for="(item, index) in contacts">
                                <div class="cc-image-block">
                                    <!--<a href="contact-profile.html" class="contact-image w-inline-block"></a>-->

                                    <router-link :to="{name:'contactDetails',
                                    params:{id:item.id+'-'+ $root.linkify(item.first_name+' '+item.last_name)}}"
                                                 class="contact-image w-inline-block"
                                                 :style="item.medias | imagePathForStyle" v-if="$root.$data.user">

                                    </router-link>

                                    <router-link :to="{name:'contactDetails',
                                    params:{id:item.id+'-'+ $root.linkify(item.first_name+' '+item.last_name)}}"
                                                 class="contact-image w-inline-block"  v-else>

                                    </router-link>

                                </div>
                                <div class="connect-data-flex">
                                    <div class="connect-data-block">
                                        <router-link :to="{name:'contactDetails',
                                        params:{id:item.id+'-'+ $root.linkify(item.first_name+' '+item.last_name)}}"
                                                     class="link-block w-inline-block">
                                            <h2 class="asset-title-h2">{{item.first_name+' '+item.last_name}}</h2>
                                            <div class="connect-data" v-if="item.job_title">{{item.job_title.name}}</div>
                                        </router-link>

                                        <div class="asset-list-data-block" v-if="item.company">
                                            <router-link :to="{name:'companyDetails',
                                            params:{id:item.company.id+'-'+ $root.linkify(item.company.name)}}"
                                                         class="company-link" v-if="$root.$data.user">{{item.company.name}}
                                            </router-link>
                                            <div class="lock-block" v-else>
                                                <span class="lock"></span> Login to view company
                                            </div>
                                            <!--<a href="company-profile.html" class="company-link">{{item.company.name}}</a>-->
                                        </div>
                                    </div>
                                    <div @click="postLike(index, item.id, 'App\\Contact')">
                                        <a href="#" :class="{'connect-button w-button':true,
                                        'active': $root.checkObject_key_value(item.likes,'user_id', $root.$data.user, 'id')}">
                                            Connect
                                        </a>
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

<script src="./js/contact.js"></script>


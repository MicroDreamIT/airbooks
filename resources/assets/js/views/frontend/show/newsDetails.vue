<template>
	<div v-if="metas">

		<search-layout></search-layout>

		<div class="asset-details-section">
			<div class="container w-container">
				<div class="details-page-h1-block">
					<h1 class="details-page-h1-title own-upper" >{{news.title}}</h1>
					<div class="details-page-date"><span class="asset-details-clock-icon"></span> Published {{news.date | moment("MMM DD, YYYY")}}</div>
				</div>
				<div class="module-details-row w-row">
					<div class="module-details-column right-borderline w-col w-col-7">
						<div class="asset-details-widget-block">
							<div class="asset-details-widget nohover">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">{{news.views}}</div>
							</div>
							<a href="#" class="asset-details-widget w-inline-block"
							   :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(news.likes,'user_id', $root.$data.user, 'id')||likesActive}"
							   @click="postLike(news.id, 'App\\News')">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">
									{{news.likes.length}}
								</div>
							</a>
							<a href="#share" class="asset-details-widget w-inline-block">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">Share</div>
							</a>
						</div>
						<template v-if="news.medias">
							<div class="news-event-image news-details" :style="news.medias | imagePathForStyle"></div>
						</template>

					</div>
					<div class="module-details-column left-borderline w-col w-col-5">
						<div class="region-block">
							<div class="globe"></div>
							<div class="asset-details-contact-info-block">
								<template v-for="(category, index) in news.categories" v-if="news.categories">
								<h4 class="asset-details-contact-name">{{category.name}}</h4>
								<h4 class="asset-details-contact-name" v-if="index < news.categories.length-1 ">| </h4>
								</template>
								<div class="asset-details-contact-title" v-if="news.region">{{news.region.name}}</div>
							</div>

						</div>
						<div id="ShareProfile" class="heading-block news-events-page" v-if="news.company">
							<h3 class="home-section-title profile-connect-title">Story Regarding</h3>
							<div class="line-block">
								<div class="blueline"></div>
								<div class="redline"></div>
							</div>
						</div>
                        <template v-if="news.company">
                            <router-link :to="{name:'companyDetails',params:{id:news.company.id}}" class="asset-details-page-side-block w-inline-block">
                                <div class="company-default-image" :style="news.company.medias|imagePathForStyle"></div>
                                <div class="asset-details-contact-info-block">
                                    <h4 class="asset-details-contact-name" v-if="news.company">{{news.company.name}}</h4>
                                    <template v-if="news.company">
                                        <template v-for="(speciality, index) in news.company.specialities">
                                            <div class="asset-details-contact-title">{{speciality.name }}</div>
                                            <div class="asset-details-contact-title"  v-if="index < news.company.specialities.length-1 "> {{' | '}}</div>
                                        </template>
                                    </template>
                                </div>
                            </router-link>
                        </template>

						<div id="share" class="asset-details-share-wrapper">
							<div class="general-divider"></div>
							<div class="send-message-label"><span class="message-icon"></span> Share this News</div>
							<share-this></share-this>
						</div>
						<div class="general-divider"></div>
					</div>
				</div>
				<div class="module-details-row w-row">
					<div class="module-details-column right-borderline w-col w-col-7">
						<div class="news-event-details w-richtext cus-details-margin" v-html="news.details">
						</div>
					</div>

					<div class="module-details-column left-borderline w-col w-col-5" >
                        <template v-if="news.source">
                            <div class="news-source-label">Source</div>

                            <a :href="news.source" target="_blank" class="event-external-link"><span class="external-link-span"></span>{{news.source}}</a>
                            <div class="general-divider"></div>
                        </template>

						<template v-if="getNewsByList">
                            <div  class="heading-block news-events-page" v-if="newsListData">
                                <h3 class="home-section-title profile-connect-title">Related News</h3>
                                <div class="line-block">
                                    <div class="blueline"></div>
                                    <div class="redline"></div>
                                </div>
                            </div>



                            <div class="ne-block" v-for="item in newsListData">

                                <router-link :to="{name:'newsDetails',params:{id:item.id+'-'+$root.linkify(item.title)}}" class="ne-image w-inline-block w--current" :style="item| imagePathForStyle" @click.native="getList()"></router-link>

                                <div class="home-news-event-info">
                                    <router-link :to="{name:'newsDetails',params:{id:item.id+'-'+$root.linkify(item.title)}}" class="home-news-events-headline w--current" @click.native="getList()">{{item.title}}</router-link>
                                    <div class="news-events-info-wrapper-div">
                                        <div class="news-events-date-location"><span class="clock-icon-span"></span>{{news.date | moment("MMM DD, YYYY")}}</div>
                                        <div class="dot-spacer likes-next"></div>
                                        <div class="airbook-likes" @click="postLike(item.id, 'App\\News')">
                                            <a href="#" :class="{'airbook-like-button':true, 'active': item.hasLike}" ></a>
                                            {{item.likes}}
                                        </div>
                                    </div>
                                </div>
                            </div>
						</template>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script src="../js/details/news-details.js"></script>



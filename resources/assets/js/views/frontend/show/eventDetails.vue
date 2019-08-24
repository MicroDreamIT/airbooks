<template>
	<div v-if="metas">

	<search-layout></search-layout>

		<div class="asset-details-section">
			<div class="container w-container">
				<div class="details-page-h1-block">
					<h1 class="details-page-h1-title own-upper">{{event.title}}</h1>
					<div class="details-page-date"><span class="asset-details-clock-icon"></span> Published {{event.created_at | moment("MMM DD, YYYY")}}</div>
				</div>
				<div class="module-details-row w-row">
					<div class="module-details-column right-borderline w-col w-col-7">
						<div class="asset-details-main-widget-wrapper">
							<div class="asset-details-main-widget-block first-widget">
								<div class="main-widget-label">From</div>
								<h2 class="main-widget-data-label">{{event.start_date | moment("MMM DD, YYYY")}}</h2>
							</div>
							<div class="asset-details-main-widget-block">
								<div class="main-widget-label">TO</div>
								<h2 class="main-widget-data-label">{{event.end_date | moment("MMM DD, YYYY")}}</h2>
							</div>
						</div>
						<div class="flag-block" v-if="event.country || event.city">
                            <template v-if="event.country">
                                <div class="country-flag" :style="event.country.medias | imagePathForStyle" v-if="event.country.medias"></div>
                            </template>
							<div class="asset-details-contact-info-block">
								<h4 class="events-city-label" v-if="event.country">{{event.country.name}}</h4>
								<div class="asset-details-contact-title" v-if="event.city">{{event.city.name}}</div>
							</div>
						</div>
					</div>
					<div class="module-details-column left-borderline w-col w-col-5">
						<div class="asset-details-widget-block events-details-page">
							<div class="asset-details-widget">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">{{event.views}}</div>
							</div>
							<a href="#" class="asset-details-widget w-inline-block"
							   :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(event.likes,'user_id', $root.$data.user, 'id')||likesActive}"
							   @click="postLike(event.id, 'App\\Event')">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">
									{{event.likes.length}}
								</div>
							</a>
							<a href="#"
							   :class="{'asset-details-widget w-inline-block':true,
                               'active': event.hasInterested}"
							   @click="postEventInterested(0, event.id, 'App\\Event')">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">I'm Interested</div>
							</a>
						</div>
                        <template>
                            <div class="general-divider" v-if="event.website"></div>
                            <a href="#" class="event-external-link">
                                <span class="external-link-span"></span>{{event.website}}
                            </a>
                        </template>

						<div class="general-divider"></div>
					</div>
				</div>
				<div class="module-details-row w-row">
					<div class="module-details-column right-borderline w-col w-col-7">
						<template v-if="event.medias">
							<div class="news-event-image" :style="event.medias | imagePathForStyle">

							</div>
						</template>
						<div class="news-event-details w-richtext cus-details-margin" v-html="event.details">

						</div>
						<!--<div class="event-location">{{event.name}}</div>-->
					</div>
					<div class="module-details-column left-borderline w-col w-col-5">
						<div id="share" class="asset-details-share-wrapper">
							<div class="send-message-label event-details-page">
								<span class="message-icon"></span>
								Share this Event
							</div>
							<share-this></share-this>
						</div>

						<template v-if="getInterestedById">
                            <template v-if="interestedData.length">
                                <div class="general-divider"></div>
                                <div id="ShareProfile" class="heading-block news-events-page" >
                                    <h3 class="home-section-title profile-connect-title">Who is Attending</h3>
                                    <div class="line-block">
                                        <div class="blueline"></div>
                                        <div class="redline"></div>
                                    </div>
                                </div>
                                <template v-for="item in interestedData">
                                    <router-link :to="{name:'contactDetails',params:{id:item.contact.id+'-'+item.contact.first_name+'-'+item.contact.last_name}}" class="general-sidebar w-inline-block">
                                        <h3 class="attending-person-name" v-if="item.contact">{{item.contact|fullName}}</h3>
                                        <div class="attending-person-title" v-if="item.contact.company">{{item.contact.job_title.name}} at {{item.contact.company.name}}</div>
                                    </router-link>
                                </template>
                            </template>

						</template>

					<template v-if="getEventByCategory">
						<div class="general-divider"></div>
						<div class="heading-block news-events-page" v-if="eventListData.length">
							<h3 class="home-section-title profile-connect-title">Related Events</h3>
							<div class="line-block">
								<div class="blueline"></div>
								<div class="redline"></div>
							</div>
						</div>
						<div class="ne-block" v-for="item in eventListData">
							<router-link :to="{name:'eventDetails',params:{id:item.id+'-'+$root.linkify(item.title)}}"
										 class="ne-image w-inline-block w--current"
										 :style="item| imagePathForStyle" @click.native="getList()"></router-link>
							<div class="home-news-event-info" >
								<router-link :to="{name:'eventDetails',params:{id:item.id+'-'+$root.linkify(item.title)}}"
											 class="home-news-events-headline w--current" @click.native="getList()">{{item.title}}</router-link>
								<div class="events-date-block">
									<div class="news-events-date-location"><span class="clock-icon-span"></span>
										{{item.start_date | moment("MMM DD, YYYY")}}</div>
									<div class="dot-spacer events-dot"></div>
									<div class="news-events-date-location"><span class="clock-icon-span"></span>
										{{item.end_date | moment("MMM DD, YYYY")}}</div>
								</div>
								<div class="news-events-date-location"><span class="clock-icon-span"></span>{{item.name}}</div>
								<div class="news-events-info-wrapper-div">
                                    <div class="airbook-likes" @click="postLike(item.id, 'App\\Event')">
                                        <a href="#" :class="{'airbook-like-button':true, 'active': item.hasLike}" ></a>
                                        {{item.likes}}
                                    </div>
									<div class="dot-spacer likes-next"></div>
									<div class="event-interest">
                                        <a href="#"
                                           :class="{'like-icon-span':true,'active': item.hasInterested}"
                                           @click="postEventInterested(0, item.id, 'App\\Event')"></a>Interested</div>
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

<script src="../js/details/event-details.js"></script>


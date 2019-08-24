<template>
	<div>
		<search-layout></search-layout>
		<div class="asset-details-section">
			<div class="container w-container">
				<div class="module-details-row w-row">
					<div class="module-details-column right-borderline w-col w-col-5">
						<div
                                class="contact-profile-image"
                                :style="contact.medias|imagePathForStyle"
                                v-if="$root.$data.user">

                        </div>
						<div class="contact-profile-image" v-else></div>
					</div>
					<div class="module-details-column left-borderline w-col w-col-7">
						<div class="asset-details-widget-block">
							<div class="asset-details-widget">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">{{contact.views}}</div>
							</div>
							<a href="#" class="asset-details-widget w-inline-block"
							   :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(contact.likes,'user_id', $root.$data.user, 'id')}"
							   @click="postLike(contact.id, 'App\\Contact')">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">{{contact.likes.length}}</div>
							</a>
							<a href="#" class="asset-details-widget w-inline-block"
							   @click="$root.postFavourite(contact.modelType,contact.id, 'App\\Contact' )">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">Save</div>
							</a>
							<a href="#SendMessage" class="asset-details-widget w-inline-block" @click.prevent="$root.callFocus()">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">Email</div>
							</a>
							<a href="#share" class="asset-details-widget w-inline-block">
								<div class="asset-details-widget-icon"></div>
								<div class="asset-details-widget-data">Share</div>
							</a>
						</div>
						<div class="general-divider"></div>
						<template v-if="contact.first_name || contact.last_name">
							<h1 class="details-page-h1-title">{{contact|fullName}}</h1>
						</template>

						<div class="details-page-date"><span class="asset-details-clock-icon"></span> Member since {{contact.created_at | moment("MMM DD, YYYY")}}</div>
						<div class="asset-details-data-block profile-page-title" v-if="contact.job_title">
							<div class="asset-details-data-label">Job Title</div>
							<h2 class="company-specialty-label">{{contact.job_title.name}}</h2>
						</div>
						<template v-if="contact.company">

							<router-link :to="{name:'companyDetails',params:{id:contact.company.id+'-'+contact.company.name}}" class="asset-details-page-side-block w-inline-block" v-if="$root.$data.user">
								<div class="company-default-image" :style="contact.company.medias|imagePathForStyle"></div>
								<div class="asset-details-contact-info-block">
									<h4 class="asset-details-contact-name">{{contact.company.name}}</h4>
									<div class="asset-details-contact-title">
										<template v-for="(speciality, index) in contact.company.specialities" v-if="contact.company.specialities">
										{{speciality.name}}
										<strong v-if="index < contact.company.specialities.length-1 "> | </strong>

										</template>
									</div>
								</div>
							</router-link>

                            <a href="#" class="asset-details-page-side-block w-inline-block" v-else>
                                <div class="company-default-image"></div>
                                <div class="asset-details-contact-info-block">
                                    <div class="lock-block" v-if="!$root.$data.user">
                                        <span class="lock"></span> Login to view company
                                    </div>
                                </div>
                            </a>



						</template>

					</div>
				</div>
				<div class="module-details-row w-row">
					<div class="module-details-column right-borderline w-col w-col-5">
						<div class="general-divider"></div>
						<div class="asset-details-data-block" v-if="contact.email">
							<div class="asset-details-data-label">Email</div>
                            <a :href="$root.$data.user?'mailto:'+contact.email+'?subject=Lead%20from%20Airbook': ''" class="call-link" v-if="$root.$data.user">{{contact.email}}</a>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>

						<div class="asset-details-data-block" v-if="contact.mobile_phone">
							<div class="asset-details-data-label">Mobile Phone</div>
                            <a href="#" class="call-link" v-if="$root.$data.user">{{contact.mobile_phone}}</a>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>

                        </div>
                        <div class="asset-details-data-block" v-if="contact.skype">
                            <div class="asset-details-data-label">Skype</div>
                            <a href="#" class="call-link" v-if="$root.$data.user">{{contact.skype}}</a>

                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>

                        </div>
                        <div class="asset-details-data-block" v-if="contact.linkedin">
                            <div class="asset-details-data-label">Linkedin</div>
                            <a href="#" class="call-link" v-if="$root.$data.user">{{contact.linkedin}}</a>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>

                        </div>

						<div class="asset-details-data-block" v-if="contact.business_phone">
							<div class="asset-details-data-label">Office Phone</div>
                            <a href="tel:+97141234567" class="call-link" v-if="$root.$data.user">{{contact.business_phone}}</a>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
                        </div>
						<div class="asset-details-data-block" v-if="contact.preferred_contact_method">
							<div class="asset-details-data-label">Preferred Contact Method</div>
							<div class="asset-details-data" v-if="$root.$data.user">{{contact.preferred_contact_method}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
                        <template v-if="contact.birthday">
                            <div class="asset-details-data-block" v-if="contact.birthday.length>1">
                                <div class="general-divider"></div>
                                <div class="asset-details-data-label">Birthday</div>
                                <div class="asset-details-data" v-if="$root.$data.user">{{contact.birthday | moment("MMM DD")}}</div>
                                <div class="lock-block" v-else>
                                    <span class="lock"></span> Login to view
                                </div>
                            </div>
                        </template>

						<div class="general-divider"></div>
						<div class="asset-details-data-block" v-if="contact.department">
							<div class="asset-details-data-label" >Department</div>
							<div class="asset-details-data" v-if="$root.$data.user">{{contact.department.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
						<div class="asset-details-data-block" v-if="contact.address">
							<div class="asset-details-data-label">Address</div>
                            <div class="asset-details-data" v-if="$root.$data.user">{{contact.address}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
						<div class="asset-details-data-block" v-if="contact.city">
							<div class="asset-details-data-label">City</div>
							<div class="asset-details-data" v-if="$root.$data.user">{{contact.city.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
						<div class="asset-details-data-block" v-if="contact.state">
							<div class="asset-details-data-label">State</div>
							<div class="asset-details-data" v-if="$root.$data.user">{{contact.state.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
						<div class="asset-details-data-block" v-if="contact.country">
							<div class="asset-details-data-label">Country</div>
							<div class="asset-details-data" v-if="$root.$data.user">{{contact.country.name}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
						<div class="general-divider" v-if="contact.about"></div>
						<div class="asset-details-data-block" v-if="contact.about">
							<div class="asset-details-data-label">About</div>
							<div class="asset-details-data description" v-if="$root.$data.user">{{contact.profile}}</div>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>
						</div>
						<div class="general-divider"></div>
					</div>
					<div class="module-details-column left-borderline w-col w-col-7">
						<div class="asset-details-contact-block">
							<sendmail :model="contact"></sendmail>

						</div>
						<div class="profile-related-info-wrapper no-top" v-if="getAssetByUserId">
							<div class="heading-block profile-page">
								<h3 class="home-section-title profile-connect-title">On Airbook by {{contact.first_name}}</h3>
								<div class="line-block">
									<div class="blueline"></div>
									<div class="redline"></div>
								</div>
							</div>
                            <template v-if="$root.$data.user">
							<template v-for="item in assetListData">
								<router-link :to=" '/' +item.modelType + '/' + item.id+'-'+item.title | linkify" class="profile-asset-block w-inline-block" >
									<h2 class="asset-title-h2">{{item.title| filterTitle | titlify }} </h2>
									<div class="asset-list-data-block">
										<div class="asset-list-data yom" v-if="item.YOM"> {{item.YOM | moment("YYYY") }}</div>
										<div class="dot-spacer" v-if="item.YOM"></div>
										<div class="asset-list-data-block" v-if="!$root.$data.user">
											<div class="asset-list-data sn" v-if="item.modelType=='aircraft'">MSN</div>
											<div class="asset-list-data sn" v-else-if="item.modelType=='engine'">ESN</div>
											<div class="asset-list-data sn" v-else-if="item.modelType=='apu'">SN</div>
											<div class="lock-block">
												<span class="lock"></span> Login
											</div>
										</div>
										<div class="asset-list-data-block">
											<div class="asset-list-data sn" v-if="item.modelType=='aircraft'">MSN
                                                <template v-if="$root.$data.user">
                                                    {{item.MSN}}

                                                </template>
                                                <div class="lock-block" v-else>
                                                    <span class="lock"></span> Login to view
                                                </div>
                                            </div>
											<div class="asset-list-data sn" v-else-if="item.modelType=='engine'">ESN
                                                <template v-if="$root.$data.user">
                                                    {{item.ESN}}
                                                </template>
                                                <div class="lock-block" v-else>
                                                    <span class="lock"></span> Login to view
                                                </div>

                                            </div>
											<div class="asset-list-data sn"  v-else-if="item.modelType=='apu'">SN
                                                <template v-if="$root.$data.user">
                                                    {{item.serial_number}}

                                                </template>
                                                <div class="lock-block" v-else>
                                                    <span class="lock"></span> Login to view
                                                </div>
                                            </div>
										</div>
									</div>

									<div class="asset-list-data-block">
                                        <template v-if="item.modelType!='wanted'">
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
                                        </template>
                                        <template v-else="">
                                            <div :class="{'business-tag':true,
                                            'acmi':item.terms=='ACMI',
                                                    'charter':item.terms=='Charter',
                                                    'lease':item.terms=='Dry Lease' || item.terms=='Wet Lease'||
                                                                item.terms=='Lease'|| item.terms=='Lease Purchase',
                                                    'outright':item.terms=='Outright Purchase',
                                                    'exchange':item.terms=='Exchange',
                                                    'partOut':item.terms=='Part out',
                                                    'sale':item.terms=='Sale'}"

                                            >{{item.terms}}</div>
                                        </template>

											<div class="dot-spacer"></div>
											<div class="asset-list-data yom">in <span class="own-uppercase">{{item.modelType}}</span></div>
									</div>

								</router-link>
							</template>
                            </template>
                            <div class="lock-block" v-else>
                                <span class="lock"></span> Login to view
                            </div>


						</div>
						<div class="general-divider"></div>
						<div id="share" class="asset-details-share-wrapper">
							<div class="send-message-label"><span class="message-icon"></span> Share Profile</div>
							<share-this></share-this>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script src="../js/details/contactDetails.js"></script>



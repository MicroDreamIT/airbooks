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
								<span class="h1-span-1">Companies</span>
								search and explore airlines, lessors, operators and more
							</h1>
						</div>
						<div class="asset-list">
							<div class="cc-list-block" v-for="(item, index) in companies">
								<div class="cc-image-block">
                                  <!--Due to some issue i have done like this way-->
									<router-link
                                            :to="{name:'companyDetails',params:{id:item.id+'-'+ $root.linkify(item.name)}}"
                                            class="company-list-logo w-inline-block"
                                            :style="item|imagePathForStyle" v-if="item.original_file_name">

                                    </router-link>

                                    <router-link
                                            :to="{name:'companyDetails',params:{id:item.id+'-'+ $root.linkify(item.name)}}"
                                            class="company-list-logo w-inline-block" v-else >

                                    </router-link>
                                    <!---->

								</div>
								<div class="connect-data-flex companies-page">
									<router-link :to="{name:'companyDetails',params:{id:item.id+'-'+ $root.linkify(item.name)}}" class="connect-data-block w-inline-block">
										<h2 class="asset-title-h2">{{item.name}}</h2>
										<div class="connect-data">{{item.speciality_name}}</div>
										<div class="connect-data country-name">{{item.country_name}}</div>
									</router-link>
									<div class="connect-info-block">
										<div class="connect-data number-of-contacts">{{item.contactCount}} Contacts</div>
										<div
												class="airbook-likes"
											 @click="postLike(index, item.id, 'App\\Company')">
											<a href="#"
											   :class="{'airbook-like-button':true, 'active': item.hasLike}">
												
											</a>
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

<script src="./js/company.js"></script>


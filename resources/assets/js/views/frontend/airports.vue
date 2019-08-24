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
								<span class="h1-span-1">Airports </span>
								search, explore and contribute airports across the globe
							</h1>
						</div>
						<div class="asset-list">
							<div class="airport-wrapper" v-for="(item,index) in airports">
								<div class="airport-info-block-wrapper">
									<router-link :to="{name:'aircraftDetails',params:{id:item.id+'-'+$root.linkify(item.name)}}"
                                                 class="airport-info-block w-inline-block">
										<h2 class="asset-title-h2">{{item.name}}</h2>
										<div class="asset-list-data-block">
											<div class="asset-list-data">{{item.city_name+', '+item.country_name}}</div>
										</div>
										<div class="asset-list-data-block">
											<div class="asset-list-data iata-icao">IATA {{item.iata_code}}</div>
											<div class="dot-spacer"></div>
											<div class="asset-list-data iata-icao">ICAO {{item.icao_code}}</div>
										</div>
										<div class="asset-list-data-block">
											<div class="asset-list-data">{{item.airfield_name}}</div>
										</div>
									</router-link>
									<div class="airbook-likes" @click="postLike(index, item.id, 'App\\Airport')">
										<a href="#" :class="{'airbook-like-button':true, 'active': item.hasLike}" ></a>
										{{item.likes}}
									</div>
								</div>
								<div class="airport-controls-block" v-if="$root.user">
									<a href="#" class="pencil" @click.prevent="airportsEdit(item.id)"></a>
								</div>

							</div>
                            <!--Airport Edit modal-->
                            <div class="airportsModal" v-if="airportsModal">
                                <div class="inner-data">
                                    <div class="modal-header">
                                        <span>Airport Edit</span>
                                        <span @click.prevent="closeAirportModal">X</span>
                                    </div>

                                    <div class="airport-modal-body">
                                        <airport-edit :id="editId" :pageType="'airports'"></airport-edit>
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

<script src="./js/airport.js"></script>

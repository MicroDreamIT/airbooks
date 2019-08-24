<template>
    <div v-if="metas">

       <search-layout></search-layout>

        <div class="asset-details-section">
            <div class="container w-container">
                <div class="details-page-h1-block">
                    <h1 class="details-page-h1-title">{{airport.name}}</h1>
                    <div class="details-page-date"><span class="asset-details-clock-icon"></span> Published {{airport.created_at | moment("MMM DD, YYYY")}} - Updated {{airport.updated_at | moment("MMM DD, YYYY")}}</div>
                </div>
                <div class="module-details-row w-row">
                    <div class="module-details-column w-col w-col-7">
                        <div class="asset-details-main-widget-wrapper">
                            <div class="asset-details-main-widget-block first-widget" v-if="airport.iata_code">
                                <div class="main-widget-label">IATA</div>
                                <h2 class="main-widget-data-label iataicao">{{airport.iata_code}}</h2>
                            </div>
                            <div class="asset-details-main-widget-block" v-if="airport.icao_code">
                                <div class="main-widget-label">ICAO</div>
                                <h2 class="main-widget-data-label iataicao">{{airport.icao_code}}</h2>
                            </div>
                        </div>
                        <div class="heading-block asset-details-page">
                            <h3 class="home-section-title">Airport Details</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="asset-details-data-block" v-if="airport.airfield">
                            <div class="asset-details-data-label">Airfield Type</div>
                            <div class="asset-details-data">{{airport.airfield.name}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="airport.city">
                            <div class="asset-details-data-label">City</div>
                            <div class="asset-details-data">{{airport.city.name}}</div>
                        </div>
                        <template v-if="airport.city">
                            <div class="asset-details-data-block" v-if="airport.city.state">
                                <div class="asset-details-data-label">State</div>
                                <div class="asset-details-data">{{airport.city.state.name}}</div>
                            </div>
                        </template>
                       <template v-if="airport.city">
                           <div class="asset-details-data-block" v-if="airport.city.state.country">
                               <div class="asset-details-data-label">Country</div>
                               <div class="asset-details-data">{{airport.city.state.country.name}}</div>
                           </div>
                       </template>

                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="airport.latitude">
                            <div class="asset-details-data-label">Latitude</div>
                            <div class="asset-details-data">{{airport.latitude}}</div>
                        </div>
                        <div class="asset-details-data-block" v-if="airport.longitude">
                            <div class="asset-details-data-label">Longitude</div>
                            <div class="asset-details-data">{{airport.longitude}}</div>
                        </div>
                        <div class="general-divider"></div>
                        <div class="asset-details-data-block" v-if="airport.sunrise">
                            <div class="asset-details-data-label">Sunrise</div>
                            <div class="asset-details-data">{{airport.sunrise}} UTC</div>
                        </div>
                        <div class="asset-details-data-block" v-if="airport.sunset">
                            <div class="asset-details-data-label">Sunset</div>
                            <div class="asset-details-data">{{airport.sunset}} UTC</div>
                        </div>
                        <div class="general-divider"></div>
                    </div>
                    <div class="module-details-column left-borderline w-col w-col-5">
                        <div class="asset-details-widget-block">
                            <div class="asset-details-widget">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">{{airport.views}}</div>
                            </div>
                            <a href="#" class="asset-details-widget w-inline-block"
                               :class="{'asset-details-widget w-inline-block':true,
                               'active': $root.checkObject_key_value(airport.likes,'user_id', $root.$data.user, 'id') || likesActive}"
                               @click="postLike(airport.id, 'App\\Airport')">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">{{airport.likes.length}}</div>
                            </a>
                            <a href="#" :class="{'asset-details-widget':true, 'w-inline-block':true, 'active': $root.checkObject_key_value(airport.favourites,'user_id', $root.$data.user, 'id') || favouriteActive}"
                               @click="postFavourite(airport.id, 'App\\Airport')">
                                <div class="asset-details-widget-icon "></div>
                                <div class="asset-details-widget-data">
                                    Favorite
                                </div>
                            </a>
                            <a href="#Share" class="asset-details-widget w-inline-block">
                                <div class="asset-details-widget-icon"></div>
                                <div class="asset-details-widget-data">Share</div>
                            </a>
                        </div>
                            <div class="general-divider"></div>
                            <template v-if="$root.$data.user">
                                <a href="#" class="contribute-block w-inline-block cust-button-color" @click.prevent="airportsEdit">
                                    <div class="contribute-icon"></div>
                                    <div >
                                        <h3 class="contribute-headline">Edit Airport</h3>
                                        <div class="contribute-sub-label">Contribute Information</div>
                                    </div>
                                </a>
                            </template>

                            <template v-else>
                                <a href="#" class="contribute-block w-inline-block cust-button-color" @click.prevent="">
                                    <div class="contribute-icon"></div>
                                    <div >
                                        <h3 class="contribute-headline">Edit Airport</h3>
                                        <div class="contribute-sub-label">
                                            <span class="lock" style="color:white!important;" ></span> Login to Contribute Information
                                        </div>
                                    </div>
                                </a>
                            </template>

                    <template v-if="airport.user">
                        <div class="general-divider"></div>
                        <div class="heading-block profile-page">
                            <h3 class="home-section-title profile-connect-title">Recent CONTRIBUTORS</h3>
                            <div class="line-block">
                                <div class="blueline"></div>
                                <div class="redline"></div>
                            </div>
                        </div>
                        <div class="airport-sidebar-wrapper">

                            <template>
                                <router-link :to="{name:'contactDetails',
                                params:{id:airport.user.contact.id+'-'+airport.user.contact.first_name+'-'+airport.user.contact.last_name}}"
                                             class="general-sidebar w-inline-block">

                                    <h3 class="attending-person-name" v-if="airport.user.contact">
                                        {{airport.user.contact|fullName}}</h3>
                                    <div class="attending-person-title" >
                                        <template v-if="airport.user.contact.job_title">
                                            {{airport.user.contact.job_title.name}} at
                                        </template>

                                        <template class="own-uppercase" v-if="airport.user.contact.company">
                                            {{airport.user.contact.company.name}}</template>
                                    </div>
                                </router-link>
                            </template>


                            <div class="airbook-likes" v-if="airport.user.contact">
                                <a href="#" :class="{'airbook-like-button':true,
                                    'active': $root.checkObject_key_value(airport.user.contact.likes,'user_id', $root.$data.user, 'id')}"
                                   @click="postLike(airport.user.contact.id, 'App\\Contact','Contact')"
                                ></a>{{airport.user.contact.likes.length}}

                            </div>

                        </div>
                    </template>


                        <template v-if="getAirportByCountryId">
                            <div class="general-divider"></div>
                            <div class="heading-block profile-page" v-if="airportListData.length">
                                <h3 class="home-section-title profile-connect-title" v-if="airport.city">More Airports in {{airport.city.state.country.name}}</h3>
                                <div class="line-block">
                                    <div class="blueline"></div>
                                    <div class="redline"></div>
                                </div>
                            </div>

                            <div class="airport-sidebar-wrapper" v-for="item in airportListData">
                                <router-link :to="{name:'aircraftDetails',
                                params:{id:item.id+'-'+$root.linkify(item.name)}}"
                                             class="general-sidebar w-inline-block" @click.native="getData()">

                                    <h3 class="attending-person-name">{{item.name}}</h3>
                                    <div class="iata-sidebar-label"><span class="iataicao-span">IATA</span>
                                        {{item.iata_code}}</div>
                                    <div class="iata-sidebar-label"><span class="iataicao-span">ICAO</span>
                                        {{item.icao_code}}</div>
                                </router-link>
                                <div class="airbook-likes">
                                    <a href="#" :class="{'airbook-like-button':true,
                                 'active': item.hasLike}" @click="postLike(item.id, 'App\\Airport')"></a>
                                    {{item.likes}}
                                </div>
                            </div>

                        </template>

                        <div class="general-divider"></div>
                        <div id="Share" class="asset-details-share-wrapper">
                            <div class="send-message-label-2"><span class="message-icon"></span> Share this Airport</div>
                            <share-this></share-this>
                        </div>

                        <!--Airport Edit modal-->
                        <div class="airportsModal" v-if="airportsModal">
                            <div class="inner-data">
                                <div class="modal-header">
                                    <span>Airport Edit</span>
                                    <span @click.prevent="closeAirportModal">X</span>
                                </div>

                                <div class="airport-modal-body">
                                    <airport-edit :id="airport.id" :pageType="'airports'"></airport-edit>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script src="../js/details/airportDetails.js"></script>

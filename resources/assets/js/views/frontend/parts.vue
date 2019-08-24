<template>
    <!--
    24345, 24345,338,4567,3456,456456,678687,12312,7897897,456456,34232,45623,5674234
    435,454,344,343,433,113,112
    -->
    <div v-if="metas">
        <div class="asset-page-section">
            <div class="container w-container">
                <div class="asset-page-wrapper">

                    <sidebar-search-layout
                            @searchDataList="searchEmitData"
                            v-if="showLayout"
                            :searchTitleNumbers="items"
                            ref="sideBarRef"
                    >
                    </sidebar-search-layout>

                    <div class="list-wrapper">
                        <div class="preloader-block"></div>
                        <div class="list-page-h1-block" v-if="!showLayout">
                            <h1 class="list-page-h1"><span class="h1-span-1">Parts</span> database search for commercial
                                aircraft, engines and components</h1>
                        </div>
                        <div class="list-page-h1-block" v-if="showLayout">
                            <h1 class="list-page-h1">Search results for PN <span
                                    class="parts-results-span">{{numbers}}</span></h1>
                        </div>
                        <div class="parts-page-search-block">
                            <div class="parts-search-form-block w-form">
                                <form id="wf-form-Parts-Search" name="wf-form-Parts-Search" data-name="Parts Search"
                                      class="parts-search-form" @submit.prevent="getData(1)">

                                <textarea id="Part-Number"
                                          name="Part-Number" data-name="Part Number" maxlength="5000"
                                          placeholder="Enter one part number per line"
                                          required=""
                                          v-model="numbers"
                                          :rows="showLayout?2:5"

                                          class="parts-search-field w-input">
                                </textarea>

                                    <input type="submit" value="Search" data-wait="Search"
                                           class="part-search-button w-button">
                                </form>
                                <div class="w-form-done">
                                    <div>Thank you! Your submission has been received!</div>
                                </div>
                                <div class="w-form-fail">
                                    <div>Oops! Something went wrong while submitting the form.</div>
                                </div>
                            </div>
                        </div>
                        <template v-if="showLayout">
                            <div class="rfq-block" v-if="selectedItems.length">
                                <a href="#" class="rfq-button w-button" @click="$root.mailModalShow(selectedItems)" >
                                    SEND RFQ TO THE SELECTED
                                </a>
                                <div class="pn-selected">{{selectedItems.length}} Selected</div>
                            </div>
                            <div class="parts-list-wrapper" v-for="items in parts">
                                <div v-for="item in items">
                                    <div class="pn-block">
                                        <div class="pn-checkbox-block">
                                            <div class="pretty p-icon p-smooth">
                                                <input type="checkbox" v-model="selectedItems" :value="item"/>
                                                <div class="state p-primary">
                                                    <i class="icon mdi mdi-check"></i>
                                                    <label></label>
                                                </div>
                                            </div>
                                            <!--<div class="pn-checkbox"></div>-->
                                        </div>
                                        <div class="pn-data-block">
                                            <div class="pn-data">
                                                <div class="pn-alt-pn">
                                                    <h2 class="asset-title-h2">{{item.part_number}}</h2>
                                                    <div class="part-number alt-pn"><span class="alt-pn-span">ALT PN</span>
                                                        {{item.alternate_part_number}}
                                                    </div>
                                                </div>
                                                <div class="part-condition-label" v-if="item.condition">
                                                    {{item.condition.name}}
                                                </div>
                                            </div>
                                            <div class="pn-data">
                                                <div class="part-description">{{item.description}}</div>
                                            </div>
                                            <div class="pn-data flex-data">
                                                <div class="part-label" v-if="item.quantity">{{item.quantity}} EA</div>
                                                <div class="part-label" v-if="item.price">US$
                                                    {{(Number(item.price)).toFixed(2)}} EA
                                                </div>
                                                <div class="part-label" v-if="item.release">FAA {{item.release.name}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="parts-company-info-wrapper">
                                    <div class="part-company-info-block">
                                        <router-link :to="{name:'companyDetails', params:{id:items[0].contact.company.id + '-' + $root.linkify(items[0].contact.company.name)}}" target="_blank"
                                                     class="part-supplier-profile-link"
                                                     v-if="items[0].contact.company">
                                            {{items[0].contact.company.name}}
                                        </router-link>
                                        <div class="parts-info-block">
                                            <div class="parts-contact-block" v-if="items[0].contact.company">
                                                <div class="parts-contact-label">AOG</div>
                                                <a href="mailto:abc@abc.com?subject=Airbook%20AOG%20Request"
                                                   class="parts-link">{{items[0].contact.company.aog_email}}</a>
                                            </div>
                                            <div class="parts-contact-block" v-if="items[0].contact.company">
                                                <div class="parts-contact-label">RFQ</div>
                                                <a href="mailto:abc@abc.com?subject=Airbook%20RFQ" class="parts-link">
                                                    {{items[0].contact.company.rfq_email}}
                                                </a>
                                            </div>
                                            <div class="parts-contact-block" v-if="items[0].contact.company">
                                                <div class="parts-contact-label">TEL</div>
                                                <a href="tel:+1234567879" class="parts-link">
                                                    {{items[0].contact.company.business_phone}}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="parts-info-block">
                                            <div class="parts-list-data" v-if="items[0].contact">
                                                <template v-if="items[0].contact.company">
                                                    <template v-if="items[0].contact.company.country">
                                                        {{items[0].contact.company.country.name}}
                                                    </template>
                                                </template>

                                            </div>
                                            <div class="parts-list-data">
                                                Published
                                                <span class="parts-list-data-span">
                                                    {{items[0].created_at | moment("DD/MM/YYYY") }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rfq-block" v-if="selectedItems.length">
                                <a href="#" class="rfq-button w-button" @click="$root.mailModalShow(selectedItems)" >
                                    SEND RFQ TO THE SELECTED
                                </a>
                                <div class="pn-selected">{{selectedItems.length}} Selected</div>
                            </div>
                        </template>

                        <own-pagination ref="pagination" :pagination-data="paginationData"></own-pagination>

                        <h2 class="parts-signup-message" v-if="!showLayout && !$root.$data.user">
                            Want to list your parts?
                            <a href="/register" class="parts-search-register-link">Register now</a> and upload your parts
                            CSV file. It&#x27;s Free.</h2>

                    </div>
                </div>
            </div>
            <div class="device-filter-button" data-ix="show-filter"
                 @click="$root.callFilter()">
                
            </div>
            <modal name="sendMail" height="auto" >
                <sendmail :model="$root.$data.mailModalData" :fromModal="true"></sendmail>
            </modal>
        </div>
    </div>

</template>

<script src="./js/part.js"></script>

<template>
        <div class="filter-wrapper">
            <div class="filter-header">
                <div class="filter-elements">
                    <div class="filter-font"></div>
                    <div class="filter-label">Search Filters</div>
                </div>
                <a href="#"
                         class="filter-close-button w-hidden-main w-button"
                         data-ix="close-filter"
                         @click.prevent="$root.closeFilter">Close
                </a>
            </div>
            <div class="filter-block" v-if="$route.path.replace('/','')=='wanted'">
                <div class="filter-block-heading-block">
                    <div class="filter-block-headline">Asset Type</div>
                    <div class="down-arrow"></div>
                </div>
                <div class="filter-form-block w-form">
                    <form  name="wf-form-Filter-Form" data-name="Filter Form">
                        <div class="filter-fields-block">
                            <div class="filter-checkbox w-checkbox" v-for="item in assetType">
                                <input type="checkbox"  name="checkbox-6"
                                       v-model="assetTypeItemList"
                                       :value="item.type"
                                       @change="getDataBySidebarSearch()"
                                       data-name="Checkbox 6" class="filter-select w-checkbox-input"><label  class="filter-checkbox-label w-form-label own-uppercase">{{item.type}}</label>
                                <span class="catItemNumber">({{item.itemCount}})</span>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
            <div class="filter-contents-block">
                <div class="filter-block"
                     v-if="['aircraft', 'engine', 'apu','wanted'].includes($route.path.replace('/',''))">

                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline" v-if="$route.path.replace('/','')=='wanted'">Wanted Terms</div>
                        <div class="filter-block-headline" v-else="">Offered for</div>
                        <div class="down-arrow"></div>
                    </div>

                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">
                            <div class="filter-fields-block no-scrollable">
                                <div class="filter-checkbox w-checkbox" v-for="offer in offerFors">
                                    <input type="checkbox"
                                           v-model="offerForItemList"
                                           :value="$route.path.replace('/','')=='wanted'?offer.terms:offer.offer_for"
                                           @change="getDataBySidebarSearch()"
                                           name="checkbox-6" data-name="Checkbox 6" class="filter-select w-checkbox-input" >
                                    <label  class="filter-checkbox-label w-form-label">
                                        {{$route.path.replace('/','')=='wanted'?offer.terms:offer.offer_for}}</label>
                                    <span class="catItemNumber">({{offer.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block"  v-if="['aircraft', 'engine', 'apu','news','event'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline" v-if="$route.path.replace('/','')=='news'">News Type</div>
                        <div class="filter-block-headline" v-else-if="$route.path.replace('/','')=='event'">Event Type</div>
                        <div class="filter-block-headline" v-else>Category
                        </div>
                        <div class="down-arrow"></div>
                    </div>

                    <div class="filter-form-block w-form" >
                        <form id="wf-form-Filter-Form" name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="categorySearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category"
                                   data-name="Search Category"
                                   :placeholder="['news','event'].includes($route.path.replace('/',''))?'Search '
                                   +$root.jsUcfirst($route.path.replace('/',''))+' Type':'Search Category'"
                                   id="Search-Category" required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="(item,index) in categorySearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           data-name="Checkbox 6"
                                           class="filter-select w-checkbox-input"
                                           :id="'categoryCheckBox'+index"
                                           :value="item.id"
                                           v-model="categorySearchItemList" @change="getDataBySidebarSearch()">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['aircraft', 'engine', 'apu'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Manufacturer</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">

                            <input type="text"
                                   v-model="manufacturerSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256" name="Search-Manufacturer"
                                   data-name="Search Manufacturer"
                                   placeholder="Search Manufacturer"
                                   id="Search-Manufacturer" required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in manufacturerSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           :value="item.id"
                                           v-model="manufacturerSearchItemList" @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label  class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['aircraft', 'engine', 'apu'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline own-uppercase">{{$route.path.replace('/','')}} Type</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">

                            <input type="text" v-model="typeSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256" name="Search-Manufacturer-3"
                                   data-name="Search Manufacturer 3"
                                   placeholder="Search Type"
                                   id="Search-Manufacturer-3"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in typeSearchList">
                                    <input type="checkbox"  name="checkbox-6"
                                           data-name="Checkbox 6"
                                           :value="item.id"
                                           v-model="typeSearchItemList"
                                           @change="getDataBySidebarSearch()"
                                           class="filter-select w-checkbox-input">
                                    <label  class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['aircraft', 'engine', 'apu'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline own-uppercase">{{$route.path.replace('/','')}} Model</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">

                            <input type="text" v-model="modelSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256" name="Search-Manufacturer-2"
                                   data-name="Search Manufacturer 2"
                                   placeholder="Search Model"
                                   id="Search-Manufacturer-2"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in modelSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="modelSearchItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6"
                                           class="filter-select w-checkbox-input">
                                    <label  class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="$route.path.replace('/','')=='aircraft'">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">YOM</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">
                            <div class="filter-fields-block no-scrollable">
                                <div class="filter-yom">
                                    <select name="From-YOM"
                                            v-model="yom_start"
                                            @change="getDataBySidebarSearch()"
                                            data-name="From YOM"
                                            class="filter-select-field left-select w-select">
                                        <template v-for="item in yomFromOptions">
                                            <option :value="item.value" >{{item.year}}</option>
                                        </template>
                                    </select>


                                    <select id="TO-YOM-2"
                                            v-model="yom_end"
                                            @change="getDataBySidebarSearch()"
                                            name="TO-YOM"
                                            data-name="TO YOM"
                                            class="filter-select-field w-select">
                                        <template v-for="item in yomToOptions">
                                            <option :value="item.value" >{{item.year}}</option>
                                        </template>
                                    </select></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block"  v-if="['engine', 'apu'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Cycle Remaining</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <div class="filter-fields-block no-scrollable">
                                <div class="filter-yom">

                                    <select  name="From-YOM" data-name="From YOM" v-model="from_cycleRemaning"
                                             @change="getDataBySidebarSearch()"
                                             class="filter-select-field left-select w-select">
                                        <template v-for="item in cycleRemaningOptions" v-if="cycleRemaningOptions.length">
                                            <option :value="item.value" >{{item.item}}</option>
                                        </template>
                                        <template  v-else>
                                            <option value="0" >0</option>
                                        </template>

                                    </select>

                                    <select  name="TO-YOM" data-name="TO YOM"
                                             v-model="to_cycleRemaning"
                                             @change="getDataBySidebarSearch()"class="filter-select-field w-select">
                                        <template v-for="item in cycleRemaningOptionsTo" v-if="cycleRemaningOptions.length">
                                            <option :value="item.value" >{{item.item}}</option>
                                        </template>
                                        <template  v-else>
                                            <option value="0" >0</option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>






                <div class="filter-block" v-if="['parts'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Condition</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="conditionSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category-2"
                                   data-name="Search Category 2"
                                   placeholder="Search Condition"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in conditionSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="conditionItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="filter-block" v-if="['contact'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Job Title</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="jobTitleSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256" name="Search-Category-2" data-name="Search Category 2" placeholder="Search Job Title"  required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in jobTitleSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="jobTitleItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['company'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Specialty</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="specialitySearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category-2"
                                   data-name="Search Category 2"
                                   placeholder="Search Industry"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in specialitySearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="specialityItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['airport'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Airfield Type</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">
                            <!--<input type="text"-->
                                   <!--v-model="airfieldSearch"-->
                                   <!--class="filter-search-field w-input"-->
                                   <!--maxlength="256" name="Search-Category-2" data-name="Search Category 2"-->
                                   <!--placeholder="Search Airfield" required="">-->

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in airfieldSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="airfieldItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['contact'].includes($route.path.replace('/','')) && $root.$data.user">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Company</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="companySearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category-2"
                                   data-name="Search Category 2"
                                   placeholder="Search Company"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in companySearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="companyItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['news','event','airport','contact','company','parts','wanted'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline" v-if="$route.path.replace('/','')!='wanted'">Country</div>
                        <div class="filter-block-headline" v-if="$route.path.replace('/','')=='wanted'">Wanted Location</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="countrySearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category-2"
                                   data-name="Search Category 2"
                                   :placeholder="$route.path.replace('/','')=='wanted'?'Search Location':'Search Country'"
                                   id="Search-Category-2"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in countrySearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="countryItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>




                <div class="filter-block" v-if="['aircraft','engine','apu'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline own-uppercase">{{$route.path.replace('/','')}} Status</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in status">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="assetStatusItemList"
                                           :value="item.status"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6"
                                           class="filter-select w-checkbox-input">
                                    <label  class="filter-checkbox-label w-form-label own-uppercase">
                                        {{item.status}}
                                    </label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['news','event'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Regions</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="regionSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category"
                                   data-name="Search Region"
                                   placeholder="Search Region"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in regionSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="regionItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="filter-block" v-if="['news','event'].includes($route.path.replace('/',''))">
                    <div class="filter-block-heading-block">
                        <div class="filter-block-headline">Continent</div>
                        <div class="down-arrow"></div>
                    </div>
                    <div class="filter-form-block w-form">
                        <form  name="wf-form-Filter-Form" data-name="Filter Form">
                            <input type="text"
                                   v-model="continentSearch"
                                   class="filter-search-field w-input"
                                   maxlength="256"
                                   name="Search-Category-2"
                                   data-name="Search Category 2"
                                   placeholder="Search Continent"
                                   required="">

                            <div class="filter-fields-block">
                                <div class="filter-checkbox w-checkbox" v-for="item in continentSearchList">
                                    <input type="checkbox"
                                           name="checkbox-6"
                                           v-model="continentItemList"
                                           :value="item.id"
                                           @change="getDataBySidebarSearch()"
                                           data-name="Checkbox 6" class="filter-select w-checkbox-input">
                                    <label class="filter-checkbox-label w-form-label">{{item.name}}</label>
                                    <span class="catItemNumber">({{item.itemCount}})</span>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

</template>

<script src="./js/sidebarSearchLayout.js"></script>







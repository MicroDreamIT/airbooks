<template>
    <div>
        <div class="row mt-2 mb-2">
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="widget widget-tile custom">
                    <div class="chart sparkline" id="spark1">
                        <canvas width="85" height="50" style="display: inline-block; width: 85px; height: 25px!important; vertical-align: top;"></canvas>
                    </div>
                    <div class="data-info">
                        <div class="desc fs"> Aircraft</div>
                        <div class="value pt-2">
                            <span class="indicator indicator-positive mdi mdi-chevron-up"></span>{{aircraftActive}}
                            <span class="indicator indicator-negative mdi mdi-chevron-down"></span>{{aircraftInactive}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="widget widget-tile custom">
                    <div class="chart sparkline" id="spark2">
                        <canvas width="81" height="50" style="display: inline-block; width: 81px; height: 25px!important; vertical-align: top;"></canvas></div>
                    <div class="data-info">
                        <div class="desc fs">Engines</div>
                        <div class="value pt-2">
                            <span class="indicator indicator-positive mdi mdi-chevron-up"></span>{{engineActive}}
                            <span class="indicator indicator-negative mdi mdi-chevron-down"></span>{{engineInactive}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="widget widget-tile custom">
                    <div class="chart sparkline" id="spark3"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="data-info">
                        <div class="desc fs">APU’s</div>
                        <div class="value pt-2">
                            <span class="indicator indicator-positive mdi mdi-chevron-up"></span>{{apuActive}}
                            <span class="indicator indicator-negative mdi mdi-chevron-down"></span>{{apuInactive}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="widget widget-tile custom">
                    <div class="chart sparkline" id="spark4"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="data-info">
                        <div class="desc fs">Wanted</div>
                        <div class="value pt-2">
                            <span class="indicator indicator-positive mdi mdi-chevron-up"></span>{{wantedActive}}
                            <span class="indicator indicator-negative mdi mdi-chevron-down"></span>{{wantedInactive}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="widget be-loading">
                    <div class="widget-head">
                        <div class="title">Top Leads</div>
                    </div>
                    <user-dashboard-chart :data="chartData" v-if="chartLoad"></user-dashboard-chart>
                    <!--<div class="widget-chart-container">-->
                        <!--&lt;!&ndash;<div id="top-sales" style="height: 178px;"></div>&ndash;&gt;-->
                        <!---->
                        <!--&lt;!&ndash;<div class="chart-pie-counter">36</div>&ndash;&gt;-->
                    <!--</div>-->
                    <div class="chart-legend">
                        <table>
                            <tr>
                                <td>Aircraft</td>
                                <td class="chart-legend-value">{{chartData[0]}}</td>
                            </tr>
                            <tr>
                                <td>Engine</td>
                                <td class="chart-legend-value">{{chartData[1]}}</td>
                            </tr>
                            <tr>
                                <td>APU</td>
                                <td class="chart-legend-value">{{chartData[2]}}</td>
                            </tr>
                            <tr>
                                <td>Wanted</td>
                                <td class="chart-legend-value">{{chartData[3]}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="be-spinner">
                        <svg width="40px" height="40px" viewBox="0 0 66 66" >
                            <circle class="circle" fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card card-table custom-title-adjust-dashboard">
                    <div class="card-header">
                        <div class="title ">Recent Leads</div>
                        <router-link :to="{name:'userLeadList'}"
                                     class="own-right btn btn-sm btn-primary btn-adjust">
                            Go to Leads
                        </router-link>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Contact</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody class="no-border-x">
                                <tr v-for="item in leads">
                                    <td> {{getTitleByData(item)|filterTitle}} </td>
                                    <td >
                                        <template v-if="item.user">
                                            <template v-if="item.user.contact">

                                                {{item.user.contact.fullName}}
                                            </template>

                                        </template>
                                    </td>
                                    <td>{{item.created_at|moment('DD/MM/YYYY')}}</td>
                                    <td>{{item.lead_status}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-table custom-title-adjust-dashboard">
                    <div class="card-header">
                        <div class="title ">My Recent Aircraft</div>
                        <router-link :to="{name:'userAircrafts'}"
                                     class="own-right btn btn-sm btn-primary btn-adjust">
                            Go to Aircrafts
                        </router-link>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th style="width:70%;">Title</th>
                                <th style="width:10%;">MSN</th>
                                <th style="width:10%;">Status</th>
                                <th style="width:10%;">Views</th>
                            </tr>
                            </thead>
                            <tbody class="no-border-x">
                            <tr v-for="item in aircrafts">
                                <td>{{item.title|filterTitle}}</td>
                                <td>{{item.MSN}}</td>
                                <td>{{item.isActiveStatus}}</td>
                                <td>{{item.views}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-table custom-title-adjust-dashboard">
                    <div class="card-header">
                        <div class="title ">My Recent Engines</div>
                        <router-link :to="{name:'userEngineList'}"
                                     class="own-right btn btn-sm btn-primary btn-adjust">
                            Go to Engines
                        </router-link>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th style="width:40%;">Title</th>
                                <th style="width:25%;">ESN</th>
                                <th style="width:25%;">Status</th>
                                <th style="width:10%;">Views</th>
                            </tr>
                            </thead>
                            <tbody class="no-border-x">
                            <tr v-for="item in engines">
                                <td>{{item.title|filterTitle}}</td>
                                <td>{{item.esn}}</td>
                                <td>{{item.isActiveStatus}}</td>
                                <td>{{item.views}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-table custom-title-adjust-dashboard">
                    <div class="card-header">
                        <div class="title ">My Recent APU’s</div>
                        <router-link :to="{name:'userApuList'}"
                                     class="own-right btn btn-sm btn-primary btn-adjust">
                            Go to APU's
                        </router-link>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th style="width:40%;">Title</th>
                                <th style="width:25%;">ESN</th>
                                <th style="width:25%;">Status</th>
                                <th style="width:10%;">Views</th>
                            </tr>
                            </thead>
                            <tbody class="no-border-x">
                            <tr v-for="item in apus">
                                <td>{{item.title|filterTitle}}</td>
                                <td>{{item.serial_number}}</td>
                                <td>{{item.isActiveStatus}}</td>
                                <td>{{item.views}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-table custom-title-adjust-dashboard">
                    <div class="card-header">
                        <div class="title ">My Recent Wanted</div>
                        <router-link :to="{name:'userWantedIndex'}"
                                     class="own-right btn btn-sm btn-primary btn-adjust">
                            Go to Wanteds
                        </router-link>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <th style="width:50%;">Title</th>
                                <th style="width:25%;">Status</th>
                                <th style="width:25%;">Views</th>
                            </tr>
                            </thead>
                            <tbody class="no-border-x">
                            <tr v-for="item in wanteds">
                                <td>{{item.title|filterTitle}}</td>
                                <td>{{item.is_active==1?'Active':'Inactive'}}</td>
                                <td class="text-center">{{item.views}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    import userDashboardChart from '../../components/charts/userDashboardChart.vue'
    export default {
        components:{
            userDashboardChart:userDashboardChart
        },
        name: "userDashboard",
        data(){
            return{
                aircraftActive:0,
                aircraftInactive:0,
                engineActive:0,
                engineInactive:0,
                apuActive:0,
                apuInactive:0,
                wantedActive:0,
                wantedInactive:0,
                aircrafts:[],
                engines:[],
                apus:[],
                wanteds:[],
                leads:[],
                chartData:[],
                aircraftCount:[],
                engineCount:[],
                apuCount:[],
                wantedCount:[],
            }

        },
        computed:{
            chartLoad(){
                if(this.chartData){
                    if(this.chartData.length){
                        return true
                    }
                }
            },
        },
        created(){
         this.getDashBoardData()
            this.getLead()
            this.getAircraft()
            this.getEngine()
            this.getApu()
            this.getWanted()

        },
        beforeUpdate(){

            $("#spark1").sparkline(this.aircraftCount, {
                type: 'bar',
                height: '25',
                barColor: '#fbbc04'});
            $("#spark2").sparkline(this.engineCount, {
                height: '25',
                lineColor: '#007f3f',
                type: 'discrete'});
            $("#spark3").sparkline(this.apuCount, {
                type: 'line',
                lineColor: '#1144bf',
                fillColor: '#fff',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});
            $("#spark4").sparkline(this.wantedCount, {
                type: 'line',
                lineColor: '#06994d',
                fillColor: '#5590cc',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});
        },
        methods:{
            getDashBoardData(){
                axios.get('/user/ajax/get-dashboard-data').then(res=>{
                        this.aircraftActive=res.data.aircraftActive
                        this.aircraftInactive=res.data.aircraftInactive
                        this.engineActive=res.data.engineActive
                        this.engineInactive=res.data.engineInactive
                        this.apuActive=res.data.apuActive
                        this.apuInactive=res.data.apuInactive
                        this.wantedActive=res.data.wantedActive
                        this.wantedInactive=res.data.wantedInactive
                    this.chartData=res.data.chartData
                    this.aircraftCount=res.data.airViewsData
                    this.engineCount=res.data.engViewsData
                    this.apuCount=res.data.apuViewsData
                    this.wantedCount=res.data.wantedViewsData
                })
            },
            getApu(){
                axios.get('/ajax/apu?resultPerPage=4&sortOrder=desc&sortName=id&fromSection=user' +
                    '&is_active_by_user=1&sortOrder=desc&paging=true').then(res=>{
                    this.apus=res.data.data
                })
            },
            getWanted(){
                axios.get('/ajax/wanted?resultPerPage=4&sortOrder=desc&sortName=id&fromSection=user&' +
                    'is_active=1&sortOrder=desc&paging=true').then(res=>{
                    this.wanteds=res.data.data
                })
            },
            getAircraft(){
                axios.get('/ajax/aircrafts?resultPerPage=4&sortName=id&fromSection=user' +
                    '&sortName=id&sortOrder=desc&is_active_by_user=1&i&paging=true').then(res=>{
                    this.aircrafts=res.data.data
                })
            },
            getEngine(){
                axios.get('/ajax/engine?resultPerPage=4&sortOrder=desc&fromSection=user' +
                    '&sortName=id&&is_active_by_user=1&sortOrder=desc&paging=true').then(res=>{
                    this.engines=res.data.data
                })
            },
            getLead(){
                axios.get('/ajax/lead?resultPerPage=7&sortOrder=desc'+
                    '&sortName=id&user=true&is_active=1&sortOrder=desc&paging=true').then(res=>{
                    this.leads=res.data.data
                })
            },
            getTitleByData(value){
                if(value){
                    let withFor = value.leadable_type.replace(/[-_.]/g,' ')
                    let whereIsForIndex
                    whereIsForIndex = withFor.indexOf('\\')
                    let model =(withFor.substring(whereIsForIndex+1)).toLocaleLowerCase()
                    if(['aircraft','engine','apu','wanted','news','event'].includes(model)){
                        return value.leadable.title
                    }else if(['company','airport'].includes(model)){
                        return value.leadable.name
                    }else{
                        return value.leadable.first_name+' '+value.leadable.last_name
                    }
                }
            }
        },
    }
    
    
    
    
</script>
<style scoped>
    .btn-adjust{
        margin-top: -25px;
    }
</style>


<template>
   <div v-if="$root.$data.createPermission && $root.$data.showPermission && $root.$data.editPermission">
       <div class="row">
           <div class="col-lg-4">
               <div class="widget be-loading">
                   <div class="widget-head">
                       <div class="title">Airbookers</div>
                   </div>
                   <admin-dashboard-pie-chart :data="pieChartData" v-if="chartLoad"></admin-dashboard-pie-chart>
                   <div class="chart-legend">
                       <table>
                           <tr>
                               <td>Free Plan</td>
                               <td class="chart-legend-value">{{pieChartData[0]}}</td>
                           </tr>
                           <tr>
                               <td>Personal Plan</td>
                               <td class="chart-legend-value">{{pieChartData[1]}}</td>
                           </tr>
                           <tr>
                               <td>Corporate Plan</td>
                               <td class="chart-legend-value">{{pieChartData[2]}}</td>
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
               <div class="card">
                   <div class="card-header card-header-divider">
                       <span class="title">New Users</span>
                       <span class="card-subtitle">New users based on monthly</span>
                   </div>
                   <div class="card-body">
                       <admin-dashboard-line-chart
                               :data="lineChartData"
                               v-if="chartLoad">
                       </admin-dashboard-line-chart>
                   </div>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark1"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Users</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeUser}}</span>
                           <span class="iindicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveUser}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark2"><canvas width="81" height="35" style="display: inline-block; width: 81px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Companies</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeCompany}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveCompany}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark3"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Contacts</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeContact}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveContact}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark4"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Total Assets</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeTotalAsset}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveTotalAsset}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark5"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Aircraft</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeAircraft}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveAircraft}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark6"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Engines</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeEngine}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveEngine}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark7"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">APU's</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeApu}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveApu}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark8"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Wanted</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeWanted}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveWanted}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark9"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Parts</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activePart}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActivePart}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark10"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Airports</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeAirport}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveAirport}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark11"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">News</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeNews}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveNews}}</span>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-12 col-lg-6 col-xl-3">
               <div class="widget widget-tile">
                   <div class="chart sparkline" id="spark12"><canvas width="85" height="35" style="display: inline-block; width: 85px; height: 35px; vertical-align: top;"></canvas></div>
                   <div class="data-info">
                       <div class="desc">Events</div>
                       <div class="value">
                           <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{activeEvent}}</span>
                           <span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                           <span class="number" data-toggle="counter" data-end="80">{{inActiveEvent}}</span>
                       </div>
                   </div>
               </div>
           </div>

       </div>
       <div class="row">
           <div class="col-md-12">
               <div class="card card-table">
                   <div class="card-header">Recent Airbookers

                   </div>
                   <div class="card-body">
                       <table class="table table-striped table-recent-airbookers">
                           <thead>
                           <tr>
                               <th>Name</th>
                               <th class="number">Email</th>
                               <th class="number">Company</th>
                               <th class="actions">Date</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr v-for="item in airbookers">
                               <td>
                                   <template v-if="item.contact">
                                       {{item.contact.first_name+' '+item.contact.last_name}}
                                   </template>
                               </td>
                               <td>{{item.email}}</td>
                               <td>
                                   <template v-if="item.contact">
                                       <template v-if="item.contact.company">
                                           {{item.contact.company.name}}
                                       </template>
                                   </template>

                               </td>
                               <td>
                                    {{item.created_at|moment('DD/MM/YYYY')}}
                               </td>
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
    import adminDashboardPieChart from '../../components/charts/adminDashboardPieChart.vue'
    import adminDashboardLineChart from '../../components/charts/adminDashbordLineChart.vue'

    export default {
        components:{
            adminDashboardPieChart:adminDashboardPieChart,
            adminDashboardLineChart:adminDashboardLineChart
        },
        data(){
            return{
                pieChartData:[],
                lineChartData:[],
                activeUser:0,
                inActiveUser:0,
                activeCompany:0,
                inActiveCompany:0,
                activeContact:0,
                inActiveContact:0,
                activeAircraft:0,
                inActiveAircraft:0,
                activeEngine:0,
                inActiveEngine:0,
                activeApu:0,
                inActiveApu:0,
                activeWanted:0,
                inActiveWanted:0,
                activePart:0,
                inActivePart:0,
                activeTotalAsset:0,
                inActiveTotalAsset:0,
                activeAirport:0,
                inActiveAirport:0,
                activeNews:0,
                inActiveNews:0,
                activeEvent:0,
                inActiveEvent:0,
                airbookers:[]
            }
        },
        created(){
            this.getDashBoardData()
            this.getairbookersData()
        },
        computed:{
            chartLoad(){
                if(this.pieChartData){
                    if(this.pieChartData.length){
                        return true
                    }
                }
            },
        },

        methods:{
            getDashBoardData(){
                axios.get('/admin/get-dashboard-data').then(res=>{
                        this.pieChartData=res.data.pieChartData
                        this.lineChartData=res.data.lineChartData
                        this.activeUser=res.data.activeUser
                        this.inActiveUser=res.data.inActiveUser
                        this.activeCompany=res.data.activeCompany
                        this.inActiveCompany=res.data.inActiveCompany
                        this.activeContact=res.data.activeContact
                        this.inActiveContact=res.data.inActiveContact
                        this.activeAircraft=res.data.activeAircraft
                        this.inActiveAircraft=res.data.inActiveAircraft
                        this.activeEngine=res.data.activeEngine
                        this.inActiveEngine=res.data.inActiveEngine
                        this.activeApu=res.data.activeApu
                        this.inActiveApu=res.data.inActiveApu
                        this.activeWanted=res.data.activeWanted
                        this.inActiveWanted=res.data.inActiveWanted
                        this.activePart=res.data.activePart
                        this.inActivePart=res.data.inActivePart
                        this.activeTotalAsset=res.data.activeTotalAsset
                        this.inActiveTotalAsset=res.data.inActiveTotalAsset
                        this.activeAirport=res.data.activeAirport
                        this.inActiveAirport=res.data.inActiveAirport
                        this.activeNews=res.data.activeNews
                        this.inActiveNews=res.data.inActiveNews
                        this.activeEvent=res.data.activeEvent
                        this.inActiveEvent=res.data.inActiveEvent
                })
            },
            getairbookersData(){
                axios.get('/admin/airbooker?resultPerPage=10&paging=true&sortOrder=desc&sortName=id&is_active=1').then(res=>{
                    this.airbookers=res.data.data
                })
            }


        },
        beforeUpdate(){

            $("#spark1").sparkline([20,18,16,14,2,10,5,6,8,7,10,20,15,12,13,14,15,20], {
                type: 'bar',
                height: '25',
                barColor: '#fbbc04'});
            $("#spark2").sparkline([25,14,12,15,13,5,2,10,5,6,8,7,10,20,15,12,13,14,15,20,6,5,1,2,3,4,8,7,8,6,3,2,5,7], {
                height: '25',
                lineColor: '#007f3f',
                type: 'discrete'});
            $("#spark3").sparkline([12,8,10,15,14,13,2,10,5,6,8,7,10,20,15,12,13,14,15,20,8,5,6,7,9,10,12,14,1,5,7,3,4], {
                type: 'line',
                lineColor: '#1144bf',
                fillColor: '#fff',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});
            $("#spark4").sparkline([2,10,5,6,8,7,10,20,15,12,13,14,15,20,3,5,7,8,9,10,25,1,14,3,12,8,6,17,9,10], {
                type: 'line',
                lineColor: '#06994d',
                fillColor: '#5590cc',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});
            $("#spark5").sparkline([5,6,12,8,10,15,14,13,2,7,9,10,12,14,1,5,7,3,4,10,5,6,8,7,10,20,15,12,13,14,15,20,8], {
                type: 'line',
                lineColor: '#1144bf',
                fillColor: '#fff',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});
            $("#spark6").sparkline([2,13,14,15,20,3,5,7,8,9,10,25,1,14,3,12,8,6,2,10,5,6,8,7,10,20,15,1,17,9,10], {
                type: 'line',
                lineColor: '#06994d',
                fillColor: '#5590cc',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});
            $("#spark7").sparkline([15,12,13,20,18,16,14,18,10,5,6,8,7,10,20,15,12,13,20,18,16,14,18,20,14,15,20], {
                type: 'bar',
                height: '25',
                barColor: '#8e5ea2'});
            $("#spark8").sparkline([10,20,15,12,13,14,15,20,6,5,1,2,3,4,8,7,8,6,25,14,12,15,13,5,2,10,5,6,8,7,3,2,5,7], {
                height: '25',
                lineColor: 'rgba(41, 171, 228)',
                type: 'discrete'});

            $("#spark9").sparkline([2,13,14,15,20,3,5,7,8,9,10,25,1,14,3,12,8,6,2,10,5,6,8,7,10,20,15,1,17,9,10], {
                type: 'line',
                lineColor: 'rgba(135, 31, 234)',
                fillColor: 'rgba(241, 90, 36)',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: 'red',
                maxSpotColor: 'rgba(135, 31, 234)'});
            $("#spark10").sparkline([10,5,6,8,7,10,20,15,12,13,20,18,16,14,18,20,14,15,20], {
                type: 'bar',
                height: '25',
                barColor: 'rgba(41, 171, 228)'});

            $("#spark11").sparkline([25,14,12,15,13,5,2,10,5,6,8,7,10,20,15,12,13,14,15,20,6,5,1,2,3,4,8,7,8,6,3,2,5,7], {
                height: '25',
                lineColor: '#007f3f',
                type: 'discrete'});

            $("#spark12").sparkline([12,8,10,15,14,13,2,10,5,6,8,7,10,20,15,12,13,14,15,20,8,5,6,7,9,10,12,14,1,5,7,3,4], {
                type: 'line',
                lineColor: '#1144bf',
                fillColor: '#fff',
                spotColor: '#005fbf',
                height: '25',
                minSpotColor: '#0000bf',
                maxSpotColor: '#00bfbf'});

        },
	    

    }
</script>

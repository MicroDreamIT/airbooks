<template>
    <div>
        <div class="modal-container modal-effect-1 modal-show cusmodal" id="nft-default" v-if="selectPromoteModal">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true">
                        <span class="mdi mdi-close" @click.prevent="closeSelectPromote()"></span>
                    </button>
                </div>
                <div class="text-center">
                    <p style="font-size: 18px;    line-height: 24px; font-weight: 600;"> {{title}}</p>
                    <hr>
                </div>
                <div class="modal-body">
                    <div class="row mx-auto">
                        <div class="col-md-6">
                            <div class="basicPlan">
                                <span>Basic   </span>
                                <span>Free</span> <br> <br>

                                <button @click.prevent="$emit('planStatus', {status:true,promote:false}), closeSelectPromote('goCreate')"
                                        class="btn btn-primary btn-space wizard-next basicPlanSelect">Select
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="PremiumPlan">
                                <span>Premium  </span>
                                <span>Paid</span>
                                    <br>
                                    <p v-if="points>99">{{countedPoints}} of Unlimited credit used</p>
                                    <p v-else>{{points-countedPoints}} of {{points<100?points:'Unlimited'}} credit available</p>
                                    <ul>
                                        <li><span class="mdi mdi-money"></span>Maximize Leads</li>
                                        <li><span class="mdi mdi-account-add"></span> Reach more people</li>
                                        <li><span class="mdi mdi-desktop-windows"></span> Premium Position on all pages</li>
                                        <li><span class="fa fa-newspaper"></span> Included in Global Newsletter </li>
                                    </ul>

                                    <template v-if="hasSubscription || nonSubscriptionUser">
                                        <button v-if="hasSubscription" @click.prevent="$emit('planStatus',{status:true,promote:true}),closeSelectPromote('goCreate')"
                                                class="btn btn-primary btn-space wizard-next basicPlanSelect">Select
                                        </button>
                                        <button v-if="hasSubscription==false || nonSubscriptionUser" @click.prevent="goPlanPage"
                                                class="btn btn-primary btn-space wizard-next basicPlanSelect">Go Plan
                                        </button>
                                    </template>
                                <div  v-else>
                                    <atom-spinner :color="'#4285f4'"></atom-spinner>
                                </div>





                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            title: {
                type: String,
                default: () => ''
            },
            listRoute: {
                type: String,
                default: () => ''
            },
            redirectUrl: {
                type: String,
                default: () => ''
            }
        },
        data() {
            return {
                selectPromoteModal: true,
                hasSubscription: null,
                planDetails:null,
                creditAvailable:0,
                points:0,
                countedPoints:0,
                nonSubscriptionUser:null,


            }
        },
        created(){
            this.getPlanDeatils()

        },
        methods: {
            closeSelectPromote(val) {
                this.selectPromoteModal = false
                val != 'goCreate'? this.$router.push({name: this.listRoute}) : null

            },
            goPlanPage() {
                this.closeSelectPromote()
                this.$router.push({name: 'userPromoteList',params:{redirectUrl:this.redirectUrl}})
            },
            getPlanDeatils(){
                axios.get('/user/ajax/get-plan-details',{
                    params:{
                        type:this.$route.path.replace('/','').split('/')[1]
                    }
                }).then(res=>{
                    this.planDetails=res.data.plan
                    if(this.planDetails){
                        let point = this.planDetails.points.filter(data=> data.points_type==this.$route.path.replace('/','').split('/')[1])[0]
                        this.points=point.number_points

                    }else{
                        this.nonSubscriptionUser=true
                    }
                    this.countedPoints=res.data.countData
                    if(this.points){
                        if(this.countedPoints<this.points){
                            this.hasSubscription=true
                        }else{
                            this.hasSubscription=false
                        }
                    }
                })
            }


        }

    }
</script>

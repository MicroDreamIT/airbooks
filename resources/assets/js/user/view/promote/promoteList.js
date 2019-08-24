export default {
    data(){
        return{
            counter: 0,
            card:{},
            planType:'monthly',
            planName:'free',
            currentPlan:'', //monthly, yearly
            leftPlan:{},
            centerPlan:{},
            rightPlan:{},
            count:0,
            date:new Date(),
            paymentDetails:{
                amount:'10',
                title:'asdfasf',
                product_names:'personal-monthly',
            },
            payTabInfo:null,
            countUpdate:0,

            corporateBtnShow:true,
            personalBtnShow:true,
            corporateCheckoutBtn:false,
            personalCheckoutBtn:false,
            paymentGetwaySetting:{
                settings: {
                    merchant_id: "10034946",
                    secret_key: "DqOE5IswKdWATei1ljtynBBXzU3Uoyu2YiG419AMmwmgLFi6YLEmngjWbnQAVkCUDjYEsyrP5N6QsoXq9CNwT6s5tjFoDiigBgV4",
                    amount: "",
                    currency: "USD",
                    title: "",
                    product_names: "Product1",
                    order_id: 1001,
                    url_redirect: "https://airbook.aero/user/payment-history",
                    display_customer_info: 1,
                    display_billing_fields: 0,
                    display_shipping_fields: 0,
                    language: "en",
                    redirect_on_reject: 0
                },
                billing_address:{
                    full_address: "Xbs, Aero",
                    city: "Aviation City",
                    state: "Dubai South - Business Park",
                    country: "ARE",
                    postal_code: "712430"
                },
            }


        }
    },

    computed:{
        loaded(){

            if(this.$root.$data.user.order_id){
                if(this.count<1) {
                    this.count++
                    this.getProductDeatilsByOrderId(this.$root.$data.user.order_id)
                }

                //Stripe
                // if(this.count<1){
                //     this.count++
                //     if(this.$root.$data.user.subscriptions){
                //         this.planName = this.$root.$data.user.subscriptions.length>0?this.$root.$data.user.subscriptions[0].name.split(' ')[0].toLowerCase():this.planName
                //         this.currentPlan = this.$root.$data.user.subscriptions.length>0? this.$root.$data.user.subscriptions[0].name.split(' ')[1].toLowerCase():''
                //         this.planType = this.currentPlan?this.currentPlan:'monthly'
                //
                //     }
                // }
                //
                // return this.$root.$data.user.id?true:false
            }

            return true

        }
    },


    created(){

        axios.get('/commercial/get-plan').then(response=>{
            this.leftPlan=response.data.leftPlan
            this.centerPlan=response.data.centerPlan
            this.rightPlan=response.data.rightPlan
        })

    },
    methods:{
        payTabs(planName){

            this.setPaymentSetting(planName)

            if(planName=='personal'){
                document.getElementById('personalBtn').click()
                this.personalBtnShow=false

            }else{
                document.getElementById('corporateBtn').click()
                this.corporateBtnShow=false

            }

            this.$nextTick(() => {
                this.initPaytabs()
            });
            this.$nextTick(() => {
                let checkout = document.getElementById('en_button')
                checkout.click()

            });


        },
        initPaytabs(){
            this.counter++;
            if(this.counter<2){
                Paytabs("#express_checkout").expresscheckout(this.paymentGetwaySetting);
            }

        },

        pay(planName){
            if (this.$root.$data.user.stripe_id == null || this.$root.$data.user.stripe_id == '') {
                this.planName=planName
                $('#myModal').modal('show')
            } else {
                this.submitRequest(planName)
            }


        },
        emitName(data){
            this.planName=data
        },
        emitType(data){
            this.currentPlan =data
        },
        generateOrderId(){
            let d =new Date();
            return d.getYear()+d.getMonth()+d.getDay()+d.getHours()+d.getMinutes()+d.getSeconds()+d.getMilliseconds()
        },
        submitRequest(planName){
            this.$root.$data.totalLoading=true

            axios.post('/payment/swap',{
                planName:this.planName,
                planType:this.planType
            })
                .then(res=>{
                    this.currentPlan = this.planType
                    this.planName = planName

                    // planName=='personal' && currentPlan==planType
                    this.$root.$data.totalLoading=false

                    this.$root.alertMessage({
                        type:'success', message:'Subscription has been changed successfully'
                    })
                    var url=this.$route.params.redirectUrl
                    console.log(url)
                    this.$router.push({name:url})
                })
                .catch(error=>{
                    // console.log(error.response.data.message);
                    this.$root.$data.totalLoading=false
                    this.$root.alertMessage({
                        type:'danger', message:error.response.data.message
                    })
                    window.location='/user/settings'
                })
        },

        setPaymentSetting(planName){
            let planAmount=0
            if(planName=='personal'){
                this.personalCheckoutBtn=true
                if(this.planType=='monthly'){
                    planAmount = this.centerPlan.price
                    this.paymentGetwaySetting.settings.order_id= 101
                }else{
                    planAmount = (this.centerPlan.price*12)-((this.centerPlan.price*12*10)/100)
                    this.paymentGetwaySetting.settings.order_id= 102
                }

            }else {
                this.corporateCheckoutBtn=true

                if(this.planType=='monthly'){
                    planAmount = this.rightPlan.price
                    this.paymentGetwaySetting.settings.order_id= 201
                }else {
                    planAmount = (this.rightPlan.price*12)-((this.rightPlan.price*12*25)/100)
                    this.paymentGetwaySetting.settings.order_id= 202
                }

            }

            this.paymentGetwaySetting.settings.amount=planAmount,
                this.paymentGetwaySetting.settings.title=this.$root.$data.user.contact.fullName,
                this.paymentGetwaySetting.settings.product_names=planName + '-' + this.planType

        },
        getProductDeatilsByOrderId(val){
            val=Number(val)
            switch (val){
                case 101:
                    this.planType ='monthly'
                    this.planName ='personal'
                    this.currentPlan ='monthly'
                    break;
                case 102:
                    this.planType ='yearly'
                    this.planName ='personal'
                    this.currentPlan ='yearly'
                    break;
                case 201:
                    this.planType ='monthly'
                    this.planName = 'corporate'
                    this.currentPlan ='monthly'
                    break;
                case 202:
                    this.planType='yearly'
                    this.planName= 'corporate'
                    this.currentPlan ='yearly'
                    break;
                default:

            }

        }

    }
}
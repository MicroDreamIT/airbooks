<template>
    <div  class="card pt-4 pb-4" >
            <div class="paymentSystem">
                <div class="header">
                    <h4>  Payment Details</h4>
                </div>
                <template v-if="history.order_id">
                    <div class="text-capitalize text-center p-2 ">your last payment information</div>
                    <div class="body">
                        <div class="left-top">
                            <div>Product Name: <strong>{{getProductName(history.order_id)}}</strong></div>
                            <div>Plan Type: <strong>{{productType}}</strong></div>
                            <div>Transaction ID: {{history.transaction_id}}</div>
                        </div>

                        <div class="right-top text-right">
                            <img src="/images/card.svg"   alt="image missing">
                            <div>Name:  <strong>{{history.customer_name}}</strong> </div>
                            <div>Email:  <strong>{{history.customer_email}}</strong> </div>
                            <div>Currency : <strong> {{history.transaction_currency}}</strong></div>
                        </div>
                    </div>
                    <div class="body middle">
                        <div class="left-top ">
                            <div class="capitalize">{{history.card_brand}}</div>
                            <div> **** **** **** {{history.last_4_digits}}</div>
                        </div>

                        <div class="right-top text-right">
                            <div>${{history.transaction_amount}}</div>
                            <div>{{history.trans_date|moment("MMM DD, YYYY")}}</div>
                        </div>
                    </div>
                    <div class="body info">
                        <div>
                            Thank you for your business. For any questions or comments, please contact us at <span style="color:blue">support@airbook.aero</span>  </div>
                        <div>
                            <p class="pt-3"> <img src="/images/logo.svg" width="120px" class="mx-auto"></p>
                        </div>
                    </div>
                </template>

                <template v-if="history.has">
                    <h4>No Payment History Found</h4>
                </template>

            </div>


       <!--<div class="col-md-6 mx-auto mt-1">-->
            <!--<div class="card  card-border-color">-->
                <!--<div class="card-header font-weight-bold">-->
                    <!--Payment Details <hr>-->
                <!--</div>-->
                <!--<div class="card-body payment">-->
                    <!--<p class="">Name: <strong>{{history.customer_name}}</strong></p>-->
                    <!--<p class="">Transaction ID:  <strong>{{history.transaction_id}}</strong></p>-->
                    <!--<p class="">Product Name:  <strong>{{getProductName(history.order_id)}}</strong></p>-->
                    <!--<p class="">Plan Type: <strong>{{productType}}</strong></p>-->
                    <!--<p class="">Currency : <strong> {{history.transaction_currency}}</strong></p>-->
                    <!--<p class="">Transaction Amount:  <strong>{{history.transaction_amount}}</strong></p>-->
                    <!--<p class="">Transaction Date: <strong>{{history.trans_date}}</strong> </p>-->
                <!--</div>-->
            <!--</div>-->

       <!--</div>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
              history:{
                  has:false
              },
                productType:''
            }
        },
        computed:{

        },
        created(){
          axios.get('/user/ajax/payment-history') .then(res=>{
              if(res.data.id){
                  this.history=res.data
              }else {
                  this.history.has=true
              }

          })
        },
        methods: {
            getProductName(val){
                val=Number(val)
                switch (val){
                    case 101:
                        this.productType='Monthly'
                        return 'Personal'
                        break;
                    case 102:
                        this.productType='Yearly'
                        return 'Personal'
                        break;
                    case 201:
                        this.productType='Monthly'
                        return 'Corporate'
                        break;
                    case 202:
                        this.productType='Yearly'
                        return 'Corporate'
                        break;
                    default:
                        this.productType=''
                }

            }


        }

    }
</script>

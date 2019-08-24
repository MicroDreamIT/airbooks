<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <form id="payment-form" >
                    <div class="form-row" >
                        <label for="card-element" class="card-element-title">
                            <span class="mdi mdi-card"></span>  Credit or debit card
                        </label>
                        <div id="card-element">  </div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                        
                    </div>
                    <button class="mt-2 btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "cardInformation",
        props:[
            'planName','planType','redirectUrl'
        ],
        mounted(){
            this.setupCreditCardForm()

        },
        methods:{
//2424 4242 4244 4442
            setupCreditCardForm(){

                const stripe = window.Stripe('pk_test_W2KUwqBuxRunx1a4pF1Unehs')
                const elements = stripe.elements()
                var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                }


                var card = elements.create('card', {style: style})
                this.card= card
                card.mount('#card-element')
                card.addEventListener('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
                var form = document.getElementById('payment-form');
                form.addEventListener('submit', event => {
                    event.preventDefault();

                    stripe.createToken(card).then(result => {
                        if (result.error) {
                            // Inform the user if there was an error.
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {

                            this.stripeTokenHandler(result.token);
                        }
                    });
                });

            },
            stripeTokenHandler(token) {
                console.log(token);
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                this.$root.$data.totalLoading=true
                if(this.$router.currentRoute.path=='/user/promote'){
                    axios.post('/payment/create-customer',{
                            token:token,
                            planName:this.planName,
                            planType:this.planType
                        }
                    ).then(res=>{
                        this.$emit('planNameSuccess', this.planName)
                        this.$emit('planTypeSuccess', this.planType)
                        $('#myModal').modal('hide')
                        this.$root.$data.totalLoading=false
                        this.$root.alertMessage({
                            type:'success', message:'Purchase Successful'
                        })
                        this.$router.push({name:this.redirectUrl})

                    }).catch(error=>{
                        var displayError = document.getElementById('card-errors');
                        if (event.error) {
                            displayError.textContent = event.error.message;
                        } else {
                            displayError.textContent = '';
                        }
                        this.$root.$data.totalLoading=false
                        this.$root.alertMessage({
                            type:'danger', message:error.response.data.message
                        })
                    })
                }else{
                    axios.post('/payment/create-or-update-customer', token).then(res=>{
                        this.$root.$data.totalLoading=false
                        this.$root.alertMessage({
                            type:res.data.message.type, message:res.data.message.message
                        })
                    }).catch(error=>{
                        this.$root.$data.totalLoading=false
                        this.$root.alertMessage({
                            type:'danger', message:error.response.data.message
                        })
                    })
                }
            },
        }
    }
</script>

<style scoped>
    #card-element{
        width: 100% !important;
    }
    .StripeElement {
        background-color: white;
        height: 40px;
        padding: 10px 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>

<template>
    <div v-if="loading" style="
    display: flex;
    justify-content: center;
    height: 300px;
    align-items: center;">
        <atom-spinner color="#068dff"></atom-spinner>
    </div>
    <div v-else>
        <div class="send-message-label"><span class="message-icon"></span> Message
            <template v-if="model.user && $root.$data.user">
                {{model.user.contact.first_name}}
            </template>
        </div>
        <div class="details-message-form-block w-form">
            <form id="wf-form-Asset-Contact"
                  @submit.prevent="postMail()"
                  name="wf-form-Asset-Contact"
                  data-name="Asset Contact"
                  class="asset-details-form">
                <textarea id="Message-2"
                          name="Message-2"
                          data-name="Message 2"
                          maxlength="5000"
                          placeholder="Write your Message here"
                          required
                          class="details-page-message-box w-input"
                          v-model="message"
                ></textarea>
                <input type="submit"
                       value="Send"
                       data-wait="Please wait..."
                       class="asset-details-button w-button" @click="hideModal()">
            </form>


            <div class="success-message w-form-done">
                <div>Thank you! Your message has been sent!</div>
            </div>
            <div class="w-form-fail">
                <div>Oops! Something went wrong. Please try again later.</div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "sendmail",
        props:['model', 'fromModal'],
        data(){
            return {
                message:'',
                loading:false
            }
        },
        mounted(){

        },
        methods:{
            hideModal(){
                if(this.fromModal){
                    this.$root.mailModalhide()
                }
            },
            postMail(){
                this.loading=true
                let url = '';
                if(this.$route.path==='/parts'){
                    url = '/user/ajax/front-email-parts'
                }else{
                    url = '/user/ajax/front-email'
                }
                axios.post(url,
                    {
                        modelData:this.model,
                        user:this.$root.$data.user,
                        message:this.message
                    })
                    .then(res=>{
                        this.$root.alertMessage(res.data)
                        this.message=''
                        this.loading=false
                    })
                    .catch(err=>{
                        this.$root.errorMessage(err.response.data)
                        this.loading=false
                    })

            },
        }
    }
</script>

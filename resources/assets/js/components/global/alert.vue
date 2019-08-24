<template>

    <div v-show="$root.$data.alert" id="alert_component">
        <div class="alert alert-success alert-dismissible"
             role="alert"
             v-show="$root.$data.alert.type=='success'">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
                <span class="mdi mdi-close" aria-hidden="true"></span>
            </button>
            <div class="icon"><span class="mdi mdi-check"></span></div>
            <div class="message">
                <strong>Success! </strong>{{this.$root.$data.alert.message}}
            </div>
        </div>

        <div class="alert alert-danger alert-dismissible"
             role="alert"
             v-show="$root.$data.alert.type=='danger'">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
                <span class="mdi mdi-close" aria-hidden="true"></span>
            </button>
            <div class="icon"><span class="mdi mdi-check"></span></div>
            <div class="message">
                <strong></strong>{{this.$root.$data.alert.message}}
            </div>
        </div>
        <div class="alert alert-info alert-dismissible"
             role="alert"
             v-show="$root.$data.alert.type=='info'">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
                <span class="mdi mdi-close" aria-hidden="true"></span>
            </button>
            <div class="icon"><span class="mdi mdi-check"></span></div>
            <div class="message">
                <strong>Info! </strong>{{this.$root.$data.alert.message}}
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible"
             role="alert"
             v-show="$root.$data.alert.type=='warning'">
            <button class="close" type="button" data-dismiss="alert" aria-label="Close" @click="closeAlert()">
                <span class="mdi mdi-close" aria-hidden="true"></span>
            </button>
            <div class="icon"><span class="mdi mdi-check"></span></div>
            <div class="message">
                <strong>Warning! </strong>{{this.$root.$data.alert.message}}
            </div>
        </div>
    </div>


</template>

<script>
    export default {
        name: "alert",
        methods:{
            closeAlert(){
                this.$root.$data.alert.type=null
                this.$root.$data.alert.message=null
            }
        }
    }
</script>

<style scoped>

    #alert_component .alert.alert-dismissible{
        position: fixed;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        max-width: 521px;
        top: 0;
        z-index: 100000;
    }

</style>
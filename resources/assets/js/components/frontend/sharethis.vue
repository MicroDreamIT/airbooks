<template>
    <div class="asset-details-social-block">
        <a :href="'https://www.facebook.com/sharer/sharer.php?u=https://airbook.aero'+$route.path+ '&display=popup'"
           class="asset-details-social-share" target="_blank">
            
        </a>
        <a :href="'https://twitter.com/share?url=https://airbook.aero'+ $route.path"
           class="asset-details-social-share" target="_blank">
            
        </a>
        <a :href="'https://www.linkedin.com/shareArticle?mini=true&url=https://airbook.aero'+ $route.path"
           class="asset-details-social-share" target="_blank">
            
        </a>
        <a :href="'https://api.whatsapp.com/send?phone=whatsappphonenumber&text=https://airbook.aero'+ $route.path"
           class="asset-details-social-share" target="_blank">
            
        </a>
        <a :href="'https://plusone.google.com/_/+1/confirm?hl=en&url=https://airbook.aero'+ $route.path"
           class="asset-details-social-share" target="_blank">
            
        </a>
    </div>
</template>

<script>
    export default {
        name: "sharethis"
    }
</script>

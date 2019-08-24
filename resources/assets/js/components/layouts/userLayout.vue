<template>
    <div>
        <user-header></user-header>
        <user-sidebar></user-sidebar>

        <div class="be-content ">
            <div class="main-content container-fluid">
                <router-view></router-view>
            </div>
        </div>
        <user-right-sidebar></user-right-sidebar>
    </div>
</template>

<script>
    import userHeader from './userLayoutPartial/header.vue';
    import userSidebar from './userLayoutPartial/sidebar.vue';
    import userContent from './userLayoutPartial/user-content.vue';
    import userRightSidebar from './userLayoutPartial/rightSidebar.vue';

    export default {
        components: {
            userHeader,
            userSidebar,
            userContent,
            userRightSidebar
        },

    }
</script>

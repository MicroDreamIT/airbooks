<template>
    <div>
        <admin-header></admin-header>
        <admin-sidebar></admin-sidebar>

        <div class="be-content ">
            <div class="main-content container-fluid">
                <router-view></router-view>
            </div>

        </div>
        <admin-right-sidebar></admin-right-sidebar>
        <!--<admin-content>

            <template slot="content">
                <slot name="aside"></slot>
                <slot name="content"></slot>
            </template>
        </admin-content>-->
    </div>
</template>

<script>
    import adminHeader from './adminLayoutPartial/header.vue';
    import adminSidebar from './adminLayoutPartial/sidebar.vue';
    import adminContent from './adminLayoutPartial/admin-content.vue';
    import adminRightSidebar from './adminLayoutPartial/rightSidebar.vue';

    export default {
        components: {
            adminHeader,
            adminSidebar,
            adminRightSidebar
        },

    }
</script>


<template>
    <slot name="head">
        <AppHead :title="head.title" />
    </slot>

    <sidebar
        :width="sidebar.width"
        :width-collapsed="sidebar.widthCollapsed"
        @on-collapse="onCollapse($event)"
    />

    <div class="min-vh-100 bg-gray-200" :style="getSidebarMarginStyle">
        <!-- Page Content -->
        <slot name="header">
            <Header :title="header.title" :description="header.description" />
        </slot>
        <main>
            <MDBContainer class="pt-4" style="padding-bottom: 3.8rem">
                <slot />
            </MDBContainer>
            <app-footer :style="getSidebarMarginStyle"></app-footer>
        </main>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Sidebar from '@/Layouts/Partials/Sidebar/Sidebar';
import HowItWorks from '@/Pages/Home/Partials/HowItWorks';
import LanguageSwitcher from '@/Layouts/Partials/LanguageSwitcher';
import AppFooter from '@/Layouts/Partials/AppFooter';
import Header from '@/Layouts/Partials/Header';
import AppHead from '@/Layouts/Partials/AppHead';

export default {
    components: {
        AppHead,
        Header,
        Sidebar,
        HowItWorks,
        Link,
        LanguageSwitcher,
        AppFooter,
    },

    props: {
        headerInfo: Object,
    },

    data() {
        return {
            sidebar: {
                collapsed: false,
                width: '300px',
                widthCollapsed: '70px',
            },
            header: {
                title: this.$helpers.getHeadersData(
                    this.$page.component,
                    this.headerInfo,
                ).title,
                description: this.$helpers.getHeadersData(
                    this.$page.component,
                    this.headerInfo,
                ).description,
            },
            head: {
                title: this.$helpers.getHeadersData(
                    this.$page.component,
                    this.headerInfo,
                ).title,
            },
        };
    },
    computed: {
        getSidebarMarginStyle() {
            return {
                'margin-left': this.sidebar.collapsed
                    ? this.sidebar.widthCollapsed
                    : this.sidebar.width,
            };
        },
    },

    methods: {
        onCollapse(event) {
            this.sidebar.collapsed = event.collapsed;
        },
    },
};
</script>

<style lang="scss">
@import 'resources/css/mdb';

.v-sidebar-menu {
    .vsm--toggle-btn,
    .vsm--mobile-bg,
    .vsm--item:hover {
        background-color: $primary !important;
    }

    .vsm--header {
        color: $primary;
    }
}
</style>

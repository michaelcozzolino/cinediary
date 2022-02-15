<template>
    <!--    <Head title="title"/>-->

    <sidebar :width="sidebar.width"
             :width-collapsed="sidebar.widthCollapsed"
             @on-collapse="onCollapse($event)"
    />

    <div class="min-vh-100 bg-gray-200" :style="getSidebarMarginStyle">
        <!-- Page Content -->
        <header>
            <div
                class="p-5 text-center bg-image"
                style="background-image: url('/css/images/header.jpg'); height: 300px;"
            >
                <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white">
                            <h1 class="mb-3">
                                <slot name="header-title"/>
                            </h1>
                            <h5 class="mb-3">
                                <slot name="header-description"/>
                            </h5>

                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main>

            <MDBContainer class="pt-4" style="padding-bottom: 3.8rem">
                <slot />

            </MDBContainer>
            <app-footer :style="getSidebarMarginStyle"></app-footer>
        </main>
    </div>


</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import SideNav from "@/Layouts/Partials/Sidebar";
import Sidebar from "@/Layouts/Partials/Sidebar";
import HowItWorks from "@/Pages/Home/Partials/HowItWorks";
import LanguageSwitcher from "@/Layouts/Partials/LanguageSwitcher";
import AppFooter from "@/Layouts/Partials/AppFooter";


export default {
    components: {
        Sidebar,
        HowItWorks,
        Link,
        SideNav,
        LanguageSwitcher,
        AppFooter
    },

    data() {

        return {
            sidebar: {
                collapsed: false,
                width: "300px",
                widthCollapsed: "70px",

            },
        }
    },
    computed:{

        getSidebarMarginStyle(){
            return {
                'margin-left': (this.sidebar.collapsed ? this.sidebar.widthCollapsed : this.sidebar.width),
            }
        },
    },

    methods:{

        onCollapse(event){
            this.sidebar.collapsed = event.collapsed;
        }
    }

}
</script>

<style lang="scss">
@import "~mdb-vue-ui-kit/src/scss/standard/bootstrap/functions";
@import "~mdb-vue-ui-kit/src/scss/standard/bootstrap/variables";
@import "~mdb-vue-ui-kit/src/scss/standard/bootstrap/mixins";

.v-sidebar-menu {

    .vsm--toggle-btn , .vsm--mobile-bg, .vsm--item:hover, {
        background-color: $primary !important;

    }


}

</style>



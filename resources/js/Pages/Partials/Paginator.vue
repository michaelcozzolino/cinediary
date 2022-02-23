<template>
    <MDBBtnGroup class="mb-4" v-if="paginator.links.length > 3" aria-label="paginator">
        <Link as="button" class="btn btn-primary ripple-surface" color="primary"
              :href="getPageUrl(this.paginator.links[0])"
              :disabled="isDisabled(this.paginator.links[0])"
              v-text="__('previous')"
        />
        <Link as="button" class="btn btn-primary ripple-surface active" :href="getActivePage.url" color="primary"
              v-text="getActivePage.label"/>

        <Link as="button" class="btn btn-primary ripple-surface" color="primary"
              :href="getPageUrl(this.paginator.links[linksLength - 1])"
              :disabled="isDisabled(this.paginator.links[linksLength - 1])"
              v-text="__('next')"
        />
    </MDBBtnGroup>
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "Paginator",
    components : {Link},
    props: {
        paginator: Object,
    },

    computed: {
        linksLength(){
            return this.paginator.links.length;
        },

        getActivePage() {
            let links = this.paginator.links;
            let linksLength = this.linksLength;

            for(let i = 0; i < linksLength; i++){
                let link = links[i];
                if(link.active) {
                    return link;

                }
            }
        }

    },

    methods: {
        getPageUrl(link) {
            return link.url ?? '#';
        },

        isDisabled(link) {
            return this.getPageUrl(link) === null;
        },

        getPageLabel(link) {
            return link.label;
        },



    }

}
</script>

<style scoped>
.btn-group {
    box-shadow: none !important;
}
</style>

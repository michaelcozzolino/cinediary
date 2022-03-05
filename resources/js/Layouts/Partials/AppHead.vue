<template>
    <Head>
        <link rel="icon" type="image/svg+xml" href="/images/favicon.svg" />
        <title>{{ this.getTitle }}</title>
        <meta name="description" :content="getDescription" />
    </Head>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
export default {
    components: { Head },
    props: {
        title: String,
    },

    computed: {
        getTitle() {
            if (this.title)
                return this.title + ' - ' + this.$helpers.getAppName();
            return this.$helpers.getAppName();
        },
        getDescription() {
            return this.__('cinediary_info.description');
        },
    },
};
</script>

<style scoped></style>

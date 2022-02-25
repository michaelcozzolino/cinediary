<script>
import { h } from 'vue';
import link from '@inertiajs/inertia-vue3/src/link';

export default {
    name: 'CustomLink',
    props: ['item'],
    render() {
        return h(link, this.$slots.default);
    },
    watch: {
        '$page.url'() {
            this.onRouteChange();
        },
    },
    inject: ['onRouteChange'],
};
</script>

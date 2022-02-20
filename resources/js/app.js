import {createApp, h} from 'vue';
import {createInertiaApp, Head} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import 'mdb-vue-ui-kit/css/mdb.min.css';

import 'jarallax/dist/jarallax.css';
import '@/Core/jarallax';

import VueSidebarMenu from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';
import {RegisterComponents} from "@/Core/RegisterComponents";
import {__} from "@/Core/Translator";

require("@/Core/Icons");
require('@/Core/bootstrap');
import helpers from "@/Core/helpers";
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const helpersPlugin = {
    install (app, options) {
        app.config.globalProperties.$helpers = helpers;
    }
};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const myApp = createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueSidebarMenu);

        RegisterComponents(myApp);

        return myApp.mixin({ methods: { route, __ }}).use(helpersPlugin)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

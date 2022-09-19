<template>
    <sidebar-menu
        class="bg-dark"
        :link-component-name="'custom-link'"
        @update:collapsed="onToggleCollapse"
        v-bind="sidebar"
        @item-click="onItemClick"
    />
</template>
<script>
import { Inertia } from '@inertiajs/inertia';
import { markRaw } from '@vue/reactivity';
import Logo from '@/Pages/Partials/Logo';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { usePage } from '@inertiajs/inertia-vue3';
import Separator from '@/Layouts/Partials/Separator';
import GuestAlert from '@/Layouts/Partials/Sidebar/Partials/GuestAlert';

export default {
    emits: ['OnCollapse'],

    props: {
        width: {
            type: String,
            required: true,
        },

        widthCollapsed: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            sidebar: {
                width: this.width,
                widthCollapsed: this.widthCollapsed,
                visible: true,
                collapsed: false,
                menu: [],
                onMobile: false,
            },
        };
    },

    mounted() {
        this.onResize();
        window.addEventListener('resize', this.onResize);
        this.setActiveItem();
    },

    created() {
        this.createMenu();
    },

    methods: {
        setActiveItem() {
            this.sidebar.menu.forEach((element) => {
                let isSearching =
                    (element.href === route('search.create') ||
                        element.href === route('search.index')) &&
                    this.$page.url.startsWith('/search');

                element.class =
                    element.href === window.location.href || isSearching
                        ? 'vsm--link_active'
                        : '';
            });
        },

        onItemClick(event, item) {
            if (item.title === this.__('Logout')) Inertia.post(route('logout'));
        },
        onToggleCollapse(collapsed) {
            this.sidebar.collapsed = collapsed;
            this.$emit('OnCollapse', { collapsed });
        },

        onResize() {
            if (window.innerWidth <= 976) {
                this.sidebar.isOnMobile = true;
                this.sidebar.collapsed = true;
            } else {
                this.sidebar.isOnMobile = false;
                this.sidebar.collapsed = false;
            }

            this.$emit('OnCollapse', { collapsed: this.sidebar.collapsed });
        },

        createMenuItem(href, title, icon) {
            return { href, title, icon };
        },

        getDiaryItemIcon(diaryName, iconClass = ['px-2']) {
            return {
                element: markRaw(FontAwesomeIcon),
                class: iconClass,
                attributes: {
                    icon:
                        diaryName === 'to watch'
                            ? 'eye'
                            : diaryName === 'Favourite'
                            ? 'heart'
                            : diaryName === 'Watched'
                            ? 'film'
                            : 'book-open',
                },
            };
        },

        createDiaryMenuItems() {
            let diaries = [
                {
                    header: this.__('Your main diaries'),
                    hiddenOnCollapse: true,
                },
            ];
            let mainDiaries = [];

            let userDiaries = this.$helpers.getUser().diaries;

            for (let userDiaryIndex in userDiaries) {
                let userDiary = userDiaries[userDiaryIndex];

                if (userDiary.type !== null) {
                    let diaryName = userDiary.name;
                    let href = route('diaries.movies.index', {
                        diary: userDiary.id,
                    });
                    let title = this.__(diaryName);
                    let icon = this.getDiaryItemIcon(diaryName);
                    mainDiaries.push(this.createMenuItem(href, title, icon));
                }
            }

            return diaries.concat(mainDiaries);
        },

        createMenu() {
            let logoItem = {
                component: markRaw(Logo),
                hiddenOnCollapse: true,
            };
            if (this.$helpers.needsAuthentication()) {
                let main = [
                    logoItem,
                    {
                        header:
                            this.__('Welcome') +
                            ', ' +
                            this.$helpers.getUser().name,
                        hiddenOnCollapse: true,
                    },
                    {
                        href: route('dashboard'),
                        title: this.__('Dashboard'),
                        icon: {
                            element: markRaw(FontAwesomeIcon),
                            class: 'px-2',
                            attributes: { icon: 'chart-line' },
                        },
                    },
                ];

                let other = [
                    {
                        component: markRaw(Separator),
                    },

                    {
                        href: route('diaries.index'),
                        title: this.__('Manage diaries'),
                        icon: {
                            element: markRaw(FontAwesomeIcon),
                            class: 'px-2',
                            attributes: { icon: 'book' },
                        },
                    },

                    {
                        href: route('search.create'),
                        title: this.__('Add movies or TV series'),
                        icon: {
                            element: markRaw(FontAwesomeIcon),
                            class: 'px-2',
                            attributes: { icon: 'search-plus' },
                        },
                    },

                    {
                        header: this.__('Other'),
                        hiddenOnCollapse: true,
                    },
                    {
                        href: route('settings.index'),
                        title: this.__('Settings'),
                        icon: {
                            element: markRaw(FontAwesomeIcon),
                            class: 'px-2',
                            attributes: { icon: 'cog' },
                        },
                    },
                    {
                        href: undefined,
                        title: this.__('Logout'),
                        icon: {
                            element: markRaw(FontAwesomeIcon),
                            class: 'px-2',
                            attributes: { icon: 'sign-out-alt' },
                        },
                    },
                ];

                this.sidebar.menu = main.concat(
                    this.createDiaryMenuItems(),
                    other,
                );
            } else {
                let alert = {
                    component: markRaw(GuestAlert),
                    hiddenOnCollapse: true,
                };
                this.sidebar.menu = [logoItem, alert];
            }
        },
    },
};
</script>

<style scoped></style>

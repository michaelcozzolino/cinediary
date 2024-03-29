<template>
    <authenticated :header-info="{ diary }">
        <!--    buttons and search section        -->
        <MDBRow class="pb-2 text-center">
            <MDBCol>
                <MDBInput
                    :formOutline="false"
                    :input-group="true"
                    aria-label="Example text with two button addons"
                    type="text"
                    id="search"
                    wrapper-class="mb-3"
                    class="form-icon-trailing"
                    :placeholder="getFindBarPlaceholder"
                    @input="this.find()"
                    v-model="findQuery"
                >
                    <span class="input-group-text" id="search-addon">
                        <font-awesome-icon icon="search" class="trailing" />
                    </span>

                    <template #prepend>
                        <MDBBtn
                            v-for="(tab, tabId) in tabs"
                            :color="tab.color"
                            @click="
                                this.$inertia.get(
                                    route('diaries.' + tabId + '.index', {
                                        diary: diary.id,
                                    }),
                                )
                            "
                            v-text="tab.title"
                        />
                    </template>
                </MDBInput>
            </MDBCol>
        </MDBRow>

        <screenplays v-if="hasScreenplays" class="d-flex text-center">
            <screenplay
                @on-delete="currentDiary.delete($event)"
                v-for="screenplay in this.currentDiary.getScreenplays()"
                :screenplay="screenplay"
                :current-diary="this.currentDiary"
                :md="'3'"
                removable
            >
                <template v-slot:title>{{ screenplay.title }}</template>
            </screenplay>

            <MDBRow>
                <MDBCol class="d-flex justify-content-center">
                    <Paginator :paginator="this.currentDiary.getPaginator()" />
                </MDBCol>
            </MDBRow>
        </screenplays>

        <alert v-else>
            <template #message
                >{{ getNotFoundMessage }}
                <a
                    class="here fw-bold"
                    style="color: inherit; text-decoration: underline"
                    :href="route('search.index')"
                    v-text="this.__('here')"
                />!
            </template>
        </alert>
    </authenticated>
</template>

<script>
import Authenticated from '@/Layouts/Authenticated';
import Screenplays from '@/Pages/Partials/Screenplays/Screenplays';
import Screenplay from '@/Pages/Partials/Screenplays/Screenplay';
import { usePage } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import Paginator from '@/Pages/Partials/Paginator';

class Diary {
    constructor(data) {
        for (let property in data) {
            console.log(property);
            this[property] = data[property];
        }
    }

    getId() {
        return this.diary.id;
    }

    getPaginator() {
        return this['screenplays'][this.getScreenplayType()];
    }

    getScreenplays() {
        // data property will be available if there is a paginator
        return this['screenplays'][this.getScreenplayType()].hasOwnProperty(
            'data',
        )
            ? this['screenplays'][this.getScreenplayType()].data
            : this['screenplays'][this.getScreenplayType()];
    }

    setScreenplays(screenplays) {
        this['screenplays'] = screenplays;
    }

    getScreenplayType() {
        return this.screenplayType;
    }

    getScreenplaysLength() {
        return this.getScreenplays().length;
    }

    getScreenplayRoute(screenplayId) {
        // console.log(screenplayId);
        // console.log(22);
        // if (this.getScreenplaysType() === "movies")
        //     return route('movies.show', {'movie': screenplayId});
        // else if (this.getScreenplaysType() === "series")
        //     return route('series.show', {'series': screenplayId});

        return '#';
    }

    /* returns the index of a screenplay in the diary, given an id */
    getScreenplayIndex(id) {
        let screenplays = this.getScreenplays();
        return Object.keys(screenplays).find(
            (key) => screenplays[key].id === id,
        );
    }

    getRoute(action, parameters = {}) {
        return route(
            'diaries.' + this.getScreenplayType() + '.' + action,
            parameters,
        );
    }
}

import { reactive } from 'vue';
import Alert from '@/Pages/Partials/Alert';

export default {
    components: {
        Alert,
        Paginator,
        Screenplay,
        Screenplays,
        Authenticated,
        Diary,
        Link,
    },
    props: {
        screenplays: Object,
        diary: Object, // this is the diary returned by the ScreenplaysTrait
        paginator: Object,
        query: String, //query returned from the get request after the screenplays have been found
    },

    data() {
        return reactive({
            // this is the diary object that manages the diary in the frontend
            currentDiary: new Diary({
                diary: this.diary,
                screenplays: reactive(this.screenplays),
                screenplayType: usePage().props.value.screenplayType,
            }),

            tabs: {
                movies: { title: this.__('Movies'), color: 'primary' },
                series: { title: this.__('TV series'), color: 'primary' },
            },

            activeTab: null,
            findQuery: this.query, // query that the user inputs to find a screenplay in his diary
        });
    },

    mounted() {
        this.activeTab = this.currentDiary.getScreenplayType();
        this.tabs[this.activeTab].color = 'success';
    },

    computed: {
        hasScreenplays() {
            return this.currentDiary.getScreenplaysLength();
        },
        getFindBarPlaceholder() {
            return this.__(
                'Find ' +
                    this.currentDiary.getScreenplayType() +
                    ' in this diary',
            );
        },
        getNotFoundMessage() {
            return this.__(
                'No ' +
                    this.currentDiary.getScreenplayType() +
                    ' found, you can add them',
            );
        },
    },

    methods: {
        find: _.debounce(function () {
            let route = this.currentDiary.getRoute('index', {
                query: this.findQuery,
                diary: this.currentDiary.getId(),
            });

            this.$inertia.visit(route, {
                preserveState: false,
                only: ['screenplays', 'query'],
            });
        }, 750),
    },
};
</script>

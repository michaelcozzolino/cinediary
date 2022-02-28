<template>
    <authenticated>
        <h6
            class="text-muted text-uppercase"
            v-show="lastQuery !== undefined"
            v-text="this.__('Your last search')"
            style="font-size: 14px; font-weight: 600"
        />

        <form @submit.prevent="search.search(this.getSearchedScreenplays)">
            <MDBInput
                :input-group="true"
                :formOutline="false"
                wrapperClass="mb-3"
                v-model="search.form.query"
                @input="search.form.clearErrors('query')"
                :placeholder="this.__('Search for movies or TV series')"
                aria-label="query"
                aria-describedby="query"
                id="query"
            >
                <MDBBtn
                    color="primary"
                    type="submit"
                    id="search-button"
                    :ripple="{ color: 'dark' }"
                >
                    <font-awesome-icon icon="search" />
                    {{ this.__('Search') }}
                </MDBBtn>
            </MDBInput>
            <validation-error :error="search.form.errors.query" />
        </form>

        <MDBTabs :model-value="search.activeTabId" v-if="search.hasSearched()">
            <!-- Tabs navs -->
            <MDBTabNav fill tabsClasses="mb-3">
                <MDBTabItem
                    tabId="movies"
                    href="movies"
                    v-text="this.__('Movies')"
                />
                <MDBTabItem
                    tabId="series"
                    href="series"
                    v-text="this.__('TV series')"
                />
            </MDBTabNav>
            <!-- Tabs navs -->
            <!-- Tabs content -->
            <MDBTabContent>
                <MDBTabPane tabId="movies">
                    <screenplays
                        class="d-flex text-center"
                        v-if="search.hasMovies()"
                    >
                        <screenplay
                            v-for="movie in search.getMovies()"
                            :screenplay="movie"
                            :md="'3'"
                            screenplay-type="movies"
                        >
                        </screenplay>
                    </screenplays>

                    <alert v-else>
                        <template #message>
                            {{ this.__('No movies matching your search') }}!
                        </template>
                    </alert>
                </MDBTabPane>
                <MDBTabPane tabId="series">
                    <screenplays
                        class="d-flex text-center"
                        v-if="search.hasSeries()"
                    >
                        <screenplay
                            v-for="series in search.getSeries()"
                            :screenplay="series"
                            :md="'3'"
                            screenplay-type="series"
                        >
                            <template v-slot:title>{{ series.title }}</template>
                        </screenplay>
                    </screenplays>

                    <alert v-else>
                        <template #message>
                            {{ this.__('No TV series matching your search') }}!
                        </template>
                    </alert>
                </MDBTabPane>
            </MDBTabContent>
            <!-- Tabs content -->
        </MDBTabs>
    </authenticated>
</template>

<script>
import Authenticated from '@/Layouts/Authenticated';
import Screenplay from '@/Pages/Partials/Screenplays/Screenplay';
import Screenplays from '@/Pages/Partials/Screenplays/Screenplays';
import { reactive } from 'vue';
import ValidationError from '@/Pages/Partials/ValidationError';
import Alert from '@/Pages/Partials/Alert';

class Search {
    constructor(data) {
        for (let property in data) {
            if (data.hasOwnProperty(property)) this[property] = data[property];
        }
    }

    getScreenplays() {
        return this['screenplays'];
    }

    setScreenplays(screenplays) {
        this['screenplays'] = screenplays;
    }
    getMovies() {
        if (this.getScreenplays().hasOwnProperty('movies'))
            return this.getScreenplays()['movies'];
        return {};
    }

    getSeries() {
        if (this.getScreenplays().hasOwnProperty('series'))
            return this.getScreenplays()['series'];
        return {};
    }

    /* it checks the length of an object  */
    has(object) {
        if (object) return Object.keys(object).length;
        return 0;
    }

    hasMovies() {
        return this.has(this.getMovies());
    }

    hasSeries() {
        return this.has(this.getSeries());
    }

    /* it checks if a search has been performed,
     * if true, the screenplays object has to contain the single arrays for movies & series */
    hasSearched() {
        return this.has(this.getScreenplays()); //non vero
    }

    search(callback) {
        this['form'].post(route('search.make'), {
            preserveScroll: true,
            onSuccess: () => this.setScreenplays(callback()),
        });
    }
}

export default {
    components: {
        Alert,
        ValidationError,
        Authenticated,
        Screenplay,
        Screenplays,
    },

    props: {
        screenplays: Object, // the screenplays returned from the search
        lastQuery: String,
        errors: Object,
    },
    data() {
        return {
            search: new Search(
                reactive({
                    screenplays: this.screenplays ?? {},
                    activeTabId: 'movies',
                    form: this.$inertia.form({
                        query: this.lastQuery ?? '',
                    }),
                }),
            ),
        };
    },

    methods: {
        getSearchedScreenplays() {
            return this.screenplays;
        },
    },
};
</script>

<style scoped></style>

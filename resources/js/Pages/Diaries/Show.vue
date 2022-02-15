<template>

    <authenticated>
        <template #header-title>{{header.title}}</template>
        <template #header-description>{{header.description}}</template>

        <!--    buttons and search section        -->
        <MDBRow class="pb-2 text-center" >
            <MDBCol>
                <MDBInput
                    :formOutline="false"
                    :input-group="true"
                    aria-label="Example text with two button addons"
                    type="text"
                    id="search"
                    wrapper-class="mb-3"
                    class="form-icon-trailing"
                    :placeholder="'Find ' + this.currentDiary.getScreenplayType() + ' in your diary'"
                    @input="this.currentDiary.find($event)"
                >

                         <span class="input-group-text" id="search-addon">
                                <font-awesome-icon icon="search" class="trailing"/>
                            </span>

                    <template #prepend>
                        <MDBBtn v-for="(tab, tabId) in tabs"
                                :color="tab.color"
                                @click="this.$inertia.get(route('diaries.' + tabId +'.index', {'diary': diary.id }))"
                        >
                            {{ __(tab.title) }}
                        </MDBBtn>
                    </template>
                </MDBInput>
            </MDBCol>
        </MDBRow>



        <screenplays v-if="hasScreenplays"  class="d-flex text-center">
            <screenplay v-if="!this.currentDiary.isFinding()" @on-delete="currentDiary.delete($event)"
                        v-for="screenplay in this.currentDiary.getScreenplays()"
                        :screenplay="screenplay"
                        :id="screenplay.id"
                        :diary-id="diary.id"
                        :href="currentDiary.getScreenplayRoute(screenplay.id)"
                        :md="'3'" :poster-path="screenplay.posterPath"
                        with-delete-button
            >
                <template v-slot:title>{{screenplay.title}}</template>
            </screenplay>

            <!--    find section    -->
            <screenplay v-else v-for="screenplay in this.currentDiary.settings.found.screenplays"
                        :href="currentDiary.getScreenplayRoute(screenplay.id)"
                        :md="'3'" :poster-path="screenplay.posterPath">
                <template v-slot:title>{{screenplay.title}}</template>
            </screenplay>

            <Paginator :paginator="this.currentDiary.getPaginator()"/>

        </screenplays>

        <alert v-else>
            <template #message>
                {{ __('No ' + this.currentDiary.getScreenplayType() +' found, you can add them') }}
                <a class="here"
                   style="color: inherit; text-decoration: underline;"
                   :href="route('search.index')"><strong>{{ __('here') }}</strong>
                </a>!

            </template>
        </alert>




    </authenticated>
</template>

<script>

// import Diary from "@/components/Diary";
import Authenticated from "@/Layouts/Authenticated";
import Screenplays from "@/Pages/Partials/Screenplays/Screenplays";
import Screenplay from "@/Pages/Partials/Screenplays/Screenplay";
import { usePage } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import Paginator from "@/Pages/Partials/Paginator";
class Diary{

    constructor(data) {
        for (let property in data) {
            console.log(property);
            this[property] = data[property];
        }

    }


    getId(){
        return this.id;
    }

    getPaginator(){
        return this['screenplays'][this.getScreenplayType()];
    }
    getScreenplays(){
        // data property will be available if there is a paginator
        return this['screenplays'][this.getScreenplayType()].hasOwnProperty('data') ?
            this['screenplays'][this.getScreenplayType()].data :
            this['screenplays'][this.getScreenplayType()];
    }

    setScreenplays(screenplays){
        this['screenplays'] = screenplays;
    }

    getSettings(){
        return this['settings'];
    }

    getScreenplayType(){
        return this.getSettings()['screenplays']['type'];
    }

    isFinding(){
        return this.getSettings()['found']['isFinding'];
    }

    getScreenplaysLength(){
        return this.getScreenplays().length;
    }

    getScreenplayRoute(screenplayId){
        // console.log(screenplayId);
        // console.log(22);
        // if (this.getScreenplaysType() === "movies")
        //     return route('movies.show', {'movie': screenplayId});
        // else if (this.getScreenplaysType() === "series")
        //     return route('series.show', {'series': screenplayId});

        return "#";
    }

    find = _.debounce((event) => {

        if(!this.settings.found.isFinding)
            this.settings.found.isFinding = true;

        let query = event.target.value;

        if(query.length === 0){
            this.settings.found.isFinding = false;
            this.settings.found.screenplays = [];
        } else {
            this.settings.found.screenplays = this.getScreenplays().filter((screenplay) => {
                if(screenplay.title.toLowerCase().indexOf(query) !== -1)
                    return screenplay;

            });
        }
    },150);

    /* returns the index of a screenplay in the diary, given an id */
    getScreenplayIndex(id){
        let screenplays = this.getScreenplays();
        return Object.keys(screenplays).find((key) => screenplays[key].id === id);

    }

    delete(event){
        console.log(event);
        let screenplayBindName = this.getScreenplayType() === "movies" ? "movie" : this.getScreenplayType;
        let parameters = { diary: this.getId() };
        let screenplayId = event.id;
        parameters[screenplayBindName] = screenplayId;
        console.log(this.getRoute("destroy", parameters));
        Inertia.delete(this.getRoute("destroy", parameters), {
            preserveScroll: true,
            onSuccess: () => {
                let deleted = usePage().props.value.flash.message;
                this['screenplays'][this.getScreenplayType()].data.splice(this.getScreenplayIndex(screenplayId),1);

            }
        });

    };

    getRoute(action, parameters = {}){
        return route("diaries." + this.getScreenplayType() + "." + action , parameters);
    }

}

import {reactive} from "vue"
import {Inertia} from "@inertiajs/inertia";
import Alert from "@/Pages/Partials/Alert";
export default {
    components: {Alert, Paginator, Screenplay, Screenplays, Authenticated, Diary, Link},
    props: {
        screenplays: Object,
        diary: Object, // this is the diary returned by the ScreenplaysTrait
        paginator: Object

    },

    data(){
        return {
            // this is the diary object that manages the diary in the frontend
            currentDiary: new Diary(reactive({
                id: this.diary.id,
                settings: {
                    screenplays: {
                        type: usePage().props.value.screenplayType,

                    },

                    title: {
                        class: ['text-dark'],
                        text: 'Upcoming Movies'
                    },
                    // settings used to find screenplays in a given diary
                    found: {
                        isFinding: false,
                        screenplays: [],
                    },
                },
                screenplays: this.screenplays,


            })),


            tabs: {
                movies: { title: "Movies", color: "primary"},
                series: { title: "TV Series", color: "primary" },
            },
            activeTab: null

        }
    },

    mounted() {
        this.activeTab = this.currentDiary.getScreenplayType();
        this.tabs[this.activeTab].color= "success";
    },

    computed:{


        header(){
            return {
                'title' : this.diary.name,
                'description': this.diary.description
            }
        },

        hasScreenplays(){
            return this.currentDiary.getScreenplaysLength();// || this.searchData.screenplays.length();
        }


    },

    methods:{
        search: _.debounce(function(event){

            if(!this.searchData.isSearching)
                this.searchData.isSearching = true;

            let query = event.target.value;

            if(query.length === 0){
                this.searchData.isSearching = false;
                this.searchData.screenplays = [];
            }


            this.searchData.screenplays = this.screenplays[this.screenplayType].data.filter((screenplay) => {
                if(screenplay.title.toLowerCase().indexOf(query) !== -1)
                    return screenplay;

            });

        },150),


    },
}
</script>

<style scoped>

</style>

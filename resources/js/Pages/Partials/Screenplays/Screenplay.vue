<template xmlns="http://www.w3.org/1999/html">

    <MDBCol :id="this.screenplay.id" :sm="'6'" :md="md"  class="mb-4 text-center">

        <MDBCard class="h-100" >
<!--      TO-DO: create screenplays show page      -->
            <a href="route" v-mdb-ripple="{ color: 'light' }">
                <MDBCardImg :src="getPosterPath" top alt="..." />
            </a>
            <MDBCardBody>
                <MDBCardTitle class="fw-bold">
                    <div class="title" v-text="screenplay.title" />

                    <div class="mt-2 text-muted float-start text-sm" v-text="getFurtherData" >

                    </div>

                </MDBCardTitle>
            </MDBCardBody>

            <MDBCardFooter class="w-100">
                <MDBBtnGroup vertical aria-label="Button group with nested dropdown">

                    <remove-from-diary
                        v-if="removable"
                        :href="getHref"
                        :screenplay-id="screenplay.id"
                        :screenplay-type="getScreenplayType"
                        :current-diary-id="currentDiary.getId()"
                    />

                    <add-to-diary
                                  :screenplay-id="screenplay.id"
                                  :screenplay-type="getScreenplayType"
                                  :href="getHref"
                    />

                </MDBBtnGroup>
            </MDBCardFooter>
        </MDBCard>

    </MDBCol>

</template>

<script>
import { mdbRipple } from "mdb-vue-ui-kit";
import Dropdown from "../../../Core/Dropdown";
import {usePage} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";
import AddToDiary from "@/Pages/Partials/Screenplays/Partials/AddToDiary";
import RemoveFromDiary from "@/Pages/Partials/Screenplays/Partials/RemoveFromDiary";

export default {

    directives: {
        mdbRipple
    },

    components: {
        RemoveFromDiary,
        AddToDiary
    },

    props: {
        screenplay: { type: Object, required: true },
        currentDiary: Object,
        screenplayType: String,
        md: String,
        removable: Boolean,

    },

    emits: ['OnDelete'],
    data(){
        return {
            dropdown:false,
            newAddedToDiaryScreenplaysIds : {movies: [], series: []},



        }
    },

    methods: {

    },

    computed: {

        // screenplayType is not present when searching for a screenplay by using TMDB api in Search.vue
        // because the route doesn't have a movies or series binding, in that case we pass the screenplayType as props
        // else we get the screenplayType from the currentDiary that uses the shared inertia data
        getScreenplayType(){
            return this.currentDiary ? this.currentDiary.getScreenplayType() : this.screenplayType;
        },

        getPosterPath(){
            return this.screenplay.posterPath === "" ? "/css/images/reel.png" : this.screenplay.posterPath;
        },

        getFurtherData(){
            return this.screenplay.genre ?
                this.screenplay.genre + ', ' + this.screenplay.releaseDate :
                this.screenplay.releaseDate
        },

        getHref(){
            return "#" + this.screenplay.id;
        },
    }


}
</script>

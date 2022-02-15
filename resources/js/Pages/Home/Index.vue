<template>
<!-- to-do RENAME APP TO HOME    -->
    <guest>
        <template v-slot:main>

            <how-it-works></how-it-works>
            <popular id="popular-movies" title="movies" start="start" end="end" />
            <popular id="popular-series" title="series" end="start" start="end" />
            <section class="statistics bg-info text-center fs-1 fw-bold">
                <statistics></statistics>
            </section>

        </template>
    </guest>
</template>

<script>
import AppFooter from "../../Layouts/Partials/AppFooter";
import HowItWorks from "@/Pages/Home/Partials/HowItWorks";
import Statistics from "@/Pages/Home/Partials/Statistics";
import Jarallax from "@/Pages/Partials/Jarallax";
import SectionTitle from "@/Pages/Partials/SectionTitle";
import Guest from "@/Layouts/Guest";
import Popular from "@/Pages/Home/Partials/Popular";

export default {
    components: {
        Popular,
        Guest, Jarallax, AppFooter, HowItWorks, Statistics, SectionTitle},
    props: {
        user: Object
    },

    data() {

        return {

            upcomingMoviesDiary: {
                settings: {
                    screenplays: {
                        type: 'movies',
                    },
                    jarallax: {
                        imageUrl: null
                    },
                    title: {
                        class: ['text-dark'],
                        text: 'Upcoming Movies'
                    }
                },
                screenplaysRows: [],
            }

        }
    },



    created() {
    },

    methods: {


    }


}
</script>

<style>
@import 'https://use.fontawesome.com/releases/v5.15.1/css/all.css';
/* possible fix for an unwated strange margin for rows*/
.row{
    margin-right: 0;
}
</style>

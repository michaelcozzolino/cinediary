<template>
        <jarallax v-if="popular.screenplays.length" speed="0.2" :image-src="popular.backgroundImageUrl">

            <section-title :title-class="['text-uppercase']">
                <template #title>{{ __('popular') + ' ' + __(title) }}</template>
            </section-title>
            <MDBContainer class="text-center py-4">

                <screenplays  v-for="(screenplaysRow,index) in popular.screenplays"
                              :class="'d-flex justify-content-' + ((index + 1) % 2 === 0 ? start : end)">
                    <screenplay v-for="screenplay in screenplaysRow"
                                :screenplay="screenplay"
                                :md="'3'"
                                />
                </screenplays>
            </MDBContainer>
        </jarallax>
</template>

<script>
import Jarallax from "@/Pages/Partials/Jarallax";
import SectionTitle from "@/Pages/Partials/SectionTitle";
import Screenplays from "@/Pages/Partials/Screenplays/Screenplays";
import Screenplay from "@/Pages/Partials/Screenplays/Screenplay";

export default {
    components : {Jarallax, SectionTitle, Screenplays, Screenplay},

    props: {
        title: {
            type: String,
            required: true,
        },

        start: {
            type: String,
            required: true,
        },
        end: {
            type: String,
            required: true,
        }

    },

    data(){
        return {
            popular: { screenplays: [], backgroundImageUrl: null },
            // screenplaysCategories: {
            //     upcomingMovies: { screenplays: [], backgroundImageUrl: null},
                // popularTvSeries: { screenplays: [], backgroundImageUrl: null},

            }

        },

    created() {
        let popularScreenplaysRoute = null;
        if(this.title === 'movies')
            popularScreenplaysRoute = 'popular-movies';
        else if(this.title === 'series')
            popularScreenplaysRoute = 'popular-tv-series';

        if(popularScreenplaysRoute !== null){
            axios.get(route(popularScreenplaysRoute)).then((result) => {
                let data = result.data;
                this.popular.screenplays = data.screenplays;
                this.popular.backgroundImageUrl = data.randomBackdropPath;

                // console.log(this.popular.screenplays);
                // let randomNumber = _.random(0, this.popular.screenplays.length);
                // console.log(this.popular.screenplays[randomNumber]);
                // this.popular.backgroundImageUrl =
                //     this.popular.screenplays[randomNumber]['backdropPath'];
                // this.popular.screenplays =
                //     _.chunk(this.popular.screenplays, 2);
            })
            .catch((error) =>{
                console.log(error);
            });
        }

    },
}
</script>

<style scoped>

</style>

<template xmlns="http://www.w3.org/1999/html">
    <!--    <Head title="Dashboard" />-->

    <authenticated>
        <screenplays
            v-for="(screenplays, screenplayType) in lastWatchedScreenplaysData"
            v-show="screenplays.length"
        >
            <h3
                class="text-dark"
                v-text="getLastWatchedTitle(screenplayType)"
            />
            <screenplay
                v-for="screenplay in screenplays"
                :screenplay="screenplay"
                :screenplay-type="screenplayType"
                :md="'3'"
            />
        </screenplays>

        <MDBRow class="mb-4">
            <h3
                class="text-dark"
                v-text="this.__('Movies and TV series you watched by letter')"
            />
            <MDBCol>
                <div id="letters-bar-chart" />
            </MDBCol>
        </MDBRow>

        <MDBRow>
            <h3
                class="text-dark"
                v-text="this.__('Total Movies and TV series you watched')"
            />
            <MDBCol>
                <div id="watched-screenplays-percentage-chart" />
            </MDBCol>
        </MDBRow>

        <MDBRow>
            <h3
                class="text-dark"
                v-text="this.__('Total genres you watched')"
            />
            <MDBCol>
                <div id="watched-genres-percentage-chart" />
            </MDBCol>
        </MDBRow>
    </authenticated>
</template>

<script>
import Authenticated from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Chart } from 'frappe-charts/dist/frappe-charts.esm';
import 'frappe-charts/src/css/charts.scss';
import SectionTitle from '@/Pages/Partials/SectionTitle';
import Screenplays from '@/Pages/Partials/Screenplays/Screenplays';
import Screenplay from '@/Pages/Partials/Screenplays/Screenplay';
export default {
    components: {
        Screenplay,
        Screenplays,
        SectionTitle,
        Authenticated,
        Head,
    },

    props: {
        chartData: Object,
        lastWatchedScreenplaysData: Object,
    },

    data() {
        return {
            lettersBarChart: {
                data: {
                    labels: Object.keys(
                        this.chartData['lettersBarChart']['movies'],
                    ),
                    datasets: [
                        {
                            name: 'Movies',
                            values: this.getLettersBarChartValues('movies'),
                            chartType: 'bar',
                        },
                        {
                            name: 'Series',
                            values: this.getLettersBarChartValues('series'),
                            chartType: 'bar',
                        },
                    ],
                },
                chart: null,
            },

            watchedScreenplaysPercentageChart: {
                data: {
                    labels: Object.keys(
                        this.chartData['watchedScreenplaysPercentageChart'],
                    ),
                    datasets: [
                        {
                            values: [
                                this.chartData[
                                    'watchedScreenplaysPercentageChart'
                                ]['movies'],
                                this.chartData[
                                    'watchedScreenplaysPercentageChart'
                                ]['series'],
                            ],
                        },
                    ],
                },
                chart: null,
            },
            watchedGenresPercentageChart: {
                data: {
                    labels: Object.keys(
                        this.chartData['watchedGenresPercentageChart'],
                    ),
                    datasets: [
                        {
                            values: Object.values(
                                this.chartData['watchedGenresPercentageChart'],
                            ),
                        },
                    ],
                },
                chart: null,
            },
        };
    },

    mounted() {
        this.lettersBarChart.chart = new Chart('#letters-bar-chart', {
            data: this.lettersBarChart.data,
            type: 'bar',
            height: 250,
            colors: ['#64B5F6', '#0D47A1'],
        });

        this.watchedScreenplaysPercentageChart.chart = new Chart(
            '#watched-screenplays-percentage-chart',
            {
                data: this.watchedScreenplaysPercentageChart.data,
                type: 'percentage',
                height: 180,
                colors: ['#64B5F6', '#0d47a1'],
            },
        );

        this.watchedGenresPercentageChart.chart = new Chart(
            '#watched-genres-percentage-chart',
            {
                data: this.watchedGenresPercentageChart.data,
                type: 'percentage',
                height: 180,
                // colors: ['#64B5F6', '#0d47a1'],
            },
        );
    },

    methods: {
        getLettersBarChartValues(screenplayType) {
            return Object.values(
                this.chartData['lettersBarChart'][screenplayType],
            );
        },
        getLastWatchedTitle(screenplayType) {
            let value =
                screenplayType === 'movies' ? screenplayType : 'TV series';
            return this.__('Last watched ' + value);
        },
    },
};
</script>

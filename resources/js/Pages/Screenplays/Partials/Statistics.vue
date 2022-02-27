<template>
    <MDBRow v-for="statisticsRow in getStatistics">
        <MDBCol md="6" sm="12" v-for="statistic in statisticsRow">
            <h4 class="fw-bold text-uppercase text-dark my-4">
                <font-awesome-icon :icon="statistic.icon" />
                {{ this.__(statistic.name) }}
            </h4>
            <h4 class="fw-bold text-dark mb-4" v-text="statistic.value" />
        </MDBCol>
    </MDBRow>
</template>

<script>
export default {
    props: {
        statistics: {
            type: Object,
            required: true,
        },
    },

    computed: {
        getStatistics() {
            return [
                [
                    {
                        name: this.__('Watchers'),
                        value: this.statistics.watchers,
                        icon: 'film',
                    },
                    {
                        name: this.__('Lovers'),
                        value: this.statistics.lovers,
                        icon: 'heart',
                    },
                ],
                [
                    {
                        name: this.__('Future watchers'),
                        value: this.statistics.futureWatchers,
                        icon: 'eye',
                    },
                    {
                        name: this.__('Containing diaries'),
                        value: this.statistics.containingDiariesNumber,
                        icon: 'book',
                    },
                ],
            ];
        },
    },
};
</script>

<style scoped></style>

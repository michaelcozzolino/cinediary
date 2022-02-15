<template>
        <section-title :title-class="['text-uppercase']">
            <template #title>Statistics</template>
        </section-title>
        <MDBContainer>

            <MDBRow>
                <MDBCol md="3" v-for="statistic in statistics">
                    <h4 class="fw-bold text-uppercase text-dark my-4" v-text="statistic.name"/>
                    <h4 class="fw-bold text-dark mb-4" v-text="statistic.value"/>
                </MDBCol>
            </MDBRow>
        </MDBContainer>
</template>
<script>
import SectionTitle from "../../Partials/SectionTitle";
export default {
    components: {SectionTitle},
    data() {
        return {
            statistics: {
                registeredUsers: {"name": "Registered Users", "value": 0},
                createdDiaries: {"name": "Created Diaries", "value": 0},
                trackedMovies: {"name": "Tracked Movies", "value": 0},
                trackedSeries: {"name": "Tracked TV Series", "value": 0},
            }
        }
    },


    created() {
        axios.get(route('statistics')).then((result) => {
            let data = result.data;

            this.statistics.registeredUsers.value = data.registeredUsers;
            this.statistics.createdDiaries.value = data.createdDiaries;
            this.statistics.trackedMovies.value = data.trackedMovies;
            this.statistics.trackedSeries.value = data.trackedSeries;
        }).catch((error) => {
            console.log(error);
        });
    }


}
</script>
<style scoped>

</style>

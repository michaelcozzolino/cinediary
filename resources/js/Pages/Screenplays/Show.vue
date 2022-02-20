<template>
    <authenticated>
        <template #header>
            <Header :title="screenplay.title"
                    :image-url="screenplay.backdropPath"
                    :description="screenplay.overview"
                    :height="600"
            />
        </template>

        <MDBRow class="row text-center" >
            <MDBCol md="3" sm="8">
                <info :screenplay="screenplay" />
            </MDBCol>
            <MDBCol md="9" sm="4">
                <statistics :statistics="statistics" />
            </MDBCol>

<!--       TODO: add actors section     -->
        </MDBRow>

    </authenticated>
</template>

<script>
import Authenticated from "@/Layouts/Authenticated";
import Header from "@/Layouts/Partials/Header";
import Poster from "@/Pages/Screenplays/Partials/Poster";
import Info from "@/Pages/Screenplays/Partials/Info";
import SectionTitle from "@/Pages/Partials/SectionTitle";
import Statistics from "@/Pages/Screenplays/Partials/Statistics";
export default {

    components: {Statistics, SectionTitle, Info, Poster, Header, Authenticated},

    props: {
        screenplay: {
            type: Object,
            required: true,
        },
        statistics: {
            type: Object,
            required: true,
        },

    },

    computed: {

    }
}
</script>

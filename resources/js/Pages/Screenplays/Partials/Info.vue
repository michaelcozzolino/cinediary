<template>
    <MDBTable class="bg-white">
        <thead>
            <tr class="text-light bg-dark text-uppercase">
                <th colspan="2" class="fw-bold" v-text="screenplay.title" />
            </tr>
            <tr>
                <th colspan="2">
                    <poster :image-url="screenplay.posterPath" />
                </th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="field in info">
                <td
                    class="text-light bg-dark text-uppercase"
                    v-text="field.key"
                />
                <td v-text="field.value" />
            </tr>
        </tbody>
    </MDBTable>
</template>

<script>
import SectionTitle from '@/Pages/Partials/SectionTitle';
import Poster from '@/Pages/Screenplays/Partials/Poster';
export default {
    components: { Poster, SectionTitle },

    props: {
        screenplay: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            info: [
                /* TODO: add more fields (see wikipedia) */
                {
                    key: this.__('Original title'),
                    value: this.screenplay.originalTitle,
                },
                {
                    key: this.__('Year'),
                    value: this.screenplay.releaseDate,
                },
                {
                    key: this.__('Runtime'),
                    value: this.screenplay.runtime,
                },
                {
                    key: this.__('Genre'),
                    value: this.screenplay.genre,
                },
            ],
        };
    },
};
</script>

<style scoped>
th img {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>

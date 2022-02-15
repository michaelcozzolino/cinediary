<template>
    <authenticated>
        <template #header-title>
            {{ __('settings') }}
        </template>
        <template #header-description>
            {{__('manage your settings here')}}
        </template>

        <form @submit.prevent="update">
            <MDBInput
                type="password"
                :label="this.__('TMDB API key')"
                aria-describedby="tmdb-api-key"
                :formText="this.__('You can use your TMDB API key instead of using the Cinediary\'s one to speed up your searches. We do not store this key as plain text') + '.'"
                v-model="form.TMDBApiKey"
            />
            <div v-if="errors.TMDBApiKey">{{ errors.TMDBApiKey }}</div>
            <MDBSwitch wrapper-class="my-4"
                       :label="this.__('Include adult content to be found')"
                       v-model="form.adultContent"
            />
            <div class="d-grid gap-2 col-6 mx-auto">
                <MDBBtn type="submit" color="primary" v-text="this.__('save')"/>
            </div>
        </form>
    </authenticated>
</template>

<script>
import Authenticated from "@/Layouts/Authenticated";
export default {

    components: {Authenticated},
    props: {
        settings: Object,
        errors: Object,
    },

    data(){
        return {
            form: this.$inertia.form({
                TMDBApiKey: '',
                adultContent: false,
            }),
        }
    },

    created() {
        this.form.TMDBApiKey = this.settings.TMDBApiKey;
        this.form.adultContent = this.settings.adultContent > 0;
    },

    methods: {
        update(){
            this.form.patch(route('settings.update'))
        }
    }
}
</script>

<style scoped>

</style>

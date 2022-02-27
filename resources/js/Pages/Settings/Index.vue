<template>
    <authenticated>
        <form @submit.prevent="update">
            <MDBInput
                type="password"
                :label="this.__('TMDB API key')"
                aria-describedby="tmdb-api-key"
                :formText="
                    this.__(
                        'You can use your TMDB API key instead of using the Cinediary\'s one to speed up your searches. We do not store this key as plain text',
                    ) + '.'
                "
                v-model="form.TMDBApiKey"
            />
            <validation-error :error="errors.TMDBApiKey" />

            <MDBSwitch
                wrapper-class="my-4"
                :label="this.__('Include NSFW content to be found')"
                v-model="form.adultContent"
            />
            <validation-error :error="errors.adultContent" />

            <div class="d-grid gap-2 col-6 mx-auto">
                <MDBBtn
                    type="submit"
                    color="primary"
                    v-text="this.__('Save')"
                />
            </div>
        </form>
    </authenticated>
</template>

<script>
import Authenticated from '@/Layouts/Authenticated';
import ValidationError from '@/Pages/Partials/ValidationError';
export default {
    components: { ValidationError, Authenticated },
    props: {
        settings: Object,
        errors: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                TMDBApiKey: '',
                adultContent: false,
            }),
        };
    },

    created() {
        this.form.TMDBApiKey = this.settings.TMDBApiKey;
        this.form.adultContent = this.settings.adultContent > 0;
    },

    methods: {
        update() {
            this.form.patch(route('settings.update'));
        },
    },
};
</script>

<style scoped></style>

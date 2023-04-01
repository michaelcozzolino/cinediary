<template>
    <authenticated>
        <form @submit.prevent="update">
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
                adultContent: false,
            }),
        };
    },

    created() {
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

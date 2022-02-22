<template>
    <modal ref="forgotPassword"
           id="forgot-password"
           centered
           @on-close="close()"
           :title-class="['text-uppercase']"
           static-backdrop
    >
        <template #title>
            {{ __('forgot password') }}
        </template>

        <template #body>
            <MDBInput @input="form.clearErrors()" wrapper-class="mb-3" v-model="form.email"  :label="__('email')" type="email" required/>
            <validation-error :error="form.errors.email"/>
        </template>

        <template #footer>
            <form @submit.prevent="submit()">
                <MDBBtn type="submit" color="primary" v-text="__('email password reset link')" :disabled="form.processing" />
                <div class="my-2 text-sm text-success" v-if="status" v-text="status" />
            </form>
        </template>
    </modal>
</template>

<script>

import Modal from "@/Pages/Partials/Modal";
import ValidationError from "@/Pages/Partials/ValidationError";

export default {
    components: {
        ValidationError,
        Modal,
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },


    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        },
        resetForm(){
            if(!this.form.processing) {
                this.form.reset();
                this.form.clearErrors();
            }
        },

        open(){
            this.$refs['forgotPassword'].open();
        },

        close(){
            this.resetForm();
            this.$inertia.reload({ only: ['status'] });
        },
    },

}
</script>

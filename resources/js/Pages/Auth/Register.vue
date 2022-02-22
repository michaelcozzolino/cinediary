<template>
    <modal ref="registerModal"
           id="register-modal"
           centered
           @on-close="resetForm()"
           :title-class="['text-uppercase']"
    >
        <template #title>
            {{ __('register') }}
        </template>

        <template #body>
            <MDBInput @input="form.clearErrors('name')" wrapper-class="mb-3" v-model="form.name"  :label="__('name')" type="text" required/>
            <validation-error :error="form.errors.name"/>

            <MDBInput @input="form.clearErrors('email')" wrapper-class="mb-3" v-model="form.email"  :label="__('email')" type="email" required/>
            <validation-error :error="form.errors.email"/>

            <MDBInput @input="form.clearErrors('password')" wrapper-class="mb-3" v-model="form.password" :label="__('password')" type="password" required/>
            <MDBInput @input="form.clearErrors('password_confirmation')" wrapper-class="mb-3" v-model="form.password_confirmation" :label="__('confirm password')" type="password" required />

            <validation-error :error="form.errors.password"/>
            <validation-error :error="form.errors.password_confirmation"/>
            <!--  TODO: checkbox for terms and conditions acceptance          -->
            <!--  <MDBCheckbox :label="__('terms')" v-model="form.terms" :disabled="form.processing"/>-->

        </template>

        <template #footer>
            <form @submit.prevent="submit()">
                <MDBBtn type="submit" color="primary" v-text="__('sign up')" :disabled="form.processing"/>

            </form>
        </template>
    </modal>

</template>

<script>

import {
    MDBBtn,
    MDBCheckbox,
} from 'mdb-vue-ui-kit';
import ValidationError from "@/Pages/Partials/ValidationError";
import Modal from "@/Pages/Partials/Modal";

export default {

    components: {
        Modal,
        ValidationError,
        MDBBtn,
        MDBCheckbox,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {

        submit() {
            this.form.post(this.route('register'), {
                onStart: () => this.close(),
                onError: () => this.open(),
                onFinish: () => this.form.reset('password', 'password_confirmation')
            })
        },

        open(){
            this.$refs['registerModal'].open();
        },

        close(){
            this.$refs['registerModal'].close()
        },

        resetForm(){
            if(!this.form.processing) {
                this.form.reset();
                this.form.clearErrors();
            }
        }
    }
}
</script>






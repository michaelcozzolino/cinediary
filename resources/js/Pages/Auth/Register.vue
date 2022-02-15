<template>
    <MDBModal
        id="registerModal"
        tabindex="-1"
        labelledby="registerModalTitle"
        v-model="registerModalOpen"
        centered
        @hide="this.hide()"
    >
        <MDBModalHeader>
            <MDBModalTitle class="text-uppercase fw-bold" id="registerModalTitle" v-text="__('register')"/>
        </MDBModalHeader>
        <form @submit.prevent="submit()">
            <MDBModalBody>

                <MDBInput @input="form.clearErrors('name')" wrapper-class="mb-3" v-model="form.name"  :label="__('name')" type="text" required/>
                <validation-error :error="form.errors.name"/>

                <MDBInput @input="form.clearErrors('email')" wrapper-class="mb-3" v-model="form.email"  :label="__('email')" type="email" required/>
                <validation-error :error="form.errors.email"/>

                <MDBInput @input="form.clearErrors('password')" wrapper-class="mb-3" v-model="form.password" :label="__('password')" type="password" required/>
                <MDBInput @input="form.clearErrors('password_confirmation')" wrapper-class="mb-3" v-model="form.password_confirmation" :label="__('confirm password')" type="password" required />

                <validation-error :error="form.errors.password"/>
                <validation-error :error="form.errors.password_confirmation"/>

<!--                <MDBCheckbox :label="__('terms')" v-model="form.terms" :disabled="form.processing"/>-->

            </MDBModalBody>
            <MDBModalFooter>
                <MDBBtn type="submit" color="primary" v-text="__('sign up')" :disabled="form.processing"/>
            </MDBModalFooter>
        </form>
    </MDBModal>
</template>

<script>

import {
    MDBModal,
    MDBModalHeader,
    MDBModalTitle,
    MDBModalBody,
    MDBModalFooter,
    MDBBtn,
    MDBCheckbox,
} from 'mdb-vue-ui-kit';
import ValidationError from "@/Pages/Partials/ValidationError";

export default {

    components: {
        ValidationError,
        MDBModal,
        MDBModalHeader,
        MDBModalTitle,
        MDBModalBody,
        MDBModalFooter,
        MDBBtn,
        MDBCheckbox,
    },


    data() {
        return {
            registerModalOpen: false,
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
                onStart: () => {
                    this.use();

                },
                onError: () => this.use(),
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        },

        use(){
            this.registerModalOpen = !this.registerModalOpen
        },

        hide(){
            if(!this.form.processing) {
                this.form.reset();
                this.form.clearErrors();
            }
        }


    }
}
</script>






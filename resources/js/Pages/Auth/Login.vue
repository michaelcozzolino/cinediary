<template>
    <MDBModal
        id="loginModal"
        tabindex="-1"
        labelledby="loginModalTitle"
        v-model="loginModalOpen"
        centered
        @hide="this.hide"
    >
        <MDBModalHeader>
            <MDBModalTitle class="text-uppercase fw-bold" id="loginModalTitle" v-text="__('login')"/>
        </MDBModalHeader>
        <form @submit.prevent="submit()">
            <MDBModalBody>

                <MDBInput @input="form.clearErrors()" wrapper-class="mb-3" v-model="form.email"  :label="__('email')" type="email" required/>
                <MDBInput @input="form.clearErrors()" wrapper-class="mb-3" v-model="form.password" :label="__('password')" type="password" required/>
                <validation-error :error="form.errors.email"/>
                <MDBCheckbox :label="__('remember me')" v-model="form.remember" />

            </MDBModalBody>
            <MDBModalFooter>
                <MDBBtn type="submit" color="primary" v-text="__('sign in')" :disabled="form.processing"/>
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
            loginModalOpen: false,
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {

        submit() {
            this.form.post(this.route('login'), {
                onStart: () => {
                    this.use();

                },
                onError: () => this.use(),
                onFinish: () => this.form.reset('password') ,

            })

        },

        use(){
            this.loginModalOpen = !this.loginModalOpen
        },

        /*
        * I don't care that the password is on clear, because it's a demo user
        * */
        loginDemo(){
            this.use();
            this.form.email = 'demo@demo.demo';
            this.form.password = '@demo-password@';
            this.form.remember = true;
            this.submit();
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

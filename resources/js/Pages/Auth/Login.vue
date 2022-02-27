<template>
    <modal
        ref="loginModal"
        id="login-modal"
        centered
        @on-close="resetForm()"
        :title-class="['text-uppercase']"
    >
        <template #title>
            {{ this.__('Login') }}
        </template>

        <template #body>
            <MDBInput
                @input="form.clearErrors()"
                wrapper-class="mb-3"
                v-model="form.email"
                :label="this.__('Email')"
                type="email"
                required
            />
            <MDBInput
                @input="form.clearErrors()"
                wrapper-class="mb-3"
                v-model="form.password"
                :label="this.__('Password')"
                type="password"
                required
            />
            <validation-error :error="form.errors.email" />
            <MDBCheckbox
                :label="this.__('Remember me')"
                v-model="form.remember"
            />
        </template>

        <template #footer>
            <form @submit.prevent="submit()">
                <MDBBtn
                    type="submit"
                    color="primary"
                    v-text="this.__('Sign in')"
                    :disabled="form.processing"
                />
            </form>
            <MDBBtn
                color="primary"
                v-text="this.__('Forgot your password?')"
                :disabled="form.processing"
                @click="this.$emit('OnForgotPasswordButtonClick')"
            />
        </template>
    </modal>
</template>

<script>
import { MDBBtn, MDBCheckbox } from 'mdb-vue-ui-kit';
import ValidationError from '@/Pages/Partials/ValidationError';
import Modal from '@/Pages/Partials/Modal';
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
        Modal,
        ValidationError,
        MDBBtn,
        MDBCheckbox,
        Link,
    },

    emits: ['OnForgotPasswordButtonClick'],

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onStart: () => this.close(),
                onError: () => this.open(),
                onFinish: () => this.form.reset('password'),
            });
        },

        open() {
            this.$refs['loginModal'].open();
        },

        close() {
            this.$refs['loginModal'].close();
        },

        /*
         * I don't care that the password is on clear, because it's a demo user
         * */
        demoLogin() {
            this.form.email = 'demo@demo.demo';
            this.form.password = '@demo-password@';
            this.form.remember = true;
            this.submit();
        },

        resetForm() {
            if (!this.form.processing) {
                this.form.reset();
                this.form.clearErrors();
            }
        },
    },
};
</script>

<template>
    <modal
        ref="resetPasswordModal"
        id="reset-password-modal"
        centered
        static-backdrop
        @on-close="resetForm()"
        :title-class="['text-uppercase']"
    >
        <template #title>
            {{ this.__('Reset Password') }}
        </template>

        <template #body>
            <MDBInput
                @input="form.clearErrors('email')"
                wrapper-class="mb-3"
                v-model="form.email"
                :label="this.__('Email')"
                type="email"
                required
            />
            <validation-error :error="form.errors.email" />

            <MDBInput
                @input="form.clearErrors('password')"
                wrapper-class="mb-3"
                v-model="form.password"
                :label="this.__('Password')"
                type="password"
                required
            />
            <MDBInput
                @input="form.clearErrors('password_confirmation')"
                wrapper-class="mb-3"
                v-model="form.password_confirmation"
                :label="this.__('Confirm Password')"
                type="password"
                required
            />

            <validation-error :error="form.errors.password" />
            <validation-error :error="form.errors.password_confirmation" />
        </template>

        <template #footer>
            <form @submit.prevent="submit()">
                <MDBBtn
                    type="submit"
                    color="primary"
                    v-text="this.__('Reset Password')"
                    :disabled="form.processing"
                />
            </form>
        </template>
    </modal>
</template>

<script>
import Modal from '@/Pages/Partials/Modal';
import ValidationError from '@/Pages/Partials/ValidationError';

export default {
    components: {
        ValidationError,
        Modal,
    },

    props: {
        email: String,
        token: String,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            }),
        };
    },

    mounted() {
        if (this.$page.url.startsWith('/reset-password')) this.open();
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () =>
                    this.form.reset('password', 'password_confirmation'),
            });
        },

        open() {
            this.$refs['resetPasswordModal'].open();
        },

        close() {
            this.$refs['resetPasswordModal'].close();
        },

        resetForm() {
            if (!this.form.processing) {
                this.form.reset();
                this.form.clearErrors();
                this.$inertia.visit(route('home'));
            }
        },

        passwordReset() {
            /* TODO: maybe i will use it to show that the password has been changed after automatic login */
            return this.status === 'Your password has been reset!';
        },
    },
};
</script>

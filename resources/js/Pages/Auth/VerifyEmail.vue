<template>
    <modal
        ref="verifyEmailModal"
        id="verify-email-modal"
        centered
        static-backdrop
        @on-close="logout()"
        :title-class="['text-uppercase']"
    >
        <template #title>
            {{ this.__('Thanks for signing up!') }}
        </template>

        <template #body>
            <span
                v-text="
                    this.__(
                        'Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
                    )
                "
            />
        </template>
        <!--  TODO: improve html email template       -->
        <template #footer>
            <form @submit.prevent="submit()">
                <MDBBtn
                    type="submit"
                    color="primary"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </MDBBtn>
                <div
                    class="my-2 text-sm text-success"
                    v-if="verificationLinkSent"
                    v-text="
                        this.__(
                            'A new verification link has been sent to the email address you provided during registration.',
                        )
                    "
                />
            </form>
        </template>
    </modal>
</template>

<script>
import Modal from '@/Pages/Partials/Modal';

export default {
    components: {
        Modal,
    },

    props: {
        status: String,
        mustVerifyEmail: Boolean,
    },

    data() {
        return {
            form: this.$inertia.form(),
        };
    },

    mounted() {
        this.open(); // called when the user access the website when already logged in without having the email verified
    },

    updated() {
        this.open(); //called when the user logs in without having the email verified
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'));
        },

        logout() {
            this.$inertia.post(route('logout'));
        },

        open() {
            if (this.mustVerifyEmail) this.$refs['verifyEmailModal'].open();
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        },
    },
};
</script>

<style scoped>
.btn-close {
    visibility: hidden;
}
</style>

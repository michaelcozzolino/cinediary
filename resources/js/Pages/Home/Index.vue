<template>
    <guest>
        <template #main>
            <!--   auth components            -->
            <register ref="register" />
            <verify-email
                :status="status"
                :must-verify-email="mustVerifyEmail"
            />

            <login
                @on-forgot-password-button-click="
                    this.openModal('forgot-password')
                "
                ref="login"
            />
            <forgot-password ref="forgot-password" :status="status" />
            <reset-password
                @on-password-reset="this.openModal('login')"
                ref="reset-password"
                :email="email"
                :token="token"
                :status="status"
            />

            <how-it-works
                @on-button-click="this.openModal($event.refName)"
                @on-demo-login="this.$refs['login'].demoLogin()"
            />
            <popular
                screenplay-type="movies"
                id="popular-movies"
                title="movies"
                start="start"
                end="end"
            />
            <popular
                screenplay-type="series"
                id="popular-series"
                title="series"
                end="start"
                start="end"
            />
            <section class="statistics bg-info text-center fs-1 fw-bold">
                <statistics></statistics>
            </section>
        </template>
    </guest>
</template>

<script>
import AppFooter from '../../Layouts/Partials/AppFooter';
import HowItWorks from '@/Pages/Home/Partials/HowItWorks';
import Statistics from '@/Pages/Home/Partials/Statistics';
import Jarallax from '@/Pages/Partials/Jarallax';
import SectionTitle from '@/Pages/Partials/SectionTitle';
import Guest from '@/Layouts/Guest';
import Popular from '@/Pages/Home/Partials/Popular';
import VerifyEmail from '@/Pages/Auth/VerifyEmail';
import ForgotPassword from '@/Pages/Auth/ForgotPassword';
import Register from '@/Pages/Auth/Register';
import Login from '@/Pages/Auth/Login';
import ResetPassword from '@/Pages/Auth/ResetPassword';

export default {
    components: {
        ResetPassword,
        Login,
        Register,
        ForgotPassword,
        VerifyEmail,
        Popular,
        Guest,
        Jarallax,
        AppFooter,
        HowItWorks,
        Statistics,
        SectionTitle,
    },
    props: {
        user: Object,
        status: String,
        mustVerifyEmail: Boolean,
        email: String,
        token: String,
    },

    data() {
        return {
            upcomingMoviesDiary: {
                settings: {
                    screenplays: {
                        type: 'movies',
                    },
                    jarallax: {
                        imageUrl: null,
                    },
                    title: {
                        class: ['text-dark'],
                        text: 'Upcoming Movies',
                    },
                },
                screenplaysRows: [],
            },
        };
    },

    methods: {
        openModal(refName) {
            if (refName in this.$refs) {
                if (refName === 'forgot-password') {
                    this.$inertia.reload({ only: ['status'] });
                    this.$refs['login'].close();
                }
                this.$refs[refName].open();
            }
        },
    },
};
</script>

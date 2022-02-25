<template>
    <!-- Footer -->
    <MDBFooter
        bg="dark"
        class="fixed-bottom"
        :text="['center', 'lg-start', 'light']"
        :style="style"
    >
        <div class="d-flex justify-content-center mx-2 my-2">
            <!-- Copyright -->
            <p class="p-1" style="background-color: rgba(0, 0, 0, 0.05)">
                © 2021 - {{ currentYear }}&nbsp&nbsp<a
                    class="text-reset fw-bold"
                    :href="route('home')"
                    v-text="this.$page.props.env.APP_NAME"
                />
            </p>
            &nbsp&nbsp

            <font-awesome-icon
                @click="goToGithub"
                :icon="['fab', 'github']"
                size="2x"
                style="cursor: pointer"
            />
            &nbsp&nbsp

            <language-switcher />
        </div>

        <!-- Copyright -->
    </MDBFooter>
    <!-- Footer -->
</template>

<script>
import LanguageSwitcher from '@/Layouts/Partials/LanguageSwitcher';

export default {
    components: { LanguageSwitcher },
    props: ['style'],
    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
    },

    methods: {
        goToGithub() {
            window.open(this.$page.props.env.GITHUB_URL, '_blank');
        },
    },
};
</script>

<style scoped>
footer {
    height: 65px;
}
</style>

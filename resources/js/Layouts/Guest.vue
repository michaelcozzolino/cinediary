<template>
    <AppHead />
    <div>
        <div class="bg-dark">
            <Logo />
        </div>

        <main style="padding-bottom: 3.5rem">
            <slot name="main" />
        </main>
        <AppFooter />
    </div>
</template>

<script>
import AppFooter from '@/Layouts/Partials/AppFooter';
import { Link } from '@inertiajs/inertia-vue3';
import Login from '@/Pages/Auth/Login';
import Logo from '@/Pages/Partials/Logo';
import AppHead from '@/Layouts/Partials/AppHead';

export default {
    components: {
        AppHead,
        Logo,
        Login,
        AppFooter,
        Link,
    },
};
</script>

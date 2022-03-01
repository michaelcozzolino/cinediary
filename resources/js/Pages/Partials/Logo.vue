<template>
    <Link :href="route('home')">
        <img
            src="/css/images/logo.png"
            class="img-fluid mx-auto d-block"
            alt="..."
        />
    </Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    components: { Link },
};
</script>

<style scoped></style>

<template>
    <Link :href="route('home')">
        <img
            src="https://puu.sh/IFwCQ/b0171fbe7a.png"
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

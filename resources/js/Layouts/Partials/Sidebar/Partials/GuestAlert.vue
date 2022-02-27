<template>
    <div
        class="w-100 px-5 d-flex align-items-center justify-content-center"
        style="height: 100vh"
    >
        <Link
            as="button"
            class="btn btn-warning"
            :href="route('home')"
            v-text="__('register or login to use all the available features!')"
        />
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: { Link },
};
</script>

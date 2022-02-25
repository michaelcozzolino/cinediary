<template>
    <div data-jarallax :data-speed="speed" class="jarallax">
        <img :src="imageSrc" class="jarallax-img" alt="alternative" />
        <slot />
    </div>
</template>

<script>
export default {
    props: {
        speed: [Number, String],
        imageSrc: String,
    },
};
</script>

<style scoped></style>

<template>
    <img :src="imageUrl" class="img-fluid rounded" alt="" />
</template>

<script>
export default {
    props: {
        imageUrl: {
            type: String,
            required: true,
        },
    },
};
</script>

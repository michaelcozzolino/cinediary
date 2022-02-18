<template>
    <div v-if="error">
        <p class="text-danger fw-bold" v-text="__(error)" />
    </div>
</template>

<script>
export default {
    props: {
        error: {
            type: String,
            required: true,
        }
    }
}
</script>

<style scoped>

</style>

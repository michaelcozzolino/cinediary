<template>
    <header>
        <div class="p-5 text-center bg-image" :style="getStyle">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6)">
                <div
                    class="d-flex justify-content-center align-items-center h-100"
                >
                    <div class="text-white mx-5">
                        <h1 class="mb-3" v-text="title" />
                        <!-- TODO: customize scrollbar                        -->
                        <h5
                            class="mb-3"
                            v-text="description"
                            style="max-height: 400px; overflow-y: auto"
                        />
                        <div v-if="getMessage">
                            <hr />
                            <small
                                class="text-warning font-weight-bolder"
                                v-text="getMessage"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    props: {
        title: String,
        description: String,
        // message: String,
        height: Number,
        imageUrl: String,
    },

    computed: {
        getStyle() {
            return {
                'background-image': `url(${this.getImageUrl})`,
                height: `${this.getHeight}px`,
            };
        },

        getImageUrl() {
            return this.imageUrl ?? '/images/header.jpg';
        },

        getHeight() {
            return this.height ?? 300;
        },

        getMessage() {
            return this.$page.props.flash.message;
        },
    },
};
</script>

<style scoped></style>

<template>
    <MDBModal
        :id="this.id"
        tabindex="-1"
        :labelledby="titleId"
        v-model="this.modal.isOpen"
        :centered="centered"
        :static-backdrop="staticBackdrop"
        @hide="this.$emit('OnClose')"
    >
        <MDBModalHeader>
            <MDBModalTitle v-if="this.$slots.title" :class="getTitleClass" :id="titleId">
                <slot name="title" />
            </MDBModalTitle>
        </MDBModalHeader>

        <MDBModalBody v-if="this.$slots.body">
            <slot name="body" />
        </MDBModalBody>

            <MDBModalFooter v-if="this.$slots.footer">
                <slot name="footer" />
            </MDBModalFooter>

    </MDBModal>
</template>

<script>
export default {
    name: "Modal",

    emits: ['OnClose'],

    props: {
        id: {
            type: String,
            required: true,
        },
        titleClass: Array,
        staticBackdrop: {
            type: Boolean,
            default: false,
        },
        centered: {
            type: Boolean,
            default: false,
        },

    },

    data() {
        return {
           modal: {
               isOpen: false,
           }
        }
    },

    computed: {
        titleId() {
            return this.id + "-title";
        },

        getTitleClass() {
            return ['fw-bold'].concat(this.titleClass);
        }
    },

    methods: {
        open() {
            this.modal.isOpen = true;
        },
        close() {
            this.modal.isOpen = false;
        }

    }
}
</script>

<style scoped>

</style>

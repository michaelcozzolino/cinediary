<template>
    <MDBModal
        id="destroy-diary-model"
        tabindex="-1"
        labelledby="destroy-diary-model-label"
        v-model="active"
        centered
        static-backdrop
        @hide="this.diary = null"
    >
        <MDBModalHeader>
            <MDBModalTitle
                id="destroy-diary-model-label"
                v-text="this.__('delete diary')"
            />
        </MDBModalHeader>

        <MDBModalBody>
            All movies and tv series belonging to this diary will be removed.
            Are you sure you want to delete it?
        </MDBModalBody>
        <MDBModalFooter>
            <MDBBtn
                type="button"
                color="danger"
                v-text="this.__('yes, delete this diary')"
                @click="this.destroyDiary()"
            />
            <MDBBtn
                type="button"
                color="primary"
                v-text="this.__('no')"
                @click="active = false"
            />
        </MDBModalFooter>
    </MDBModal>
</template>

<script>
export default {
    data() {
        return {
            active: false,
            diary: null,
        };
    },

    methods: {
        closeModal() {
            this.diary = null;
            this.active = false;
        },

        destroyDiary() {
            this.$inertia.delete(
                route('diaries.destroy', { diary: this.diary.id }),
                {
                    preserveScroll: true,
                    onSuccess: this.closeModal(),
                },
            );
        },
    },
};
</script>

<style scoped></style>

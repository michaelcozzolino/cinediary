<template>
    <div class="d-grid gap-2 col-6 mx-auto">
        <MDBBtn
            type="button"
            color="primary"
            v-text="this.__('Create new diary')"
            aria-controls="create-new-diary-model"
            @click="createNewDiaryModal.active = true"
        />
    </div>

    <MDBModal
        id="create-new-diary-model"
        tabindex="-1"
        labelledby="create-new-diary-model-label"
        v-model="createNewDiaryModal.active"
        centered
        static-backdrop
        @hide="createNewDiaryModal.form.reset()"
    >
        <MDBModalHeader>
            <MDBModalTitle
                id="create-new-diary-model-label"
                v-text="this.__('create new diary')"
            />
        </MDBModalHeader>
        <form @submit.prevent="createNewDiary()">
            <MDBModalBody>
                <MDBInput
                    type="text"
                    :label="this.__('diary name')"
                    aria-describedby="diary-name"
                    v-model="createNewDiaryModal.form.diaryName"
                    @input="
                        this.createNewDiaryModal.form.clearErrors('diaryName')
                    "
                />
                <div v-if="createNewDiaryModal.form.errors.diaryName">
                    {{ createNewDiaryModal.form.errors.diaryName }}
                </div>
            </MDBModalBody>
            <MDBModalFooter>
                <MDBBtn
                    type="submit"
                    color="primary"
                    v-text="this.__('create')"
                />
            </MDBModalFooter>
        </form>
    </MDBModal>
</template>

<script>
export default {
    data() {
        return {
            createNewDiaryModal: {
                active: false,
                form: this.$inertia.form({
                    diaryName: '',
                }),
            },
        };
    },

    methods: {
        createNewDiary() {
            this.createNewDiaryModal.form.post(route('diaries.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.createNewDiaryModal.active = false;
                    this.createNewDiaryModal.form.reset();
                },
            });
        },
    },
};
</script>

<style scoped></style>

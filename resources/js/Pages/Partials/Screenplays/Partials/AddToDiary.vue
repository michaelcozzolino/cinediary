<template>
    <MDBBtnGroup :id="dropdownId()">
        <MDBBtn
            color="primary"
            @click="this.dropdown.use()"
            class="dropdown-toggle"
            id="add-to-diary-dropdown"
            v-text="this.__('Add to')"
        />

        <MDBDropdown
            v-model="this.dropdown.isActive"
            class="mb-2"
            :target="dropdownId(true)"
        >
            <MDBDropdownMenu aria-labelledby="add-to-diary-dropdown">
                <MDBDropdownItem
                    v-for="diary in this.$helpers.getUser().diaries"
                    @click="addToDiary(diary.id)"
                    :href="href"
                >
                    {{ diary.isMain ? this.__(diary.name) : diary.name }}
                    <font-awesome-icon
                        class="text-success"
                        v-if="isAlreadyInDiary(diary.id)"
                        icon="check"
                    />
                </MDBDropdownItem>
            </MDBDropdownMenu>
        </MDBDropdown>
    </MDBBtnGroup>
</template>

<script>
import Dropdown from '@/Core/Dropdown';
import { inject } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

export default {
    /* TO-DO: build popup on screenplay stored */
    emits: ['OnScreenplayStored'],

    props: {
        screenplayType: String,
        screenplayId: { type: Number, required: true },
        href: String,
    },

    data() {
        return {
            dropdown: new Dropdown(null),
            addToDiaryForm: this.$inertia.form({
                screenplayId: null,
            }),
        };
    },

    computed: {},
    methods: {
        dropdownId(withHashtag = false) {
            let id = this.screenplayType + '_' + this.screenplayId;
            return withHashtag ? '#' + id : id;
        },

        addToDiary(diaryId) {
            if (!this.isAlreadyInDiary(diaryId)) {
                let routeName = 'diaries.' + this.screenplayType + '.add';
                this.addToDiaryForm.screenplayId = this.screenplayId;

                this.addToDiaryForm.post(route(routeName, { diary: diaryId }), {
                    preserveScroll: false,
                    preserveState: false,
                });
            }
        },

        /* checks if a screenplay is already in a diary */
        isAlreadyInDiary(diaryId) {
            return Object.values(
                usePage().props.value.alreadyInDiariesScreenplaysIds[diaryId][
                    this.screenplayType
                ],
            ).filter((screenplayId) => screenplayId == this.screenplayId)
                .length;
        },
    },
};
</script>

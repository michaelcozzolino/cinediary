<template>
    <authenticated>
        <MDBRow class="pb-2 d-flex justify-content-center text-center">
            <MDBCol>
                <MDBTable striped>
                    <thead class="">
                        <tr class="text-light bg-dark text-uppercase">
                            <th class="fw-bold">Name</th>
                            <th class="fw-bold">Total movies</th>
                            <th class="fw-bold">Total series</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="diary in diaries">
                            <td>
                                <Link
                                    class="text-decoration-underline fw-bold text-primary"
                                    :href="diaryRoute(diary.id)"
                                    v-text="diary.name"
                                />
                                &nbsp
                                <font-awesome-icon
                                    v-show="diary.isDeletable"
                                    class="text-danger"
                                    icon="times"
                                    style="cursor: pointer"
                                    @click="openDestroyDiaryModal(diary)"
                                />
                            </td>
                            <td v-text="diary.moviesCount" />
                            <td v-text="diary.seriesCount" />
                        </tr>
                    </tbody>
                </MDBTable>
                <create />
                <destroy ref="destroyDiaryModal" />
            </MDBCol>
        </MDBRow>
    </authenticated>
</template>

<script>
import Authenticated from '@/Layouts/Authenticated';
import { mdbRipple } from 'mdb-vue-ui-kit';
import Create from '@/Pages/Diaries/Create';
import Destroy from '@/Pages/Diaries/Destroy';
import Header from '@/Layouts/Partials/Header';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: { Header, Destroy, Create, Authenticated, Link },
    directives: {
        mdbRipple,
    },

    props: {
        diaries: Object,
    },

    methods: {
        diaryRoute(diaryId) {
            return route('diaries.movies.index', { diary: diaryId });
        },

        openDestroyDiaryModal(diary) {
            let destroyDiaryModal = this.$refs.destroyDiaryModal;
            destroyDiaryModal.active = true;
            destroyDiaryModal.diary = diary;
        },
    },
};
</script>

<style scoped></style>

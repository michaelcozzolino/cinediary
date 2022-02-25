<template>
    <MDBBtn @click="remove()" tag="a" color="danger" :href="href" class="px-2">
        <span>
            {{ __('remove') }}
            &nbsp&nbsp<font-awesome-icon size="lg" icon="times" />
        </span>
    </MDBBtn>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        screenplayId: { type: Number, required: true },
        currentDiaryId: { type: Number, required: true },
        screenplayType: { type: String, required: true },
        href: String,
    },

    methods: {
        remove() {
            let parameters = { diary: this.currentDiaryId };
            let screenplayBindName =
                this.screenplayType === 'movies'
                    ? 'movie'
                    : this.screenplayType;
            parameters[screenplayBindName] = this.screenplayId;
            Inertia.delete(
                route(
                    'diaries.' + this.screenplayType + '.destroy',
                    parameters,
                ),
                {
                    preserveScroll: true,
                    preserveState: false,
                },
            );
        },
    },
};
</script>

<style scoped></style>

<template>
    <MDBRow :class="this.class">
        <slot/>
    </MDBRow>
</template>


<script>
import Screenplay from "./Screenplay";
export default {
    components: {Screenplay},
    props: {
        alreadyInDiariesScreenplaysIds: { type: Object, required: false },
        class: {required: false},
    },

    methods: {

    }




}
</script>

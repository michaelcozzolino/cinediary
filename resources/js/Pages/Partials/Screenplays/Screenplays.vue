<template>
    <MDBRow :class="this.class">
        <slot />
    </MDBRow>
</template>

<script>
import Screenplay from './Screenplay';
export default {
    components: { Screenplay },
    props: {
        class: [String, Array],
    },
};
</script>

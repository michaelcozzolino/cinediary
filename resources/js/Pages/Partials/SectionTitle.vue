<template>
    <MDBContainer class="text-center py-4 text-light bg-indigo-400" fluid>
        <MDBRow>
            <MDBCol>
                <h3 v-if="this.$slots.title" :class="getTitleClass">
                    <slot name="title"/>
                </h3>
                <h4 v-if="this.$slots.subtitle" class="fst-italic">
                    <slot name="subtitle"/>
                </h4>
            </MDBCol>

        </MDBRow>
    </MDBContainer>
</template>

<script>
export default {
    props: { titleClass: Array},
    data(){
        return {
        }
    },

    computed:{
        getTitleClass(){
            return ['fw-bold'].concat(this.titleClass);
        }
    }

}
</script>

<style scoped>

</style>

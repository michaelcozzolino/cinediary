<template>

    <MDBCol :id="this.screenplay.id" :sm="'6'" :md="md"  class="mb-4 text-center">

        <MDBCard class="h-100" >

            <a href="route" v-mdb-ripple="{ color: 'light' }">
                <MDBCardImg :src="getPosterPath" top alt="..." />
            </a>
            <MDBCardBody>
                <MDBCardTitle class="fw-bold">
                    <div class="title" v-text="screenplay.title" />

                    <div class="mt-2 text-muted float-start text-sm" v-text="getFurtherData" >

                    </div>

                </MDBCardTitle>
            </MDBCardBody>

            <MDBCardFooter v-if="hasButtons">
                <!--   delete button  -->
                <div v-if="withDeleteButton">
                    <MDBBtn @click="this.$emit('OnDelete', {id:this.screenplay.id})" tag="a" color="danger" :href="href">
                        {{ __('Delete') }} <font-awesome-icon size="lg" icon="times"/>
                    </MDBBtn>
                </div>

                <!--   add to -->

                <form v-if="this.withDropdownButton" >
                    <MDBDropdown  v-model="this.dropdown.isActive" class="mb-2">
                        <MDBDropdownToggle
                            tag="a"
                            class="btn btn-primary"
                            @click="this.dropdown.use()"
                            id="diaries-dropdown">
                            Add to</MDBDropdownToggle>
                        <MDBDropdownMenu aria-labelledby="diaries-dropdown">
                            <MDBDropdownItem v-for="diary in this.$page.props.auth.userData.diaries"
                                             @click="addToDiary(diary.id)"

                                             :href="href">
                                {{ diary.name }} <font-awesome-icon class="text-success" v-if="alreadyInDiary(diary.id)"
                                                                    icon="check"

                            />
                            </MDBDropdownItem>
                        </MDBDropdownMenu>
                    </MDBDropdown>
                </form>

            </MDBCardFooter>
        </MDBCard>

    </MDBCol>

</template>

<script>
import { mdbRipple } from "mdb-vue-ui-kit";
import Dropdown from "../../../Core/Dropdown";
import {usePage} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";

export default {

    directives: {
        mdbRipple
    },

    props: {
        screenplay: { type: Object, required: true },
        diary: Object,
        md: String,
        screenplayType: String,

        withDropdownButton: Boolean,
        withDeleteButton: Boolean,
        alreadyInDiariesScreenplaysIds: Object,

    },

    emits: ['OnScreenplayStored', 'OnDelete'],
    data(){
        return {
            newAddedToDiaryScreenplaysIds : {movies: [], series: []},
            dropdownItems: [
                {'text': 'Watchlist'},
                {'text': 'Favourite'},
            ],
            dropdown: new Dropdown(this.dropdownItems),
            addToDiaryForm: this.$inertia.form({
                screenplayId: null,
            })

        }
    },
    mounted() {

    },
    methods: {

        /* methods used for and with diaries pages that do not use TMDB api */

        /* checks if a screenplay is already in a diary */
        alreadyInDiary(diaryId){
            return Object.values(this.alreadyInDiariesScreenplaysIds[diaryId][this.getScreenplayType])
                .indexOf(this.screenplay.id) !== -1;
        },

        onDropdownClicked(){
            console.log(this.dropdown);
            return {dropdown: this.dropdown}
        },


        /* methods used for and with TMDB api */

        addToDiary(diaryId) {
            console.log(this.getScreenplayType);
            if (!this.alreadyInDiary(diaryId)) {
                let routeName = "diaries." + this.getScreenplayType + ".store";
                console.log(this.getScreenplayType);
                this.addToDiaryForm.screenplayId = this.screenplay.id;

                this.addToDiaryForm.post(route(routeName, {diary: diaryId}), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.$emit('OnScreenplayStored', {
                            screenplayType: _.capitalize(this.getScreenplayType),
                            screenplayId: this.screenplay.id,
                            diaryId: diaryId,
                        });
                    }
                });

            }
        },


    },

    computed: {

        // screenplayType is not present when searching for a screenplay by using TMDB api in Search.vue
        // because the route doesn't have a movies or series binding, in that case we pass the screenplayType as props
        // else we use the Inertia shared data
        getScreenplayType(){
            return this.screenplayType ?? usePage().props.value.screenplayType;
        },

        hasButtons(){
            return this.withDeleteButton || this.withDropdownButton;
        },

        getPosterPath(){
            return this.screenplay.posterPath === "" ? "/css/images/reel.png" : this.screenplay.posterPath;
        },

        getFurtherData(){
            return this.screenplay.genre ?
                this.screenplay.genre + ', ' + this.screenplay.releaseDate :
                this.screenplay.releaseDate
        },

        href(){
            return "#" + this.screenplay.id;
        }


    }


}
</script>

<style lang="scss" scoped>


.btn-close{
    position: relative;
    top:3px;

    color: white;

}


</style>

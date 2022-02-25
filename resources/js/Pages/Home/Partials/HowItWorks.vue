<template>
    <MDBContainer class="text-center py-4 text-light bg-indigo-400" fluid>
        <MDBRow>
            <MDBCol class="text-light">
                <h3 class="fw-bold">
                    Cinediary allows you to track movies and tv series.
                </h3>
                <h4 class="fst-italic">How does it work?</h4>
            </MDBCol>
        </MDBRow>
    </MDBContainer>

    <MDBContainer class="text-center py-4 bg-gray-200" fluid>
        <MDBRow class="mx-2">
            <MDBCol md="3" class="my-2" v-for="step in steps">
                <MDBCard :class="step.class">
                    <MDBCardBody>
                        <font-awesome-icon
                            class="mb-4"
                            :icon="step.icon.name"
                            :size="step.icon.size"
                            aria-hidden="true"
                        ></font-awesome-icon>
                        <MDBCardTitle class="font-weight-bold text-uppercase">{{
                            step.title
                        }}</MDBCardTitle>
                        <MDBCardText class="dark-grey-text">
                            {{ step.description.text }}
                        </MDBCardText>
                    </MDBCardBody>
                    <MDBCardFooter border="info">
                        <MDBBtn
                            @click="step.button.onClick"
                            tag="a"
                            color="primary"
                            :href="step.button.href"
                        >
                            {{ step.button.text }}
                        </MDBBtn>
                    </MDBCardFooter>
                </MDBCard>
            </MDBCol>
        </MDBRow>
    </MDBContainer>
</template>

<script>
import { mdbRipple } from 'mdb-vue-ui-kit';
import Screenplay from '../../Partials/Screenplays/Screenplay';
import SectionTitle from '../../Partials/SectionTitle';
export default {
    components: { SectionTitle, Screenplay },
    directives: {
        mdbRipple,
    },

    emits: ['OnButtonClick', 'OnDemoLogin'],

    data() {
        return {
            steps: [
                {
                    icon: { name: 'user-plus', size: '3x' },
                    title: 'Sign up for free in few minutes',
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-deep-purple-200',
                    ],
                    description: {
                        text: 'Create your account with a few simple steps by providing some basic information such as your username.',
                    },
                    button: {
                        text: 'Register',
                        onClick: () =>
                            this.$emit('OnButtonClick', {
                                refName: 'register',
                            }),
                    },
                },
                {
                    icon: { name: 'search', size: '3x' },
                    title: 'Find and discover Movies and TV Series',
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-pink-200',
                    ],
                    description: {
                        text: 'Search for a movie or a tv-series you have watched or you want to watch between a 1M+ database.',
                    },
                    button: {
                        text: 'Discover',
                        onClick: () => false,
                        href: '#popular-movies',
                    },
                },
                {
                    icon: { name: 'book-open', size: '3x' },
                    title: 'Add to your diaries!',
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-teal-200',
                    ],
                    description: {
                        text: 'You can track every movie and tv series by adding them to your diaries. A diary is a list of movies or tv series representing a common fact, such as "watched movies". ',
                    },
                    button: {
                        text: 'Login',
                        onClick: () =>
                            this.$emit('OnButtonClick', { refName: 'login' }),
                    },
                },
                {
                    icon: { name: 'question-circle', size: '3x' },
                    title: 'Not convinced yet?',
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-deep-orange-200',
                    ],
                    description: {
                        text: 'You can try a demo by clicking on the following button and login with an already registered demo user.',
                    },
                    button: {
                        text: 'Try a demo user',
                        onClick: () => this.$emit('OnDemoLogin'),
                    },
                },
            ],
        };
    },
};
</script>

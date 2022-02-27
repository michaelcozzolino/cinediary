<template>
    <MDBContainer class="text-center py-4 text-light bg-indigo-400" fluid>
        <MDBRow>
            <MDBCol class="text-light">
                <h3
                    class="fw-bold"
                    v-text="this.__('cinediary_info.description')"
                />
                <h4
                    class="fst-italic"
                    v-text="this.__('cinediary_info.help')"
                />
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
                        />
                        <MDBCardTitle
                            class="font-weight-bold text-uppercase"
                            v-text="step.title"
                        />
                        <MDBCardText
                            class="dark-grey-text"
                            v-text="step.description"
                        />
                    </MDBCardBody>
                    <MDBCardFooter border="info">
                        <MDBBtn
                            @click="step.button.onClick"
                            tag="a"
                            color="primary"
                            :href="step.button.href"
                            v-text="step.button.text"
                        />
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
                    title: this.__('step_1.title'),
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-deep-purple-200',
                    ],
                    description: this.__('step_1.description'),
                    button: {
                        text: this.__('Register'),
                        onClick: () =>
                            this.$emit('OnButtonClick', {
                                refName: 'register',
                            }),
                    },
                },
                {
                    icon: { name: 'search', size: '3x' },
                    title: this.__('step_2.title'),
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-pink-200',
                    ],
                    description: this.__('step_2.description'),
                    button: {
                        text: this.__('Discover'),
                        onClick: () => false,
                        href: '#popular-movies',
                    },
                },
                {
                    icon: { name: 'book-open', size: '3x' },
                    title: this.__('step_3.title'),
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-teal-200',
                    ],
                    description: this.__('step_3.description'),
                    button: {
                        text: this.__('Login'),
                        onClick: () =>
                            this.$emit('OnButtonClick', { refName: 'login' }),
                    },
                },
                {
                    icon: { name: 'question-circle', size: '3x' },
                    title: this.__('step_4.title'),
                    class: [
                        'h-100',
                        'hover-shadow',
                        'text-dark',
                        'bg-deep-orange-200',
                    ],
                    description: this.__('step_4.description'),
                    button: {
                        text: this.__('Try a demo user'),
                        onClick: () => this.$emit('OnDemoLogin'),
                    },
                },
            ],
        };
    },
};
</script>

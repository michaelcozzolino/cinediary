<template>
    <MDBDropdown v-model="languageDropdown">
        <MDBDropdownToggle
            @click="languageDropdown = !languageDropdown"
            v-text="currentLanguage"
        />
        <MDBDropdownMenu aria-labelledby="dropdownMenuButton">
            <MDBDropdownItem
                href="#"
                v-for="language in languages"
                @click="changeLanguage(language)"
            >
                {{ language }}
                <font-awesome-icon
                    v-show="isCurrentLanguage(language)"
                    class="text-success"
                    icon="check"
                />
            </MDBDropdownItem>
        </MDBDropdownMenu>
    </MDBDropdown>
</template>

<script>
import { usePage } from '@inertiajs/inertia-vue3';

export default {
    data() {
        return {
            languageDropdown: false,
            languages: this.getLanguages(),
        };
    },

    methods: {
        changeLanguage(language) {
            language = language.toLowerCase();
            this.$inertia.get(route('language', { language }));
        },

        getLanguages() {
            return usePage().props.value.availableLocales.map((language) =>
                language.toUpperCase(),
            );
        },

        isCurrentLanguage(language) {
            return this.currentLanguage === language;
        },
    },
    computed: {
        currentLanguage() {
            let locale = usePage().props.value.current_language;
            return locale.toUpperCase();
        },
    },
};
</script>

<style scoped></style>

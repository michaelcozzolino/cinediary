import { usePage } from '@inertiajs/inertia-vue3';
import { __ } from '@/Core/Translator';

export default {
    getHeadersData(component, info = {}) {
        let data = {
            title: '',
            description: '',
        };

        switch (component) {
            case 'Diaries/Show':
                data.title = info.diary.isMain
                    ? __(info.diary.name)
                    : info.diary.name;
                data.description = info.diary.description;
                break;
            case 'Home/Dashboard/Index':
                data.title = __('Dashboard');
                data.description = __(
                    'Here you can see your statistics and your last watched movies and TV series',
                );
                break;
            case 'Diaries/Index':
                data.title = __('Manage diaries');
                data.description = __(
                    'Here you can create and delete your diaries',
                );
                break;
            case 'Search/Index':
                data.title = __('Add movies or TV series');
                data.description = __(
                    'Search for movies or TV series to add them to your diaries',
                );
                break;
            case 'Settings/Index':
                data.title = __('Settings');
                data.description = __('Here you can manage your settings');
                break;
        }
        return data;
    },

    /**
     * Check if authentication is strictly needed.
     * Some authenticated pages can be visited also as a guest
     * by hiding the components that need authentication
     * */
    needsAuthentication() {
        return this.getSharedProps().auth.userData.user !== null;
    },

    getSharedProps() {
        return usePage().props.value;
    },

    getAppName() {
        return this.getSharedProps().config.app_name;
    },
};

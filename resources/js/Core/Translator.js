import { usePage } from '@inertiajs/inertia-vue3';

/**
 * Translate the given key.
 */
export const __ = (key, replace = {}) => {
    let translation = _.get(usePage().props.value.translations, key, key);

    Object.keys(replace).forEach(function (key) {
        translation = translation.replace(':' + key, replace[key]);
    });

    return translation;
};

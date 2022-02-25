import { usePage } from '@inertiajs/inertia-vue3';

/**
 * Translate the given key.
 */
export const __ = (key, replace = {}) => {
    let translation = usePage().props.value.language[key]
        ? usePage().props.value.language[key]
        : key;

    Object.keys(replace).forEach(function (key) {
        translation = translation.replace(':' + key, replace[key]);
    });

    return translation;
};

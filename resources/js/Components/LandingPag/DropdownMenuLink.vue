<script setup>
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue'

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="tw-flex tw-text-gray-800 tw-p-2 tw-flex-row tw-gap-2 tw-uppercase tw-font-title tw-text-base tw-items-center tw-my-2 tw-border-b-2 tw-border-transparent tw-leading-5 hover:tw-text-gray-700 border-box hover:tw-border-gray-100 focus:tw-outline-none focus:tw-text-gray-900 hover:tw-bg-gray-100 focus:tw-border-gray-300 tw-transition tw-duration-150 tw-ease-in-out"
    >
        <slot />
    </Link>
</template>

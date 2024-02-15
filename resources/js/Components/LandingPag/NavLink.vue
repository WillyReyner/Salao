<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue'

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'tw-inline-flex tw-gap-2 tw-uppercase tw-font-title tw-text-lg tw-items-center tw-px-2 tw-pt-1 tw-border-b-2 tw-border-navy-500 tw-leading-5 tw-text-gray-900 focus:tw-outline-none focus:tw-border-navy-900 tw-transition tw-duration-150 tw-ease-in-out'
        : 'tw-inline-flex tw-gap-2 tw-uppercase tw-font-title tw-text-lg tw-items-center tw-px-2 tw-pt-1 tw-border-b-2 tw-border-transparent tw-leading-5 tw-text-gray-900 hover:tw-text-gray-700 border-box hover:tw-border-gray-100 focus:tw-outline-none focus:tw-text-gray-900 focus:tw-border-gray-300 tw-transition tw-duration-150 tw-ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

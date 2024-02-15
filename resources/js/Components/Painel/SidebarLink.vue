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
    icon: {
        type: String,
    },
    reduced: {
        type: Boolean,
        default: false
    }
});

const classes = computed(() =>
    props.active
        ? 'tw-flex btn-hover tw-py-3 tw-px-4 tw-bg-green-100 btn-active tw-font-body tw-border-r-2 tw-border-primary tw-text-primary tw-text-lg tw-items-center tw-leading-5 focus:tw-outline-none tw-transition tw-duration-150 tw-ease-in-out'
        : 'tw-flex btn-hover tw-py-3 tw-px-4 tw-font-body tw-text-base tw-items-center tw-border-r-2 hover:tw-bg-green-100 tw-border-white hover:tw-border-primary hover:tw-text-primary tw-leading-5 tw-text-gray-700 border-box focus:tw-outline-none tw-transition tw-duration-150 tw-ease-in-out'
);
</script>

<style>
    .btn-hover:hover > svg > path, .btn-active > svg > path {
        color: green
    }
</style>
<template>
    <Link :href="href" :class="[classes, reduced ? 'tw-justify-center tw-items-center' : 'tw-pl-6']">

        <Icon v-if="icon" :icon="icon" class="tw-h-[28px] tw-w-[28px] tw-text-gray-500 tw-transition-all" :class="!reduced && 'tw-mr-2'"/>
        <slot v-if="!reduced"/>
    </Link>
</template>

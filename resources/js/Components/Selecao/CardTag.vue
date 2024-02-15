<script setup>
import { Icon } from '@iconify/vue';
const props = defineProps({
    icon: {
        type: String,
        default: 'clarity:building-line',
    },
    title: {
        type: String,
        default: '',
    },
    description: {
        type: String,
        default: '',
    },
    selected: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div class="tw-flex tw-flex-1 tw-justify-between md:tw-justify-normal  tw-p-4 tw-flex-row md:tw-flex-col tw-gap-4 tw-shadow-md tw-transition-all tw-rounded-xl tw-cursor-pointer tw-border-2" :class="(selected ? 'tw-border-primary' : 'tw-border-white')">
        <div class="tw-flex tw-flex-row tw-gap-2 tw-items-center">
            <h4 class="tw-font-title tw-text-base tw-text-primary tw-uppercase tw-font-semibold">{{ title }}</h4>
        </div>
        <p class="tw-hidden md:tw-flex tw-text-gray-500 tw-text-xs tw-flex-1 tw-font-normal tw-font-body">
            {{ description }}
        </p>
    </div>
</template>
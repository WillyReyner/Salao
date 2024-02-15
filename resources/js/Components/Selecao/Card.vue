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
    <div class="lg:tw-flex tw-flex-1 sm:tw-grid tw-grid-cols-2 tw-justify-between md:tw-justify-normal tw-p-4 tw-flex-row md:tw-flex-col tw-gap-4 tw-shadow-md tw-transition-all tw-rounded-xl tw-cursor-pointer tw-border-2 tw-h-[100%]" :class="(selected ? 'tw-border-primary' : 'tw-border-white')">
        <div class="tw-grid tw-flex-row tw-gap-2 tw-items-center">
            <h4 class="tw-font-title tw-text-xl tw-text-primary tw-uppercase tw-font-semibold">{{ title }}</h4>
            <p class="sm:tw-grid tw-grid-cols-2 md:tw-flex tw-text-gray-500 tw-flex-1 tw-text-base tw-font-normal tw-font-body">{{ description }}</p>
        </div>
        <div>
            <h5 class="tw-flex md:tw-self-end tw-items-center tw-justify-end tw-text-primary tw-gap-4 tw-font-title tw-text-base tw-font-semibold">
                <span class="tw-hidden md:tw-inline">SELECIONAR</span>
                <Icon icon="icons8:right-round" class="tw-h-8 tw-w-8 tw-text-primary" />
            </h5>
        </div>
    </div>
</template>

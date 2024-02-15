<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

import { Icon } from '@iconify/vue'

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'tw-py-1 tw-bg-white',
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

const buttonClasses = computed(() =>
    open.value
        ? 'tw-flex tw-flex-1 tw-gap-1 tw-uppercase tw-font-title tw-text-base tw-items-center tw-pt-1 tw-border-b-2 tw-border-navy-500 tw-leading-5 tw-text-gray-900 focus:tw-outline-none focus:tw-border-navy-900 tw-transition tw-duration-150 tw-ease-in-out'

        : 'tw-flex tw-flex-1 tw-gap-2 tw-uppercase tw-font-title tw-text-base tw-items-center tw-pt-1 tw-border-b-2 tw-border-transparent tw-leading-5 tw-text-gray-900 hover:tw-text-gray-700 border-box hover:tw-border-gray-100 focus:tw-outline-none focus:tw-text-gray-900 focus:tw-border-gray-300 tw-transition tw-duration-150 tw-ease-in-out'
);

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'tw-origin-top-left tw-left-0';
    } else if (props.align === 'right') {
        return 'tw-origin-top-right tw-right-0';
    } else {
        return 'tw-origin-top';
    }
});

const expandIcon = computed(() => 
    open.value ? 'tw-rotate-180 tw-transition-transform' : 'tw-rotate-0 tw-transition-transform'
);

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        48: 'tw-w-48',
    }[props.width.toString()];
});

const open = ref(false);
</script>

<template>
    <div class="tw-flex tw-flex-1 tw-items-center tw-relative">
        <div @click="open = !open" class="tw-flex tw-h-14 tw-flex-1 tw-cursor-pointer" :class=buttonClasses>
            <slot name="trigger" />
            <Icon icon="ooui:expand" :class=expandIcon />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="tw-fixed tw-w-50 tw-inset-0 tw-z-40" @click="open = false"></div>

        <transition
            enter-active-class="tw-transition tw-ease-out tw-duration-200"
            enter-from-class="tw-transform tw-opacity-0 tw-scale-95"
            enter-to-class="tw-transform tw-opacity-100 tw-scale-100"
            leave-active-class="tw-transition tw-ease-in tw-duration-75"
            leave-from-class="tw-transform tw-opacity-100 tw-scale-100"
            leave-to-class="tw-transform tw-opacity-0 tw-scale-95"
        >
            <div
                v-show="open"
                class="tw-absolute tw-z-50 tw-top-20 tw-rounded-b-md tw-shadow-lg"
                :class="[widthClass, alignmentClasses]"
                style="display: none"
                @click="open = false"
            >
                <div class="tw-rounded-b-md tw-ring-1 tw-ring-black tw-ring-opacity-5 tw-mt-[1px]" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </transition>
    </div>
</template>

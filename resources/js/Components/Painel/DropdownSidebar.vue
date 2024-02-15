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
    icon: {
        type: String,
    },
    reduced: {
        type: Boolean,
        default: false
    }
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

const buttonClasses = computed(() =>
    open.value
    ? 'tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-bg-green-100 btn-active tw-font-body tw-border-r-2 tw-border-primary tw-text-primary tw-text-lg tw-items-center tw-leading-5 focus:tw-outline-none tw-transition tw-duration-150 tw-ease-in-out'
    : 'tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-items-center tw-border-r-2 hover:tw-bg-green-100 tw-border-white hover:tw-border-primary hover:tw-text-primary tw-leading-5 tw-text-gray-700 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out'
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
    <div>
        <div @click="open = !open" class="tw-cursor-pointer" :class="[buttonClasses, !reduced && 'tw-pl-6']" >
            <div class="tw-flex tw-flex-1 tw-items-center tw-gap-1" :class="reduced && 'tw-justify-center tw-items-center'">
                <Icon v-if="icon" :icon="icon" class="tw-h-[28px] tw-w-[28px] tw-text-gray-500 tw-transition-all" :class="reduced && 'tw-scale-100'"/>
                
                <slot name="trigger" v-if="!reduced" class="tw-h-[28px] tw-w-[28px] tw-text-gray-500 tw-transition-all" />
            </div>

            <Icon icon="icon-park-outline:right" class="tw-text-gray-400" :class=expandIcon v-if="!reduced" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="tw-fixed tw-inset-0 tw-z-40" @click="open = false"></div>

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
                class="relative tw-z-[9999999] -tw-right-16 tw-bottom-0 tw-rounded-b-md tw-shadow-lg"
                :class="[widthClass, alignmentClasses, !reduced && 'tw-left-[264px]']"
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

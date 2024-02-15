<script setup>

const props = defineProps({
    buttonClass: {
        type: String,
        default: '',
    },
});

</script>

<template>
    <button
        class="tw-inline-flex tw-items-center tw-self-center tw-px-12 tw-py-4 tw-rounded-xl tw-font-title tw-text-base tw-text-center tw-uppercase hover:tw-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-primary focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150"
        :class=props.buttonClass
        >
        <slot />
    </button>
</template>

<script setup>
import { Icon } from '@iconify/vue';

defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="tw-block tw-text-gray-700">
        <span class="tw-flex tw-font-body tw-items-center tw-justify-start tw-text-[14px]">
            {{ value }} <span v-if="required" class="tw-text-red-500 tw-pl-1"> *</span>
        </span>
    </label>
</template>

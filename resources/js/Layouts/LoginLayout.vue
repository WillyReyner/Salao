<script setup>
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>


<template>
    <div class="tw-min-h-screen tw-flex tw-flex-col sm:tw-justify-center tw-items-center lg:tw-items-start tw-bg-white"
        >
        <img src="./../../imgs/bg-login.jpeg" class="tw-w-full max-lg:tw-hidden tw-absolute tw-h-screen tw-z-0"/> 
        <div class="tw-z-50 tw-px-8 lg:tw-px-40 bg-white tw-flex tw-flex-1 tw-justify-center tw-flex-col" >
            <img src="./../../imgs/logo-efg.svg" class="tw-h-auto tw-w-56 tw-z-50 tw-mb-16">
        
            <slot />
        </div>
    </div>
</template>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@100;300;400;700;800&family=Open+Sans:wght@300;400;600;800&display=swap');

    [type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus,
    [type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus,
    [type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus,
    textarea:focus, select:focus{
        --tw-ring-shadow: 0;
    }

    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        border-radius: 10px;
        background: rgba(243, 243, 243, 0.1);
    }
    ::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background: rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.4);
    }
    ::-webkit-scrollbar-thumb:active {
        background: rgba(0, 0, 0, 0.9);
    }
</style>

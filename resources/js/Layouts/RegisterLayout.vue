<script setup>
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>


<template>
    <main class="relative bg-registro tw-min-h-screen tw-min-w-screen tw-overflow-hidden tw-flex tw-flex-col tw-justify-center tw-items-center">
        <img src="./../../imgs/bg-registro.png" class="tw-w-screen tw-absolute tw-h-screen marcas-registro tw-z-0"/>      
        <div class="tw-z-50 tw-py-5">
            <div class="tw-py-5 tw-px-8 lg:tw-px-20  tw-max-w-[90vw] max-sm:tw-min-w-[80vw] tw-min-w-[30vw] tw-justify-center tw-flex tw-flex-col tw-items-center tw-bg-white tw-rounded-lg tw-p-2 tw-overflow-auto tw-overflow-x-hidden" >
                <slot />
        
            </div>
        </div>
    </main>
</template>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@100;300;400;700;800&family=Open+Sans:wght@300;400;600;800&display=swap');

    body {
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
    }

    .bg-registro {
        background: linear-gradient(65.43deg, #90C78E 0%, rgba(144, 199, 142, 0.25) 17.62%, rgba(144, 199, 142, 0.25) 72.41%, #90C78E 99.26%), linear-gradient(90deg, #009C66 33.85%, #007EA5 66.15%), #FFFFFF;
    }
    .marcas-registro {
      object-fit: cover;
    }

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

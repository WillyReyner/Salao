<script setup>
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>


<template>
    <main class="relative bg-selecao tw-min-h-screen tw-overflow-x-hidden tw-w-full tw-flex tw-flex-col tw-justify-center tw-items-center">
      <img src="./../../imgs/bg-selecao.png" class="tw-w-screen tw-absolute tw-h-screen marcas-selecao tw-z-0"/>      
      <div class="tw-z-50 tw-py-5 lg:py-0">
        <slot />
      </div>
    </main>
</template>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@100;300;400;700;800&family=Open+Sans:wght@300;400;600;800&display=swap');

    body {
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
    }

    .bg-selecao {
      background: linear-gradient(65.72deg, #90C78E 19.14%, rgba(144, 199, 142, 0.25) 45.6%, rgba(144, 199, 142, 0.25) 73.71%, #90C78E 98.52%), linear-gradient(252.44deg, #009C66 0%, #007EA5 100%);
    }
    .marcas-selecao {
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

    .q-checkbox__bg{
      background-color: white;
      border-color: rgb(148, 148, 148);
      padding: 1px;
      border-radius: 6px;
      border-width: 1px;
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative!important;
  }
  .q-checkbox__inner--truthy .q-checkbox__bg {
      background-color: rgb(0, 218, 0);
  }
  .q-checkbox__bg > svg {
      display: flex;
      position: relative;
      width: 70%!important;
      height: 70%!important;
  }
</style>

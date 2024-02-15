<script setup>
import { computed, ref } from 'vue';
import PrimaryButton from '../Pages/PrimaryButton.vue';
import image from "primevue/image/Image.vue";
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { defineComponent } from 'vue'
</script>
<template>
  <section class="tw-flex tw-flex-1 tw-w-auto tw-pt-10" id="header">
    <div class="tw-flex tw-flex-1 tw-flex-col tw-py-20 tw-justify-center tw-items-center tw-text-center">
      <h5 class="tw-text-xl tw-font-title tw-font-bold tw-leading-7 tw-text-green-700">ESCOLAS DO FUTURO</h5>
      <h4 class="tw-text-5xl tw-font-title tw-font-bold tw-leading-[68px] lg:tw-max-w-2xl tw-text-navy-500 " >Para você mudar o <span class="tw-text-grass-600">mundo!</span><br/></h4>
	    <p class="tw-text-[22px] tw-w-[50%] lg:tw-max-w-5xl tw-text-gray-700 tw-leading-2 tw-py-4">Toda a transformação começa com um primeiro passo. Venha se profissionalizar nas Escolas do Futuro de Goiás! Cursos Gratuitos na área de tecnologia e artes.</p>
        <PrimaryButton class="tw-text-white tw-bg-green-800 tw-h-10">INSCREVA-SE</PrimaryButton>
    </div>
  </section>
</template>

<style>
  #header {
    background-image: url('../../../imgs/bg-header.png');
    background-size: cover;
    background-position: center;
    object-fit: cover;
    min-height: 30vh;
  }
</style>
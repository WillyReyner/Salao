<script setup>
import { computed, ref } from 'vue';
import PrimaryButton from '../Pages/PrimaryButton.vue';
import image from "primevue/image/Image.vue";
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { defineComponent } from 'vue'
import logoEfg from "../../../imgs/logo-efg.png";
</script>
<template>
	<div class="tw-py-10">
		<div class="tw-flex tw-flex-0 tw-flex-col tw-justify-center tw-items-center tw-text-center tw-pb-4">
			<h5 class="tw-text-lg tw-font-title tw-font-bold tw-text-green-700">NOTÍCIAS</h5>
			<h5 class="tw-text-[42px] tw-font-title tw-font-bold tw-leading-[60px] tw-text-navy-500" >Veja aqui as últimas notícias publicadas</h5>
		</div>
		<div class="tw-flex tw-flex-1 tw-px-20 tw-gap-6">
			<div class="tw-w-[100%]">
				<q-card class="tw-w-[100%] tw-h-[100%] tw-rounded-2xl">
					<div class="tw-flex tw-flex-1 tw-justify-center tw-item-center tw-h-[100%]">
						<img :src=logoEfg class="tw-h-[100%] tw-w-[100%] tw-item-center tw-fill-current tw-object-contain" alt=""/>
					</div>
				</q-card>
			</div>
			<div class="tw-w-[100%] tw-flex tw-flex-col tw-gap-4">
				<q-card class="tw-p-3 tw-rounded-2xl">
					<div class="tw-flex tw-flex-1 tw-gap-3 tw-items-center">
						<div class="tw-w-[100%] tw-h-[170px] tw-rounded-2xl tw-bg-gray-100">
							<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
						</div>
						<div class="grid grid-cols-2">
							<div>
								<div class="tw-text-left tw-text-3xl tw-font-bold tw-font-['Poppins', sans-serif] tw-pb-2">Minicursos</div>
								<p maxlength="100" class="tw-text-left tw-font-['Poppins', sans-serif']">Experimente um assunto novo! Se você está em dúvida se aquele conhecimento é o que você está procurando ou precisa para dominar um determinado assunto na área de tecnologia ou empreendedorismo, os minicursos</p>
							</div>
							<div class="flex items-end justify-end">
								<PrimaryButton class="tw-text-green-800 tw-border tw-border-green-800 tw-h-1 tw-w-[41%] tw-text-xs">Saiba Mais</PrimaryButton>
							</div>
						</div>
					</div>
				</q-card>
				<q-card class="tw-p-3 tw-rounded-2xl">
					<div class="tw-flex tw-flex-1 tw-gap-3 tw-items-center">
						<div class="tw-w-[100%] tw-h-[170px] tw-rounded-2xl tw-bg-gray-100">
							<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
						</div>
						<div class="grid grid-cols-2">
							<div>
								<div class="tw-text-left tw-text-3xl tw-font-bold tw-font-['Poppins', sans-serif] tw-pb-2">Minicursos</div>
								<p maxlength="100" class="tw-text-left tw-font-['Poppins', sans-serif']">Experimente um assunto novo! Se você está em dúvida se aquele conhecimento é o que você está procurando ou precisa para dominar um determinado assunto na área de tecnologia ou empreendedorismo, os minicursos</p>
							</div>
							<div class="flex items-end justify-end">
								<PrimaryButton class="tw-text-green-800 tw-border tw-border-green-800 tw-h-1 tw-w-[41%] tw-text-xs">Saiba Mais</PrimaryButton>
							</div>
						</div>
					</div>
				</q-card>
				<q-card class="tw-p-3 tw-rounded-2xl">
					<div class="tw-flex tw-flex-1 tw-gap-3 tw-items-center">
						<div class="tw-w-[100%] tw-h-[170px] tw-rounded-2xl tw-bg-gray-100">
							<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
						</div>
						<div class="grid grid-cols-2">
							<div>
								<div class="tw-text-left tw-text-3xl tw-font-bold tw-font-['Poppins', sans-serif] tw-pb-2">Minicursos</div>
								<p maxlength="100" class="tw-text-left tw-font-['Poppins', sans-serif']">Experimente um assunto novo! Se você está em dúvida se aquele conhecimento é o que você está procurando ou precisa para dominar um determinado assunto na área de tecnologia ou empreendedorismo, os minicursos</p>
							</div>
							<div class="flex items-end justify-end">
								<PrimaryButton class="tw-text-green-800 tw-border tw-border-green-800 tw-h-1 tw-w-[41%] tw-text-xs">Saiba Mais</PrimaryButton>
							</div>
						</div>
					</div>
				</q-card>
			</div>
		</div>
		<div class="tw-flex tw-flex-0 tw-item-center tw-justify-center tw-pt-5 tw-pb-20">
			<PrimaryButton class="tw-border-1 tw-bg-green-800 tw-text-white tw-h-10">VER TODAS AS NOTÍCIAS</PrimaryButton>
		</div>
	</div>

</template>

<style>
  #header {
    background-image: url('../../../imgs/bg-header.png');
    background-size: cover;
    background-position: center;
    object-fit: cover;
    min-height: 30vh;
  }

  .carousel__slide {
	  padding: 5px;
  }

  .carousel__viewport {
	  perspective: 2000px;
  }

  .carousel__track {
	  transform-style: preserve-3d;
  }

  .carousel__slide--sliding {
	  transition: 0.5s;
  }

  .carousel__slide {
	  opacity: 0.9;
	  transform: rotateY(-20deg) scale(0.9);
  }

  .carousel__slide--active ~ .carousel__slide {
	  transform: rotateY(20deg) scale(0.9);
  }

  .carousel__slide--prev {
	  opacity: 1;
	  transform: rotateY(-10deg) scale(0.95);
  }

  .carousel__slide--next {
	  opacity: 1;
	  transform: rotateY(10deg) scale(0.95);
  }

  .carousel__slide--active {
	  opacity: 1;
	  transform: rotateY(0) scale(1.1);
  }

</style>
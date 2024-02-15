<script setup>
import { computed, ref } from 'vue';
import PrimaryButton from '../Pages/PrimaryButton.vue';
import image from "primevue/image/Image.vue";
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { defineComponent } from 'vue'
import logoEfg from "../../../imgs/logo-efg.png";

const props = defineProps({
	cursos:
		 {
			 type: Array,
			 default: () => [],
		 },
	 }
);

// const slides = props.cursos.map(resp => ({ label: resp.name, value: resp.id }))
//
// const chunkArray = (array, chunkSize) => {
// 	const chunks = [];
// 	for (let i = 0; i < array.length; i += chunkSize) {
// 		chunks.push(array.slice(i, i + chunkSize));
// 	}
// 	return chunks;
// };
//
// // Dividindo os cursos em grupos de quatro
// const groupedCursos = computed(() => chunkArray(props.cursos, 4));
//
// const slide = ref(1)
// const slider = ref(1)
// const autoplay = ref(true)

</script>
<template>

	<div class="tw-py-15 tw-pb-10">
		<div class="tw-flex tw-flex-1 tw-flex-col tw-w-auto tw-justify-center tw-items-center tw-text-center tw-px-24">
			<h5 class="tw-text-[42px] tw-font-title tw-font-bold tw-leading-[60px] lg:tw-w-auto tw-text-navy-500 tw-pb-4" >Vários espaços pra você aprender e empreender</h5>
			<div class="tw-text-center tw-px-20">
				<div class="tw-grid tw-grid-cols-2 tw-gap-6">
					<q-card class="tw-p-3 tw-rounded-1xl">
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
					<q-card class="tw-p-3 tw-rounded-1xl">
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
					<q-card class="tw-p-3 tw-rounded-1xl">
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
					<q-card class="tw-p-3 tw-rounded-1xl">
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
					<q-card class="tw-p-3 tw-rounded-1xl">
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
					<q-card class="tw-p-3 tw-rounded-1xl">
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
		</div>
		<q-card>

		</q-card>
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
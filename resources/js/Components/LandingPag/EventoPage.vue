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


const chunkArray = (array, chunkSize) => {
	const chunks = [];
	for (let i = 0; i < array.length; i += chunkSize) {
		chunks.push(array.slice(i, i + chunkSize));
	}
	return chunks;
};

// Dividindo os cursos em grupos de quatro
const groupedCursos = computed(() => chunkArray(props.cursos.data, 4));

const slide = ref(1)
const slider = ref(1)
const autoplay = ref(true)

</script>
<template>

	<div class="tw-py-10">
		<div class="tw-flex tw-flex-0 tw-flex-col tw-justify-center tw-items-center tw-text-center">
			<h5 class="tw-text-lg tw-font-title tw-font-bold tw-text-green-700">EVENTOS</h5>
			<h5 class="tw-text-[42px] tw-font-title tw-font-bold tw-leading-[60px] lg:tw-max-w-2xl tw-text-navy-500 " >Agenda de Eventos</h5>
			<p class="tw-text-[22px] tw-w-[50%] lg:tw-max-w-5xl tw-text-gray-700 tw-leading-2 tw-py-4">Confira os próximos eventos das Escolas do Futuro de Goiás</p>
		</div>
		<div class="tw-w-auto tw-mx-auto">
			<Carousel :autoplay="5000" :itemsToShow="3.95" :wrapAround="true" :transition="500">
				<Slide v-for="slider in groupedCursos" :key="slider" class="tw-py-10">
					<q-card class="tw-rounded-2xl tw-w-[95%]">
						<div class="tw-w-auto tw-h-[200px] tw-flex tw-flex-1 tw-p-10">
							<img :src=logoEfg class=" tw-w-auto tw-fill-current" alt=""/>
						</div>
						<q-card-section class="tw-w-full tw-flex tw-flex-1 tw-flex-col tw-p-3">
							<div class="tw-flex tw-flex-1 tw-pb-1">
								<Icon icon="mingcute:star-fill"  style="color: #94193e" />
								<Icon icon="mingcute:star-fill"  style="color: #94193e" />
								<Icon icon="mingcute:star-fill"  style="color: #94193e" />
								<Icon icon="mingcute:star-fill"  style="color: #94193e" />
								<Icon icon="mingcute:star-fill"  style="color: #94193e" />
							</div>
							<div class="tw-uppercase tw-text-green-800 tw-flex tw-justify-start tw-items-center">
								Nível Iniciante
							</div>
							<div class="tw-text-base tw-font-bold tw-flex tw-justify-start tw-items-center tw-pb-2">{{ slider.nome  }}</div>
							<div>
								<p class="tw-flex tw-flex-1 tw-items-center tw-text-left">Este curso tem por objetivo possibilitar o estudante aplicar o raciocínio lógico e computacional na resolução de problemas usando sistemas lógicos</p>
							</div>
							<div class="tw-flex tw-flex-1 tw-gap-2">
								<div class="tw-flex tw-gap-2 tw-items-center tw-text-sm">
									<Icon icon="fluent-mdl2:group"  style="color: #199432" />
									+ 16 anos</div>
								<div class="tw-flex tw-gap-2 tw-items-center tw-text-sm">
									<Icon icon="teenyicons:clock-outline"  style="color: #199432" />
									40h</div>
							</div>
							<div class="tw-flex tw-flex-1 tw-gap-2">
								<div class="tw-flex tw-gap-2 tw-items-center tw-text-sm">
									<Icon icon="ph:map-pin"  style="color: #199432" />
									Santo Antônio do Descoberto</div>
							</div>
							<div class="tw-flex tw-flex-1 tw-gap-2">
								<div class="tw-flex tw-gap-2 tw-items-center tw-text-sm">
									<Icon icon="ph:house-simple"  style="color: #199432" />
									EFG Sarah Luisa Lemos Kubitschek de Oliveira</div>
							</div>
							<div class="tw-flex tw-flex-1 tw-justify-between tw-items-center tw-w-auto tw-gap-2 tw-pt-4">
								<PrimaryButton class="tw-w-[100%] tw-text-green-800 tw-text-xs tw-h-5">SAIBA MAIS</PrimaryButton>
								<PrimaryButton class="tw-w-[100%] tw-text-green-800 tw-bg-white tw-border tw-border-green-800 tw-text-xs tw-h-5">INSCREVA-SE</PrimaryButton>
							</div>
						</q-card-section>
					</q-card>
				</Slide>
			</Carousel>
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
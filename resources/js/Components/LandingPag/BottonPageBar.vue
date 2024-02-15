<script setup>
import { computed, ref } from 'vue';
import PrimaryButton from '../Pages/PrimaryButton.vue';
import image from "primevue/image/Image.vue";
import { Carousel, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import { defineComponent } from 'vue'
import {Icon} from "@iconify/vue";
import logoEfg from "../../../imgs/logo-efg.png";



</script>
<template>
<div class=" tw-border-2 tw-border-t-green-800 tw-p-10">
	<div class="tw-grid tw-grid-cols-10 tw-border-b-2">
		<div>
			<p class="tw-font-bold">CURSOS</p>
			<p>Cursos</p>
			<p>Minicursos</p>
			<p>Editais</p>
		</div>
		<div class="tw-font-['Open Sans']">
			<p class="tw-font-bold">IDEIA AO NEGÓCIO</p>
			<p>Laboratório de Inovação</p>
			<p>Espaço Coletivo</p>
			<p>Consultorio</p>
			<p>Monte seu Negócio</p>
			<p>Projetos de Extensão e Cultura Maker</p>
			<p>Editais</p>
		</div>
		<div class="tw-pl-4 tw-font-['Open Sans']">
			<p class="tw-font-bold">INSTITUCIONAL</p>
			<p>Grupos de Pesquisa</p>
			<p>Grupos de Extensão e Cultura Maker</p>
			<p>Levemente</p>
			<p>Biblioteca</p>
		</div>
		<div class="tw-pl-4 tw-font-['Open Sans']">
			<p class="tw-font-bold">INSTITUCIONAL</p>
			<p>Quem Somos</p>
			<p>Unidades</p>
			<p>Notícias</p>
			<p>Identidade Virtual</p>
			<p>Fale Conosco</p>
			<p>Trabalhe Conosco</p>
		</div>
	</div>
	<div class="tw-flex tw-flex-1 tw-justify-between tw-items-center">
		<div class="tw-flex tw-flex-col">
			<div class="tw-flex tw-flex-1 tw-gap-4 tw-p-5" >
				<div class="tw-border tw-rounded-2xl tw-border-gray-500 tw-p-2">
					<Icon icon="ph:instagram-logo-thin" width="20" height="20" style="color: #1ee646" />
				</div>
				<div class="tw-border tw-rounded-2xl tw-border-gray-500 tw-p-2">
					<Icon icon="ph:tiktok-logo-thin" width="20" height="20" style="color: #1ee646" />
				</div>
				<div class="tw-border tw-rounded-2xl tw-border-gray-500 tw-p-2">
					<Icon icon="streamline:facebook-1" width="20" height="20" style="color: #1ee646" />
				</div>
				<div class="tw-border tw-rounded-2xl tw-border-gray-500 tw-p-2">
					<Icon icon="arcticons:youtube" width="20" height="20" style="color: #1ee646" />
				</div>
			</div>
			<div class="tw-flex tw-flex-1 tw-gap-5">
				<p class="tw-font-bold">ACESSO A INFORMAÇÃO . TRANSPARENCIA . SIGA ALUNO</p>
			</div>
		</div>
		<div class="tw-flex tw-items-center tw-gap-5">
			<div class="tw-w-[100%] tw-h-[60px] tw-rounded-2xl tw-bg-gray-100">
				<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
			</div>
			<div class="tw-w-[100%] tw-h-[60px] tw-rounded-2xl tw-bg-gray-100">
				<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
			</div>
			<div class="tw-w-[100%] tw-h-[60px] tw-rounded-2xl tw-bg-gray-100">
				<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
			</div>
			<div class="tw-w-[100%] tw-h-[60px] tw-rounded-2xl tw-bg-gray-100">
				<img :src=logoEfg class="tw-h-[100%] tw-fill-current tw-object-contain" alt=""/>
			</div>
		</div>

	</div>

</div>
<div class="tw-flex tw-text-lg tw-bg-[#1B6F2E] tw-items-center tw-justify-between tw-font-title tw-font-semibold tw-px-9 tw-text-white tw-uppercase tw-py-4">
	<div>
		governo do estado de goias
	</div>
	<div>
		todos direitos reservados cett/ufg - 2023
	</div>
</div>
</template>

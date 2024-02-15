<script setup>
import Header from "@/Components/LandingPag/HeaderPage.vue";
import PortalLayout from '@/Layouts/PortalLayout.vue';
import Curso from "@/Components/LandingPag/CursosPage.vue";
import Espaco from "@/Components/LandingPag/EspacoPage.vue";
import Evento from "@/Components/LandingPag/EventoPage.vue";
import Noticia from "@/Components/LandingPag/NoticiaPage.vue";
import BottonBar from "@/Components/LandingPag/BottonPageBar.vue";

import { Head } from "@inertiajs/vue3";


const props = defineProps({
	cursos: {
			 type: Array,
			 default: [],
		 },
})
</script>

<template>
  <Head title="Portal EFG" />
  <PortalLayout >
    <Header/>
	 <Curso :cursos="props.cursos"/>
	 <Espaco :cursos="props.cursos"/>
	 <Evento :cursos="props.cursos"/>
	 <Noticia :cursos="props.cursos"/>
	 <BottonBar :cursos="props.cursos"/>
  </PortalLayout>
</template>

<style>
@import url("https://fonts.googleapis.com/css2?family=Exo+2:wght@100;300;400;700;800&family=Open+Sans:wght@300;400;600;800&display=swap");

[type="text"]:focus,
[type="email"]:focus,
[type="url"]:focus,
[type="password"]:focus,
[type="number"]:focus,
[type="date"]:focus,
[type="datetime-local"]:focus,
[type="month"]:focus,
[type="search"]:focus,
[type="tel"]:focus,
[type="time"]:focus,
[type="week"]:focus,
[multiple]:focus,
textarea:focus,
select:focus {
  --tw-ring-shadow: 0;
}
</style>

<script setup>
import Navbars from "@/Components/LandingPag/Navbars.vue";
</script>

<template>
    <main>
	    <Navbars />
	    <slot />
    </main>
</template>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@100;300;400;700;800&family=Open+Sans:wght@300;400;600;800&display=swap');

    [type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus,
    [type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus,
    [type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus,
    textarea:focus, select:focus{
        --tw-ring-shadow: 0;
    }
</style>

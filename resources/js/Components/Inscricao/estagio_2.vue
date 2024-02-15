<template>
  <div class="tw-grid tw-grid-cols-4 tw-gap-3">
    <div v-for="tag, index in props.tags" :key="index" class="tw-justify-between">
      <CardTag v-if="tags.includes(tag.nome)" @click="() => toogleTags(tag.nome)" :value="tag"
        :selected="tagsSelecionada(tag.nome)" class="tw-w-[100%] tw-h-[100%] tw-p-1" :title="tag.nome" />
    </div>
  </div>
  <!-- Rodapé -->
  <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
    <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
    <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
      <PrimaryButton @click="voltar"
        button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
      </PrimaryButton>
      <PrimaryButton @click="avancar"
        button-class="tw-text-white tw-flex tw-bg-primary tw-h-10 tw-transition-all">
        {{ tagsSelected.length ? 'Avançar' : 'Não quero definir Tag' }}
      </PrimaryButton>
    </div>
  </div>
</template>
<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import SelecaoLayout from '@/Layouts/SelecaoLayout.vue';
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import { ref } from "vue";
import Card from "@/Components/Selecao/Card.vue";
import CardTag from "@/Components/Selecao/CardTag.vue";
import { Icon } from "@iconify/vue";
import { computed } from "vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Notify } from 'quasar';
import axios from 'axios';

const props = defineProps({
  Turmas: {
    type: Array,
    default: []
  },
})

const tagsSelected = ref([])
const estagio = ref(0)

const tags = props.tags.map(tag => tag.nome);


function tagsSelecionada(tags) {
  return tagsSelected.value.includes(tags)
}

function avancar() {
  estagio.value = estagio.value + 1
}

function voltar() {
  estagio.value = estagio.value - 1
}

const form = useForm({
  modalidadesSelected: '',
})

function store() {
  console.log('Função store acionada');
  form.modalidadesSelected = modalidadesSelected.value;
  form.post(route('inscricao.estagio_1'), {
  onFinish: () => {
    Notify.create({
      type: 'positive',
    });
  },
});
}

</script>
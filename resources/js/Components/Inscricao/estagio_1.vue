<template>
  <!-- Cards -->
  <div class="tw-flex tw-flex-1 tw-max-h-full">
    <div class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
      <Card v-if="modalidades.includes('Presencial')" @click="() => toogleModalidade('Presencial')"
        :selected="modalidadeSelecionada('Presencial')" icon="clarity:building-line" title="Presencial"
        description="O professor ensina em salas de aula e laboratórios, seguindo um cronograma previamente estabelecido" />
      <Card v-if="modalidades.includes('EAD')" @click="() => toogleModalidade('EAD')"
        :selected="modalidadeSelecionada('EAD')" icon="teenyicons:computer-outline" title="EAD"
        description="20% das aulas são presenciais, de acordo com a legislação. O restante é ensinado de forma online, dentro dos prazos estabelecidos" />
      <Card v-if="modalidades.includes('MOOC')" @click="() => toogleModalidade('MOOC')"
        :selected="modalidadeSelecionada('MOOC')" icon="teenyicons:computer-outline" title="MOOC"
        description="Os cursos MOOC são virtuais e automatizados, com inscrição e conclusão online, respeitando os prazos previstos" />
      <Card v-if="modalidades.includes('Online')" @click="() => toogleModalidade('Online')"
        :selected="modalidadeSelecionada('Online')" icon="typcn:video-outline" title="Online"
        description="Aprendizado é promovido através da plataforma virtual, usando computadores, smartphones ou tablets, com acesso à internet" />
    </div>
  </div>
  <!-- Rodapé -->
  <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
    <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
    <div class="tw-flex tw-flex-1 tw-gap-4 tw-justify-end tw-flex-col lg:tw-flex-row">
      <PrimaryButton @click="voltar"
        button-class="tw-text-primary tw-px-14 tw-self-center tw-bg-white tw-border-2 tw-border-primary tw-h-10">
        Voltar</PrimaryButton>
      <PrimaryButton @click="selecionarModalidade" button-class="tw-text-white tw-px-14 tw-self-center tw-bg-primary tw-h-10">
        {{ modalidadesSelected.length ? 'AVANÇAR' : 'NÃO QUERO DEFINIR MODALIDADE' }}
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
  escolas: {
    type: Array,
    default: [],
  },
  turmas: {
    type: Array,
    default: [],
  },
  modalidade_turma: {
    type: Array,
    default: []
  },
  editais: {
    type: Array,
    default: []
  },
  tagsCursos: {
    type: Array,
    default: []
  },
  tags: {
    type: Array,
    default: []
  }
})

const modalidades = props.modalidade_turma.map(turma => turma.modalidade);
const modalidadesSelected = ref([]);
const estagio = ref(0)
const modalidadesTagsCursos = ref([]);

function modalidadeSelecionada(modalidade) {
  return modalidadesSelected.value.includes(modalidade)
}

function toogleModalidade(mod) {
  if (modalidadesSelected.value.includes(mod))
    modalidadesSelected.value = modalidadesSelected.value.filter(m => m != mod)
  else
    modalidadesSelected.value.push(mod)
}

const form = useForm({
  modalidadesSelected: [],
})

function selecionarModalidade() {
  axios.post(route('inscricao.estagio_1'), { modalidadesSelected: modalidadesSelected.value })
    .then((res) => {

      console.log(res.data.tagsCursos)
      const modalidadesTagsCursosSet = new Set();
      res.data.tagsCursos.forEach(tags => tags.split(',').map(tag => modalidadesTagsCursosSet.add(tag.trim())));

      modalidadesTagsCursos.value = Array.from(modalidadesTagsCursosSet);

      if (modalidadesTagsCursosSet.size > 0) {
        Notify
          .create({
            message: "Inscrição realizada com sucesso.",
            color: "secondary"
          });
        estagio.value += 1;
      } else {
        Notify.create({
          message: "Selecione pelo menos uma modalidade.",
          color: "negative"
        });
      }
    })
    .catch((err) => {
      Notify.create({
        message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
        color: "negative"
      });
      estagio.value = 9;
    });
}

function avancar() {
  estagio.value += 1;
}

function voltar() {
  estagio.value -= 1;
}

</script>
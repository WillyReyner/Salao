<template>
   <Head title="Sistema de Seleção" />
   <SelecaoLayout>
     <div class="tw-rounded-lg tw-pb-1 tw-overflow-x-hidden">
       <div v-if="estagio == 0" class="tw-w-[1100px] tw-flex tw-flex-row tw-justify-center tw-rounded-lg">
         <div class="tw-flex tw-items-center lg:tw-flex-row">
           <img src="../../../imgs/Logotipo.svg" class="tw-mx-15 lg:tw-mx-0 lg:tw-mr-10" />
         </div>
         <div class="vertical-line tw-px-2"></div>
         <div class="tw-flex tw-flex-col tw-justify-center tw-p-6 tw-bg-white tw-items-center tw-rounded-lg">
           <div class="tw-flex tw-flex-1 tw-justify-center tw-items-center tw-flex-col lg:tw-flex-row">
             <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
           </div>
           <h4 class="tw-text-center tw-pb-3">Envio de Arquivos</h4>
           <p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-5 tw-text-center">
             Olá! Você esta acessando a página para envio de arquivos.
           </p>
           <p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-5 tw-text-center">
             Conforme descrito no Edital, separe seus documentos e vamos lá.
           </p>
           <br />
           <!-- Rodapé -->
           <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
             <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-center tw-flex-row">
               <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">CONTINUAR</PrimaryButton>
             </div>
           </div>
         </div>
       </div>
       <div v-if="estagio == 1" class="tw-justify-center tw-bg-white tw-py-6 tw-flex tw-flex-col tw-items-center tw-gap-5 tw-w-[800px] tw-rounded-lg">
         <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
           <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
         </div>
         <h4>Dados Pessoais</h4>
         <p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-3">
           Preencha os campos abaixo para continuar
         </p>
         <div class="tw-gap-5">
           <div class="tw-w-[500px] tw-justify-center">
             <InputLabel for="verificacao_cpf" value="CPF:" />
             <q-input outlined mask="###.###.###-##" id="verificacao_cpf" type="text" autofocus autocomplete="cpf"
               class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
               v-model="form.verificacao_cpf" :error="form.errors.cpf" />
             <InputError class="tw-mt-2" :message="form.errors.verificacao_cpf" />
           </div>
           <br />
           <div class="tw-w-[500px] tw-justify-center">
             <InputLabel for="verificacao_nascimento" value="Data de Nascimento" />
             <q-input outlined id="verificacao_nascimento" type="date" autofocus autocomplete="verificacao_nascimento"
               class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
               v-model="form.verificacao_nascimento" />
             <InputError class="tw-mt-2" :message="form.errors.verificacao_nascimento" />
           </div>
         </div>
         <br />
         <!-- Rodapé -->
         <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
           <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
             <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">CONTINUAR
             </PrimaryButton>
           </div>
         </div>
       </div>
       <br />
       <div v-if="estagio == 2" class="tw-bg-white tw-p-6 tw-flex tw-flex-col tw-gap-4 tw-w-[800px] tw-rounded-lg">
         <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
           <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
         </div>
         <h4>Lista de Cursos</h4>
         <div v-for="(item, index) in filtroInscricao" :key="index">
           <q-card style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 20px;">
             <h5 v-if="filtroTurma[index] && filtroTurma[index].categoria"
               class="tw-text-green-500 tw-text-sm tw-font-normal tw-font-body">
               Categoria: {{ filtroTurma[index].categoria }}
             </h5>
             <h5 v-if="filtroCurso[index] && filtroCurso[index].nome"
               class="tw-text-grey-500 tw-text-xl tw-font-normal tw-font-body">
               Cursos: {{ filtroCurso[index].nome }}
             </h5>
             <div class="tw-flex tw-justify-end">
               <button @click="openItem(item)">...</button>
             </div>
             <Transition name="fade">
               <div v-if="open == item">
                 <p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-3 tw-pt-6">
                   {{ formattedDate(item.created_at) }}
                 </p>
                 <p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-3">
                   {{ item.municipio }}
                 </p>
                 <p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-3">
                   {{ escolas[0].nome }}
                 </p>
                 <div style=" min-width: 35vw; max-width: 300px; border-radius: 10px; padding: 20px;">
                   <p class="tw-text-green-800" style="border-bottom: 1px solid #ccc">
                     DOCUMENTOS PESSOAIS ANEXADOS
                   </p>
                   <div class="tw-grid tw-grid-cols-2 tw-gap-5">
                     <div v-for="doc in props.comprovantes" :key="doc.id" class="tw-w-full">
                       <div class="tw-w-full">
                         <InputLabel :for="`tipo_arquivo_${doc.id}`" :value="getNomeDocumento(doc.tipo_arquivo_id)" />
                         <a
                           class="tw-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
                           VER DOCUMENTACAO
                           <div class="tw-ml-auto">
                             <Icon icon="material-symbols-light:quick-reference-all-outline" class="tw-text-green-700"
                               @click="openFileModal(doc.caminho)" />
                           </div>
                         </a>
                         <InputError class="tw-mt-2" :message="form.errors.nome_completo" />
                       </div>
                     </div>
                     <q-dialog v-model="fileModalVisible" full-width>
                       <q-card class="column full-height" style="width: 300px">
                         <q-card-section style="width: 100%; height: 93%">
                           <iframe :src="fileToView" style="width: 100%; height: 100%; border: none"></iframe>
                         </q-card-section>
                         <q-card-actions align="right">
                           <q-btn label="Fechar" color="primary" @click="closeFileModal" />
                         </q-card-actions>
                       </q-card>
                     </q-dialog>
                   </div>
                   <br />
                   <!-- Modal de visualização de arquivo -->
                   <q-dialog v-model="fileMatriculaModalVisible">
                     <q-card>
                       <q-card-section style="width: 800px; height: 600px">
                         <iframe :src="fileMatriculaToView" style="width: 70%; height: 100%"></iframe>
                       </q-card-section>
                       <q-card-actions align="right">
                         <q-btn label="Fechar" color="primary" @click="closeMatriculaFileModal" />
                       </q-card-actions>
                     </q-card>
                   </q-dialog>
                 </div>
                 <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
                   <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
                     <PrimaryButton @click="avancarId(item.id)" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">
                       ENVIAR DOCUMENTAÇÃO PARA MATRÍCULA</PrimaryButton>
                   </div>
                 </div>
               </div>
             </Transition>
             <br />
           </q-card>
         </div>
         <!-- Rodapé -->
         <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
           <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
             <PrimaryButton @click="voltar"
               button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
             </PrimaryButton>
           </div>
         </div>
       </div>
       <div v-if="estagio === 3" class="tw-flex tw-flex-1 tw-bg-white tw-p-6 tw-flex-col tw-min-w-[40vw] tw-rounded-lg">
         <!-- Arquivos (Documentos Anexos) -->
         <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
           <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
         </div>
         <br>
         <div v-for="(item, index) in props.documentacao_matricula" :key="index" class="tw-pb-5">
           <div class="tw-flex md:tw-flex-row tw-flex-col">
             <div class="tw-flex tw-flex-1 tw-flex-col">
               <h5 class="tw-text-gray-600 tw-font-body tw-text-sm tw-mb-1">{{ item.nome }}</h5>
               <q-file outlined rounded bg-color="white" label-color="green" v-model="form.arquivos[index]"
                 accept="application/pdf"
                 input-class="tw-text-primary tw-block tw-self-start focus:tw-border-primary focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                 label="Anexar Comprovante">
                 <template v-slot:prepend>
                   <Icon icon="majesticons:file-line" class="tw-text-green-700" />
                 </template>
                 <template v-slot:append>
                   <div class="tw-ml-auto">
                     <Icon icon="material-symbols-light:quick-reference-all-outline" class="tw-text-green-700"
                       @click="openFileModal(form.arquivos[index])" />
                   </div>
                 </template>
               </q-file>
             </div>
           </div>
         </div>
         <!-- Modal de visualização de arquivo -->
         <q-dialog v-model="fileModalVisible" full-width>
           <q-card class="column full-height" style="width: 300px">
             <q-card-section style="width: 100%; height: 93%">
               <iframe :src="fileToView" style="width: 100%; height: 100%; border: none"></iframe>
             </q-card-section>
             <q-card-actions align="right">
               <q-btn label="Fechar" color="primary" @click="closeFileModal" />
             </q-card-actions>
           </q-card>
         </q-dialog>
         <!-- Rodapé -->
         <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row tw-mt-2">
           <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
             <PrimaryButton @click="voltar"
               button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
             </PrimaryButton>
             <PrimaryButton @click="store" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">ENVIAR
             </PrimaryButton>
           </div>
         </div>
       </div>
       <div v-if="estagio == 4" class="tw-flex tw-flex-1 tw-flex-col tw-gap-6 tw-p-8 tw-text-center tw-justify-center tw-bg-white tw-w-[820px] tw-rounded-lg">
         <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5" />
         <h2 class="tw-font-bold tw-font-title tw-text-blue-900 tw-text-5xl tw-leading-9 tw-pb-1 ">
           Obrigado! Iremos validar os documentos!
         </h2>
         <h5 class="tw-font-bold tw-font-title tw-text-blue-900 tw-text-3xl tw-leading-7">
           Fique ligado em nossas redes sociais!
         </h5>
         <h6 class="tw-font-medium tw-font-subtitle tw-text-blue-900 tw-text-lg tw-leading-6 tw-mb-4">
           Indique a nossa escola para alguém que também pode aproveitas essa oportunidade!
         </h6>
       </div>
     </div>
     <!-- Confirmado -->
     <br />
   </SelecaoLayout>
 </template>
 <script setup>
 import { Head, Link, useForm } from "@inertiajs/vue3";
 import SelecaoLayout from "@/Layouts/SelecaoLayout.vue";
 import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
 import { ref } from "vue";
 import Card from "@/Components/Selecao/Card.vue";
 import { Icon } from "@iconify/vue";
 import { computed } from "vue";
 import InputLabel from "@/Components/Pages/InputLabel.vue";
 import InputError from "@/Components/Pages/InputError.vue";
 import { evaCloseCircleOutline } from "@quasar/extras/eva-icons";
 import { Notify } from "quasar";
 import axios from "axios";
 
 const props = defineProps({
   inscricoes: {
     type: Array,
     default: [],
   },
   turmas: {
     type: Array,
     default: {},
   },
   comprovantes: {
     type: Object,
     default: {},
   },
   comprovantesMatricula: {
     type: Object,
     default: {},
   },
   documentacao_inscricao: {
     type: Array,
     default: [],
   },
   documentacao_matricula: {
     type: Array,
     default: [],
   },
   curso: {
     type: Array,
     Default: [],
   },
   escolas: {
     type: Array,
     Default: [],
   },
   editais: {
     type: Array,
     default: []
   }
 });
 
 const open = ref('');
 
 function openItem(item) {
   if (open.value == item) {
     open.value = null;
   } else {
     open.value = item;
   }
 }
 
 const getNomeDocumento = (tipoArquivoId) => {
   const tipoArquivoIdNum = parseInt(tipoArquivoId);
   const documento = props.documentacao_inscricao.find(
     (doc) => doc.id === tipoArquivoIdNum
   );
   return documento ? documento.nome : "";
 };
 
 const estagio = ref(0);
 
 const fileToView = ref("");
 const fileModalVisible = ref(false);
 
 const openFileModal = (caminho) => {
   fileToView.value = getPublicStorageUrl(caminho);
   fileModalVisible.value = true;
 };
 
 const closeFileModal = () => {
   fileToView.value = "";
   fileModalVisible.value = false;
 };
 
 const fileMatriculaToView = ref("");
 const fileMatriculaModalVisible = ref(false);
 
 
 const closeMatriculaFileModal = () => {
   fileMatriculaToView.value = "";
   fileMatriculaModalVisible.value = false;
 };
 
 function avancar() {
   applyCursoFilter();
   estagio.value = estagio.value + 1;
 }
 
 function voltar() {
   estagio.value = estagio.value - 1;
 }
 
 function avancarId(inscId, docId) {
   const arquivosString = props?.editais?.documentos_matricula || '';
   const nomesDeArquivos = arquivosString.split(',');
   const arquivos = nomesDeArquivos.map(nome => ({ nome: nome.trim(), arquivo: null }));
 
   form.inscricaoId = inscId;
   form.documentoMatriculaId = docId;
   form.arquivos = arquivos;
 
   estagio.value = estagio.value + 1;
 }
 
 const filtroInscricao = ref([])
 const filtroTurma = ref([])
 const filtroCurso = ref([])
 const filtroEditais = ref([])
 const filtroEscola = ref([])
 const filtroComprovante = ref([])
 
 function applyCursoFilter() {
   const cpf = form.verificacao_cpf;
   const dataNascimento = form.verificacao_nascimento;
   const inscricoesEncontradas = props.inscricoes.filter((inscricao) => inscricao.cpf === cpf && inscricao.data_nascimento === dataNascimento);
   const turmasEncontradas = inscricoesEncontradas.map((inscricaoEncontrada) => { return props.turmas.find((turma) => turma.id === inscricaoEncontrada.turma_id); });
   const cursosEncontrados = turmasEncontradas.map((turmaEncontrada) => { return props.curso.find((cursos) => cursos.id === turmaEncontrada.curso_id) })
   const editaisEncontrados = turmasEncontradas.map((turmaEncontrada) => { return props.editais.find((edital) => edital.id === turmaEncontrada.edital_id) })
   const comprovantesEncontrados = inscricoesEncontradas.map((inscricaoEncontrada) => { return props.comprovantes.find((comprovante) => comprovante.inscricao_id === inscricaoEncontrada.id); });
   const escolasEncontradas = turmasEncontradas.map((turmaEncontrada) => { return props.escolas.find((escola) => escola.id === turmaEncontrada.escola_id) })
 
   filtroTurma.value = turmasEncontradas;
   filtroCurso.value = cursosEncontrados;
   filtroEditais.value = editaisEncontrados;
   filtroEscola.value = escolasEncontradas;
   filtroComprovante.value = comprovantesEncontrados;
   filtroInscricao.value = inscricoesEncontradas;
 }
 
 const form = useForm({
   verificacao_cpf: "",
   verificacao_nascimento: "",
   inscricaoId: props.inscricoes.id,
   documentoMatriculaId: '',
   arquivos: []
 });
 
 function store() {
   const arquivosSelecionados = form.arquivos.filter(item => item.name);
 
   console.log(arquivosSelecionados)
   if (arquivosSelecionados.length === 0) {
     Notify.create({
       message: "Nenhum arquivo selecionado.",
       color: "negative"
     });
     estagio.value = 3;
     return;
   }
 
   form.post(route('inscricao.matricula.store'), {
     inscricaoId: form.inscricaoId,
     documentoMatriculaId: form.documentoMatriculaId,
     arquivos: form.arquivos,
     onSuccess: (res) => {
       form.reset();
       Notify.create({
         message: "Inscrição realizada com sucesso.",
         color: "secondary"
       });
       estagio.value = 4;
     },
     onError: (err) => {
       Notify.create({
         message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
         color: "negative"
       });
       // Retornar para o estágio 2 em caso de erro
       estagio.value = 3;
     }
   });
 }
 
 
 const getPublicStorageUrl = (path) => {
   return `/storage/${path}`;
 };
 
 const formattedDate = (dateString) => {
   const options = {
     day: "2-digit",
     month: "2-digit",
     year: "numeric",
     hour: "2-digit",
     minute: "2-digit",
   };
   const date = new Date(dateString);
   return date.toLocaleDateString("pt-BR", options);
 };
 </script>
 
 <style scoped>
 /*
   Enter and leave animations can use different
   durations and timing functions.
 */
 .fade-enter-active {
   transition: all 0.8s ease-out;
 }
 
 .fade-leave-active {
   transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
 }
 
 .fade-enter-from,
 .fade-leave-to {
   transform: translateX(20px);
   opacity: 0;
 }
 
 .vertical-line {
   border-left: 2px solid #ffffff;
   height: 400px;
   margin: 0 20px;
 }
 </style>
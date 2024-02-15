<template>
  <Head title="Cursos" />

  <AuthenticatedLayout>
	  <div class="tw-flex tw-flex-1 tw-flex-col">
		  <div
			   class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
			  <div
				   class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
				  <h4 class="tw-font-title tw-font-semibold">Adicionar Curso</h4>
			  </div>
			  <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
				  <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
					  INFORMAÇÕES SOBRE O CURSO
				  </p>
			  </div>
			  <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-2 tw-gap-2">
				  <div class="tw-flex tw-flex-2 tw-flex-col">
					  <div class="q-file-image">
						  <q-file outlined :model-value="form.imagem" @update:model-value="updateFile" accept=".jpg,.png">
							  <template v-slot:before>
								  <div class="q-file-image-preview" :style="getImagePreviewStyle">
								  </div>
							  </template>
						  </q-file>
					  </div>
				  </div>
				  <div class="tw-flex tw-flex-auto tw-flex-col">
					  <div class="tw-flex tw-flex-row tw-justify-between">
						  <div class="tw-flex tw-flex-col tw-mr-4 tw-w-3/4">
							  <InputLabel for="nome" value="Nome do Curso" required />
							  <q-input id="nome" v-model="form.nome" type="text" outlined
							           class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
							  <InputError class="tw-mt-2" :message="form.errors.nome" />
						  </div>
						  <div class="tw-flex tw-flex-col tw-w-1/4">
							  <InputLabel for="situacao" value="Status" required />
							  <q-select id="situacao" v-model="form.situacao" :options="opcoesSituacao" outlined
							            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
							  <InputError class="tw-mt-2" :message="form.errors.situacao" />
						  </div>
					  </div>
					  <div class="tw-flex tw-flex-col tw-mt-4">
						  <InputLabel for="destaque" value="Destaque" required />
						  <div class="tw-flex tw-flex-row">
							  <q-radio v-model="form.destaque" val="Sim" label="Sim" />
							  <q-radio v-model="form.destaque" val="Nao" label="Não" />
						  </div>
						  <InputError class="tw-mt-2" :message="form.errors.destaque" />
					  </div>
					  <div class="tw-flex tw-flex-0 tw-gap-4 tw-my-1">
						  <div class="tw-w-full">
							  <InputLabel for="link_video_apresentacao" value="Link do Vídeo sobre o Curso" required />
							  <q-input id="link_video_apresentacao" outlined v-model="form.link_video_apresentacao" type="text" />
							  <InputError class="tw-mt-2" :message="form.errors.link_video_apresentacao" />
						  </div>
						  <div class="tw-w-full">
							  <InputLabel for="horas_curso" value="Carga Horária" required />
							  <q-select outlined :options="opcoesCargahoraria" v-model="form.horas_curso" id="horas_curso" />
							  <InputError class="tw-mt-2" :message="form.errors.horas_curso" />
						  </div>
					  </div>
					  <div class="tw-flex tw-flex-0 tw-gap-4 tw-my-2">
						  <div class="tw-w-full">
							  <InputLabel for="nivel" value="Nível" required />
							  <q-select outlined :options="opcoesNivel" v-model="form.nivel" id="nivel" />
							  <InputError class="tw-mt-2" :message="form.errors.nivel" />
						  </div>
						  <div class="tw-w-full">
							  <InputLabel for="faixa_etaria" value="Faixa Etária" required />
							  <q-select outlined :options="opcoesfaixaEtaria" v-model="form.faixa_etaria" id="horas_curso" />
							  <InputError class="tw-mt-2" :message="form.errors.faixa_etaria" />
						  </div>
					  </div>
				  </div>
			  </div>
			  <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-gap-2 tw-gap-2">
				  <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-mb-4">
					  INFORMAÇÕES COMPLEMENTARES
				  </p>
			  </div>
			  <div class="tw-flex tw-flex-0 tw-gap-4 tw-mb-4">
				  <div class="tw-w-full">
					  <InputLabel for="area" value="Área Principal" required />
					  <q-select
						   use-chips
						   multiple
						   outlined
						   use-input
						   v-model="form.area"
						   input-debounce="0"
						   :options="optionsArea"
						   @filter="filterFn" behavior="menu">
						  <template v-slot:no-option>
							  <q-item>
								  <q-item-section class="text-grey">
									  No results
								  </q-item-section>
							  </q-item>
						  </template>
					  </q-select>
					  <InputError class="tw-mt-2" :message="form.errors.area" />
				  </div>
				  <!--				 <div class="tw-w-full">-->
				  <!--					 <InputLabel for="subarea" value="Sub áreas" required />-->
				  <!--					 <q-select-->
				  <!--						  use-chips-->
				  <!--						  multiple-->
				  <!--						  outlined-->
				  <!--						  use-input-->
				  <!--						  v-model="form.subarea"-->
				  <!--						  input-debounce="0"-->
				  <!--						  :options="optionsTags"-->
				  <!--						  @filter="filterFn" behavior="menu"-->
				  <!--						 >-->
				  <!--						 <template v-slot:no-option>-->
				  <!--							 <q-item>-->
				  <!--								 <q-item-section class="text-grey">-->
				  <!--									 No results-->
				  <!--								 </q-item-section>-->
				  <!--							 </q-item>-->
				  <!--						 </template>-->
				  <!--					 </q-select>-->
				  <!--					 <InputError class="tw-mt-2" :message="form.errors.subarea" />-->
				  <!--				 </div>-->
			  </div>
			  <div class="tw-flex tw-flex-col tw-pt-2 tw-justify-start">
				  <InputLabel for="resumo" value="Texto para Site" required />
				  <q-input outlined rows="4"
				           v-model="form.texto_site" type="textarea" />
				  <InputError class="tw-mt-2" :message="form.errors.texto_site" />
			  </div>
			  <div>
				  <q-toggle class="tw-text-neutral-600 tw-mb-2" left-label v-model="form.des_texto_site" label="Ocultar campo no site"  />
			  </div>
			  <div class="tw-flex tw-flex-col tw-pt-2">
				  <InputLabel for="conteudo_programatico" value="Disciplina" required />
				  <q-input outlined rows="4"
				           class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-smauto-upload"
				           v-model="form.disciplina" type="textarea" />
				  <InputError class="tw-mt-2" :message="form.errors.disciplina" />
			  </div>
			  <div>
				  <q-toggle class="tw-text-neutral-600 tw-mb-2" left-label v-model="form.des_disciplina" label="Ocultar campo no site"/>
			  </div>
			  <div class="tw-flex tw-flex-col tw-pt-2">
				  <InputLabel for="conteudo_programatico" value="Conteúdo Programático" required />
				  <q-input outlined rows="4"
				           class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
				           v-model="form.conteudo_programatico" type="textarea" />
				  <InputError class="tw-mt-2" :message="form.errors.conteudo_programatico" />
			  </div>
			  <div>
				  <q-toggle class="tw-text-neutral-600 tw-mb-2" left-label v-model="form.des_conteudo" label="Ocultar campo no site"/>
			  </div>

			  <div class="tw-flex tw-flex-col tw-pt-2">
				  <InputLabel for="area_atuacao" value="Áreas de Atuação" required />
				  <q-input outlined rows="4"
				           class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
				           v-model="form.area_atuacao" type="textarea" />
				  <InputError class="tw-mt-2" :message="form.errors.area_atuacao" />
			  </div>
			  <div>
				  <q-toggle class="tw-text-neutral-600 tw-mb-2" left-label v-model="form.des_area_atuacao" label="Ocultar campo no site"/>
			  </div>
			  <div class="tw-flex tw-justify-end tw-gap-2 tw-pt-2">
				  <Link :href="route('painel.cursos')"
				        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
					  CANCELAR
				  </Link>
				  <span @click="update()"
				        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-gray-300 tw-bg-white tw-items-center">
				 <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
				 Salvar Rascunho
			  </span>
				  <span @click="store()"
				        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center">
				 <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
				 Salvar
			  </span>
			  </div>
		  </div>
	  </div>
  </AuthenticatedLayout>
</template>
<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { Notify } from 'quasar';
import { onMounted } from 'vue';
import { ref, computed } from 'vue';

const props = defineProps({
  turmas: {
    type: Array,
    default: []
  },
  curso: {
    type: Object,
    default: {}
  },
	tags: {
    type: Array,
    default: []
  },
})
const optionsArea = ref([])
const optionsSubArea = ref([])

const opcoesArea = props.tags.map((tag) => ({ label: tag.nome, value: tag.id }));
const opcoesSubArea = props.tags.map((tag) => ({ label: tag.nome, value: tag.id }));

const opcoesNivel = ["Iniciante", "Intermediário", "Avançado"];
const opcoesCargahoraria = [	"Curta (40 a 80 horas)", "Média (160 a 240 horas)", "Longa (800 a 1440 horas)" ];
const opcoesSituacao = ["Ativo", "Inativo", "Bloqueado"];
const opcoesfaixaEtaria = ["Faixa Etaria 1","Faixa Etaria 2","Faixa Etaria 3"]

const form = useForm({
	id: props.curso.id,
	nome: props.curso.nome,
	id_curso_siga: props.curso.id_curso_siga,
	escola_curso_siga: props.curso.escola_curso_siga,
	situacao: props.curso.situacao,
	destaque: props.curso.destaque,
	link_video_apresentacao: props.curso.link_video_apresentacao,
	horas_curso: props.curso.horas_curso,
	nivel: props.curso.nivel,
	faixa_etaria: props.curso.faixa_etaria,
	area: props.curso.tags.length > 0 ? props.curso.tags.filter((item) => item.tipo === 'area').map((item) => {return { label: item.tag.nome, value: item.tag.id }}) : [],
	subarea: props.curso.tags.length > 0 ? props.curso.tags.filter((item) => item.tipo === 'subarea').map((item) => {return { label: item.tag.nome, value: item.tag.id }}) : [],
	texto_site: props.curso.texto_site,
	des_texto_site: props.curso.des_texto_site === 1 ? true : 0,
	disciplina: props.curso.disciplina,
	des_disciplina: props.curso.des_disciplina === 1 ? true : 0,
	conteudo_programatico: props.curso.conteudo_programatico,
	des_conteudo: props.curso.des_conteudo === 1 ? true : 0,
	area_atuacao: props.curso.area_atuacao,
	des_area_atuacao: props.curso.des_area_atuacao === 1 ? true : 0,
	imagem: props.curso.imagem,
});

function filterFn(val, update) {
  if (val === "") {
    update(() => {
      optionsArea.value = opcoesArea;
		optionsSubArea.value = opcoesSubArea;
    });
    return;
  }

  update(() => {
    const needle = val.toLowerCase();
    optionsArea.value = opcoesArea.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
	  optionsSubArea.value = opcoesSubArea.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
  });
}

const defaultImage = ref(
  "https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
);

const srcImage = ref(null);

const toBase64 = (file) =>
  new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });

const updateFile = async (event) => {
  srcImage.value = await toBase64(event);
  form.imagem = event
};

const getImagePreviewStyle = computed(() => {
  let url = srcImage.value || defaultImage.value;
  return `background-image: url(${url})`;
});

const ImageBd = computed(() => {
  let url = props.curso.imagem;
  return `background-image: url(${url})`;
});

function validateForm() {
	const fieldLabels = {
		nome: 'Nome',
		situacao: "",
		destaque: 'Destaque',
		link_video_apresentacao: 'Link do Video',
		horas_curso: 'Carga Horária',
		nivel: 'Nível',
		faixa_etaria: "",
		area: 'Área',
		subarea: 'Subarea',
		texto_site: 'Texto do Site',
		des_texto_site: 'Ocultar Texto do Site?',
		disciplina: 'Disciplina',
		des_disciplina: 'Ocultar Disciplina?',
		conteudo_programatico: 'Conteudo Programatico',
		des_conteudo: 'Ocultar Conteudo?',
		area_atuacao: 'Área de Atuação',
		des_area_atuacao: 'Ocultar Ação?',
		imagem: 'Imagem',
	};

  const requiredFields = Object.keys(fieldLabels);

  requiredFields.forEach(field => {
    if (!form[field]) {
      form.errors[field] = `O campo ${fieldLabels[field]} é obrigatório`;
    } else {
      form.errors[field] = null;
    }
  });
}

function capitalizeFirstLetter(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function update() {

  validateForm()

  router.post(route('painel.cursos.update', form.id), {
    _method: 'patch',
    ...form
  }, {
    preserveScroll: true,
    onSuccess: (res) => {
      form.reset()
      Notify.create({
        message: "Dados do curso atualizado com sucesso.",
        color: "secondary"
      })
    },
    onError: (err) => {
      Notify.create({
        message: "Não foi possível atualizar os dados do curso.",
        color: "negative"
      })
    }
  })
}
</script>
<style>
.custom-uploader {
  max-width: 800px;
}

.q-file-image {
  width: 400px;
  position: relative;
  height: 330px;
  overflow: hidden;
  border-radius: 4px;
}

.q-file-image .q-field {
  padding: 0;
  border: 0 none;
}

.q-file-image .q-field .q-field__before,
.q-file-image .q-field .q-field__inner,
.q-file-image .q-field .q-field__control,
.q-file-image .q-field .q-field__control-container,
.q-file-image .q-field .q-field__native,
.q-file-image .q-field .q-field__input,
.q-file-image .q-field .q-field__control:before {
  margin: 0 !important;
  padding: 0 !important;
  border: 0 none !important;
  box-shadow: none !important;
  border-radius: 0;
}

.q-file-image .q-field .q-field__control,
.q-file-image .q-field .q-field__native {
  height: 400px;
}

.q-file-image .q-file-image-preview {
  position: absolute;
  left: 0;
  top: 0;
  height: 340px;
  width: 100%;
}

.q-file-image .q-file-image-preview img {
  display: block;
  width: 100%;
  object-fit: cover;
  border-radius: 4px;
}

.q-file-image .q-file-image-preview {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
}
</style>
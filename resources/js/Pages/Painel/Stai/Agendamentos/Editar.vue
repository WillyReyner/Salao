<template>
	<Head title="Editais"/>
	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				 class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">
						Alterar Edital
					</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
					   style="border-bottom: 2px solid #ccc">
						INFORMAÇÕES BÁSICAS
					</p>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md: tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_publicacao" required value="Data de Publicação"/>
						<q-input id="dt_publicacao" v-model="form.dt_publicacao" autocomplete="dt_publicacao" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_publicacao" class="tw-mt-2"/>
						<div class="tw-flex tw-flex-auto tw-flex-col tw-mt-4">
							<InputLabel for="agendar_publicacao" required value="Agendar Publicação"/>
							<div class="tw-flex tw-flex-row">
								<q-radio v-model="form.agendar_publicacao" label="Sim" val="Sim"/>
								<q-radio v-model="form.agendar_publicacao" label="Não" val="Nao"/>
							</div>
							<InputError :message="form.errors.destaque" class="tw-mt-2"/>
						</div>
					</div>
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_fim_edital" required value="Fim do Edital"/>
						<q-input id="dt_fim_edital" v-model="form.dt_fim_edital" autocomplete="dt_fim_edital" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_fim_edital" class="tw-mt-2"/>
					</div>

					<div class="tw-flex tw-flex-col tw-w-[40%]">
						<InputLabel for="nome" required value="Nome"/>
						<q-select v-model="form.nome" :options="opcoesEditalModelo"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          outlined
						/>
						<InputError :message="form.errors.nome" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[20%]">
						<InputLabel for="numero_edital" required value="Número do Edital"/>
						<q-input v-model="form.numero_edital"
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         mask="###########"
						         outlined/>
						<InputError :message="form.errors.numero_edital" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[20%]">
						<InputLabel for="situacao" required value="Status"/>
						<q-select v-model="form.situacao" :options="opcoesStatus"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          outlined
						          readonly/>
						<InputError :message="form.errors.situacao" class="tw-mt-2"/>
					</div>
				</div>
				<!-- Linha 02 -->
				<div class="tw-grid tw-grid-cols-12 tw-gap-5">
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-2">
						<InputLabel for="dt_inicio_inscricao" required value="Início da Inscrição"/>
						<q-input id="dt_inicio_inscricao" v-model="form.dt_inicio_inscricao"
						         autocomplete="dt_inicio_inscricao" autofocus
						         class="tw-mt-1 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_inicio_inscricao" class="tw-mt-2"/>
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-2">
						<InputLabel for="dt_fim_inscricao" required value="Término da Inscrição"/>
						<q-input id="dt_fim_inscricao" v-model="form.dt_fim_inscricao" autocomplete="dt_fim_inscricao"
						         autofocus
						         class="tw-mt-1  tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_fim_inscricao" class="tw-mt-2"/>
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-4">
						<InputLabel for="escola_id" required value="Escolas"/>
						<q-select v-model="form.escola_id" :options="optionsEscolas" behavior="menu"
						          class="tw-mt-1 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0"
						          outlined use-input @filter="filterFn"
						          @update:modelValue="updateMunicipioBasedOnEscola">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.escola_id" class="tw-mt-2"/>
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-4">
						<InputLabel for="municipio_id" required value="Municipios"/>
						<q-select id="municipio_id" v-model="form.municipio_id" :options="opcoesMunicipio"
						          :readonly="form.udepi === 'Nao' || form.udepi === ''"
						          class="tw-mt-1 tw-text-gray-700  tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          emit-value map-options
						          outlined
						          placeholder="Selecione a Escola primeiro"/>
						<InputError :message="form.errors.municipio_id" class="tw-mt-2"/>
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
						<InputLabel for="udepi" required value="UDEPI?"/>
						<div class="tw-flex tw-flex-row">
							<!-- Adicione esta div para alinhar os radio buttons lado a lado -->
							<q-radio v-model="form.udepi" label="Sim" val="Sim" @update:modelValue="enableUdepiField('Sim')"/>
							<q-radio v-model="form.udepi" label="Não" val="Nao" @update:modelValue="enableUdepiField('Nao')"/>
						</div>
						<InputError :message="form.errors.destaque" class="tw-mt-2"/>
					</div>
				</div>
				<!-- <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						DOCUMENTAÇÃO EXIGIDA
					</p>
				</div>
				<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3 tw-pb-2">
					<InputLabel for="documentos_inscricao" value="Documentação Exigida" required />
					<q-select use-chips multiple outlined use-input v-model="form.documentos_inscricao" input-debounce="0"
						 :options="optionsDocInsc" @filter="filterFn" behavior="menu"
						class="tw-mt-1 tw-h-[100%] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						 <template v-slot:no-option>
							  <q-item>
									<q-item-section class="text-grey">
										 No results
									</q-item-section>
							  </q-item>
						 </template>
					</q-select>
			  </div> -->
				<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
					<InputLabel for="documentos_matricula" required value="Documentação Para Matricula"/>
					<q-select v-model="form.documentos_matricula" :options="optionsDocMat" behavior="menu"
					          class="tw-mt-1 tw-h-[100%] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
					          input-debounce="0" multiple
					          outlined use-chips use-input
					          @filter="filterFn">
						<template v-slot:no-option>
							<q-item>
								<q-item-section class="text-grey">
									No results
								</q-item-section>
							</q-item>
						</template>
					</q-select>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
					   style="border-bottom: 2px solid #ccc">
						ANEXAR ARQUIVOS
					</p>
				</div>
				<DocumentInEdital :documentos="props.documentos" :edital_id="props.edital.id"/>
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
						VINCULE AS TURMAS DO EDITAL
					</p>
					<div
						 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
						<a :href="route('painel.turmas.create')" target="_blank">
							<PrimaryButton class="tw-text-white tw-bg-green-500 tw-items-center">
								<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add"/>
								ADICIONAR TURMA
							</PrimaryButton>
						</a>
					</div>
				</div>
				<TurmaInEdital :edital_id="props.edital.id" :turmas="props.turmas"/>
				<div class="tw-flex tw-justify-end tw-gap-2 tw-pt-4">
					<Link :href="route('painel.editais')"
					      class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
						CANCELAR
					</Link>
					<span
						 class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center "
						 @click="update()">
						<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="fluent:save-16-regular"/>
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
import TurmaInEdital from '@/Components/Selecao/TurmaInEdital.vue'
import DocumentInEdital from '@/Components/Selecao/DocumentInEdital.vue'
import {Icon} from '@iconify/vue';
import {Head, useForm, router, Link} from '@inertiajs/vue3';
import {evaArrowBackOutline} from '@quasar/extras/eva-icons';
import {Notify} from 'quasar';
import {onMounted} from 'vue';
import {ref, computed, watch} from 'vue';

const props = defineProps({
	edital: {
		type: Object,
		default: {},
	},
	escolas: {
		type: Array,
		default: [],
	},
	tiposArquivo: {
		type: Array,
		default: [],
	},
	municipios: {
		type: Array,
		default: '',
	},
	turmas: {
		type: Array,
		default: '',
	},
	documentos: {
		type: Array,
		default: '',
	},
	tipoarquivos: {
		type: Array,
		default: []
	},
	editalModelo: {
		type: Array,
		default: []
	}
});

const agendar_publicacao = ref('');
const udepi = ref('');
const selectedCourseId = ref(null);
const municipioId = ref(null);

const optionsEscolas = ref([])
const optionsDocInsc = ref([])
const optionsDocMat = ref([])

const opcoesEscola = props.escolas.map(escola => ({label: escola.nome, value: escola.id}))
const opcoesMunicipio = props.municipios.map(municipio => ({label: municipio.nome, value: municipio.id}))

const opcoesEditalModelo = props.editalModelo.map(editalModel =>  ({label: editalModel.nome, value: editalModel.id}));

const opcoesStatus = ['Ativo', 'Inativo', 'Bloqueado'];

const opcoesDocumentosInscricao = props.tipoarquivos.map(documentacoes_inscricoes => ({
	label: documentacoes_inscricoes.nome,
	value: documentacoes_inscricoes.id
}));
const opcoesDocumentosMatricula = props.tipoarquivos.map(documentacoes_matriculas => ({
	label: documentacoes_matriculas.nome,
	value: documentacoes_matriculas.id
}));

const form = useForm({
	id: props.edital.id,
	nome: props.edital.nome,

	dt_publicacao: props.edital.dt_publicacao ? props.edital.dt_publicacao.split(' ')[0] : '',
	dt_fim_edital: props.edital.dt_fim_edital ? props.edital.dt_fim_edital.split(' ')[0] : '',
	numero_edital: props.edital.numero_edital,
	escola_id: props.edital.escola_id ? props.edital.escola.nome : '',

	documentos_inscricao: props.edital.tipo_arquivos.length > 0 ? props.edital.tipo_arquivos.filter(tags => tags.tipo === '1').map(tags => ({
		label: tags.tipo_arquivo.nome,
		value: tags.tipo_arquivo.id
	})) : [],

	documentos_matricula: props.edital.tipo_arquivos.length > 0 ? props.edital.tipo_arquivos.filter(tags => tags.tipo === '2').map(tags => ({
		label: tags.tipo_arquivo.nome,
		value: tags.tipo_arquivo.id
	})) : [],

	agendar_publicacao: props.edital.agendar_publicacao,
	dt_inicio_inscricao: props.edital.dt_inicio_inscricao ? props.edital.dt_inicio_inscricao.split(' ')[0] : '',
	dt_fim_inscricao: props.edital.dt_fim_inscricao ? props.edital.dt_fim_inscricao.split(' ')[0] : '',
	situacao: props.edital.situacao,
	municipio_id: props.edital.municipio_id,
	udepi: props.edital.udepi,
});

function filterFn(val, update) {
	if (val === "") {
		update(() => {
			optionsEscolas.value = opcoesEscola;
			optionsDocInsc.value = opcoesDocumentosInscricao;
			optionsDocMat.value = opcoesDocumentosMatricula;
		});
		return;
	}

	update(() => {
		const needle = val.toLowerCase();
		optionsEscolas.value = opcoesEscola.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsDocInsc.value = opcoesDocumentosInscricao.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsDocMat.value = opcoesDocumentosMatricula.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
	});
}

function validateForm() {
	const fieldLabels = {
		dt_publicacao: 'Data de Publicação',
		dt_fim_edital: 'Fim do Edital',
		numero_edital: 'Número do Edital',
		escola_id: 'Escola',
		documentos_inscricao: 'Documentação Exigida',
		documentos_matricula: 'Documentação para Matrícula',
		agendar_publicacao: 'Agendar Publicação',
		dt_inicio_inscricao: 'Início da Inscrição',
		dt_fim_inscricao: 'Término da Inscrição',
		situacao: 'Status',
		municipio_id: 'Município',
		udepi: 'UDEPI',
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

	form.escola_id = props.edital.escola.id

	router.post(
		 route('painel.editais.update', form.id),
		 {
			 _method: 'patch',
			 ...form,
		 },
		 {
			 preserveScroll: true,
			 forceFormData: true,
			 onSuccess: (res) => {
				 form.reset();
				 Notify.create({
					 message: 'Dados do edital atualizados com sucesso.',
					 color: 'secondary',
				 });
			 },
			 onError: (err) => {
				 Notify.create({
					 message: 'Não foi possível atualizar os dados do edital.',
					 color: 'negative',
				 });
			 },
		 }
	);
}


//Exportar CSV
const exportToCSV = () => {
	// Dados da tabela
	const columns = [
		'ID',
		'Turma',
		'Vagas',
		'Status',
	];

	const data = filteredTurmas.value.map((turma) => [
		turma.id,
		turma.nome,
		turma.vagas,
		turma.situacao,
	]);

	// Preparar os dados para exportação CSV
	const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;

	// Criar um objeto Blob para o conteúdo CSV
	const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});

	// Criar um URL para o Blob
	const url = window.URL.createObjectURL(blob);

	// Criar um link de download
	const link = document.createElement('a');
	link.setAttribute('href', url);
	link.setAttribute('download', 'turmas.csv');
	document.body.appendChild(link);

	// Clicar no link para iniciar o download
	link.click();

	// Limpar o link e revogar o objeto URL
	document.body.removeChild(link);
	window.URL.revokeObjectURL(url);
};


watch(
	 () => form.udepi,
	 (newValue) => {
		 if (newValue !== 'Sim') {
			 if (municipioId.value !== null) {
				 form.municipio_id = municipioId.value;
			 }
		 }
	 }
);

watch(
	 () => [form.dt_publicacao, form.dt_fim_edital],
	 ([publicacao, fimEdital]) => {
		 const currentDate = new Date();
		 const editalStartDate = new Date(publicacao);
		 const editalEndDate = new Date(fimEdital);

		 // Verifique se a data atual está entre dt_publicacao e dt_fim_edital
		 if (editalStartDate <= currentDate && currentDate <= editalEndDate) {
			 form.situacao = 'Ativo';
		 } else {
			 form.situacao = 'Inativo';
		 }
	 }
);


function updateMunicipioBasedOnEscola() {
	if (form.escola_id !== null) {
		form.municipio_id = props.escolas.find((escola) => escola.id === form.escola_id.value)?.municipio_id;
	} else {
		form.municipio_id = null;
	}
}

function enableUdepiField(value) {
	if (value === 'Sim') {
		municipioId.value = form.municipio_id;
	} else if (value === 'Nao') {
		form.municipio_id = municipioId.value;
	}
}
</script>

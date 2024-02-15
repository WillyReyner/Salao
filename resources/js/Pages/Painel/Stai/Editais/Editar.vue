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
	staiEditais: {
		type: Object,
		default: {},
	},
});

const agendar_publicacao = ref('');
const udepi = ref('');
const selectedCourseId = ref(null);
const municipioId = ref(null);

const optionsEscolas = ref([])
const optionsDocInsc = ref([])
const optionsDocMat = ref([])

// const opcoesEscola = props.escolas.map(escola => ({label: escola.nome, value: escola.id}))
// const opcoesMunicipio = props.municipios.map(municipio => ({label: municipio.nome, value: municipio.id}))
//
// const opcoesEditalModelo = props.editalModelo.map(editalModel =>  ({label: editalModel.nome, value: editalModel.id}));
//
const opcoesStatus = ['Ativo', 'Inativo', 'Bloqueado'];
//
// const opcoesDocumentosInscricao = props.tipoarquivos.map(documentacoes_inscricoes => ({
// 	label: documentacoes_inscricoes.nome,
// 	value: documentacoes_inscricoes.id
// }));
// const opcoesDocumentosMatricula = props.tipoarquivos.map(documentacoes_matriculas => ({
// 	label: documentacoes_matriculas.nome,
// 	value: documentacoes_matriculas.id
// }));

const form = useForm({
	id: props.staiEditais.id,
	nome: props.staiEditais.nome,

	dt_publicacao: props.staiEditais.dt_publicacao ? props.staiEditais.dt_publicacao.split(' ')[0] : '',
	dt_fim_staiEditais: props.staiEditais.dt_fim_staiEditais ? props.staiEditais.dt_fim_staiEditais.split(' ')[0] : '',
	numero_staiEditais: props.staiEditais.numero_staiEditais,
	escola_id: props.staiEditais.escola_id ? props.staiEditais.escola.nome : '',

	// documentos_inscricao: props.staiEditais.tipo_arquivos.length > 0 ? props.staiEditais.tipo_arquivos.filter(tags => tags.tipo === '1').map(tags => ({
	// 	label: tags.tipo_arquivo.nome,
	// 	value: tags.tipo_arquivo.id
	// })) : [],
	//
	// documentos_matricula: props.staiEditais.tipo_arquivos.length > 0 ? props.staiEditais.tipo_arquivos.filter(tags => tags.tipo === '2').map(tags => ({
	// 	label: tags.tipo_arquivo.nome,
	// 	value: tags.tipo_arquivo.id
	// })) : [],

	agendar_publicacao: props.staiEditais.agendar_publicacao,
	dt_inicio_inscricao: props.staiEditais.dt_inicio_inscricao ? props.staiEditais.dt_inicio_inscricao.split(' ')[0] : '',
	dt_fim_inscricao: props.staiEditais.dt_fim_inscricao ? props.staiEditais.dt_fim_inscricao.split(' ')[0] : '',
	situacao: props.staiEditais.situacao,
	municipio_id: props.staiEditais.municipio_id,
	udepi: props.staiEditais.udepi,
	tipo: props.staiEditais.tipo
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
		tipo: 'Tipo de Edital',
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
				<div class="tw-flex tw-flex-row tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-col tw-w-[100%]">
						<InputLabel for="data_publicacao" required value="Data de Publicação"/>
						<q-input id="data_publicacao" v-model="form.data_publicacao" autocomplete="data_publicacao" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.data_publicacao" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[100%]">
						<InputLabel for="data_fim_edital" required value="Fim do Edital"/>
						<q-input id="data_fim_edital" v-model="form.data_fim_edital" autocomplete="data_fim_edital" autofocus
						         :disabled="hasPermission !== 'admin'"
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.data_fim_edital" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[100%]">
						<InputLabel for="dt_inicio_inscricao" required value="Início da Inscrição"/>
						<q-input id="dt_inicio_inscricao" v-model="form.dt_inicio_inscricao"
						         autocomplete="dt_inicio_inscricao" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_inicio_inscricao" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[100%]">
						<InputLabel for="dt_fim_inscricao" required value="Término da Inscrição"/>
						<q-input id="dt_fim_inscricao" v-model="form.dt_fim_inscricao" autocomplete="dt_fim_inscricao"
						         autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_fim_inscricao" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-col tw-w-[50%]">
						<InputLabel for="nome" required value="Nome"/>
						<q-input v-model="form.nome" class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined type="text"
						/>
						<InputError :message="form.errors.nome" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[25%]">
						<InputLabel for="situacao" required value="Status"/>
						<q-select v-model="form.situacao" :options="opcoesStatus"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          outlined
						/>
						<InputError :message="form.errors.situacao" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[25%]">
						<InputLabel for="tipo" required value="Status"/>
						<q-select v-model="form.tipo" :options="opcoesStatus"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          outlined
						/>
						<InputError :message="form.errors.tipo" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
					   style="border-bottom: 2px solid #ccc">
						ANEXAR ARQUIVOS
					</p>
				</div>
				<DocumentInEdital :documentos="props.documentos" :edital_id="props.staiEditais.id"/>
				<div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
						VINCULE AS TURMAS DO EDITAL
					</p>
					<div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
						<a :href="route('painel.turmas.create')" target="_blank">
							<PrimaryButton class="tw-text-white tw-bg-green-500 tw-items-center">
								<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add"/>
								ADICIONAR TURMA
							</PrimaryButton>
						</a>
					</div>
				</div>
				<TurmaInEdital :edital_id="props.staiEditais.id" :turmas="props.turmas"/>
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
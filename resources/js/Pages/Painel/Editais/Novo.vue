<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Icon} from '@iconify/vue';
import {Head, useForm, router, Link} from '@inertiajs/vue3';
import {Notify} from 'quasar';
import {onMounted} from 'vue';
import {ref, computed, watch} from 'vue';


const props = defineProps({
	escolas: {
		type: Array,
		default: []
	},
	tiposArquivo: {
		type: Array,
		default: []
	},

	editais: {
		type: Array,
		default: []
	},
	turmas: {
		type: Array,
		default: [],
	},

	municipios: {
		type: Array,
		default: [],
	},
	cursos: {
		type: Array,
		default: [],
	},
	documentacao: {
		type: Array,
		default: [],
	},
	editalModelo: {
		type: Array,
		default: [],
	}
})

const municipioId = ref('')
const optionsEscolas = ref([])
const optionsDocInsc = ref([])
const optionsDocMat = ref([])

const opcoesEditalModelo = props.editalModelo.map(editalModel =>  ({label: editalModel.nome, value: editalModel.id}));

const opcoesEscola = props.escolas.map(escola => ({label: escola.nome, value: escola.id}))
const opcoesMunicipio = props.municipios.map(municipio => ({label: municipio.nome, value: municipio.id}))

const opcoesArea = ['Arte Educação', 'Artes Visuais', 'Circo', 'Dança', 'Música', 'Superior de Tecnologia', 'Teatro', 'Tecnologia e Inovação', 'Todas']

const opcoesStatus = ['Ativo', 'Inativo', 'Bloqueado']

const opcoesDocumentosInscricao = props.documentacao.map(documentacao => ({
	label: documentacao.nome,
	value: documentacao.id
}))
const opcoesDocumentosMatricula = props.documentacao.map(documentacao => ({
	label: documentacao.nome,
	value: documentacao.id
}))

const form = useForm({
	nome: '',
	numero_edital: '',
	dt_publicacao: '',
	dt_fim_edital: '',
	escola_id: '',
	agendar_publicacao: "Nao",
	dt_inicio_inscricao: '',
	dt_fim_inscricao: '',
	situacao: '',
	municipio_id: '',
	udepi: 'Nao',
	documentos_inscricao: [],
	documentos_matricula: [],
	turma_id: '',
	area: ''
})

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

function store() {

	validateForm()

	form.escola_id = form.escola_id.value

	form.post(route('painel.editais.store'), {
		preserveScroll: true,
		forceFormData: true,
		onSuccess: (res) => {
			form.reset()
			Notify.create({
				message: "Edital registrado com sucesso.",
				color: "secondary"
			})
		},
		onError: (err) => {
			console.log(err)
			Notify.create({
				message: "Não foi possível registrar o Edital.",
				color: "negative"
			})
		}
	})
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

	const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;

	const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});

	const url = window.URL.createObjectURL(blob);

	const link = document.createElement('a');

	link.setAttribute('href', url);

	link.setAttribute('download', 'turmas.csv');

	document.body.appendChild(link);

	link.click();

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
	 () => [form.dt_publicacao, form.dt_fim_edital, form.dt_inicio_inscricao, form.dt_fim_inscricao],
	 ([publicacao, fimEdital, inicioInscricao, fimInscricao]) => {
		 const currentDate = new Date();
		 const editalStartDate = new Date(publicacao);
		 const editalEndDate = new Date(fimEdital);
		 const incricaoStartDate = new Date(inicioInscricao);
		 const inscricaoEndDate = new Date(fimInscricao);

		 if (editalEndDate < editalStartDate) {
			 form.errors.dt_fim_edital = 'A data de término do edital não pode ser menor do que a data de Publicação.';
		 } else {
			 form.errors.dt_fim_edital = '';
		 }

		 if (editalStartDate > editalEndDate) {
			 form.errors.dt_publicacao = 'A data de Publicação não pode ser maior do que a data do Fim do Edital.';
		 } else {
			 form.errors.dt_publicacao = '';
		 }

		 if (inscricaoEndDate < incricaoStartDate) {
			 form.errors.dt_fim_inscricao = 'A data de Fim da Inscrição não pode ser menor do que a data de Iníco da Inscrição.';
		 } else {
			 form.errors.dt_fim_inscricao = '';
		 }

		 if (incricaoStartDate > inscricaoEndDate) {
			 form.errors.dt_inicio_inscricao = 'A data de Inicio de Inscrição não pode ser maior do que a data do Fim do Inscrição.';
		 } else {
			 form.errors.dt_inicio_inscricao = '';
		 }

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
					<h4 class="tw-font-title tw-font-semibold">Adicionar Edital</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md: tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
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
<!--					<div class="tw-flex tw-flex-col tw-w-[100%]">-->
<!--						<InputLabel for="nome_edital" required value="Nome do Edital"/>-->
<!--						<q-input v-model="form.nome"-->
<!--						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--						         outlined-->
<!--						         type="text"/>-->
<!--						<InputError :message="form.errors.nome_edital" class="tw-mt-2"/>-->
<!--					</div>-->
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
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_inicio_inscricao" required value="Início da Inscrição"/>
						<q-input id="dt_inicio_inscricao" v-model="form.dt_inicio_inscricao"
						         autocomplete="dt_inicio_inscricao" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_inicio_inscricao" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_fim_inscricao" required value="Término da Inscrição"/>
						<q-input id="dt_fim_inscricao" v-model="form.dt_fim_inscricao" autocomplete="dt_fim_inscricao"
						         autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="date"/>
						<InputError :message="form.errors.dt_fim_inscricao" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col tw-w-[20%]">
						<InputLabel for="area" required value="Area"/>
						<q-select v-model="form.area" :options="opcoesArea"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          outlined
						          />
						<InputError :message="form.errors.area" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-col">
						<InputLabel for="escola_id" required value="Escolas"/>
						<q-select v-model="form.escola_id" :options="optionsEscolas" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
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
						<div class="tw-flex tw-flex-auto tw-flex-col tw-mt-4">
							<InputLabel for="udepi" required value="UDEPI?"/>
							<div class="tw-flex tw-flex-row">
								<q-radio v-model="form.udepi" label="Sim" val="Sim"
								         @update:modelValue="enableUdepiField('Sim')"/>
								<q-radio v-model="form.udepi" label="Não" val="Nao"
								         @update:modelValue="enableUdepiField('Nao')"/>
							</div>
							<InputError :message="form.errors.destaque" class="tw-mt-2"/>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="municipio_id" required value="Municipios"/>
						<q-select
							 id="municipio_id"
							 v-model="form.municipio_id"
							 :options="opcoesMunicipio"
							 :readonly="form.udepi === 'Nao' || form.udepi === ''"
							 class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							 emit-value label="Selecione a Escola primeiro"
							 map-options
							 outlined/>
						<InputError :message="form.errors.municipio_id" class="tw-mt-2"/>
					</div>
				</div>
				<!-- <div class="tw-flex md:tw-flex-row tw-flex-col md: tw-gap-2 tw-m-2 tw-border-b-2 tw-border-gray-200">
					 <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">DOCUMENTAÇÃO EXIGIDA</p>
				</div>
				<div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
					 <InputLabel for="documentos_inscricao" value="Documentação Exigida" required />
					 <q-select use-chips multiple outlined use-input v-model="form.documentos_inscricao" input-debounce="0"
						  :options="optionsDocInsc" @filter="filterFn" behavior="menu"
						  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						  <template v-slot:no-option>
								<q-item>
									 <q-item-section class="text-grey">
										  No results
									 </q-item-section>
								</q-item>
						  </template>
					 </q-select>
				</div> -->
				<div class="tw-flex tw-flex-col tw-gap-2 tw-m-2 tw-pb-4">
					<InputLabel for="documentos_matricula" required value="Documentação Para Matricula"/>
					<q-select v-model="form.documentos_matricula" :options="optionsDocMat" behavior="menu"
					          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
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
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.editais')"
					      class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
						CANCELAR
					</Link>
					<span
						 class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center "
						 @click="store()">
                        <Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="fluent:save-16-regular"/>
                        PRÓXIMO
                    </span>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>




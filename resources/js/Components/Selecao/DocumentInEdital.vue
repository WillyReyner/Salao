<template>
	
		<!-- Página Principal -->
		<div class="tw-flex tw-flex-1 tw-flex-col tw-m-2">
			<div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow-none sm:tw-rounded-lg tw-overflow-hidden tw-overflow-y-scroll">
				<div class="tw-grid tw-grid-cols-12 tw-gap-5">
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
						<InputLabel for="documentos" value="Tipo" required />
						<q-select id="documentos" outlined map-options emit-value v-model="formD.tipo"
							:options="opcoesTipoDocumentos"
							class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
						<InputError class="tw-mt-2" :message="formD.errors.documentos" />
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
						<InputLabel for="arquivo" value="Arquivos" required />
						<q-file standout bg-color="blue" label-color="white" v-model="formD.arquivo"
							input-class="tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							label="Anexar Arquivo">
							<template v-slot:prepend>
								<Icon icon="ph:upload-light" class="tw-text-white" />
							</template>
						</q-file>
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
						<InputLabel for="data_publicacao" value="Data de Publicacao" required />
						<q-input outlined id="data_publicacao" type="date" required autofocus autocomplete="data_publicacao"
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="formD.data_publicacao" />
						<InputError class="tw-mt-2" :message="formD.errors.data_publicacao" />
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
						<InputLabel for="versao" value="Versão" required />
						<q-select id="versao" outlined map-options emit-value v-model="formD.versao" :options="opcoesVersoes"
							class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
						<InputError class="tw-mt-2" :message="formD.errors.versao" />
					</div>
					<div class="tw-col-span-1 md:tw-col-span-12 lg:tw-col-span-12 tw-flex tw-justify-end">
						<PrimaryButton @click="storeDocumentos()" class="tw-text-white tw-bg-green-500">
							 <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
							 Adicionar Arquivo
						</PrimaryButton>
				  </div>
				</div>
				<!-- Tabela de Exibição -->
				<div class="tw-antialiased tw-font-body">
					<div class="tw-py-4 tw-overflow-x-auto">
						<div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
							<q-table flat wrap-cells :rows="filteredDocumentos" :columns="columns" :filter="busca"
								:visible-columns="visibleColumns" :pagination="initialPagination" row-key="id"
								no-data-label="Não há informações cadastradas."
								no-results-label="Não foi possível localizar informações com o filtro inserido."
								:selected="rowsSelected" selection="multiple" rows-per-page-label="Registros por página"
								v-model:pagination="initialPagination" :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`
									" :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'">
									<template v-slot:header="props">
										<q-tr :props="props" class="tw-h-20">
											 <q-td auto-width>
												  <q-checkbox dense v-model="props.selected" />
											 </q-td>
											 <q-th v-for="col in props.cols" :key="col.name" :props="props">
												  <span class="tw-font-title tw-text-gray-600 tw-text-lg">
														{{ col.label }}
												  </span>
											 </q-th>
										</q-tr>
								  </template>
								  <template v-slot:body="props">
										<q-tr :props="props" no-hover
											 class="roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-h-20 tw-transition-colors">
											 <q-td auto-width>
												  <q-checkbox dense v-model="props.selected" />
											 </q-td>
											 <q-td v-for="col in props.cols" :key="col.name" :props="props">
												  <div v-if="col.name === 'actions'">
														<PrimaryButton class="tw-text-black tw-text-lg">...
															 <q-menu auto-close>
																  <div class="tw-flex tw-flex-col tw-gap-2">
																		<span v-if="hasPermission('Excluir Habilitacao')" @click="confirmRemoving(props.row)" title="Deletar"
																			 class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-center">
																			 <Icon icon="arcticons:trashcan" class="tw-h-6 tw-w-6" />
																			 &nbsp;Excluir
																		</span>
																  </div>
															 </q-menu>
														</PrimaryButton>
												  </div>
												  <div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
														{{ col.value }}
												  </div>
											 </q-td>
										</q-tr>
								  </template>
							</q-table>
						</div>
					</div>
				</div>
			</div>
		</div>
</template>
<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { evaArrowBackOutline } from '@quasar/extras/eva-icons';
import { Notify } from 'quasar';
import { onMounted } from 'vue';
import { ref, computed, watch } from 'vue';


const props = defineProps({
	edital_id: {
		type: String,
		default: ''
	},
	documentos: {
		type: Array,
		default: []
	}
})

function confirmRemoving(data) {
	rowsSelected.value = [data]
	deleteModal.value = true
}

const formD = useForm({
	tipo: [props.tipo],
	caminho: props.caminho,
	situacao: 'Ativo',
	versao: [props.versao],
	data_publicacao: props.data_publicacao,
	edital_id: props.edital_id,
	arquivo: [],
});

const opcoesTipoDocumentos = [
	{ label: 'Comunicado', value: 'Comunicado' },
	{ label: 'Comunicado de Matrícula', value: 'Comunicado de Matrícula' },
	{ label: 'Comunicado de Recurso', value: 'Comunicado de Recurso' },
	{ label: 'Divulgação', value: 'Divulgação' },
	{ label: 'Edital', value: 'Edital' },
	{ label: 'Homologação Final', value: 'Homologação Final' },
	{ label: 'Homologação Parcial', value: 'Homologação Parcial' },
	{ label: 'Retificação do Edital', value: 'Retificação do Edital' },
	{ label: 'Resultado Final', value: 'Resultado Final' },
	{ label: 'Resultado Parcial', value: 'Resultado Parcial' },
	{ label: 'Resultado Preliminar', value: 'Resultado Preliminar' },
	{ label: 'Retificação do Resultado', value: 'Retificação do Resultado' },
];

const opcoesVersoes = [
	{ label: '1.0', value: '1.0' },
	{ label: '2.0', value: '2.0' },
	{ label: '3.0', value: '3.0' },
	{ label: '4.0', value: '4.0' },
];

function storeDocumentos() {
	formD.post(route('painel.documentos.store'), {
		preserveScroll: true,
		forceFormData: true,
		onSuccess: (res) => {
			formD.reset();
			Notify.create({
				message: 'Docuemtno inserido com sucesso.',
				color: 'secondary',
			});
			window.location.href = '/editais/editar/' + props.edital_id;
		},
		onError: (err) => {
			console.log(err);
			Notify.create({
				message: 'Não foi possível inserir esse documento.',
				color: 'negative',
			});
		},
	});
}

function removeItem(item) {

	formD.id = item.id || rowsSelected.value.map(row => row.id)

	formD.delete(route('painel.documentos.destroy', formD.id), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Documento removido com sucesso.",
				color: "secondary"
			})
			// window.location.href = '/editais/editar/${props.edital_id}';
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover essa(s) Unidade(s).",
				color: "negative"
			})
		}
	})

	deleteModal.value = false
}

const initialPagination = ref({
	sortBy: 'desc',
	descending: false,
	page: 1,
	rowsPerPage: 10,
});
const filtersModal = ref(false);

const busca = ref('');

const rowsSelected = ref([]);

const dateFormatOptions = {
	year: 'numeric',
	month: 'numeric',
	day: 'numeric',
};

function closeModal() {
	filtersModal.value = false;
}

const columns = [
	// {	name: 'id', field: 'id', label: 'ID', required: true, align: 'left', sortable: true, },
	// {	name: 'nome', field: 'nome', label: 'NOME DO ARQUIVO', align: 'left', sortable: true, },
	{ name: 'versao', field: 'versao', label: 'Versao', align: 'left', sortable: true, },
	{ name: 'tipo', field: 'tipo', label: 'TIPO', align: 'left', sortable: true, },
	{ name: 'data_publicacao', field: 'data_publicacao', label: 'DATA DE PUBLICAÇÃO', align: 'left', sortable: true, },
	{ name: 'situacao', field: 'situacao', label: 'STATUS', align: 'left', sortable: true, },
	{ name: 'caminho', field: 'caminho', label: 'STATUS', align: 'left', sortable: true, },
	{ name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
];

const visibleColumns = ['id', 'tipo', 'versao', 'data_publicacao', 'situacao', 'actions'];

//
const filtroTipo = ref([]);
const filtroStatus = ref([]);
const filtroModalidade = ref([]);
const filtroNivel = ref([]);
const filtroTurno = ref([]);
const filtroSituacao = ref([]);
const filtroCargaHoraria = ref([]);
const filtroCurso = ref([]);
const filtroEdital = ref([]);
const filteredDocumentos = ref(props.documentos);

//
const chipCategoria = computed(() => filtroTipo.value.length > 0);
const chipStatus = computed(() => filtroStatus.value.length > 0);
const chipModalidade = computed(() => filtroModalidade.value.length > 0);
const chipNivel = computed(() => filtroNivel.value.length > 0);
const chipCargaHoraria = computed(() => filtroCargaHoraria.value.length > 0);
const chipTurno = computed(() => filtroTurno.value.length > 0);
const chipSituacao = computed(() => filtroSituacao.value.length > 0);
const chipEdital = computed(() => filtroEdital.value != '');
const chipCurso = computed(() => filtroCurso.value != '');

//
const opcoesNivel = ['Iniciante', 'Intermediario', 'Avançado'];
const opcoesCargaHoraria = [
	'40 Horas',
	'160 Horas',
	'240 Horas',
	'960 Horas',
	'1440 Horas',
];
const opcoesSituacao = ['Ativo', 'Inativo'];
const opcoesModalidade = ['Cadastro de Reserva', 'EAD', 'Online', 'Presencial'];
const opcoesTurno = ['Integral', 'Matutino', 'Vespertino', 'Noturno'];
const opcoesCategoria = ['Capacitação', 'Qualificação', 'Superior', 'Técnico'];

function applyFilters() {
	const filtradoCategoria =
		filtroCategoria.value.length > 0
			? props.turmas.filter((turma) => filtroCategoria.value.includes(turma.categoria))
			: props.turmas;
	const filtradoTipo =
		filtroTipo.value.length > 0
			? props.turmas.filter((turma) => filtroTipo.value.includes(turma.tipo))
			: props.turmas;
	const filtradoModalidade =
		filtroModalidade.value.length > 0
			? filtradoEscola.filter((turma) =>
				filtroModalidade.value.includes(turma.modalidade)
			)
			: filtradoEscola;
	const filtradoNivel =
		filtroNivel.value.length > 0
			? filtradoNivel.filter((turma) => filtroNivel.value.includes(turma.nivel))
			: filtradoNivel;
	const filtradoCargaHoraria =
		filtroCargaHoraria.value.length > 0
			? filtradoCargaHoraria.filter((turma) =>
				filtroCargaHoraria.value.includes(turma.horas_curso)
			)
			: filtradoCargaHoraria;
	const filtradoTurno =
		filtroTurno.value.length > 0
			? filtradoModalidade.filter((turma) => filtroTurno.value.includes(turma.turno))
			: filtradoModalidade;
	const filtradoSituacao =
		filtroSituacao.value.length > 0
			? filtradoTurno.filter((turma) => filtroSituacao.value.includes(edital.situacao))
			: filtradoTurno;
	const filtradoEdital =
		filtroEdital.value != ''
			? filtradoSituacao.filter((turma) => turma.edital_id == filtroEdital)
			: filtradoSituacao;
	const filtradoCurso =
		filtroCurso.value != ''
			? filtradoSituacao.filter((turma) => turma.curso_id == filtroCurso)
			: filtradoSituacao;
	const filtradoStatus =
		filtroStatus.value != ''
			? filtradoStatus.filter((turma) => turma.edital_id == filtroEdital)
			: filtradoStatus;

	filteredTurmas.value = filtradoEdital;
	filtersModal.value = false;
}

function removeFilterNivel() {
	filtroNivel.value = [];
	applyFilters();
}
function removeFilterCargaHoraria() {
	filtroCargaHoraria.value = [];
	applyFilters();
}
function removeFilterStatus() {
	filtroStatus.value = [];
	applyFilters();
}
function removeFilterSituacao() {
	filtroSituacao.value = [];
	applyFilters();
}
function removeFilterModalidade() {
	filtroModalidade.value = [];
	applyFilters();
}
function removeFilterTurno() {
	filtroTurno.value = [];
	applyFilters();
}
function removeFilterEdital() {
	filtroEdital.value = '';
	applyFilters();
}

function removeFilterCurso() {
	filtroCurso.value = '';
	applyFilters();
}

function clearFilters() {
	filtroCargaHoraria.value = [];
	filtroNivel.value = [];
	filtroStatus.value = [];
	filtroTipo.value = [];
	filtroModalidade.value = [];
	filtroTurno.value = [];
	filtroSituacao.value = [];
	filtroEdital.value = [];
	filtroCurso.value = [];
}

//Exportar CSV
const exportToCSV = () => {
	// Dados da tabela
	const columns = ['ID', 'Turma', 'Vagas', 'Status'];

	const data = filteredTurmas.value.map((turma) => [
		turma.id,
		turma.nome,
		turma.vagas,
		turma.situacao,
	]);

	// Preparar os dados para exportação CSV
	const csvContent = `${columns.join(',')}\n${data
		.map((row) => row.join(','))
		.join('\n')}`;

	// Criar um objeto Blob para o conteúdo CSV
	const blob = new Blob([csvContent], {
		type: 'text/csv;charset=utf-8;',
	});

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
</script>
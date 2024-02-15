<!--suppress ALL -->
<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {evaCloseCircleOutline} from "@quasar/extras/eva-icons"
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import {Notify} from 'quasar'
import {Icon} from '@iconify/vue';

const props = defineProps({
	inscricoes: {
		type: Array,
		default: [],
	},
	escolas: {
		type: Array,
		default: []
	},
	edital: {
		type: Object,
		default: {}
	},
	cursos: {
		type: Array,
		default: []
	},
	user: {
		type: Object,
		default: {}
	}
});

const permissions = props.user.permissions
const hasPermission = (permission) => {
	return permissions.some(userPermission => userPermission === permission);
};

const selectedIds = ref([])
const form = useForm({
	id: selectedIds,
	nome: '',
})

const filtersModal = ref(false)
const deleteModal = ref(false)

const updatePage = (value) => {
	initialPagination.page = value;
}

const isExcluirDisabled = computed(() => rowsSelected.value.length === 0);
const initialPagination = ref({sortBy: 'desc', descending: false, page: 1, rowsPerPage: 10})

const busca = ref('')
const rowsSelected = ref([])

function closeModal() {
	filtersModal.value = false
}

const columns = [
	{name: 'id', align: 'left', field: 'id', label: 'ID'},
	{name: 'nome_completo', align: 'left', label: 'INSCRITO', field: 'nome_completo', sortable: true},
	{
		name: 'created_at', align: 'left', label: 'DATA E HORA', field: 'created_at', format: val => {
			const date = new Date(val);
			const hora = String(date.getUTCHours()).padStart(2, '0');
			const minutos = String(date.getUTCMinutes()).padStart(2, '0');
			const dia = String(date.getUTCDate()).padStart(2, '0');
			const mes = String(date.getUTCMonth() + 1).padStart(2, '0');
			const ano = date.getUTCFullYear();
			return `${hora}:${minutos} ${dia}/${mes}/${ano}`;
		}, sortable: true
	},
	{name: 'situacao', align: 'left', label: 'STATUS', field: 'situacao', sortable: true},
	{name: 'actions', label: 'AÇÕES', align: 'center', field: 'id'},
]

const visibleColumns = ['id', 'ordem', 'nome_completo', 'escola', 'turma', 'created_at', 'situacao', 'actions']

const opcoesStatus = ['Nova', 'Em Análise', 'Matriculado', 'Finalizado'];
const opcoesTurno = ['Matutino', 'Vespertino', 'Noturno', 'Integral'];
const opcoesRede = ['COTEC', 'EFG', 'GOIAS TEC', 'JUVENTUDE']
const opcoesModalidade = ['MOOC', 'EAD', 'Presencial', 'Online']


const filtroSituacao = ref([])
const filtroTurno = ref([])
const filtroCpf = ref([])
const filtroNome = ref([])
const filtroEdital = ref([])
const filtroCurso = ref([])
const filtroModalidade = []
const filtroTipo = []
const filtroStartDate = ref('');
const filtroEndDate = ref('');
const filtroEscola = ref([])

const filteredInscricoes = ref(props.inscricoes)

const chipStatus = computed(() => filtroSituacao.value.length > 0)
const chipTurno = computed(() => filtroTurno.value.length > 0)
const chipCpf = computed(() => filtroCpf.value.length > 0)
const chipNome = computed(() => filtroNome.value.length > 0)
const chipEdital = computed(() => filtroEdital.value.length > 0)
const chipCursos = computed(() => filtroCurso.value.length > 0)
const chipModalidade = computed(() => filtroModalidade && filtroModalidade.value && filtroModalidade.value.length > 0)


const chipEscola = computed(() => filtroEscola.value.length > 0)
const chipEndDate = computed(() => filtroEndDate.value.length > 0)
const chipStartDate = computed(() => filtroStartDate.value.length > 0)

function applyFilters() {
	let filtrado = [...props.inscricoes];

	if (filtroCategoria.value.length > 0) {
		filtrado = props.cursos.filter(inscricao => filtroCategoria.value.includes(inscricao.categoria));
	}
	if (filtroModalidade.value.length > 0) {
		filtrado = props.turma.filter(turma => filtroModalidade.value.includes(turma.modalidade));
	}
	if (filtroTurno.value.length > 0) {
		filtrado = props.turma.filter(turma => filtroTurno.value.includes(turma.turno));
	}
	if (filtroSituacao.value.length > 0) {
		filtrado = filtrado.filter(inscricao => filtroSituacao.value.includes(inscricao.situacao));
	}
	if (filtroStartDate.value) {
		filtrado = filtrado.filter(inscricao => new Date(inscricao.created_at) >= new Date(filtroStartDate.value));
	}
	if (filtroEndDate.value) {
		filtrado = filtrado.filter(inscricao => new Date(inscricao.created_at) <= new Date(filtroEndDate.value));
	}

	filteredInscricoes.value = filtrado;
	filtersModal.value = false;
}

function removeFilterStatus() {
	filtroSituacao.value = []
	applyFilters()
}

function removeFilterTurno() {
	filtroTurno.value = []
	applyFilters()
}

function removeFilterCpf() {
	filtroCpf.value = []
	applyFilters()
}

function removeFilterNome() {
	filtroNome.value = []
	applyFilters()
}

function removeFilterEdital() {
	filtroEdital.value = []
	applyFilters()
}

function removeFilterCurso() {
	filtroCurso.value = []
	applyFilters()
}

function removeFilterModalidade() {
	filtroModalidade.value = []
	applyFilters()
}

function removeFilterTipo() {
	filtroTipo.value = []
	applyFilters()
}

function removeFilterStartDate() {
	filtroStartDate.value = []
	applyFilters()
}

function removeFilterEndDate() {
	filtroEndDate.value = []
	applyFilters()
}

function removeFilterEscola() {
	filtroEscola.value = []
	applyFilters()
}

function clearFilters() {
	filtroCpf.value = [],
		 filtroNome.value = [],
		 filtroTurno.value = [],
		 filtroTipo.value = [],
		 filtroModalidade.value = [],
		 filtroEdital.value = [],
		 filtroCurso.value = [],
		 filtroSituacao.value = [],
		 filtroEndDate.value = [],
		 filtroStartDate.value = []
	filtroEscola.value = []
}

function EnviarEmail() {
	if (rowsSelected.value.length === 0) {
		Notify.create({
			message: "Nenhum item selecionado para enviar email.",
			color: "negative"
		});
		return;
	}

	const selectedIds = rowsSelected.value.map(row => row.id);

	router.patch(route('painel.inscricoes.enviarEmail', {ids: selectedIds.join(',')}), {
		_method: 'patch',
		...form
	}, {
		preserveScroll: true,
		onSuccess: (res) => {
			form.reset()
			Notify.create({
				message: "Emails enviados com sucesso.",
				color: "secondary"
			})
			window.location.href = '/inscricoes';
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível enviar os e-mails.",
				color: "negative"
			})
		}
	});
	deleteModal.value = false;
}

function removeItem(item) {
	if (rowsSelected.value.length === 0) {
		Notify.create({
			message: "Nenhum item selecionado para enviar excluir.",
			color: "negative"
		});
		return;
	}

	form.id = item.id || rowsSelected.value.map(row => row.id)

	form.post(route('painel.inscricoes.destroy'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Unidade(s) removida(s) com sucesso.",
				color: "secondary"
			})
			window.location.href = '/inscricoes';
			applyFilters()
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

function confirmRemoving(data) {
	rowsSelected.value = [data]
	deleteModal.value = true
}

const exportToCSV = () => {

	if (rowsSelected.value.length === 0) {
		const columns = [
			'ID',
			'NOME DO INSCRITO',
			'SITUACAO'
		];
		const data = filteredInscricoes.value.map((role) => [
			role.id,
			`"${role.nome_completo}"`,
			role.situacao
		]);
		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'InscritoExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	} else {
		const columns = [
			'ID',
			'NOME DO INSCRITO',
			'SITUACAO'
		];

		const data = rowsSelected.value.map((role) => [
			role.id,
			`"${role.nome_completo}"`,
			role.situacao
		]);

		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'InscritoExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}
};

</script>
<template>
	<Head title="Inscrições"/>
	<AuthenticatedLayout>
		<!-- Modal de Filtros -->
		<q-dialog v-model="filtersModal">
			<q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
						filtro abaixo:
					</div>
				</q-card-section>
				<div class="tw-flex tw-gap-3">
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">Período de Início</h5>
						<input id="data_inicio" v-model="filtroStartDate" autocomplete="data_inicio" autofocus
						       class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						       type="date"/>
					</div>
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">Período de Fim</h5>
						<input id="data_fim" v-model="filtroEndDate" autocomplete="data_fim" autofocus
						       class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						       type="date"/>
					</div>
				</div>
				<br>
				<div class="tw-flex tw-gap-3">
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">EDITAL</h5>
						<InputLabel/>
						<select v-model="filtroEdital"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="edital in props.edital">
								{{ edital.nome }}
							</option>
						</select>
					</div>
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CURSO</h5>
						<InputLabel/>
						<select v-model="filtroCurso"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="curso in props.cursos">
								{{ curso.nome }}
							</option>
						</select>
					</div>
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">ESCOLA</h5>
						<InputLabel/>
						<select v-model="filtroEscola"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="escola in props.escolas">
								{{ escola.nome }}
							</option>
						</select>
					</div>
				</div>
				<br/>
				<div class="tw-flex tw-gap-3">
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TURNO</h5>
						<InputLabel/>
						<select v-model="filtroTurno"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option v-for="opcao in opcoesTurno" :key="index" :val="opcao.id">
								{{ opcao }}
							</option>
						</select>
					</div>
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">MODALIDADE</h5>
						<InputLabel/>
						<select v-model="filtroModalidade"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option v-for="opcao in opcoesModalidade">
								{{ opcao }}
							</option>
						</select>
					</div>
					<div class="tw-w-full">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TIPO</h5>
						<InputLabel/>
						<select v-model="filtroEscola"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="escola in props.escolas">
								{{ escola.nome }}
							</option>
						</select>
					</div>
				</div>
				<q-card-section class="q-p-none">
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
						<!-- Grupo de Filtro -->
						<div class="tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">STATUS</h5>
							<!-- Filtro de Situação -->
							<div v-for="opcao in opcoesStatus"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroSituacao" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
					</div>
					<!-- Grupo de Botões -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
						<div class="tw-flex tw-flex-1">
							<button
								 class="tw-flex tw-px-8 tw-py-3  tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2  tw-border-primary tw-justify-center"
								 @click="closeModal">
								CANCELAR
							</button>
						</div>
						<div class="tw-flex tw-flex-1 flex-row tw-gap-4">
							<button
								 class="tw-flex tw-flex-1 tw-py-3   tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2  tw-border-gray-700 tw-justify-center"
								 @click="clearFilters">
								LIMPAR FILTROS
							</button>
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"
								 @click="applyFilters">
								APLICAR FILTROS
							</button>
						</div>
					</div>
				</q-card-section>
				<q-card-actions align="right">
				</q-card-actions>
			</q-card>
		</q-dialog>
		<!-- Modal de Deletar -->
		<q-dialog v-model="deleteModal">
			<q-card style="min-width: 40vw; max-width: 380px; border-radius: 20px; padding: 50px;">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold tw-text-center">
						Você tem certeza que deseja excluir o(s) registro(s) selecionado(s) definitivamente?
					</div>
				</q-card-section>
				<q-card-section class="q-p-none">
					<!-- Grupo de Botões -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
						<div class="tw-flex tw-flex-1 flex-row tw-gap-4">
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"
								 @click="deleteModal = false">
								CANCELAR
							</button>
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"
								 @click="removeItem">
								EXCLUIR
							</button>
						</div>
					</div>
				</q-card-section>

			</q-card>
		</q-dialog>
		<!-- Página Principal -->
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				 class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
				<div
					 class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Inscrições Cadastradas</h4>
					<Link :href="route('painel.inscricoes.create')">
						<PrimaryButton v-if="hasPermission('Criar Inscricoes')"
						               class="tw-text-white tw-bg-green-500 tw-items-center">
							<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add"/>
							ADICIONAR INSCRIÇÕES
						</PrimaryButton>
					</Link>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
					<!-- Filtros Selecionados -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
						<q-chip v-if="chipStatus" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterStatus">
							Status
						</q-chip>
						<q-chip v-if="chipTurno" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterTurno">
							Turno
						</q-chip>
						<q-chip v-if="chipCpf" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCpf">
							Cpf
						</q-chip>
						<q-chip v-if="chipNome" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterNome">
							Nome
						</q-chip>
						<q-chip v-if="chipEdital" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterEdital">
							Edital
						</q-chip>
						<q-chip v-if="chipCursos" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCurso">
							Cursos
						</q-chip>
						<q-chip v-if="chipModalidade" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterModalidade">
							Modalidade
						</q-chip>
						<q-chip v-if="chipTipo" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterTipo">
							Tipo
						</q-chip>
						<q-chip v-if="chipEscola" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterEscola">
							Escolas
						</q-chip>
						<q-chip v-if="chipStartDate" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterStartDate">
							Data Inicial
						</q-chip>
						<q-chip v-if="chipEndDate" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterEndDate">
							Data Final
						</q-chip>
					</div>
					<!-- Filtrar, Exportar e Pesquisar -->
					<div
						 class="tw-flex tw-flex-0 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
						<div class="tw-flex tw-flex-0 tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
							<h5 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="filtersModal = true">
								<Icon class="tw-h-6 tw-w-6" icon="ci:filter"/>
								Filtrar
							</h5>
							<h5 v-if="hasPermission('Exportar Inscricoes')"
							    class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="exportToCSV">
								<Icon class="tw-h-6 tw-w-6" icon="tabler:file-export"/>
								Exportar CSV
							</h5>
							<h5 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="EnviarEmail">
								<Icon class="tw-h-6 tw-w-6" icon="icon-park-outline:send-email"/>
								Solicitar Documentacao
							</h5>
							<!-- <h5 @click="deleteModal = true"
								 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
								 <Icon icon="ion:trash-outline" class="tw-h-6 tw-w-6" />
								 Excluir
							</h5> -->
						</div>
						<div
							 class="tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<Icon class="tw-h-6 tw-w-6 tw-text-gray-600" icon="majesticons:search-line"/>
							<input id="busca" v-model="busca" autocomplete="busca" autofocus
							       class="tw-appearance-none tw-border-none tw-w-full tw-text-gray-700"
							       placeholder="Pesquise aqui"
							       required type="text"/>
						</div>
					</div>
				</div>
				<!-- Tabela de Exibição -->
				<div class="tw-antialiased tw-font-body">
					<div class="tw-py-4 tw-overflow-x-auto">
						<div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
							<q-table v-model:pagination="initialPagination" v-model:selected="rowsSelected" :columns="columns"
							         :filter="busca"
							         :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
							         :rows="filteredInscricoes" :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'"
							         :visible-columns="visibleColumns"
							         flat
							         no-data-label="Não há informações cadastradas."
							         no-results-label="Não foi possível localizar informações com o filtro inserido."
							         row-key="id"
							         rows-per-page-label="Registros por página"
							         selection="multiple" wrap-cells>
								<template v-slot:header="props">
									<q-tr :props="props" class="tw-h-20">
										<q-td auto-width>
											<q-checkbox v-model="props.selected" dense/>
										</q-td>
										<q-th v-for="col in props.cols" :key="col.name" :props="props">
                                            <span class="tw-font-title tw-text-gray-600 tw-text-lg">
                                                {{ col.label }}
                                            </span>
										</q-th>
									</q-tr>
								</template>
								<template v-slot:body="props">
									<q-tr :props="props"
									      class="roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-h-20 tw-transition-colors"
									      no-hover>
										<q-td auto-width>
											<q-checkbox v-model="props.selected" dense/>
										</q-td>
										<q-td v-for="col in props.cols" :key="col.name" :props="props">
											<div v-if="col.name === 'actions'">
												<PrimaryButton class="tw-text-black tw-text-lg">...
													<q-menu auto-close>
														<div class="tw-flex tw-flex-col tw-gap-2">
															<Link :href="route('painel.inscricoes.show', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Info">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:searchbar-ex"/>
																&nbsp;Visualizar
															</Link>
															<Link v-if="hasPermission('Logs Inscricoes')"
															      :href="route('painel.inscricoes.log', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Info">
																<Icon class="tw-h-6 tw-w-6"
																      icon="arcticons:tenbitclockwidget"/>
																&nbsp;Histórico de Logs
															</Link>
															<Link v-if="hasPermission('Editar Inscricoes')"
															      :href="route('painel.inscricoes.editar', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Editar">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:simpletexteditor"/>
																&nbsp;Editar
															</Link>
															<span v-if="hasPermission('Excluir Inscricoes')"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-center"
															      title="Deletar"
															      @click="confirmRemoving(props.row)">
                                                                <Icon class="tw-h-6 tw-w-6" icon="arcticons:trashcan"/>
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
	</AuthenticatedLayout>
</template>

<style>
.q-table__sort-icon {
	opacity: .5;
}

.q-btn {
	box-shadow: none;
	text-shadow: none;
}

.q-btn__content {
	color: black;
	font-size: 1.5rem;
}

.q-btn__content > .q-icon {
	font-size: 1.3rem;
	display: block;
}

.q-checkbox__bg {
	background-color: white;
	border-color: rgb(148, 148, 148);
	padding: 1px;
	border-radius: 6px;
	border-width: 1px;
	flex: 1;
	display: flex;
	justify-content: center;
	align-items: center;
	position: relative !important;
}

.q-checkbox__inner--truthy .q-checkbox__bg {
	background-color: rgb(0, 218, 0);
}

.q-checkbox__bg > svg {
	display: flex;
	position: relative;
	width: 70% !important;
	height: 70% !important;
}

.q-chip {
	background-color: rgba(164, 255, 164, 0.418) !important;
	font-family: 'Open Sans';
	color: rgb(0, 255, 0);
	border: none;
}

/*
.q-chip--colored .q-chip__icon{
    color: none !important;
} */
</style>
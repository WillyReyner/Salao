<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount, computed } from "vue";
import { Notify } from 'quasar'
import { Icon } from '@iconify/vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';


const props = defineProps({
	cursos: {
		type: Array,
		default: [],
	},
	tags: {
		type: Array,
		default: []
	},
	user: {
		type: Object,
		default: {}
	},
	contador: {
		type: Number,
		default: 0
	}
});

const permissions = props.user.permissions
const filteredCursos = ref(props.cursos)

const valueProgress = ref(0);

const filtersModal = ref(false)
const deleteModal = ref(false)
const fileModalVisible = ref(false);
const visible = ref(false)
const showSimulatedReturnData = ref(false)
const secondDialog = ref(false)
const thirdDialog = ref(false)

const filtroStatus = ref([])
const filtroTurmas = ref([])
const rowsSelected = ref([])

const busca = ref('')
const filtroTags = ref('')
const filtroStartDate = ref('');
const filtroEndDate = ref('');

const chipStartDate = computed(() => filtroStartDate.value.length > 0)
const chipEndDate = computed(() => filtroEndDate.value.length > 0)
const chipTurmas = computed(() => filtroTurmas.value.length > 0)
const chipStatus = computed(() => filtroStatus.value.length > 0)
const chipTags = computed(() => filtroTags.value.length > 0)

const opcoesStatus = [
	{ label: "Ativo", value: "Ativo" },
	{ label: "Inativo", value: "Inativo" },
	{ label: "Rascunho", value: "Rascunho" },
]


const opcoesTurmas = [
	{ label: "Turmas Ativas", value: "Ativo" },
	{ label: "Turmas Inativas", value: "Inativo" },
]

const hasPermission = (permission) => {
	return permissions.some(userPermission => userPermission === permission);
};

function confirmRemoving(data) {
	rowsSelected.value = [data]
	deleteModal.value = true
}

const openFileModal = () => {
	fileModalVisible.value = true;
};

const closeThirdModal = () => {
	thirdDialog.value = false;
	window.location.href = '/cursos';
}

const closeFileModal = () => {
	window.location.href = '/cursos';
	fileModalVisible.value = false;
};

const form = useForm({
	id: [],
	nome: '',
	arquivo: null
})

const initialPagination = ref({
	sortBy: 'desc',
	descending: false,
	page: 1,
	rowsPerPage: 10
})

const dateFormatOptions = {
	year: "numeric", month: "numeric", day: "numeric"
}

function closeModal() {
	filtersModal.value = false
}

const columns = [
	{ name: 'id', field: 'id', label: 'ID', required: true, align: 'left', sortable: true },
	{ name: 'imagem', field: 'imagem', required: true, label: 'IMAGEM', align: 'left', sortable: true },
	{ name: 'nome', field: 'nome', label: 'CURSO', align: 'left', sortable: true },
	{ name: 'turmas', field: 'situacao', label: 'TURMAS', align: 'left', sortable: true },
	{ name: 'status', field: 'situacao', label: 'STATUS', align: 'left', sortable: true },
	{ name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
]

const visibleColumns = [
	'id', 'imagem', 'curso', 'nome', 'status', 'actions',
]

function applyFilters() {
	let filtrado = [...props.cursos];

	if (filtroStartDate.value.length > 0) {
		filtrado = filtrado.filter(curso => new Date(curso.created_at) >= new Date(filtroStartDate.value + "T00:00:00"));
	}
	if (filtroEndDate.value.length > 0) {
		filtrado = filtrado.filter(curso => new Date(curso.created_at) <= new Date(filtroEndDate.value + "T00:00:00"));
	}
	if (filtroStatus.value.length > 0) {
		filtrado = filtrado.filter(curso => filtroStatus.value.includes(curso.situacao));
	}
	if (filtroTags.value.length > 0) {
		filtrado = filtrado.filter(curso => curso.tags.some(tag => filtroTags.value.includes(tag.nome)));
	}
	if (filtroTurmas.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroTurmas.value.includes(turma.situacao));
	}

	filteredCursos.value = filtrado;
	filtersModal.value = false;
}

function removeFilterTags() {
	filtroTags.value = ''
	applyFilters()
}

function removeFilterStatus() {
	filtroStatus.value = []
	applyFilters()
}

function removeFilterTurmas() {
	filtroTurmas.value = []
	applyFilters()
}

function removeFilterDataInicial() {
	filtroStartDate.value = []
	applyFilters()
}

function removeFilterDataFinal() {
	filtroEndDate.value = []
	applyFilters()
}

function clearFilters() {
	filtroTags.value = []
	filtroStatus.value = []
	filtroTurmas.value = []
	filtroStartDate.value = []
	filtroEndDate.value = []
}

function removeItem(item) {

	form.id = item.id || rowsSelected.value.map(row => row.id)

	form.post(route('painel.cursos.destroy'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Curso(s) removida(s) com sucesso.",
				color: "secondary"
			})
			window.location.href = '/cursos';
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover essa(s) Curso(s).",
				color: "negative"
			})
		}
	})
	deleteModal.value = false
}

const exportToCSV = () => {
	if (rowsSelected.value.length === 0) {
		const columns = [
			'ID',
			'NOME DOS CURSOS',
			'STATUS',
		];
		const data = filteredCursos.value.map((edital) => [
			edital.id,
			`"${edital.nome}"`,
			edital.situacao,
		]);
		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'CursosExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	} else {
		const columns = [
			'ID',
			'NOME DOS CURSOS',
			'STATUS',
		];

		const data = rowsSelected.value.map((curso) => [
			curso.id,
			`"${curso.nome}"`,
			curso.situacao,
		]);

		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'CursosExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}
};

const modeloImportacao = () => {

	const columns = [
		'id_escolas_oferta',
		'id_qualificacoes',
		'id_cursos',
		'nome',
		'tipo',
		'escola',
		'eixo'
	];

	const data = [];

	const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;

	const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
	const url = window.URL.createObjectURL(blob);

	const link = document.createElement('a');
	link.setAttribute('href', url);
	link.setAttribute('download', 'CursosExport.csv');
	document.body.appendChild(link);

	link.click();

	document.body.removeChild(link);
	window.URL.revokeObjectURL(url);

}
async function importar() {
	progressBar();

	const formData = new FormData();
	formData.append('arquivo', form.arquivo);

	secondDialog.value = true;

	fileModalVisible.value = false;

	form.post(route('painel.cursos.importar'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Curso(s) importado(s) com sucesso.",
				color: "secondary",
			})
			secondDialog.value = false,
				thirdDialog.value = true
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover essa(s) Curso(s).",
				color: "negative"
			})
		}
	})
}

function progressBar() {
	const interval = setInterval(() => {
		if (valueProgress.value < 100) {
			valueProgress.value += 20;
		} else {
			clearInterval(interval);
		}
	}, 1500);
}
</script>
<template>
	<Head title="Cursos" />
	<AuthenticatedLayout>
		<!-- Modal de Filtros -->
		<q-dialog v-model="fileModalVisible">
			<q-card class="tw-p-4" style="width: 800px; max-width: 80vw;">
				<q-card-section style="width: 100%; height: 93%">
					<div class="tw-text-grey-700 tw-font-title tw-pb-6 tw-font-semibold tw-text-2xl">
						Importar Cursos
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="nome" value="Anexe o arquivo" required class="tw-mb-2" />
						<q-file v-model="form.arquivo"
						        bg-color="blue"
						        id="fileInput"
						        rounded
						        standout
						        accept=".csv, .xlsx*, .xls*"
						        input-class="tw-text-gray-700 tw-block focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						        label-color="white"
						>
							<template v-slot:prepend>
								<Icon class="tw-text-white" icon="ph:upload-light"/>
							</template>
						</q-file>
					</div>
				</q-card-section>
				<q-card-actions class="tw-flex tw-justify-between tw-pb-5">
					<div>
						<PrimaryButton button-class="tw-normal-case tw-text-green-700 tw-flex tw-bg-white tw-border-2 tw-border-green-700 tw-h-10 tw-justify-start tw" @click="closeFileModal">
							Cancelar
						</PrimaryButton>
					</div>
					<div class="tw-flex tw-items-center tw-gap-2">
						<PrimaryButton button-class="tw-normal-case tw-text-gray-300 tw-flex tw-border-2 tw-border-gray-300 tw-h-10" @click="modeloImportacao()">
							<Icon icon="solar:file-download-bold" width="20" height="20"  style="color: #1ee646" class="tw-mr-5 tw-text-gray-300" />
							Baixar modelo CSV
						</PrimaryButton>
						<PrimaryButton v-if="form.arquivo && form.arquivo.length !== ''" button-class="tw-normal-case tw-flex tw-border-2 tw-text-white tw-bg-green-700 tw-border-green-700 tw-h-10" @click="importar()">
								Importar
						</PrimaryButton>
					</div>
				</q-card-actions>
			</q-card>
		</q-dialog>
		<q-dialog v-model="secondDialog" persistent>
			<div class="tw-flex tw-flex-center">
				<q-circular-progress show-value :value="valueProgress" :thickness="0.22" color="lime" rounded
					size="350px" track-color="grey-3">{{ valueProgress }}%</q-circular-progress>
			</div>
		</q-dialog>
		<q-dialog v-model="thirdDialog" persistent full-width rounded>
			<div class="tw-flex tw-justify-center tw-w-[100%] tw-p-4 ">
				<q-card class="tw-rounded-2xl">
					<q-card-section class="tw-grid tw-justify-items-center">
						<div class="tw-flex tw-flex-1 tw-p-8">
							<p class="tw-text-3xl tw-text-grass-400 tw-font-sans">{{ props.contador }} Cursos &nbsp;</p>
							<p class="tw-text-3xl tw-text-neutral-700 ">importados com sucesso!</p>
						</div>
						<button
							class="tw-h-10 tw-w-[50%] tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"
							@click="closeThirdModal">
							Fechar
						</button>
					</q-card-section>
				</q-card>
			</div>
		</q-dialog>
		<q-dialog v-model="filtersModal">
			<q-card class="tw-w-[100%] tw-p-2 tw-rounded-2xl">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
						filtro abaixo:
					</div>
				</q-card-section>
				<!--				<div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-10 tw-m-2">-->
				<!--					<div class="tw-flex tw-flex-1 tw-flex-col">-->
				<!--						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-2">Período de Início</h5>-->
				<!--						<input id="data_inicio" v-model="filtroStartDate" autocomplete="data_inicio" autofocus-->
				<!--						       class="tw-mt-1 tw-h-auto tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
				<!--						       type="date"/>-->
				<!--						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-2">Período de Fim</h5>-->
				<!--						<input id="data_fim" v-model="filtroEndDate" autocomplete="data_fim" autofocus-->
				<!--						       class="tw-mt-1 tw-h-auto tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
				<!--						       type="date"/>-->
				<!--					</div>-->
				<!--				</div>-->
				<div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-10 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-2">Tags</h5>
						<InputLabel />
						<select v-model="filtroTags"
							class="tw-mt-1 tw-h-auto tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="tag of props.tags" :value="tag.id">
								{{ tag.nome }}
							</option>
						</select>
					</div>
				</div>
				<q-card-section>
					<div class="tw-flex tw-flex-1 tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">STATUS</h5>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<div v-for="opcao in opcoesStatus"
									class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
									<q-checkbox v-model:model-value="filtroStatus" :val="opcao.value" />
									{{ opcao.label }}
								</div>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">TURMAS</h5>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<div v-for="opcao in opcoesTurmas"
									class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
									<q-checkbox v-model:model-value="filtroTurmas" :val="opcao.value" />
									{{ opcao.label }}
								</div>
							</div>
						</div>
					</div>
					<!-- Grupo de Botões -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
						<div class="tw-flex tw-flex-1">
							<button
								class="tw-px-8 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"
								@click="closeModal()">
								CANCELAR
							</button>
						</div>
						<div class="tw-flex tw-flex-1 tw-gap-2">
							<button
								class="tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center"
								@click="clearFilters()">
								LIMPAR FILTROS
							</button>
							<button
								class="tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"
								@click="applyFilters()">
								APLICAR FILTROS
							</button>
						</div>
					</div>
				</q-card-section>
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
					<h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Cursos Cadastrados</h4>
					<div class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
						<h5 v-if="hasPermission('Importar Cursos')"
							class="tw-text-green-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							@click="openFileModal">
							<Icon class="tw-h-6 tw-w-6" icon="tabler:file-import" />
							Importar CSV
						</h5>
						<Link :href="route('painel.cursos.create')">
						<PrimaryButton v-if="hasPermission('Criar Cursos')"
							class="tw-text-white tw-bg-green-500 tw-items-center">
							<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add" />
							ADICIONAR CURSO
						</PrimaryButton>
						</Link>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
					<!-- Filtros Selecionados -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
						<q-chip v-if="chipTags" :icon="evaCloseCircleOutline" clickable color="green" outline size="lg"
							text-color="green" @click="removeFilterTags">
							Tags
						</q-chip>
						<q-chip v-if="chipStatus" :icon="evaCloseCircleOutline" clickable color="green" outline size="lg"
							text-color="green" @click="removeFilterStatus">
							Status
						</q-chip>
						<q-chip v-if="chipTurmas" :icon="evaCloseCircleOutline" clickable color="green" outline size="lg"
							text-color="green" @click="removeFilterTurmas">
							Status
						</q-chip>
						<q-chip v-if="chipStartDate" :icon="evaCloseCircleOutline" clickable color="green" outline size="lg"
							text-color="green" @click="removeFilterDataInicial">
							Data Inicio
						</q-chip>
						<q-chip v-if="chipEndDate" :icon="evaCloseCircleOutline" clickable color="green" outline size="lg"
							text-color="green" @click="removeFilterDataFinal">
							Data Fim
						</q-chip>
					</div>
					<!-- Filtrar, Exportar e Pesquisar -->
					<div class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
						<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
							<h5 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
								@click="filtersModal = true">
								<Icon class="tw-h-6 tw-w-6" icon="ci:filter" />
								Filtrar
							</h5>
							<h5 v-if="hasPermission('Exportar Cursos')"
								class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
								@click="exportToCSV">
								<Icon class="tw-h-6 tw-w-6" icon="tabler:file-export" />
								Exportar CSV
							</h5>
						</div>
						<div
							class="tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<Icon class="tw-h-6 tw-w-6 tw-text-gray-600" icon="majesticons:search-line" />
							<input id="busca" v-model="busca" autocomplete="busca" autofocus
								class="tw-appearance-none tw-border-none tw-w-full tw-text-gray-700" placeholder="Pesquise aqui"
								required type="text" />
						</div>
					</div>
				</div>
				<!-- Tabela de Exibição -->
				<div class="tw-antialiased tw-font-body">
					<div class="tw-py-4 tw-overflow-x-auto">
						<div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
							<q-table v-model:pagination="initialPagination" v-model:selected="rowsSelected" :columns="columns"
								:filter="busca" :pagination="initialPagination"
								:pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
								:rows="filteredCursos" :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'"
								:visible-columns="visibleColumns" flat no-data-label="Não há informações cadastradas."
								no-results-label="Não foi possível localizar informações com o filtro inserido." row-key="id"
								rows-per-page-label="Registros por página" selection="multiple" wrap-cells>
								<template v-slot:header="props">
									<q-tr :props="props" class="tw-h-20">
										<q-td auto-width>
											<q-checkbox v-model="props.selected" dense />
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
											<q-checkbox v-model="props.selected" dense />
										</q-td>
										<q-td v-for="col in props.cols" :key="col.name" :props="props">
											<div v-if="col.name === 'actions'">
												<PrimaryButton class="tw-text-black tw-text-lg">...
													<q-menu auto-close>
														<div class="tw-flex tw-flex-col tw-gap-2">
															<Link :href="route('painel.cursos.show', props.row.id)"
																class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
																title="Info">
															<Icon class="tw-h-6 tw-w-6" icon="arcticons:searchbar-ex" />
															&nbsp;Visualizar
															</Link>
															<Link v-if="hasPermission('Logs Cursos')"
																:href="route('painel.cursos.log', props.row.id)"
																class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
																title="Info">
															<Icon class="tw-h-6 tw-w-6" icon="arcticons:tenbitclockwidget" />
															&nbsp;Histórico de Logs
															</Link>
															<Link v-if="hasPermission('Editar Cursos')"
																:href="route('painel.cursos.editar', props.row.id)"
																class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
																title="Editar">
															<Icon class="tw-h-6 tw-w-6" icon="arcticons:simpletexteditor" />
															&nbsp;Editar
															</Link>
															<span v-if="hasPermission('Excluir Cursos')"
																class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-center"
																title="Deletar" @click="confirmRemoving(props.row)">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:trashcan" />
																&nbsp;Excluir
															</span>
														</div>
													</q-menu>
												</PrimaryButton>
											</div>
											<div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
												{{ col.value }}
											</div>
											<div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
												<div v-if="col.name === 'imagem'">
													<img :src="`/storage/${col.value}`" alt=""
														class="tw-h-14 tw-aspect-video tw-rounded-sm" />
												</div>
												<div v-else>
													{{ col.value }}
												</div>
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

.q-btn__content>.q-icon {
	font-size: 1.5rem;
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

.q-checkbox__bg>svg {
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
</style>
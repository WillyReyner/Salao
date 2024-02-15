<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {evaCloseCircleOutline} from "@quasar/extras/eva-icons"
import {Head, Link, useForm} from '@inertiajs/vue3';
import {computed, ref} from 'vue';
import {Notify} from 'quasar'
import {Icon} from '@iconify/vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';

//Propriedades
const props = defineProps({
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
	escolas: {
		type: Array,
		default: [],
	},
	cursos: {
		type: Array,
		default: [],
	},
	user: {
		type: Object,
		default: {}
	}

});

const permissions = props.user.permissions
const filteredTurmas = ref(props.turmas)

const filtersModal = ref(false)
const deleteModal = ref(false)
const deleteAllModal = ref(false)
const secondDialog = ref(false)
const thirdDialog = ref(false)

const rowsSelected = ref([])
const busca = ref('')

const filtroStatus = ref([])
const filtroCategoria = ref([])
const filtroTipo = ref([])
const filtroModalidade = ref([])
const filtroNivel = ref([])
const filtroTurno = ref([])
const filtroSituacao = ref([])
const filtroCargaHoraria = ref([])
const filtroCurso = ref('')
const filtroEdital = ref('')
const valueProgress = ref(0);

const chipCategoria = computed(() => filtroCategoria.value.length > 0)
const chipStatus = computed(() => filtroStatus.value.length > 0)
const chipModalidade = computed(() => filtroModalidade.value.length > 0)
const chipNivel = computed(() => filtroNivel.value.length > 0)
const chipCargaHoraria = computed(() => filtroCargaHoraria.value.length > 0)
const chipTurno = computed(() => filtroTurno.value.length > 0)
const chipSituacao = computed(() => filtroSituacao.value.length > 0)
const chipEdital = computed(() => filtroEdital.value.length > 0)
const chipCurso = computed(() => filtroCurso.value.length > 0)

const opcoesNivel = ['Iniciante', 'Intermediario', 'Avançado'];
const opcoesCargaHoraria = ['40 Horas', '160 Horas', '240 Horas', '960 Horas', '1440 Horas']
const opcoesSituacao = ['Ativo', 'Inativo']
const opcoesModalidade = ['MOOC', 'EAD', 'Online', 'Presencial'];
const opcoesTurno = ['Integral', 'Matutino', 'Vespertino', 'Noturno'];
const opcoesCategoria = ['Capacitação', 'Qualificação', 'Superior', 'Técnico'];

const initialPagination = ref({
	sortBy: 'desc',
	descending: false,
	page: 1,
	rowsPerPage: 10
})

const hasPermission = (permission) => {
	return permissions.some(userPermission => userPermission === permission);
};

const form = useForm({
	id: [],
	nome: '',
	arquivo: null,
	deleteRows: []
})

const dateFormatOptions = {
	year: "numeric", month: "numeric", day: "numeric"
}

function closeModal() {
	filtersModal.value = false
}

const columns = [
	{name: 'id', field: 'id', label: 'ID', required: true, align: 'left', sortable: true},
	//format: val => `${val.id} EDITAL - ${val.nome}`
	{name: 'turma', field: 'nome', label: 'TURMA', align: 'left', sortable: true},
	{name: 'vagas', field: 'vagas', label: 'VAGAS', align: 'left', sortable: true},
	{name: 'status', field: 'situacao', label: 'STATUS', align: 'left', sortable: true},
	{name: 'actions', label: 'AÇÕES', align: 'center', field: 'id'},
]

const visibleColumns = [
	'id',
	'turma',
	'vagas',
	'status',
	'actions',
]

function applyFilters() {
	let filtrado = [...props.turmas];

	if (filtroCategoria.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroCategoria.value.includes(turma.categoria));
	}
	if (filtroModalidade.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroModalidade.value.includes(turma.modalidade));
	}
	if (filtroTurno.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroTurno.value.includes(turma.turno));
	}
	if (filtroCargaHoraria.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroCargaHoraria.value.includes(turma.horas_curso));
	}
	if (filtroNivel.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroNivel.value.includes(turma.nivel));
	}
	if (filtroSituacao.value.length > 0) {
		filtrado = filtrado.filter(turma => filtroSituacao.value.includes(turma.situacao));
	}
	if (filtroEdital.value) {
		filtrado = filtrado.filter(turma => turma.edital_id == filtroEdital.value.includes(turma.edital_id));
	}
	if (filtroCurso.value) {
		filtrado = filtrado.filter(turma => turma.curso_id == filtroCurso.value);
	}

	filteredTurmas.value = filtrado;
	filtersModal.value = false;
}


function removeFilterNivel() {
	filtroNivel.value = []
	applyFilters()
}

function removeFilterCargaHoraria() {
	filtroCargaHoraria.value = []
	applyFilters()
}

function removeFilterStatus() {
	filtroStatus.value = []
	applyFilters()
}

function removeFilterSituacao() {
	filtroSituacao.value = []
	applyFilters()
}

function removeFilterCategoria() {
	filtroCategoria.value = []
	applyFilters()
}

function removeFilterModalidade() {
	filtroModalidade.value = []
	applyFilters()
}

function removeFilterTurno() {
	filtroTurno.value = []
	applyFilters()
}

function removeFilterEdital() {
	filtroEdital.value = ''
	applyFilters()
}

function removeFilterCurso() {
	filtroCurso.value = ''
	applyFilters()
}

function clearFilters() {
	filtroCargaHoraria.value = []
	filtroNivel.value = []
	filtroStatus.value = []
	filtroTipo.value = []
	filtroModalidade.value = []
	filtroTurno.value = []
	filtroSituacao.value = []
	filtroCategoria.value = []
	filtroEdital.value = []
	filtroCurso.value = []
}

function confirmRemoving(data) {
	form.id = data.id
	deleteModal.value = true
}

function confirmAllRemoving(data) {
	rowsSelected.value = data
	deleteAllModal.value = true
}

function removeItem() {
	form.delete(route('painel.turmas.destroy', form.id), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Turma(s) removida(s) com sucesso.",
				color: "secondary"
			})
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover essa(s) turma(s).",
				color: "negative"
			})
		}
	})
	deleteModal.value = false
}

function removeAllItem() {
	form.deleteRows = rowsSelected.value;
	form.post(route('painel.turmas.destroy.all'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Turma(s) removida(s) com sucesso.",
				color: "secondary"
			})
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover essa(s) turma(s).",
				color: "negative"
			})
		}
	})
	deleteAllModal.value = false
}

const exportToCSV = () => {

	if (rowsSelected.value.length === 0) {
		const columns = [
			'ID',
			'NOME DAS TURMAS',
			'STATUS',
		];
		const data = filteredTurmas.value.map((turma) => [
			turma.id,
			`"${turma.nome}"`,
			turma.situacao,
		]);
		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'TurmasExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	} else {
		const columns = [
			'ID',
			'NOME DAS TURMAS',
			'STATUS',
		];

		const data = rowsSelected.value.map((turma) => [
			turma.id,
			`"${turma.nome}"`,
			turma.situacao,
		]);

		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'TurmasExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}
};

//Modal Importar
const fileModalVisible = ref(false);

const openFileModal = () => {
	fileModalVisible.value = true;
};

const closeFileModal = () => {
	window.location.href = '/turmas';
	fileModalVisible.value = false;
};

const closeThirdModal = () => {
	thirdDialog.value = false;
	window.location.href = '/turmas';
}

async function importar() {
	const formData = new FormData();
	formData.append('arquivo', form.arquivo);

	form.post(route('painel.turmas.importar'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Turmas(s) importada(s) com sucesso.",
				color: "secondary"
			})
			secondDialog.value = false,
			thirdDialog.value = true
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível importar essa(s) Turmas(s).",
				color: "negative"
			})
		}
	})
}


function teste(){
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
	<Head title="Turmas"/>
	<AuthenticatedLayout>
		<!-- Modal de Filtros -->
		<q-dialog v-model="fileModalVisible">
			<q-card style="width: 700px; max-width: 80vw;">
				<q-card-section style="width: 100%; height: 93%">
					<div class="tw-text-green-700 tw-font-title tw-font-semibold tw-py-9 tw-text-2xl">
						IMPORTAR .CSV / .XLSX
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<q-file v-model="form.arquivo" bg-color="blue" id="fileInput"
						        input-class="tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						        label-color="white"
						        standout>
							<template v-slot:prepend>
								<Icon class="tw-text-white" icon="ph:upload-light"/>
							</template>
						</q-file>
					</div>
				</q-card-section>
				<q-card-actions align="right">
					<PrimaryButton button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
					               @click="closeFileModal">
						Fechar
					</PrimaryButton>
					<PrimaryButton
						 button-class="tw-text-primary tw-flex tw-border-2 tw-text-white tw-bg-green-500 tw-border-green tw-h-10"
						 @click="importar">
						IMPORTAR
					</PrimaryButton>
				</q-card-actions>
			</q-card>
		</q-dialog>
		<q-dialog v-model="filtersModal">
			<q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
						filtro abaixo:
					</div>
				</q-card-section>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">EDITAL</h5>
						<InputLabel/>
						<select v-model="filtroEdital"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="edital in props.editais" :key="index" :val="edital.id">
								{{ edital.nome }}
							</option>
						</select>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CURSO</h5>
						<InputLabel/>
						<select v-model="filtroCurso"
						        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<option value="">Todos</option>
							<option v-for="curso in props.cursos" :key="index" :value="curso.id">
								{{ curso.nome }}
							</option>
						</select>
					</div>
				</div>
				<br/>
				<q-card-section class="q-p-none">
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
						<!-- Grupo de Filtro -->
						<div class="tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">STATUS</h5>
							<!-- Filtro de Modalidade -->
							<div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
								<div class="tw-flex tw-flex-1 tw-flex-col">
									<div v-for="opcao in opcoesSituacao"
									     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
										<q-checkbox v-model:model-value="filtroSituacao" :val="opcao"/>
										{{ opcao }}
									</div>
								</div>
							</div>
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">CATEGORIA</h5>
							<!-- Filtro de Categoria -->
							<div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
								<div class="tw-flex tw-flex-1 tw-flex-col">
									<div v-for="opcao in opcoesCategoria"
									     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
										<q-checkbox v-model:model-value="filtroCategoria" :val="opcao"/>
										{{ opcao }}
									</div>
								</div>
							</div>
						</div>
						<div class=" tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">MODALIDADE</h5>
							<!-- Filtro de Modalidade -->
							<div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
								<div class="tw-flex tw-flex-1 tw-flex-col">
									<div v-for="opcao in opcoesModalidade"
									     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
										<q-checkbox v-model:model-value="filtroModalidade" :val="opcao"/>
										{{ opcao }}
									</div>
								</div>
							</div>
							<div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
								<div class="tw-flex tw-flex-1 tw-flex-col">
									<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TURNO</h5>
									<!-- Filtro de Situação -->
									<div v-for="opcao in opcoesTurno"
									     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
										<q-checkbox v-model:model-value="filtroTurno" :val="opcao"/>
										{{ opcao }}
									</div>
								</div>
							</div>
						</div>
						<div class=" tw-flex tw-flex-1 tw-flex-col">
							<br/>
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">DURAÇÃO ESTIMADA</h5>
							<!-- Filtro de Duração Estimada -->
							<div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
								<div class="tw-flex tw-flex-1 tw-flex-col">
									<div v-for="opcao in opcoesCargaHoraria"
									     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
										<q-checkbox v-model:model-value="filtroCargaHoraria" :val="opcao"/>
										{{ opcao }}
									</div>
								</div>
							</div>
							<div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
								<div class="tw-flex tw-flex-1 tw-flex-col">
									<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">NÍVEL</h5>
									<!-- Filtro de Situação -->
									<div v-for="opcao in opcoesNivel"
									     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
										<q-checkbox v-model:model-value="filtroNivel" :val="opcao"/>
										{{ opcao }}
									</div>
								</div>
							</div>
						</div>

					</div>
					<!-- Grupo de Botões -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">

						<div class="tw-flex tw-flex-1">
							<button
								 class="tw-flex tw-px-8 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"
								 @click="closeModal">
								CANCELAR
							</button>
						</div>

						<div class="tw-flex tw-flex-1 flex-row tw-gap-4">
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center"
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
					<!-- <q-btn label="Fechar" color="dark" v-close-popup /> -->
				</q-card-actions>
			</q-card>
		</q-dialog>

		<q-dialog v-model="secondDialog" persistent>
			<div class="q-pa-md flex flex-center">
				<q-circular-progress
					 show-value
					 :value="valueProgress"
					 :thickness="0.22"
					 class="q-ma-md"
					 color="lime"
					 rounded
					 size="250px"
					 track-color="grey-3"
				>{{ valueProgress }}%</q-circular-progress>
			</div>
		</q-dialog>
		<q-dialog v-model="thirdDialog" persistent full-width rounded >
			<div class="tw-flex tw-justify-center tw-w-[100%] tw-p-4 ">
				<q-card class="tw-rounded-2xl">
					<q-card-section class="tw-grid tw-justify-items-center" >
						<div class="tw-flex tw-flex-1 tw-p-8">
							<p class="tw-text-3xl tw-text-grass-400 tw-font-sans">{{props.contador}} Cursos &nbsp;</p><p class="tw-text-3xl tw-text-neutral-700 ">importados com sucesso!</p>
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
		<q-dialog v-model="deleteAllModal">
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
								 @click="deleteAllModal = false">
								CANCELAR
							</button>
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"
								 @click="removeAllItem">
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
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-2 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200 tw-text-sm">
					<h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Turmas Cadastradas</h4>
					<div
						 class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
						<h5 v-if="hasPermission('Importar Turmas')"
						    class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
						    @click="openFileModal">
							<Icon class="tw-h-6 tw-w-6" icon="tabler:file-import"/>
							Importar CSV
						</h5>
						<Link :href="route('painel.turmas.create')">
							<PrimaryButton v-if="hasPermission('Criar Turmas')"
							               class="tw-text-white tw-bg-green-500 tw-items-center">
								<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add"/>
								ADICIONAR TURMA
							</PrimaryButton>
						</Link>
					</div>
				</div>
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-2 tw-mb-8 tw-items-center">
					<!-- Filtros Selecionados -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-items-center md:tw-flex-row tw-pt-5">
						<q-chip v-if="chipStatus" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterStatus">
							Status
						</q-chip>
						<q-chip v-if="chipCategoria" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCategoria">
							Categoria
						</q-chip>
						<q-chip v-if="chipModalidade" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterModalidade">
							Modalidade
						</q-chip>
						<q-chip v-if="chipTurno" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterTurno">
							Turno
						</q-chip>
						<q-chip v-if="chipSituacao" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterSituacao">
							Situação
						</q-chip>
						<q-chip v-if="chipEdital" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterEdital">
							Edital
						</q-chip>
						<q-chip v-if="chipNivel" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterNivel">
							Nivel
						</q-chip>
						<q-chip v-if="chipCargaHoraria" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCargaHoraria">
							Carga Horária
						</q-chip>
						<q-chip v-if="chipCurso" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCurso">
							Curso
						</q-chip>
					</div>
					<!-- Filtrar, Exportar e Pesquisar -->
					<div
						 class=" tw-flex tw-w-auto tw-justify-end tw-items-center tw-gap-4 md:tw-flex-row tw-pt-5">
						<div
							 class="tw-flex tw-flex-1 tw-flex-row tw-gap-2 tw-justify-end tw-items-center">
							<h5 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="filtersModal = true">
								<Icon class="tw-h-6 tw-w-6" icon="ci:filter"/>
								Filtrar
							</h5>
							<h5 v-if="hasPermission('Exportar Turmas')"
							    class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="exportToCSV">
								<Icon class="tw-h-6 tw-w-6" icon="tabler:file-export"/>
								Exportar CSV
							</h5>
							<h5 v-if="rowsSelected.length > 1 "
							    class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="confirmAllRemoving(rowsSelected)">
								<Icon class="tw-h-6 tw-w-6" icon="tabler:file-export"/>
								Excluir em Massa
							</h5>
						</div>
						<div
							 class="tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
							<Icon class="tw-h-6 tw-w-6 tw-text-gray-600" icon="majesticons:search-line"/>
							<input id="busca" v-model="busca" autocomplete="busca" autofocus
							       class="tw-appearance-none tw-border-none tw-w-full tw-text-gray-700"
							       placeholder="Pesquise aqui" required
							       type="text"/>
						</div>
					</div>
				</div>
				<!-- Tabela de Exibição -->
				<div class="tw-antialiased tw-font-body">
					<div class="tw-py-4 tw-overflow-x-auto">
						<div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden tw-text-sm">
							<q-table v-model:pagination="initialPagination" v-model:selected="rowsSelected" :columns="columns"
							         :filter="busca"
							         :pagination="initialPagination"
							         :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
							         :rows="filteredTurmas"
							         :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'"
							         :visible-columns="visibleColumns"
							         flat
							         no-data-label="Não há informações cadastradas."
							         no-results-label="Não foi possível localizar informações com o filtro inserido."
							         row-key="id"
							         rows-per-page-label="Registros por página"
							         selection="multiple"
							         wrap-cells>

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
															<Link :href="route('painel.turmas.show', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Info">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:searchbar-ex"/>
																&nbsp;Visualizar
															</Link>
															<Link v-if="hasPermission('Logs Turmas')"
															      :href="route('painel.turmas.log', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Info">
																<Icon class="tw-h-6 tw-w-6"
																      icon="arcticons:tenbitclockwidget"/>
																&nbsp;Histórico de Logs
															</Link>
															<Link v-if="hasPermission('Editar Turmas')"
															      :href="route('painel.turmas.editar', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Editar">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:simpletexteditor"/>
																&nbsp;Editar
															</Link>
															<span v-if="hasPermission('Excluir Turmas')"
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
											<div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
												<div v-if="col.name === 'imagem'">
													<img :src="`/storage/${col.value}`"
													     class="tw-h-14 tw-aspect-video tw-rounded-sm"/>
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

.q-btn__content > .q-icon {
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
</style>
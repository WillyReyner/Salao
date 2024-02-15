<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, Notify } from 'quasar'
import { Icon } from '@iconify/vue';
import { computed } from 'vue';

const props = defineProps({
	staiEditais: {
		type: Array,
		default: [],
	},
});

const page = usePage();

const busca = ref('')
const filtersModal = ref(false)
const deleteModal = ref(false)
const filtroSituacao = ref([])
const filtroModalidade = ref([])
const filtroEscola = ref([])
const filtroStartDate = ref('');
const filtroEndDate = ref('');
const filtroCategoria = ref([])

const filteredEditais = ref(props.staiEditais)
console.log(usePage())
const roles = page.props.auth.user.roles

const chipSituacao = computed(() => filtroSituacao.value.length > 0)
const chipModalidade = computed(() => filtroModalidade.value.lenght > 0)
const chipCategoria = computed(() => filtroCategoria.value.length > 0)
const chipStartDate = computed(() => filtroStartDate.value.length > 0)
const chipEndDate = computed(() => filtroEndDate.value.length > 0)
const chipEscola = computed(() => filtroEscola.value.length > 0)

const opcoesSituacao = ['Ativo', 'Inativo', 'Cancelado', 'Encerrado', 'Periodo de Inscrição Expirado', 'Processo Encerrado'];
const opcoesModalidade = ['Presencial', 'EAD', 'Online', 'MOOC'];
const opcoesCategoria = ['Capacitacao', 'Qualificação', 'Técnico']

const permissions = roles.map(role => role.permissions).flat();

const hasPermission = (permission) => {
	return permissions.some(userPermission => userPermission.name === permission);
};

const form = useForm({
	id: [],
	nome: '',
})

const initialPagination = ref({
	sortBy: 'desc',
	descending: false,
	page: 1,
	rowsPerPage: 10
})

const rowsSelected = ref([])

const dateFormatOptions = {
	year: "numeric", month: "numeric", day: "numeric"
}

function closeModal() {
	filtersModal.value = false
}

const columns = [
	{ name: 'id', field: 'id', label: 'id' },
	{ name: 'ID', field: 'id', required: true, label: 'ID', align: 'left', sortable: true },
	{ name: 'nome', align: 'left', label: 'EDITAL', field: 'nome', sortable: true },
	{ name: 'turma', field: 'contagem_editais', label: 'TURMAS', sortable: true },
	{ name: 'status', align: 'right', label: 'STATUS', field: 'situacao', sortable: true },
	{ name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
]

const visibleColumns = [
	'ID', 'turma', 'nome', 'data_fim_inscricao', 'status', 'actions'
]

function applyFilters() {
	let filtrado = [...props.staiEditais];

	if (filtroSituacao.value.length > 0) { filtrado = filtrado.filter(edital => filtroSituacao.value.includes(edital.situacao)); }
	if (filtroModalidade.value.length > 0) { filtrado = filtrado.filter(edital => filtroModalidade.value.includes(edital.modalidade)); }
	if (filtroEscola.value.length > 0) { filtrado = filtrado.filter(edital => filtroEscola.value.includes(edital.escola_id)); }
	if (filtroCategoria.value.length > 0) { filtrado = filtrado.filter(edital => filtroCategoria.value.includes(edital.categoria)); }
	if (filtroStartDate.value) { filtrado = filtrado.filter(edital => new Date(edital.created_at) >= new Date(filtroStartDate.value)); }
	if (filtroEndDate.value) { filtrado = filtrado.filter(edital => new Date(edital.created_at) <= new Date(filtroEndDate.value)); }

	filteredEditais.value = filtrado;
	filtersModal.value = false;
}

function removeFilterModalidade() {
	filtroModalidade.value = []
	applyFilters()
}
function removeFilterCategoria() {
	filtroCategoria.value = []
	applyFilters()
}
function removeFilterEscola() {
	filtroEscola.value = []
	applyFilters()
}
function removeFilterSituacao() {
	filtroSituacao.value = []
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
	filtroCategoria.value = []
	filtroModalidade.value = []
	filtroEscola.value = []
	filtroSituacao.value = []
	filtroStartDate.value = []
	filtroEndDate.value = []
}

function removeItem(item) {

	form.id = item.id || rowsSelected.value.map(row => row.id)

	form.post(route('painel.stai.editais.destroy'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Edital(is) removido(s) com sucesso.",
				color: "secondary"
			})
			window.location.href = '/editais';
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover esse(s) edital(is).",
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

const editaisForaDoPrazo = props.staiEditais.filter((edital) => {
	const dtFimEdital = new Date(edital.dt_fim_edital);
	return dtFimEdital < new Date() && edital.situacao === 'Ativo';
});

editaisForaDoPrazo.forEach((edital) => {
	const formR = useForm({
		id: edital.id,
		situacao: edital.situacao
	});

	if (formR.situacao === 'Ativo') {
		formR.post(route('painel.stai.editais.autoupdate', formR.id), {
			preserveScroll: true,
			forceFormData: true,
			onSuccess: (res) => {
				formR.reset();
				console.log(`Edital ${formR.id} atualizado para 'Expirado'`);
			},
			onError: (err) => {
				console.log(err);
			},
		});
	}
});

const exportToCSV = () => {

	if (rowsSelected.value.length === 0) {
		const columns = [
			'ID',
			'NOME DOS EDITAIS',
			'STATUS',
		];
		const data = filteredEditais.value.map((edital) => [
			edital.id,
			`"${edital.nome}"`,
			edital.situacao,
		]);
		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'EditalExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}

	else {
		const columns = [
			'ID',
			'NOME DOS EDITAIS',
			'STATUS',
		];

		const data = rowsSelected.value.map((edital) => [
			edital.id,
			`"${edital.nome}"`,
			edital.situacao,
		]);

		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'EditalExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}
};

</script>

<template>
    <Head title="Stai Editais" />
    <AuthenticatedLayout>
        <!-- Modal de Filtros -->
        <q-dialog v-model="filtersModal">
            <q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
                <q-card-section>
                    <div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
                        filtro abaixo: </div>
                </q-card-section>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">Período de Início</h5>
                        <input id="data_inicio" type="date" autofocus autocomplete="data_inicio"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="filtroStartDate" />
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">Período de Fim</h5>
                        <input id="data_fim" type="date" autofocus autocomplete="data_fim"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="filtroEndDate" />
                    </div>
                </div>
                <br />
                <q-card-section class="q-p-none">
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
                        <!-- Grupo de Filtro -->
                        <div class="tw-flex tw-flex-1 tw-flex-col">
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">STATUS</h5>
                            <!-- Filtro de Situação -->
                            <div v-for="opcao in opcoesSituacao"
                                class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                                <q-checkbox :val="opcao" v-model:model-value="filtroSituacao" />
                                {{ opcao }}
                            </div>
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">MODALIDADE</h5>
                            <div v-for="opcao in opcoesModalidade"
                                class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-normal tw-flex tw-flex-row tw-items-center">
                                <q-checkbox :val="opcao" v-model:model-value="filtroModalidade" />
                                {{ opcao }}
                            </div>
                        </div>
                        <div class=" tw-flex tw-flex-1 tw-flex-col">
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">ESCOLA/UDEPI</h5>
                            <div v-for="escola of props.escolas"
                                class="tw-font-bod tw-text-gray-500 tw-text-lg tw-font-normal tw-flex tw-flex-row tw-items-center">
                                <q-checkbox :val="escola.id" v-model:model-value="filtroEscola" />
                                {{ escola.nome }}
                            </div>
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CATEGORIA</h5>
                            <div v-for="opcao in opcoesCategoria"
                                class="tw-font-bod tw-text-gray-500 tw-text-lg tw-font-normal tw-flex tw-flex-row tw-items-center">
                                <q-checkbox :val="opcao" v-model:model-value="filtroCategoria" />
                                {{ opcao }}
                            </div>
                        </div>
                    </div>
                    <!-- Grupo de Botões -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">

                        <div class="tw-flex tw-flex-1">
                            <button @click="clearFilters"
                                class="tw-flex tw-px-8 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center">
                                LIMPAR FILTROS
                            </button>
                        </div>
                        <div class="tw-flex tw-flex-1 flex-row tw-gap-4">
                            <button @click="closeModal"
                                class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                                CANCELAR
                            </button>
                            <button @click="applyFilters"
                                class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center">
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
                            <button @click="deleteModal = false"
                                class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                                CANCELAR
                            </button>
                            <button @click="removeItem"
                                class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center">
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
                    <h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Editais de STAI</h4>
                    <div
                        class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
                        <h5 v-if="hasPermission('Importar Editais')"
                            class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                            <Icon icon="tabler:file-import" class="tw-h-6 tw-w-6" />
                            Importar CSV
                        </h5>
                        <Link :href="route('painel.stai.editais.create')">
                        <PrimaryButton v-if="hasPermission('Criar Editais')" class="tw-text-white tw-bg-green-500 tw-items-center">
                            <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
                            ADICIONAR EDITAL
                        </PrimaryButton>
                        </Link>
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
                    <!-- Filtros Selecionados -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipModalidade"
                            @click="removeFilterModalidade" color="green" text-color="green">
                            Modalidade
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipEscola"
                            @click="removeFilterEscola" color="green" text-color="green">
                            Escola
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipSituacao"
                            @click="removeFilterSituacao" color="green" text-color="green">
                            Status
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipCategoria"
                            @click="removeFilterCategoria" color="green" text-color="green">
                            Categoria
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipStartDate"
                            @click="removeFilterDataInicial" color="green" text-color="green">
                            Data Inicio
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipEndDate"
                            @click="removeFilterDataFinal" color="green" text-color="green">
                            Data Fim
                        </q-chip>
                    </div>
                    <!-- Filtrar, Exportar e Pesquisar -->
                    <div
                        class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
                        <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
                            <h5 @click="filtersModal = true"
                                class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                                <Icon icon="ci:filter" class="tw-h-6 tw-w-6" />
                                Filtrar
                            </h5>
                            <h5 v-if="hasPermission('Exportar Editais')" @click="exportToCSV"
                                class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                                <Icon icon="tabler:file-export" class="tw-h-6 tw-w-6" />
                                Exportar CSV
                            </h5>
                        </div>
                        <div
                            class="tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                            <Icon icon="majesticons:search-line" class="tw-h-6 tw-w-6 tw-text-gray-600" />
                            <input id="busca" type="text" placeholder="Pesquise aqui" required autofocus
                                autocomplete="busca" class="tw-appearance-none tw-border-none tw-w-full tw-text-gray-700"
                                v-model="busca" />
                        </div>
                    </div>
                </div>
                <!-- Tabela de Exibição -->
                <div class="tw-antialiased tw-font-body">
                    <div class="tw-py-4 tw-overflow-x-auto">
                        <div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
                            <q-table flat wrap-cells :rows="filteredEditais" :filter="busca" :columns="columns"
                                :visible-columns="visibleColumns" row-key="id"
                                no-data-label="Não há informações cadastradas."
                                no-results-label="Não foi possível localizar informações com o filtro inserido."
                                rows-per-page-label="Registros por página" v-model:pagination="initialPagination"
                                :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
                                :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'"
                                v-model:selected="rowsSelected" selection="multiple">
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
                                                            <Link :href="route('painel.stai.editais.show', props.row.id)"
                                                                title="Info"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:searchbar-ex" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Visualizar
                                                            </Link>
                                                            <Link v-if="hasPermission('Logs Editais')" :href="route('painel.stai.editais.log', props.row.id)"
                                                                title="Info"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:tenbitclockwidget"
                                                                class="tw-h-6 tw-w-6" />
                                                            &nbsp;Histórico de Logs
                                                            </Link>
                                                            <Link v-if="hasPermission('Editar Editais')" :href="route('painel.stai.editais.editar', props.row.id)"
                                                                title="Editar"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:simpletexteditor" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Editar
                                                            </Link>
                                                            <span v-if="hasPermission('Excluir Editais')" @click="confirmRemoving(props.row)" title="Deletar"
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

/*
.q-chip--colored .q-chip__icon{
    color: none !important;
} */
</style>
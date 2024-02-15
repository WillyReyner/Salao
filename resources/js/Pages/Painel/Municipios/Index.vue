<template>
	<Head title="Editais"/>
	<AuthenticatedLayout>
		<!-- Modal de Filtros -->
		<q-dialog v-model="filtersModal">
			<q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
						filtro abaixo:
					</div>
				</q-card-section>
				<q-card-section class="q-p-none">
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
						<!-- Grupo de Filtro -->
						<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-6">
							<!-- Filtro de Municipio -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroMunicipio" value="Município"/>
								<select id="escola" v-model="filtroMunicipio"
								        class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
									<option value="">Todos</option>
									<option v-for="municipio of props.municipios" :key="municipio.id" :value="municipio.id">
										{{ municipio.nome }}
									</option>
								</select>
							</div>
							<!-- Filtro de Criação -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroCriacao" value="Município"/>
								<input id="filtroCriacao" v-model="filtroCriacao"
								       class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								       type="date"/>
							</div>
						</div>
					</div>
					<!-- Grupo de Botões -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
						<div class="tw-flex tw-flex-1">
							<button
								 class="tw-flex tw-px-8 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center"
								 @click="clearFilters">
								LIMPAR FILTROS
							</button>
						</div>
						<div class="tw-flex tw-flex-1 flex-row tw-gap-4">
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"
								 @click="closeModal">
								CANCELAR
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
					<h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Municipios</h4>
					<Link :href="route('painel.municipios.create')">
						<PrimaryButton v-if="hasPermission('Criar Municipios')"
						               class="tw-text-white tw-bg-green-500 tw-items-center">
							<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add"/>
							ADICIONAR MUNICIPIOS
						</PrimaryButton>
					</Link>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
					<!-- Filtros Selecionados -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
						<q-chip v-if="chipMunicipio" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterMunicipio">
							Municipio
						</q-chip>
						<q-chip v-if="chipCriacao" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCriacao">
							Data de Criação
						</q-chip>
					</div>
					<!-- Filtrar, Exportar e Pesquisar -->
					<div
						 class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
						<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
							<!-- <h5 @click="filtersModal = true"
								 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
								 <Icon icon="ci:filter" class="tw-h-6 tw-w-6" />
								 Filtrar
							</h5> -->
							<h5 v-if="hasPermission('Exportar Municipios')"
							    class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="exportToCSV">
								<Icon class="tw-h-6 tw-w-6" icon="tabler:file-export"/>
								Exportar CSV
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
						<div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
							<q-table v-model:pagination="initialPagination" v-model:rows="filteredMunicipios"
							         v-model:selected="rowsSelected" :columns="columns"
							         :filter="busca"
							         :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
							         :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'"
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
															<Link :href="route('painel.municipios.show', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Info">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:searchbar-ex"/>
																&nbsp;Visualizar
															</Link>
															<!-- <Link :href="route('painel.municipios.show', props.row.id)"
																 title="Info"
																 class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
															<Icon icon="arcticons:tenbitclockwidget"
																 class="tw-h-6 tw-w-6" />
															&nbsp;Histórico de Logs
															</Link> -->
															<Link v-if="hasPermission('Editar Municipios')"
															      :href="route('painel.municipios.editar', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Editar">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:simpletexteditor"/>
																&nbsp;Editar
															</Link>
															<span v-if="hasPermission('Excluir Municipios')"
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

<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {evaCloseCircleOutline} from "@quasar/extras/eva-icons"
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import {Notify} from 'quasar'
import {Icon} from '@iconify/vue';
import {computed} from 'vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';

const props = defineProps({
	municipios: {
		type: Array,
		default: [],
	},
	user: {
		type: Object,
		default: {},
	}
});

const permissions = props.user.permissions

const hasPermission = (permission) => {
	return permissions.some(userPermission => userPermission === permission);
};

const form = useForm({
	id: [],
	nome: '',
})

const filtersModal = ref(false)
const deleteModal = ref(false)

const busca = ref('')
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
	{name: 'id', align: 'left', field: 'id', label: 'ID', sortable: true},
	{name: 'nome', align: 'left', label: 'MUNICÍPIO', field: 'nome', sortable: true},
	{
		name: 'created_at',
		field: 'created_at',
		required: true,
		label: 'DATA DE CRIAÇÃO',
		format: val => `${new Date(val).toLocaleString('pt-BR', dateFormatOptions)}`,
		align: 'left',
		sortable: true
	},
	{name: 'status', field: 'situacao', required: true, label: 'Status', align: 'left', sortable: true},
	{name: 'actions', label: 'AÇÕES', align: 'center', field: 'id'},
]

const visibleColumns = [
	'id', 'nome', 'created_at', 'status', 'actions'
]

const filtroCriacao = ref('')
const filtroMunicipio = ref('')
const filteredMunicipios = ref(props.municipios)

const chipMunicipio = computed(() => filtroMunicipio.value !== '')
const chipCriacao = computed(() => filtroCriacao.value !== '')


function applyFilters() {
	const filtradoCriacao = filtroCriacao.value !== '' ? props.municipios.filter(municipio => municipio.created_at.split('T')[0] === filtroCriacao.value) : props.municipios
	filteredMunicipios.value = filtroMunicipio.value !== '' ? filtradoCriacao.filter(municipio => municipio.id === filtroMunicipio.value) : filtradoCriacao
	filtersModal.value = false
}

function removeFilterCriacao() {
	filtroCriacao.value = ''
	applyFilters()
}

function removeFilterMunicipio() {
	filtroMunicipio.value = ''
	applyFilters()
}

function clearFilters() {
	filtroCriacao.value = ''
	filtroMunicipio.value = ''
}

function removeItem(item) {

	form.id = item.id || rowsSelected.value.map(row => row.id)

	form.post(route('painel.municipios.destroy'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Municipio(s) removido(s) com sucesso.",
				color: "secondary"
			})
			window.location.href = '/municipios';
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover esse(s) municipio(s).",
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
			'NOME DOS MUNICIPIOS',
			'SITUACAO'
		];
		const data = filteredMunicipios.value.map((role) => [
			role.id,
			`"${role.nome}"`,
			role.situacao
		]);
		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'MunicipiosExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	} else {
		const columns = [
			'ID',
			'NOME DOS MUNICIPIOS',
			'SITUACAO'
		];

		const data = rowsSelected.value.map((role) => [
			role.id,
			`"${role.nome}"`,
			role.situacao
		]);

		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'MunicipiosExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}
};
</script>
<style>

.q-checkbox__bg > svg {
	display: flex;
	position: relative;
	width: 70% !important;
	height: 70% !important;
}

/*
.q-chip--colored .q-chip__icon{
    color: none !important;
} */</style>
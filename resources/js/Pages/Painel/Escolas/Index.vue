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
	escolas: {
		type: Array,
		default: []
	},
	municipios: {
		type: Array,
		default: [],
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
	{name: 'id', field: 'id', label: 'ID', required: true, align: 'left', sortable: true},
	{
		name: 'created_at',
		field: 'created_at',
		label: 'DATA DE CRIAÇÃO',
		format: val => `${new Date(val).toLocaleString('pt-BR', dateFormatOptions)}`,
		align: 'left',
		sortable: true
	},
	{name: 'nome', align: 'left', label: 'NOME COMPLETO', field: 'nome', sortable: true},
	{name: 'municipio', align: 'left', label: 'MUNICIPIO', field: 'municipio', format: val => val.nome, sortable: true},
	{name: 'rede', align: 'left', label: 'REDE', field: 'rede', sortable: true},
	{name: 'situacao', align: 'left', label: 'SITUAÇÃO', field: 'situacao', sortable: true},
	{name: 'actions', label: 'AÇÕES', align: 'center', field: 'id'},
]

const visibleColumns = [
	'id', 'created_at', 'nome', 'municipio', 'rede', 'situacao', 'actions'
]

const filtroCriacao = ref('')
const filtroID = ref('')
const filtroNome = ref('')
const filtroMunicipio = ref('')
const filtroRede = ref('')
const filtroSituacao = ref('')
const filteredEscolas = ref(props.escolas)

const chipCriacao = computed(() => filtroCriacao.value !== '')
const chipID = computed(() => filtroID.value !== '')
const chipNome = computed(() => filtroNome.value !== '')
const chipMunicipio = computed(() => filtroMunicipio.value !== '')
const chipRede = computed(() => filtroRede.value !== '')
const chipSituacao = computed(() => filtroSituacao.value !== '')

const opcoesRede = ['COTEC', 'EFG', 'GOIAS TEC', 'JUVENTUDE'];
const opcoesSituacao = ['Ativo', 'Inativo'];

function applyFilters() {
	const filtradoCriacao = filtroCriacao.value !== '' ? props.escolas.filter(escola => escola.created_at.split('T')[0] === filtroCriacao.value) : props.escolas
	const filtradoID = filtroID.value !== '' ? filtradoCriacao.filter(escola => escola.id === filtroID.value) : filtradoCriacao
	const filtradoNome = filtroNome.value !== '' ? filtradoID.filter(escola => escola.nome.toLowerCase().includes(filtroNome.value.toLowerCase())) : filtradoID
	const filtradoMunicipio = filtroMunicipio.value !== '' ? filtradoNome.filter(escola => filtroMunicipio.value === escola.municipio_id) : filtradoNome
	const filtradoSituacao = filtroSituacao.value !== '' ? filtradoMunicipio.filter(escola => filtroSituacao.value === escola.situacao) : filtradoMunicipio
	filteredEscolas.value = filtroRede.value !== '' ? filtradoSituacao.filter(escola => filtroRede.value.toLowerCase() === escola.rede.toLowerCase()) : filtradoSituacao
	filtersModal.value = false
}

function removeFilterCriacao() {
	filtroCriacao.value = ''
	applyFilters()
}

function removeFilterID() {
	filtroID.value = ''
	applyFilters()
}

function removeFilterNome() {
	filtroNome.value = ''
	applyFilters()
}

function removeFilterMunicipio() {
	filtroMunicipio.value = ''
	applyFilters()
}

function removeFilterRede() {
	filtroRede.value = ''
	applyFilters()
}

function removeFilterSituacao() {
	filtroSituacao.value = ''
	applyFilters()
}

function clearFilters() {
	filtroCriacao.value = ''
	filtroID.value = ''
	filtroSituacao.value = ''
	filtroMunicipio.value = ''
	filtroRede.value = ''
	filtroNome.value = ''
}

function removeItem(item) {

	form.id = item.id || rowsSelected.value.map(row => row.id)

	form.post(route('painel.escolas.destroy'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Unidade(s) removida(s) com sucesso.",
				color: "secondary"
			})
			window.location.href = '/escolas';
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
			'NOME DAS ESCOLAS',
			'STATUS',
		];
		const data = filteredEscolas.value.map((escola) => [
			escola.id,
			`"${escola.nome}"`,
			escola.situacao,
		]);
		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'EscolasExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	} else {
		const columns = [
			'ID',
			'NOME DAS ESCOLAS',
			'STATUS',
		];

		const data = rowsSelected.value.map((escola) => [
			escola.id,
			`"${escola.nome}"`,
			escola.situacao,
		]);

		const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
		const blob = new Blob([csvContent], {type: 'text/csv;charset=utf-8;'});
		const url = window.URL.createObjectURL(blob);

		const link = document.createElement('a');
		link.setAttribute('href', url);
		link.setAttribute('download', 'EscolasExport.csv');
		document.body.appendChild(link);

		link.click();

		document.body.removeChild(link);
		window.URL.revokeObjectURL(url);
	}
};
</script>
<template>
	<Head title="Unidades"/>

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
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-6">
						<!-- Grupo de Filtro -->
						<div class="tw-flex tw-flex-1 tw-flex-col tw-gap-4">
							<!-- Filtro de Criação -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroCriacao" value="Data de Criação"/>
								<input id="filtroCriacao" v-model="filtroCriacao"
								       class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								       type="date"/>
							</div>
							<!-- Filtro de Nome -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroNome" value="Data de Criação"/>
								<input id="filtroNome" v-model="filtroNome"
								       class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								       type="text"/>
							</div>
							<!-- Filtro de Rede -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="FiltroRede" value="Rede"/>
								<select id="escola" v-model="filtroRede"
								        class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
									<option value="">Todos</option>
									<option v-for="opcao of opcoesRede" :key="opcao" :value="opcao"> {{ opcao }}</option>
								</select>
							</div>
						</div>
						<!-- Grupo de Filtro Direita -->
						<div class="tw-flex tw-flex-1 tw-flex-col tw-gap-4">
							<!-- Filtro de ID -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroID" value="ID"/>
								<input id="filtroID" v-model="filtroID"
								       class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								       type="text"/>
							</div>
							<!-- Filtro de Municipio -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroMunicipio" value="Município"/>
								<select id="escola" v-model="filtroMunicipio"
								        class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
									<option value="">Todos</option>
									<option v-for="[municipio, index] of props.municipios" :key="index" :value="municipio.id">
										{{ municipio.nome }}
									</option>
								</select>
							</div>
							<!-- Filtro de Situação -->
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="filtroSituacao" value="Situação"/>
								<select id="escola" v-model="filtroSituacao"
								        class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
									<option v-for="opcao of opcoesSituacao" :key="opcao" :value="opcao"> {{ opcao }}
									</option>
								</select>
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
					<h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Unidades Cadastradas</h4>
					<Link :href="route('painel.escolas.create')">
						<PrimaryButton v-if="hasPermission('Criar Escolas')"
						               class="tw-text-white tw-bg-green-500 tw-items-center">
							<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="icon-park-outline:add"/>
							ADICIONAR ESCOLAS
						</PrimaryButton>
					</Link>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
					<!-- Filtros Selecionados -->
					<div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
						<q-chip v-if="chipCriacao" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterCriacao">
							Criacao
						</q-chip>
						<q-chip v-if="chipID" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterID">
							ID
						</q-chip>
						<q-chip v-if="chipNome" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterNome">
							Nome
						</q-chip>
						<q-chip v-if="chipMunicipio" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterMunicipio">
							Municipio
						</q-chip>
						<q-chip v-if="chipSituacao" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterSituacao">
							Situação
						</q-chip>
						<q-chip v-if="chipRede" :icon="evaCloseCircleOutline" clickable color="green" outline
						        size="lg" text-color="green" @click="removeFilterRede">
							Rede
						</q-chip>
					</div>
					<!-- Filtrar, Exportar e Pesquisar -->
					<div
						 class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">

						<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
							<h5 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"
							    @click="filtersModal = true">
								<Icon class="tw-h-6 tw-w-6" icon="ci:filter"/>
								Filtrar
							</h5>
							<h5 v-if="hasPermission('Exportar Escolas')"
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
							<q-table v-model:pagination="initialPagination" v-model:rows="filteredEscolas"
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
															<Link :href="route('painel.escolas.show', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Info">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:searchbar-ex"/>
																&nbsp;Visualizar
															</Link>
															<!-- <Link :href="route('painel.escolas.show', props.row.id)"
																 title="Info"
																 class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
															<Icon icon="arcticons:tenbitclockwidget"
																 class="tw-h-6 tw-w-6" />
															&nbsp;Histórico de Logs
															</Link> -->
															<Link v-if="hasPermission('Editar Escolas')"
															      :href="route('painel.escolas.editar', props.row.id)"
															      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"
															      title="Editar">
																<Icon class="tw-h-6 tw-w-6" icon="arcticons:simpletexteditor"/>
																&nbsp;Editar
															</Link>
															<span v-if="hasPermission('Excluir Escolas')"
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

.q-checkbox__bg > svg {
	display: flex;
	position: relative;
	width: 70% !important;
	height: 70% !important;
}

/*
.q-chip--colored .q-chip__icon{
    color: none !important;
} */
</style>
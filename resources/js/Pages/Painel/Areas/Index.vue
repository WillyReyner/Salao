<template>
    <Head title="Areas" />
    <AuthenticatedLayout>
        <!-- Modal de Filtros -->
        <q-dialog v-model="filtersModal">
            <q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
                <q-card-section>
                    <div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
                        filtro abaixo: </div>
                </q-card-section>
                <q-card-section class="q-p-none">
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
                        <!-- Grupo de Filtro -->
                        <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-6">
                            <div class="tw-flex tw-flex-1 tw-flex-col tw-gap-4">
                                <!-- Filtro de ID -->
                                <div class="tw-flex tw-flex-1 tw-flex-col">
                                    <InputLabel for="filtroID" value="ID" />
                                    <input id="filtroID" type="number"
                                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                                        v-model="filtroID" />
                                </div>
                                <!-- Filtro de Nome -->
                                <div class="tw-flex tw-flex-1 tw-flex-col">
                                    <InputLabel for="filtroCriacao" value="Data de Criação" />
                                    <input id="filtroCriacao" type="date"
                                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                                        v-model="filtroCriacao" />
                                </div>
                            </div>
                            <!-- Filtro de Criação -->
                            <div class="tw-flex tw-flex-1 tw-flex-col">
                                <InputLabel for="filtroNome" value="Descrição" />
                                <input id="filtroNome" type="text"
                                    class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                                    v-model="filtroNome" />
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
                            </button>{{ id }}
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
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div
                    class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Áreas Cadastradas</h4>
                    <div
                        class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
                        <h5 v-if="hasPermission('Importar Areas')"
                            class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                            <Icon icon="tabler:file-import" class="tw-h-6 tw-w-6" />
                            Importar CSV
                        </h5>
                        <Link :href="route('painel.areas.create')">
                        <PrimaryButton v-if="hasPermission('Criar Areas')" class="tw-text-white tw-bg-green-500 tw-items-center">
                            <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
                            ADICIONAR AREAS
                        </PrimaryButton>
                        </Link>
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
                    <!-- Filtros Selecionados -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipID"
                            @click="removeFilterID" color="green" text-color="green">
                            ID
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipNome"
                            @click="removeFilterNome" color="green" text-color="green">
                            Descrição
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipCriacao"
                            @click="removeFilterCriacao" color="green" text-color="green">
                            Data de Criação
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
                            <h5 v-if="hasPermission('Exportar Areas')" @click="exportToCSV"
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
                            <q-table flat v-model:rows="filteredAreas" :columns="columns" :visible-columns="visibleColumns"
                                row-key="id" :filter="busca" no-data-label="Não há informações cadastradas."
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
                                                            <Link :href="route('painel.areas.show', props.row.id)"
                                                                title="Info"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:searchbar-ex" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Visualizar
                                                            </Link>
                                                            <!-- <Link :href="route('painel.areas.show', props.row.id)"
                                                                title="Info"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:tenbitclockwidget"
                                                                class="tw-h-6 tw-w-6" />
                                                            &nbsp;Histórico de Logs
                                                            </Link> -->
                                                            <Link v-if="hasPermission('Editar Areas')" :href="route('painel.areas.editar', props.row.id)"
                                                                title="Editar"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:simpletexteditor" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Editar
                                                            </Link>
                                                            <span v-if="hasPermission('Excluir Areas')" @click="confirmRemoving(props.row)" title="Deletar"
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
<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, Notify } from 'quasar'
import { Icon } from '@iconify/vue';
import { computed } from 'vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';

const props = defineProps({
    areas: {
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
    created_at: '',
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
    { name: 'id', field: 'id', label: 'ID' },
    { name: 'nome', align: 'left', label: 'TIPO DE ARQUIVO', field: 'nome', sortable: true },
    { name: 'created_at', field: 'created_at', required: true, label: 'DATA DA CRIAÇÃO', format: val => `${new Date(val).toLocaleString('pt-BR', dateFormatOptions)}`, align: 'left', sortable: true },
    { name: 'situacao', field: 'situacao', required: true, label: 'STATUS', align: 'left', sortable: true },
    { name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
]

const visibleColumns = [
    'id', 'nome', 'created_at', 'situacao', 'actions'
]


const filtroID = ref('')
const filtroNome = ref('')
const filtroCriacao = ref('')
const filteredAreas = ref(props.areas)

const chipID = computed(() => filtroID.value != '')
const chipNome = computed(() => filtroNome.value != '')
const chipCriacao = computed(() => filtroCriacao.value != '')



function applyFilters() {
    const filtradoCriacao = filtroCriacao.value != '' ? props.tiposArquivo.filter(tipo => tipo.created_at.split('T')[0] == filtroCriacao.value) : props.tiposArquivo
    const filtradoID = filtroID.value != '' ? filtradoCriacao.filter(tipo => tipo.id == filtroID.value) : filtradoCriacao
    const filtradoNome = filtroNome.value != '' ? filtradoID.filter(tipo => tipo.nome.toLowerCase().includes(filtroNome.value.toLowerCase())) : filtradoID
    filteredAreas.value = filtradoNome
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

function clearFilters() {
    filtroCriacao.value = ''
    filtroID.value = ''
    filtroNome.value = ''
}

function removeItem(item) {
    form.id = item.id || rowsSelected.value.map(row => row.id)

    form.delete(route('painel.areas.destroy'), {
        preserveScroll: true,
        onSuccess: (res) => {
            Notify.create({
                message: "Tipo(s) de Arquivo(s) removido(s) com sucesso.",
                color: "secondary"
            })
            window.location.href = '/areas';
            applyFilters()
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível remover esse(s) Tipo(s) de Arquivo(s).",
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
            'NOME DAS TAGS',
            'SITUACAO'
        ];
        const data = filteredAreas.value.map((role) => [
            role.id,
            `"${role.nome}"`,
            role.situacao
        ]);
        const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'AreasExport.csv');
        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    else {
        const columns = [
            'ID',
            'NOME DAS TAGS',
            'SITUACAO'
        ];

        const data = rowsSelected.value.map((role) => [
            role.id,
            `"${role.nome}"`,
            role.situacao
        ]);

        const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'AreasExport.csv');
        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }
};
</script>

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
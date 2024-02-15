<template>
    <Head title="Perfil" />
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
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">EDITAL</h5>
                        <InputLabel />
                        <select v-model="filtroEdital"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                            <option value="">Todos</option>
                            <option v-for="edital in props.editais" :key="index" :val="edital.nome">
                                {{ edital.nome }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CURSO</h5>
                        <InputLabel />
                        <select v-model="filtroCursos"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                            <option value="">Todos</option>
                            <option v-for="curso, index of props.cursos" :key="index" :value="curso.id">
                                {{ curso.nome }}
                            </option>
                        </select>
                    </div>
                </div>
                <br />
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
                                        <q-checkbox :val="opcao" v-model:model-value="filtroSituacao" />
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
                                        <q-checkbox :val="opcao" v-model:model-value="filtroModalidade" />
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
                                        <q-checkbox :val="opcao" v-model:model-value="filtroModalidade" />
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
                                        <q-checkbox :val="opcao" v-model:model-value="filtroTurno" />
                                        {{ opcao }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" tw-flex tw-flex-1 tw-flex-col">
                            <br />
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">DURAÇÃO ESTIMADA</h5>
                            <!-- Filtro de Duração Estimada -->
                            <div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
                                <div class="tw-flex tw-flex-1 tw-flex-col">
                                    <div v-for="opcao in opcoesCargaHoraria"
                                        class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                                        <q-checkbox :val="opcao" v-model:model-value="filtroCargaHoraria" />
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
                                        <q-checkbox :val="opcao" v-model:model-value="filtroNivel" />
                                        {{ opcao }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Grupo de Botões -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
                        <div class="tw-flex tw-flex-1">
                            <button @click="closeModal"
                                class="tw-flex tw-px-8 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                                CANCELAR
                            </button>
                        </div>
                        <div class="tw-flex tw-flex-1 flex-row tw-gap-4">
                            <button @click="clearFilters"
                                class="tw-flex tw-flex-1 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center">
                                LIMPAR FILTROS
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
        <!-- Modal de Permissões-->
        <q-dialog v-model="filtersModalPermissoes">
            <q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
                <q-card-section>
                    <div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
                        filtro abaixo: </div>
                </q-card-section>

                <q-card-section class="q-p-none">
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
                        <!-- Grupo de Filtro -->
                        <div class="tw-flex tw-flex-1 tw-flex-col">
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">STATUS</h5>
                            <!-- Filtro de Modalidade -->
                            <div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
                                <div class="tw-flex tw-flex-1 tw-flex-col">
                                    <div v-for="opcao in opcoesPermissoes"
                                        class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                                        <q-checkbox :val="opcao" :label="opcao.label"
                                            v-model:model-value="form.permissions" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ selectedUserId }}
                    <!-- Grupo de Botões -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
                        <div class="tw-flex tw-flex-1">
                            <button @click="closeModal"
                                class="tw-flex tw-px-8 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                                CANCELAR
                            </button>
                        </div>
                        <div class="tw-flex tw-flex-1 flex-row tw-gap-4">
                            <button @click="savePermissions"
                                class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center">
                                SALVAR
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
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Usuários Cadastrados</h4>
                    <div class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
                        <h5 class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                            <Icon icon="tabler:file-import" class="tw-h-6 tw-w-6" />
                            Importar CSV
                        </h5>
                        <Link :href="route('painel.gestao.usuarios.create')">
                        <PrimaryButton class="tw-text-white tw-bg-green-500 tw-items-center">
                            <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
                            ADICIONAR USUARIO
                        </PrimaryButton>
                        </Link>
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">
                    <!-- Filtros Selecionados -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipStatus"
                            @click="removeFilterStatus" color="green" text-color="green">
                            Status
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipModalidade"
                            @click="removeFilterModalidade" color="green" text-color="green">
                            Modalidade
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipTurno"
                            @click="removeFilterTurno" color="green" text-color="green">
                            Turno
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipSituacao"
                            @click="removeFilterSituacao" color="green" text-color="green">
                            Situação
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipEdital"
                            @click="removeFilterEdital" color="green" text-color="green">
                            Edital
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipNivel"
                            @click="removeFilterNivel" color="green" text-color="green">
                            Nivel
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipCargaHoraria"
                            @click="removeFilterCargaHoraria" color="green" text-color="green">
                            Carga Horária
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipCurso"
                            @click="removeFilterCurso" color="green" text-color="green">
                            Curso
                        </q-chip>
                    </div>

                    <!-- Filtrar, Exportar e Pesquisar -->
                    <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
                        <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
                            <h5 @click="filtersModal = true"
                                class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                                <Icon icon="ci:filter" class="tw-h-6 tw-w-6" />
                                Filtrar
                            </h5>
                            <h5 @click="exportToCSV"
                                class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                                <Icon icon="tabler:file-export" class="tw-h-6 tw-w-6" />
                                Exportar CSV
                            </h5>
                        </div>
                        <div class="tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
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
                            <q-table flat wrap-cells :rows="filteredUsuarios" :columns="columns" :filter="busca"
                                :visible-columns="visibleColumns" :pagination="initialPagination" row-key="id"
                                no-data-label="Não há informações cadastradas."
                                no-results-label="Não foi possível localizar informações com o filtro inserido."
                                v-model:selected="rowsSelected" selection="multiple"
                                rows-per-page-label="Registros por página" v-model:pagination="initialPagination"
                                :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
                                :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'">
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
                                                            <Link :href="route('painel.gestao.usuarios.show', props.row.id)"
                                                                title="Info"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:searchbar-ex" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Visualizar
                                                            </Link>
                                                            <!-- <Link :href="route('painel.turmas.show', props.row.id)"
                                                                title="Info"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:tenbitclockwidget"
                                                                class="tw-h-6 tw-w-6" />
                                                            &nbsp;Histórico de Logs
                                                            </Link> -->
                                                            <Link
                                                                :href="route('painel.gestao.usuarios.editar', props.row.id)"
                                                                title="Editar"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="arcticons:simpletexteditor" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Editar
                                                            </Link>
                                                            <Link :href="route('painel.turmas.editar', props.row.id)"
                                                                title="Editar"
                                                                class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center">
                                                            <Icon icon="ph:export-thin" class="tw-h-6 tw-w-6" />
                                                            &nbsp;Exportar
                                                            </Link>
                                                            <span @click="confirmRemoving(props.row)" title="Deletar"
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
                                            <div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
                                                <div v-if="col.name === 'imagem'">
                                                    <img :src="`/storage/${col.value}`"
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
<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, toRefs } from 'vue';
import { Dialog, Notify } from 'quasar'
import { Icon } from '@iconify/vue';
import { computed } from 'vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import InputError from '@/Components/Pages/InputError.vue';
import axios from 'axios';

//Propriedades
const props = defineProps({
    usuarios: {
        type: Array,
        default: []
    },
    roles: {
        type: Array,
        default: []
    },
    permissions: {
        type: Array,
        default: []
    }
});

//Forms
const form = useForm({
    id: [],
    nome: '',
    permissions: [],
})

const filtersModal = ref(false)
const filtersModalPermissoes = ref(false)
const deleteModal = ref(false)
const rowsSelected = ref([])
const busca = ref('')

const columns = [
    { name: 'id', field: 'id', label: 'ID', required: true, align: 'left', sortable: true },
    { name: 'nome', field: 'name', label: 'NOME DO USUÁRIO', align: 'left', sortable: true },
    { name: 'email', field: 'email', label: 'EMAIL', align: 'left', sortable: true },
    { name: 'role', field: 'role', label: 'PERFIL DO USUARIO', align: 'left', sortable: true },
    { name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
]

const visibleColumns = [
    'id',
    'nome',
    'email',
    'role',
    'actions',
]

const dateFormatOptions = {
    year: "numeric", month: "numeric", day: "numeric"
}
const initialPagination = ref({
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10
})

const filtroTipo = ref([])
const filtroStatus = ref([])
const filtroModalidade = ref([])
const filtroNivel = ref([])
const filtroTurno = ref([])
const filtroSituacao = ref([])
const filtroPermissoes = ref([])
const filtroCargaHoraria = ref([])
const filtroCurso = ref([])
const filtroEdital = ref([])
const filteredUsuarios = ref(props.usuarios)

//
const chipCategoria = computed(() => filtroTipo.value.length > 0)
const chipStatus = computed(() => filtroStatus.value.length > 0)
const chipModalidade = computed(() => filtroModalidade.value.length > 0)
const chipNivel = computed(() => filtroNivel.value.length > 0)
const chipCargaHoraria = computed(() => filtroCargaHoraria.value.length > 0)
const chipTurno = computed(() => filtroTurno.value.length > 0)
const chipSituacao = computed(() => filtroSituacao.value.length > 0)
const chipEdital = computed(() => filtroEdital.value != '')
const chipCurso = computed(() => filtroCurso.value != '')


const opcoesRoles = props.roles.map(role => ({ label: role.nome, value: role.id }))
const opcoesPermissoes = props.permissions.map(permission => ({ label: permission.name, value: permission.id }))
//
const opcoesNivel = ['Iniciante', 'Intermediario', 'Avançado'];
const opcoesCargaHoraria = ['40 Horas', '160 Horas', '240 Horas', '960 Horas', '1440 Horas']
const opcoesSituacao = ['Ativo', 'Inativo']
const opcoesModalidade = ['Cadastro de Reserva', 'EAD', 'Online', 'Presencial'];
const opcoesTurno = ['Integral', 'Matutino', 'Vespertino', 'Noturno'];
const opcoesCategoria = ['Capacitação', 'Qualificação', 'Superior', 'Técnico'];

const selectedUserId = ref(null); // Propriedade para armazenar o ID selecionado

function closeModal() {
    filtersModal.value = false,
        filtersModalPermissoes.value = false
}

function applyFilters() {
    const filtradoCategoria = filtroCategoria.value.length > 0 ? props.turmas.filter(turma => filtroCategoria.value.includes(turma.categoria)) : props.turmas
    const filtradoTipo = filtroTipo.value.length > 0 ? props.turmas.filter(turma => filtroTipo.value.includes(turma.tipo)) : props.turmas
    const filtradoModalidade = filtroModalidade.value.length > 0 ? filtradoEscola.filter(turma => filtroModalidade.value.includes(turma.modalidade)) : filtradoEscola
    const filtradoNivel = filtroNivel.value.length > 0 ? filtradoNivel.filter(turma => filtroNivel.value.includes(turma.nivel)) : filtradoNivel
    const filtradoCargaHoraria = filtroCargaHoraria.value.length > 0 ? filtradoCargaHoraria.filter(turma => filtroCargaHoraria.value.includes(turma.horas_curso)) : filtradoCargaHoraria
    const filtradoTurno = filtroTurno.value.length > 0 ? filtradoModalidade.filter(turma => filtroTurno.value.includes(turma.turno)) : filtradoModalidade
    const filtradoSituacao = filtroSituacao.value.length > 0 ? filtradoTurno.filter(turma => filtroSituacao.value.includes(edital.situacao)) : filtradoTurno
    const filtradoEdital = filtroEdital.value != '' ? filtradoSituacao.filter(turma => turma.edital_id == filtroEdital) : filtradoSituacao
    const filtradoCurso = filtroCurso.value != '' ? filtradoSituacao.filter(turma => turma.curso_id == filtroCurso) : filtradoSituacao
    const filtradoStatus = filtroStatus.value != '' ? filtradoStatus.filter(turma => turma.edital_id == filtroEdital) : filtradoStatus

    filteredUsuarios.value = filtradoEdital
    filtersModal.value = false
    filtersModalPermissoes.value = false
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
    filtroEdital.value = []
    filtroCurso.value = []
}

function removeItem(item) {

    form.id = item.id || rowsSelected.value.map(row => row.id)

    form.post(route('painel.gestao.usuarios.destroy'), {
        preserveScroll: true,
        onSuccess: (res) => {
            Notify.create({
                message: "Turma(s) removida(s) com sucesso.",
                color: "secondary"
            })
            window.location.href = '/gestao/usuarios';
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

function confirmRemoving(data) {
    rowsSelected.value = [data]
    deleteModal.value = true
}

const exportToCSV = () => {

    if (rowsSelected.value.length === 0) {
        const columns = [
            'ID',
            'NOME DOS USUARIOS',
            'SITUACAO'
        ];
        const data = filteredUsuarios.value.map((role) => [
            role.id,
            `"${role.name}"`,
            role.situacao
        ]);
        const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'UsersExport.csv');
        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    else {
        const columns = [
            'ID',
            'NOME DOS USUARIOS',
            'SITUACAO'
        ];

        const data = rowsSelected.value.map((role) => [
            role.id,
            `"${role.name}"`,
            role.situacao
        ]);

        const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'UsersExport.csv');
        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }
};

const savePermissions = () => {
    form.post(route('painel.gestao.usuarios.permission', form.id), {
        preserveScroll: true,
        onSuccess: (response) => {
            form.reset();
            console.log(response);
        }
    })
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
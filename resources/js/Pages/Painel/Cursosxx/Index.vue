<template>
    <Head title="Cursos" />

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
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TAGS</h5>
                        <InputLabel />
                        <!-- Filtro de Nome -->
                        <div class="tw-flex tw-flex-1 tw-flex-col">
                            <InputLabel for="filtroNome" value="Busque pela Tag"/>
                            <input id="filtroNome" type="text"
                                class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                                v-model="filtroNome"
                            />
                        </div>
                    </div>
                </div>
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
                        </div>
                        <div class=" tw-flex tw-flex-1 tw-flex-col">
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">TURMAS</h5>
                            <!-- Filtro de Modalidade -->
                            <div class="tw-flex tw-flex-row tw-gap-4 tw-mt-4">
                                <div class="tw-flex tw-flex-1 tw-flex-col">
                                    <div v-for="opcao in opcoesTurma"
                                        class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                                        <q-checkbox :val="opcao" v-model:model-value="filtroTurma" />
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
                    <h4 class="tw-text-gray-900 tw-font-title tw-font-semibold">Cursos Cadastrados</h4>
                    <div
                        class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
                        <h5
                            class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                            <Icon icon="tabler:file-import" class="tw-h-6 tw-w-6" />
                            Importar CSV
                        </h5>
                        <Link :href="route('painel.cursos.create')">
                        <PrimaryButton class="tw-text-white tw-bg-green-500 tw-items-center">
                            <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
                            ADICIONAR CURSO
                        </PrimaryButton>
                        </Link>
                    </div>
                </div>

                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center">

                    <!-- Filtros Selecionados -->
                    <div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipNome"
                            @click="removeFilterNome" color="green" text-color="green">
                            Nome
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipSituacao"
                            @click="removeFilterSituacao" color="green" text-color="green">
                            Modalidade
                        </q-chip>
                        <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipTurma"
                            @click="removeFilterTurma" color="green" text-color="green">
                            Turno
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
                            <h5 @click="exportToCSV" class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
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
                            <q-table 
                                flat
                                :rows="filteredCursos" 
                                :columns="columns"
                                :filter="busca"
                                :visible-columns="visibleColumns"
                                :pagination="initialPagination"
                                row-key="id" 
                                no-data-label="Não há informações cadastradas."
                                no-results-label="Não foi possível localizar informações com o filtro inserido."
                                :selected="rowsSelected" 
                                selection="multiple"
                                
                                >
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
                                                <q-btn-dropdown color="white" label="..." class="tw-text-gray-700">
                                                    <div class="tw-flex tw-flex-col tw-gap-2">
                                                        <Link :href="route('painel.turmas.show', props.row.id)" title="Info"
                                                            class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-center tw-items-center">
                                                        Detalhes
                                                        </Link>
                                                        <Link :href="route('painel.turmas.editar', props.row.id)"
                                                            title="Editar"
                                                            class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-center tw-items-center">
                                                        Editar
                                                        </Link>
                                                        <span @click="confirmRemoving(props.row)" title="Deletar"
                                                            class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-center tw-items-center">
                                                            Deletar
                                                        </span>
                                                    </div>
                                                </q-btn-dropdown>
                                            </div>
                                            <div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
                                                {{ col.value }}
                                            </div>
                                        </q-td>
                                    </q-tr>
                                </template>
                            </q-table>
                            <!-- Linhas por Página -->
                            <!-- <div class="tw-flex flex-row tw-my-5 tw-items-center tw-text-gray-700 tw-text-lg">
                                Exibir:
                                <select id="rowsperpage"
                                    class="tw-border tw-border-gray-500 tw-rounded-xl tw-min-w-[60px] tw-text-gray-700 tw-mx-2"
                                    v-model="initialPagination.rowsPerPage">
                                    <option v-for="n in [1, 5, 10, 20, 50]" :value="n" :key="n">{{ n }}</option>
                                </select>
                                resultados por página
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- <div class="tw-flex tw-flex-1 tw-flex-row">
                    <button :disabled="!rowsSelected.length" @click="deleteModal = true" class="tw-block tw-h-[52px] tw-px-8 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-blue-500 tw-justify-center">
                        EXCLUIR
                    </button>
                </div> -->
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
import InputError from '@/Components/Pages/InputError.vue';

const props = defineProps({
    cursos: {
        type: Array,
        default: [],
    },
});

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

function closeModal(){
    filtersModal.value = false
}


const columns = [
    { name: 'id', field: 'id', label: 'ID'},
    { name: 'imagem', field: 'imagem', required: true, label: 'IMAGEM', align: 'left', sortable: true },
    { name: 'nome', align: 'left', label: 'CURSO', field: 'nome' ,sortable: true },
    { name: 'turma', align: 'left', label: 'TURMAS', field: 'turma' ,sortable: true },
    { name: 'situacao', align: 'left', label: 'STATUS', field: 'situacao', sortable: true },
    { name: 'actions', label: 'AÇÕES', align: 'center', field: 'id'},
]

const visibleColumns = [
    'id','turma', 'imagem', 'nome', 'situacao', 'actions'
]


const filtroID = ref([])
const filtroNome = ref([])
const filtroSituacao = ref([])
const filtroTurma = ref([])
const filteredCursos = ref(props.cursos)

const chipNome = computed(() => filtroNome.value.lenght > 0 )
const chipSituacao = computed(() => filtroSituacao.value.lenght > 0 )
const chipTurma = computed(() => filtroTurma.value.lenght > 0 )


const opcoesSituacao = ['Ativo', 'Inativo', 'Bloqueado'];
const opcoesTurma = ['Turmas Ativas', 'Turmas Inativas']

function applyFilters(){
    const filtradoTurma = filtroTurma.value.length > 0 ? filtradoTurma.filter(turma => filtradoTurma.value.includes(turma.id)) : filtradoTurma
    const filtradoID = chipID.value ? props.cursos.filter(curso => curso.id === filtroID.value) : props.cursos
    const filtradoNome = chipNome.value ? filtradoID.filter(curso => filtroNome.value.includes(curso.escola.nome)) : filtradoID
    const filtradoSituacao = chipSituacao.value ? filtradoNome.filter(curso => filtroSituacao.value.includes(curso.situacao)) : filtradoNome
    
    filteredCursos.value = filtradoSituacao
    filtersModal.value = false
}

function removeFilterNome(){
    filtroNome.value = ''
    applyFilters()
}
function removeFilterTurma(){
    filtroTurma.value = ''
    applyFilters()
}
function removeFilterSituacao(){
    filtroSituacao.value = ''
    applyFilters()
}

function clearFilters(){
    filtroTurma.value = []
    filtroNome.value = []
    filtroSituacao.value = []
}

function removeItem(item){
    form.id = item.id || rowsSelected.value.map(row => row.id)
    form.post(route('painel.cursos.destroy'), {
        preserveScroll: true,
        onSuccess: (res) => {
            Notify.create({
                message: "Curso(s) removido(s) com sucesso.",
                color: "secondary"
            })
            window.location.href = '/cursos';
            applyFilters()
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível remover esse(s) Curso(s).",
                color: "negative"
            })
        }
    })
    deleteModal.value = false
}

function confirmRemoving(data){
    rowsSelected.value = [data]
    deleteModal.value = true
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

  // Preparar os dados para exportação CSV
  const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;

  // Criar um objeto Blob para o conteúdo CSV
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

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
.q-checkbox__bg{
    background-color: white;
    border-color: rgb(148, 148, 148);
    padding: 1px;
    border-radius: 6px;
    border-width: 1px;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative!important;
}
.q-checkbox__inner--truthy .q-checkbox__bg {
    background-color: rgb(0, 218, 0);
}
.q-checkbox__bg > svg {
    display: flex;
    position: relative;
    width: 70%!important;
    height: 70%!important;
}

.q-chip{
    background-color: rgba(164, 255, 164, 0.418)!important;
    font-family: 'Open Sans';
    color: rgb(0, 255, 0);
    border: none;
}

</style>
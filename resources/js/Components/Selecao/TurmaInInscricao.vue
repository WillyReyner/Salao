<template>
    <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
        <!-- Começo Turmas em Editais -->
        <q-dialog v-model="filtersModal">
            <q-card style="
                    min-width: 40vw;
                    max-width: 500px;
                    border-radius: 20px;
                    padding: 40px;
                ">
                <q-card-section>
                    <div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">
                        Selecione as opções que deseja no filtro abaixo:
                    </div>
                </q-card-section>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">
                            EDITAL
                        </h5>
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
                        <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">
                            CURSO
                        </h5>
                        <InputLabel />
                        <select v-model="filtroCursos"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                            <option value="">Todos</option>
                            <option v-for="(curso, index) of props.cursos" :key="index" :value="curso.id">
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
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">
                                STATUS
                            </h5>
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
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">
                                CATEGORIA
                            </h5>
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
                        <div class="tw-flex tw-flex-1 tw-flex-col">
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">
                                MODALIDADE
                            </h5>
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
                                    <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">
                                        TURNO
                                    </h5>
                                    <!-- Filtro de Situação -->
                                    <div v-for="opcao in opcoesTurno"
                                        class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                                        <q-checkbox :val="opcao" v-model:model-value="filtroTurno" />
                                        {{ opcao }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tw-flex tw-flex-1 tw-flex-col">
                            <br />
                            <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">
                                DURAÇÃO ESTIMADA
                            </h5>
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
                                    <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">
                                        NÍVEL
                                    </h5>
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
                    <q-btn label="Fechar" color="dark" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
        <!-- Página Principal -->
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div
                class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
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
                    <div
                        class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
                    </div>
                </div>
                <!-- Tabela de Exibição -->
                <div class="tw-antialiased tw-font-body">
                    <div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
                        <q-table hide-bottom flat wrap-cells :rows="filteredTurmas" :columns="columns" :visible-columns="visibleColumns"
                            :pagination="initialPagination" row-key="id" no-data-label="Não há informações cadastradas."
                            no-results-label="Não foi possível localizar informações com o filtro inserido."
                            :selected="rowsSelected" rows-per-page-label="Registros por página"
                            v-model:pagination="initialPagination"
                            :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
                            :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'">
                            <template v-slot:header="props">
                            </template>
                            <template v-slot:body="props">
                                <q-tr :props="props" no-hover
                                    class="roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-transition-colors">
                                    <q-td v-for="col in props.cols" :key="col.name" :props="props">
                                        <div class="tw-font-body tw-text-gray-800 tw-text-base">
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
        <!-- Fim de Turmas em Editais -->
    </div>
</template>
<script setup>
import { evaCloseCircleOutline } from '@quasar/extras/eva-icons';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TurmaInEdital from '@/Components/Selecao/TurmaInEdital.vue'
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { evaArrowBackOutline } from '@quasar/extras/eva-icons';
import { Notify } from 'quasar';
import { onMounted } from 'vue';
import { ref, computed, watch } from 'vue';


const props = defineProps({
    turmas: {
        type: Array,
        default: []
    },
    edital_id: {
        type: String,
        default: ''
    },
})

const initialPagination = ref({ sortBy: 'desc', descending: false, page: 1, rowsPerPage: 10, });
const filtersModal = ref(false);
const busca = ref('');
const rowsSelected = ref([]);
const dateFormatOptions = { year: 'numeric', month: 'numeric', day: 'numeric' };
const columns = [
    { name: 'turma', field: 'nome', label: 'TURMA', align: 'left', sortable: true, },
];

function reaproveitar(turma) {
    const formR = useForm({
        id: turma.id, // Use turma.id to access the 'id' property
        nome: turma.nome,
        categoria: turma.categoria,
        turno: turma.turno,
        modalidade: turma.modalidade,
        dias_semana: turma.dias_semana,
        nivel: turma.nivel,
        faixa_etaria: turma.faixa_etaria,
        resumo: turma.resumo,
        horas_curso: turma.horas_curso,
        edital_id: props.edital_id, // Access 'edital' directly here
        curso_id: turma.curso_id,
        vagas: turma.vagas,
        hora_inicio: turma.hora_inicio,
        hora_termino: turma.hora_termino,
        data_inicio: turma.data_inicio,
    });

    formR.post(route('painel.inscricoes.reuse'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: (res) => {
            formR.reset();
            Notify.create({
                message: 'Turma reutilizada com sucesso.',
                color: 'secondary',
            });
        },
        onError: (err) => {
            console.log(err);
            Notify.create({
                message: 'Não foi possível reutilizar essa turma.',
                color: 'negative',
            });
        },
    });
}

function closeModal() {
    filtersModal.value = false;
}



const visibleColumns = ['id', 'turma', 'vagas', 'status', 'actions'];

//
const filtroTipo = ref([]);
const filtroStatus = ref([]);
const filtroModalidade = ref([]);
const filtroNivel = ref([]);
const filtroTurno = ref([]);
const filtroSituacao = ref([]);
const filtroCargaHoraria = ref([]);
const filtroCursos = ref([]);
const filtroEdital = ref([]);
const filtroCategoria = ref([])
const filteredTurmas = ref(props.turmas);

//
const chipCategoria = computed(() => filtroCategoria.value.length > 0);
const chipStatus = computed(() => filtroStatus.value.length > 0);
const chipModalidade = computed(() => filtroModalidade.value.length > 0);
const chipNivel = computed(() => filtroNivel.value.length > 0);
const chipCargaHoraria = computed(() => filtroCargaHoraria.value.length > 0);
const chipTurno = computed(() => filtroTurno.value.length > 0);
const chipSituacao = computed(() => filtroSituacao.value.length > 0);
const chipEdital = computed(() => filtroEdital.value != '');
const chipCurso = computed(() => filtroCursos.value != '');

//
const opcoesNivel = ['Iniciante', 'Intermediario', 'Avançado'];
const opcoesCargaHoraria = ['40 Horas', '160 Horas', '240 Horas', '960 Horas', '1440 Horas'];
const opcoesSituacao = ['Ativo', 'Inativo'];
const opcoesModalidade = ['Cadastro de Reserva', 'EAD', 'Online', 'Presencial'];
const opcoesTurno = ['Integral', 'Matutino', 'Vespertino', 'Noturno'];
const opcoesCategoria = ['Capacitação', 'Qualificação', 'Superior', 'Técnico'];

function applyFilters() {
    let filteredTurmas = props.turmas;
    if (filtroCategoria.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroCategoria.value.includes(turma.categoria)); }
    if (filtroTipo.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroTipo.value.includes(turma.tipo)); }
    if (filtroModalidade.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroModalidade.value.includes(turma.modalidade)); }
    if (filtroNivel.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroNivel.value.includes(turma.nivel)); }
    if (filtroCargaHoraria.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroCargaHoraria.value.includes(turma.horas_curso)); }
    if (filtroTurno.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroTurno.value.includes(turma.turno)); }
    if (filtroSituacao.value.length > 0) { filteredTurmas = filteredTurmas.filter(turma => filtroSituacao.value.includes(turma.situacao)); }
    if (filtroEdital.value !== '') { filteredTurmas = filteredTurmas.filter(turma => turma.edital_id === filtroEdital.value); }
    if (filtroCursos.value !== '') { filteredTurmas = filteredTurmas.filter(turma => turma.curso_id === filtroCursos.value); }
    filteredTurmas.value = filteredTurmas;
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
function removeFilterCategoria() {
    filtroCategoria.value = [];
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
    filtroCursos.value = '';
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
    filtroCursos.value = [];
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
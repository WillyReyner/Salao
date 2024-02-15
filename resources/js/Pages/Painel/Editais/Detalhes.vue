<template>
	<Head title="Editais" />

	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
				<div
					class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">
						Alterar Edital
					</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						INFORMAÇÕES BÁSICAS
					</p>
				</div>
				<!-- Linha 01 -->
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_publicacao" value="Data de Publicação" required />
						<q-input 
							disable 
							id="dt_publicacao" 
							type="date" 
							required
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="form.dt_publicacao" />
						<InputError class="tw-mt-2" :message="form.errors.dt_publicacao" />
						<div disabled class="tw-flex tw-flex-auto tw-flex-col tw-mt-4">
							<!-- Campo "Destaque" abaixo dos campos anteriores -->
							<InputLabel for="agendar_publicacao" value="Agendar Publicação" required />
							<div class="tw-flex tw-flex-row">
								<!-- Adicione esta div para alinhar os radio buttons lado a lado -->
								<q-radio v-model="form.agendar_publicacao" val="Sim" label="Sim" />
								<q-radio v-model="form.agendar_publicacao" val="Nao" label="Não" />
							</div>
							<InputError class="tw-mt-2" :message="form.errors.agendar_publicacao" />
						</div>
					</div>
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_fim_edital" value="Fim do Edital" required />
						<q-input 
							disable 
							id="dt_fim_edital" 
							type="date" 
							required 
							autofocus 
							autocomplete="dt_fim_edital"
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="form.dt_fim_edital" />
						<InputError class="tw-mt-2" :message="form.errors.dt_fim_edital" />
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="numero_edital" value="Numero do Edital" required />
                        <q-input 
							disable 
							placeholder="Digite o Numero do Edital" 
							v-model="form.numero_edital"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                        <InputError class="tw-mt-2" :message="form.errors.numero_edital" />
                    </div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="situacao" value="Status" required />
						<q-select
							id="situacao"
							disable 
							map-options 
							emit-value 
							v-model="form.situacao" 
							:options="opcoesStatus"
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-select>
						<InputError class="tw-mt-2" :message="form.errors.situacao" />
					</div>
				</div>
				<!-- Linha 02 -->
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_inicio_inscricao" value="Início da Inscrição" required />
						<q-input 
							disable 
							id="dt_inicio_inscricao" 
							type="date" 
							required 
							autofocus
							autocomplete="dt_inicio_inscricao"
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="form.dt_inicio_inscricao" />
						<InputError class="tw-mt-2" :message="form.errors.dt_inicio_inscricao" />
					</div>
					<div class="tw-flex tw-flex-col">
						<InputLabel for="dt_fim_inscricao" value="Término da Inscrição" required />
						<q-input 
							disable 
							id="dt_fim_inscricao" 
							type="date" 
							required 
							autofocus
							autocomplete="dt_fim_inscricao"
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="form.dt_fim_inscricao" />
						<InputError class="tw-mt-2" :message="form.errors.dt_fim_inscricao" />
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="escola_id" value="Escolas" required />
						<q-select
						map-options emit-value 
							id="escola_id"
							disable
							v-model="form.escola_id" 
							:options="opcoesEscola"
							class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" 
							@update:modelValue="updateMunicipioBasedOnEscola" />
						<InputError class="tw-mt-2" :message="form.errors.escola_id" />
						<div disabled class="tw-flex tw-flex-auto tw-flex-col tw-mt-4">
							<!-- Campo "Destaque" abaixo dos campos anteriores -->
							<InputLabel 
							for="udepi" value="UDEPI?" required />
							<div class="tw-flex tw-flex-row">
								<!-- Adicione esta div para alinhar os radio buttons lado a lado -->
								<q-radio v-model="form.udepi" val="Sim" label="Sim" @update:modelValue="enableUdepiField('Sim')" />
  								<q-radio v-model="form.udepi" val="Nao" label="Não" @update:modelValue="enableUdepiField('Nao')" />
							</div>
							<InputError class="tw-mt-2" :message="form.errors.destaque" />
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="municipio_id" value="Municipios" required />
                        <q-select 
							id="municipio_id" 
							disable 
							map-options emit-value 
							v-model="form.municipio_id"
                            :options="opcoesMunicipio" placeholder="Selecione a Escola primeiro"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" :readonly="form.udepi === 'Nao' || form.udepi === ''"/>
                        <InputError class="tw-mt-2" :message="form.errors.municipio_id" />
                    </div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						DOCUMENTAÇÃO EXIGIDA
					</p>
				</div>
				<div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
					<InputLabel for="documentos_inscricao" value="Documentação Exigida" required />
					<q-select
						use-chips
						multiple
						disable
						map-options
						emit-value
						v-model="form.documentos_inscricao"
						:options="opcoesDocumentos"
						class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"/>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						ANEXAR ARQUIVOS
					</p>
				</div>
				<DocumentInEdital disabled :edital_id="props.edital.id" :documentos="props.documentos"/>
				<div	class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
                        VINCULE AS TURMAS DO EDITAL
                    </p>
                    <div disabled
                        class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items">
                        <a :href="route('painel.turmas.create')" target="_blank">
                            <PrimaryButton class="tw-text-white tw-bg-green-500 tw-items-center">
                                <Icon icon="icon-park-outline:add"
                                    class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
                                ADICIONAR TURMA
                            </PrimaryButton>
                        </a>
                    </div>
                </div>
				<TurmaInEdital disabled :edital_id="props.edital.id" :turmas="props.turmas"/>
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.editais')"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
					CANCELAR
					</Link>
					<Link :href="route('painel.editais.editar', props.edital.id)"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
					Editar
					</Link>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>

<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TurmaInEdital from '@/Components/Selecao/TurmaInEdital.vue'
import DocumentInEdital from '@/Components/Selecao/DocumentInEdital.vue'
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { evaArrowBackOutline } from '@quasar/extras/eva-icons';
import { Notify } from 'quasar';
import { onMounted } from 'vue';
import { ref, computed, watch } from 'vue';

const props = defineProps({
	edital: {
		type: Object,
		default: {},
	},
	escolas: {
		type: Array,
		default: [],
	},
	tiposArquivo: {
		type: Array,
		default: [],
	},
	municipios: {
		type: Array,
		default: '',
	},
	turmas: {
		type: Array,
		default: '',
	},
	documentos: {
		type: Array,
		default: '',
	},
	documentacao_inscricao: {
        type: Array,
        default: [],
    }
});

const agendar_publicacao = ref('');
const udepi = ref('');
const selectedCourseId = ref(null);
const municipioId = ref(null);

const opcoesEscola = props.escolas.map(escola => ({label: escola.nome, value: escola.id}))
const opcoesMunicipio = props.municipios.map(municipio => ({label: municipio.nome, value: municipio.id}))

const opcoesStatus = [	'Ativo', 'Inativo','Bloqueado'	];

const opcoesDocumentos = props.documentacao_inscricao.map(documentacoes_exigidas => ({ label: documentacoes_exigidas.nome, value: documentacoes_exigidas.id }))

const form = useForm({
  id: props.edital.id,
  dt_publicacao: props.edital.dt_publicacao ? props.edital.dt_publicacao.split(' ')[0] : '', 
  dt_fim_edital: props.edital.dt_fim_edital ? props.edital.dt_fim_edital.split(' ')[0] : '',
  numero_edital: props.edital.numero_edital,
  escola_id: props.edital.escola_id,
  documentos_inscricao: [props.edital.documentos_inscricao],
  agendar_publicacao: props.edital.agendar_publicacao,
  dt_inicio_inscricao: props.edital.dt_inicio_inscricao ? props.edital.dt_inicio_inscricao.split(' ')[0] : '', 
  dt_fim_inscricao: props.edital.dt_fim_inscricao ? props.edital.dt_fim_inscricao.split(' ')[0] : '', 
  situacao: props.edital.situacao,
  municipio_id: props.edital.municipio_id,
  udepi: props.edital.udepi,
});

function update() {
	router.post(
		route('painel.editais.update', form.id),
		{
			_method: 'patch',
			...form,
		},
		{
			preserveScroll: true,
			forceFormData: true,
			onSuccess: (res) => {
				form.reset();
				Notify.create({
					message: 'Dados do edital atualizados com sucesso.',
					color: 'secondary',
				});
			},
			onError: (err) => {
				Notify.create({
					message: 'Não foi possível atualizar os dados do edital.',
					color: 'negative',
				});
			},
		}
	);
}

const filtersModal = ref(false);

const busca = ref('');
const initialPagination = ref({
	sortBy: 'desc',
	descending: false,
	page: 1,
	rowsPerPage: 10,
});

const rowsSelected = ref([]);

const dateFormatOptions = {
	year: 'numeric',
	month: 'numeric',
	day: 'numeric',
};

function closeModal() {
	filtersModal.value = false;
}

const columns = [
	{
		name: 'id',
		field: 'id',
		label: 'ID',
		required: true,
		align: 'left',
		sortable: true,
	},
	//format: val => `${val.id} EDITAL - ${val.nome}`
	{
		name: 'turma',
		field: 'nome',
		label: 'TURMA',
		align: 'left',
		sortable: true,
	},
	{
		name: 'vagas',
		field: 'vagas',
		label: 'VAGAS',
		align: 'left',
		sortable: true,
	},
	{
		name: 'status',
		field: 'situacao',
		label: 'STATUS',
		align: 'left',
		sortable: true,
	},
	{ name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
];

const visibleColumns = ['id', 'turma', 'vagas', 'status', 'actions'];

//
const filtroTipo = ref([]);
const filtroStatus = ref([]);
const filtroModalidade = ref([]);
const filtroNivel = ref([]);
const filtroTurno = ref([]);
const filtroSituacao = ref([]);
const filtroCargaHoraria = ref([]);
const filtroCurso = ref([]);
const filtroEdital = ref([]);
const filteredTurmas = ref(props.turmas);
const filteredDocumentos = ref(props.documentos);

//
const chipCategoria = computed(() => filtroTipo.value.length > 0);
const chipStatus = computed(() => filtroStatus.value.length > 0);
const chipModalidade = computed(() => filtroModalidade.value.length > 0);
const chipNivel = computed(() => filtroNivel.value.length > 0);
const chipCargaHoraria = computed(() => filtroCargaHoraria.value.length > 0);
const chipTurno = computed(() => filtroTurno.value.length > 0);
const chipSituacao = computed(() => filtroSituacao.value.length > 0);
const chipEdital = computed(() => filtroEdital.value != '');
const chipCurso = computed(() => filtroCurso.value != '');

//
const opcoesNivel = ['Iniciante', 'Intermediario', 'Avançado'];
const opcoesCargaHoraria = [
	'40 Horas',
	'160 Horas',
	'240 Horas',
	'960 Horas',
	'1440 Horas',
];
const opcoesSituacao = ['Ativo', 'Inativo'];
const opcoesModalidade = ['Cadastro de Reserva', 'EAD', 'Online', 'Presencial'];
const opcoesTurno = ['Integral', 'Matutino', 'Vespertino', 'Noturno'];
const opcoesCategoria = ['Capacitação', 'Qualificação', 'Superior', 'Técnico'];

function applyFilters() {
	const filtradoCategoria =
		filtroCategoria.value.length > 0
			? props.turmas.filter((turma) => filtroCategoria.value.includes(turma.categoria))
			: props.turmas;
	const filtradoTipo =
		filtroTipo.value.length > 0
			? props.turmas.filter((turma) => filtroTipo.value.includes(turma.tipo))
			: props.turmas;
	const filtradoModalidade =
		filtroModalidade.value.length > 0
			? filtradoEscola.filter((turma) =>
				filtroModalidade.value.includes(turma.modalidade)
			)
			: filtradoEscola;
	const filtradoNivel =
		filtroNivel.value.length > 0
			? filtradoNivel.filter((turma) => filtroNivel.value.includes(turma.nivel))
			: filtradoNivel;
	const filtradoCargaHoraria =
		filtroCargaHoraria.value.length > 0
			? filtradoCargaHoraria.filter((turma) =>
				filtroCargaHoraria.value.includes(turma.horas_curso)
			)
			: filtradoCargaHoraria;
	const filtradoTurno =
		filtroTurno.value.length > 0
			? filtradoModalidade.filter((turma) => filtroTurno.value.includes(turma.turno))
			: filtradoModalidade;
	const filtradoSituacao =
		filtroSituacao.value.length > 0
			? filtradoTurno.filter((turma) => filtroSituacao.value.includes(edital.situacao))
			: filtradoTurno;
	const filtradoEdital =
		filtroEdital.value != ''
			? filtradoSituacao.filter((turma) => turma.edital_id == filtroEdital)
			: filtradoSituacao;
	const filtradoCurso =
		filtroCurso.value != ''
			? filtradoSituacao.filter((turma) => turma.curso_id == filtroCurso)
			: filtradoSituacao;
	const filtradoStatus =
		filtroStatus.value != ''
			? filtradoStatus.filter((turma) => turma.edital_id == filtroEdital)
			: filtradoStatus;

	filteredTurmas.value = filtradoEdital;
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
	filtroCurso.value = '';
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
	filtroCurso.value = [];
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

watch(
  () => form.udepi,
  (newValue) => {
    if (newValue !== 'Sim') {
      form.municipio_id = props.edital.municipio_id;
    }
  }
);

watch(
    () => [form.dt_publicacao, form.dt_fim_edital],
    ([publicacao, fimEdital]) => {
        const currentDate = new Date();
        const editalStartDate = new Date(publicacao);
        const editalEndDate = new Date(fimEdital);

        // Verifique se a data atual está entre dt_publicacao e dt_fim_edital
        if (editalStartDate <= currentDate && currentDate <= editalEndDate) {
            form.situacao = 'Ativo';
        } else {
            form.situacao = 'Inativo';
        }
    }
);

// Função para atualizar o campo "Município" com base na seleção da "Escola"
function updateMunicipioBasedOnEscola() {
  // Verifica se foi selecionada uma escola
  if (form.escola_id !== null) {
    // Atribui o valor do município da escola selecionada ao campo "Município"
    form.municipio_id = props.escolas.find((escola) => escola.id === form.escola_id)?.municipio_id;
  } else {
    // Se nenhuma escola foi selecionada, defina o campo "Município" como nulo
    form.municipio_id = null;
  }
}

function enableUdepiField(value) {
  if (value === 'Sim') {
    // Quando "Sim" é selecionado, salve o valor atual de municipio_id
    municipioId.value = form.municipio_id;
  } else if (value === 'Nao') {
    // Quando "Não" é selecionado, restaure o valor de municipio_id
    form.municipio_id = municipioId.value;
  }
}
</script>

<template>
  <Head title="Sistema de Seleção" />
  <SelecaoLayout>
     <!-- Modal de Filtros --> 
      <div class="tw-flex tw-flex-1 tw-flex-col tw-gap-6 tw-text-center tw-justify-center ">
        <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5"/>
        <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">
          Inscrição realizada com sucesso!
        </h5>
        <h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-6 tw-mb-4">
          Email Confirmado com Sucesso. Obrigado!
        </h6>
        <Link :href="route('portal.index')"  class="tw-px-14 tw-inline tw-self-center tw-py-2 tw-rounded-xl tw-font-title tw-text-base tw-text-center tw-uppercase hover:tw-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-primary focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-border-2 tw-border-primary">Voltar ao Site</Link>
      </div>
  </SelecaoLayout>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import SelecaoLayout from '@/Layouts/SelecaoLayout.vue';
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import { ref } from "vue";
import Card from "@/Components/Selecao/Card.vue";
import { Icon } from "@iconify/vue";
import { computed } from "vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Notify} from 'quasar';
import axios from 'axios';

const props = defineProps({
    escolas: {
        type: Array,
        default: [],
    },
    turmas: {
        type: Array,
        default: [],
    },
})


const estagios = [
  {titulo: '', subtitulo: ''}, //Home
  {titulo: 'Selecione a modalidade de ensino que mais se adequa a sua necessidade', subtitulo: 'Modalidade'},
  {titulo: 'Selecione o local que deseja estudar', subtitulo: 'Local'}, 
  {titulo: 'Selecione o curso que deseja estudar', subtitulo: 'Cursos'},
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Pessoais'}, 
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Endereço'}, 
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Escolares'}, 
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Sociais'}, 
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Como conheceu a EFG'}, 
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Comprovantes'}, 
  {titulo: 'Formulário de Inscrição ', subtitulo: 'Antes de finalizar sua inscrição, confira seus dados até o final.'}, 
]

const filtersModal = ref(false)
const deleteModal = ref(false)
const estagio = ref(0)
const busca = ref('')
const initialPagination = ref({
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10
})
const rowsSelectedLocal = ref([])
const rowsSelectedCursos = ref([])
// Local
const filtroLocal = ref('')
const filteredEscolas = ref(props.escolas)
// Cursos
const filtroCurso = ref('')
const filtroTipo = ref([])
const filtroEscola = ref([])
const filtroModalidade = ref([])
const filtroTurno = ref([])
const filteredTurmas = ref(props.turmas)

const chipTipo = computed(() => filtroTipo.value.length > 0)
const chipEscola = computed(() => filtroEscola.value.length > 0)
const chipModalidade = computed(() => filtroModalidade.value.length > 0)
const chipTurno = computed(() => filtroTurno.value.length > 0)
// Social
const possuiDeficiencia = ref('Não')
const possuiBeneficio = ref('Não')

const dateFormatOptions = {
    year: "numeric", month: "numeric", day: "numeric" 
}

function closeModal(){
    filtersModal.value = false
}

const modalidadesSelected = ref([])

const estados = [
  'AC - Acre',
  'AL - Alagoas',
  'AP - Amapá',
  'AM - Amazonas',
  'BA - Bahia',
  'CE - Ceará',
  'DF - Distrito Federal',
  'ES - Espírito Santo',
  'GO - Goías',
  'MA - Maranhão',
  'MT - Mato Grosso',
  'MS - Mato Grosso do Sul',
  'MG - Minas Gerais',
  'PA - Pará',
  'PB - Paraíba',
  'PR - Paraná',
  'PE - Pernambuco',
  'PI - Piauí',
  'RJ - Rio de Janeiro',
  'RN - Rio Grande do Norte',
  'RS - Rio Grande do Sul',
  'RO - Rondônia',
  'RR - Roraíma',
  'SC - Santa Catarina',
  'SP - São Paulo',
  'SE - Sergipe',
  'TO - Tocantins'
];

const niveisEscolaridade = [
  'Fundamental Incompleto',
  'Fundamental Completo',
  'Médio Incompleto',
  'Médio Completo',
  'Superior Incompleto',
  'Superior Completo',
]

const tipoOrigemEscolar = [
  'Ensino Público',
  'Ensino Privado'
]

const tiposRaca = [
  'Branca (Descendentes de europeus/ocidentais)',
  'Preta (Descendentes de africanos/afro-brasileiros)',
  'Parda (Descendentes de indivíduos de cor/etnias diferentes-miscigenação mestiçagem)',
  'Cor Amarela (Descendentes de asiáticos/orientais)',
  'Indígena (Descendentes de índios)',
]

const tiposConheceu = [
  'Instagram',
  'Facebook',
  'Mutirão do Governo de Goiás',
  'Indicação de conhecidos',
  'Carro de som',
  'Rádio',
  'Whatsapp',
  'Google / site da Escola',
  'YouTube',
  'Visita na sua escola',
  'Panfleto',
  'Viu uma Escola do Futuro',
  'Jornais / notícias',
]

const opcoesTipo = ['Capacitação', 'Qualificação', 'Técnico']
const opcoesTurno = ['EAD', 'Integral', 'Matutino', 'Vespertino', 'Noturno']
const opcoesModalidade = ['MOOC', 'EAD', 'Online', 'Presencial'];
const opcoesSituacao = ['Ativo', 'Inativo'];

const columnLocal = [
    { name: 'id', field: 'id', label: 'ID'},
    { name: 'municipio', align: 'left', label: 'MUNICÍPIO', field: 'municipio', format: item => item.nome, sortable: true },
    { name: 'nome', align: 'left', label: 'EFG/UDEPI', field: 'nome', sortable: true },
    { name: 'turmas', align: 'left', label: 'CURSOS DISPONÍVEIS', align: 'center',field: 'turmas', format: item => item.length, sortable: true },
    { name: 'actions', label: '', align: 'center', field: 'id'},
]

const visibleColumnsLocal = [
   'municipio', 'nome', 'turmas', 'actions'
]

const columnCurso = [
    { name: 'id', field: 'id', label: 'ID' },
    { name: 'curso', align: 'left', label: 'CURSO', field: 'curso', format: item => item.nome, sortable: true },
    { name: 'escola', align: 'left', label: 'ESCOLA', field: 'edital', format: item => item.escola.nome, sortable: true },
    { name: 'tipo', align: 'left', label: 'CATEGORIA', field: 'tipo', sortable: true },
    { name: 'modalidade', align: 'left', label: 'MODALIDADE', field: 'modalidade', sortable: true },
    { name: 'turno', align: 'left', label: 'TURNO', field: 'turno', sortable: true },
    { name: 'vagas', align: 'center', label: 'VAGAS', field: 'vagas', sortable: true },
    { name: 'edital', align: 'left', label: 'EDITAL', field: 'edital', format: item => item.documentos[0], sortable: true },
]

const visibleColumnsCurso = [
   'curso', 'escola', 'tipo', 'modalidade', 'turno', 'vagas', 'edital'
]

function avancar(){
  estagio.value = estagio.value+1
}
function voltar(){
  estagio.value = estagio.value-1
}

function toogleModalidade(mod){
  if(modalidadesSelected.value.includes(mod))
    modalidadesSelected.value = modalidadesSelected.value.filter(m => m != mod)
  else
    modalidadesSelected.value.push(mod.toLowerCase())

  applyModalidadeFilter() 
}
function modalidadeSelecionada(modalidade) {
  return modalidadesSelected.value.includes(modalidade.toLowerCase())
}



function applyModalidadeFilter() {
  filteredEscolas.value = modalidadesSelected.value.length > 0 ? 
    props.escolas.filter(escola => 
      escola.turmas.filter(turma => modalidadeSelecionada(turma.modalidade)).length > 0
    ) : props.escolas
}

function applyCursoFilter() {
  const filtradoTipo = filtroTipo.value.length > 0 ? props.turmas.filter(turma => filtroTipo.value.includes(turma.tipo)) : props.turmas
  const filtradoEscola = filtroEscola.value.length > 0 ? filtradoTipo.filter(turma => filtroEscola.value.includes(turma.edital.escola.nome)) : filtradoTipo
  const filtradoTurno = filtroTurno.value.length > 0 ? filtradoModalidade.filter(turma => filtroTurno.value.includes(turma.turno)) : filtradoModalidade
  filteredTurmas.value = filtradoTurno
  filtersModal.value = false
}

function removeFilterTipo(){
    filtroTipo.value = []
    applyCursoFilter()
}
function removeFilterEscola(){
    filtroEscola.value = []
    applyCursoFilter()
}
function removeFilterModalidade(){
    filtroModalidade.value = []
    applyCursoFilter()
}
function removeFilterTurno(){
    filtroTurno.value = []
    applyCursoFilter()
}
function clearFilters(){
    filtroEscola.value = []
    filtroTipo.value = []
    filtroModalidade.value = []
    filtroTurno.value = []
    filtroCurso.value = ''
}

const form = useForm({
    nome_completo: '',
    cpf: '',
    data_nascimento: '',
    nome_mae: '',
    telefone: '',
    telefone_alternativo: '',
    data_nascimento: '',
    email: '',
    email_confirmation: '', 
    cep: '',
    estado: '',
    municipio: '',
    bairro: '',
    logradouro: '',
    numero: '',
    complemento: '',
    escolaridade: '',
    origem_escolar: '',
    raca: '',
    programa_social: '',
    outro_programa_social: '',
    nis_pis: '',
    deficiencia: '',
    outra_deficiencia: '',
    como_conheceu: '',
    outro_como_conheceu: '',
    arquivos: [],
    rede: 'EFG',
    turma_id: ''
});


function handleCursoSelecionado() {
  
  form.arquivos = rowsSelectedCursos.value[0] ? rowsSelectedCursos.value[0].edital.documentos_exigidos.map(doc => ({
    nome: doc.nome,
    arquivo: [],
    tipo_arquivo_id: doc.id,
  })) : []
}

function store(){

    form.turma_id = rowsSelectedCursos.value[0].id

    form.post(route('selecao.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Inscrição realizada com sucesso.",
                color: "secondary"
            })
            estagio.value = 11
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível realizar a sua inscrição. Verifique suas informações",
                color: "negative"
            })
            estagio.value = 4
        }
    })

}

async function buscarEnderecoPorCEP() {
  const cep = form.cep.replace(/\D/g, ''); // Remove caracteres não numéricos do CEP

  if (cep.length === 8) {
    try {
      const response = await axios.get(`https://viacep.com.br/ws/${cep}/json/`);
      const data = response.data;

      if (!data.erro) {
        form.estado = data.uf;
        form.municipio = data.localidade;
        form.bairro = data.bairro;
        form.logradouro = data.logradouro;
        form.numero = ''; 
        form.complemento = ''; 
      } else {
        console.error('CEP não encontrado ou inválido.');
      }
    } catch (error) {
      console.error('Erro ao buscar o CEP:', error);
    }
  }
}
</script>
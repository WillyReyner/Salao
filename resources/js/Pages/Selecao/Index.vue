<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import SelecaoLayout from '@/Layouts/SelecaoLayout.vue';
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import {ref} from "vue";
import Card from "@/Components/Selecao/Card.vue";
import {Icon} from "@iconify/vue";
import {computed} from "vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import {evaCloseCircleOutline} from "@quasar/extras/eva-icons"
import {Notify} from 'quasar';
import axios from 'axios';

const props = defineProps({
	escolas: {
		type: Array,
		default: [],
	},
	municipios: {
		type: Array,
		default: []
	},
})

const estagios = [
	{titulo: '', subtitulo: ''}, //Home
	{titulo: 'Selecione o local que deseja estudar', subtitulo: 'ONDE VOCÊ QUER ESTUDAR?'},
	{titulo: 'Selecione o curso de seu interesse', subtitulo: 'CURSOS'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Pessoais'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Endereço'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Antes de finalizar sua inscrição, confira seus dados até o final.'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Obrigado.'},

]

const filtersModal = ref(false)
const deleteModal = ref(false)
const openPresencial = ref(false)
const secondDialog = ref(false)
const estagio = ref(0)

// Cursos
const filtroTipo = ref([])
const filtroModalidade = ref([])
const filtroTurno = ref([])

function closeModal() {
	filtersModal.value = false
}

function irDadosPessoais(estagioId) {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagioId
	}, 500); // 3000 milissegundos = 3 segundos
}

function avancar() {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagio.value + 1
	}, 500); // 3000 milissegundos = 3 segundos

}

function voltar() {
	estagio.value = estagio.value - 1
}

//Passo1
const localSelected = ref('');
const escolaSelected = ref('')
const curso = ref([])
const habilitacao_item = ref('')

function localSelecionado(modalidade) {
	return localSelected.value === modalidade;
}

function toogleLocal(mod, mod1) {
	localSelected.value = mod;
}

function selecionarLocal() {
	axios.post(route('inscricao.estagio_1'), {localSelected: localSelected.value})
		 .then((res) => {
			 curso.value = res.data.curso;
			 estagio.value += 1;
		 })
		 .catch((err) => {
			 Notify.create({
				 message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
				 color: "negative"
			 });
			 estagio.value = 1;
		 });
}

const filtroLocal = ref('')

const passaFiltroLocal = (nomeCurso) => {
	const lowerCaseFiltro = filtroLocal.value.toLowerCase();
	return lowerCaseFiltro === '' || nomeCurso.toLowerCase().includes(lowerCaseFiltro);
};

//Passo2
const open = ref('');
const filtroCurso = ref('')
const optionsDoc = ['CPF', 'RG', 'CNH', 'Passaporte (pass.te)']

const passaFiltroCurso = (nomeCurso) => {
	const lowerCaseFiltro = filtroCurso.value.toLowerCase();
	return lowerCaseFiltro === '' || nomeCurso.toLowerCase().includes(lowerCaseFiltro);
};

const masks = {
	CPF: '###.###.###-##',
	RG: '##.###.###-#',
	CNH: '############',
};

const getMaskForTipoDoc = (tipoDoc) => {
	return masks[tipoDoc] || '';
};

const cursoSelected = ref('')

function openItem(item) {
	if (open.value == item) {
		open.value = null;
	} else {
		open.value = item;
	}
}

//
const formattedDate = (dateString) => {
	const options = {
		day: "2-digit",
		month: "2-digit",
		year: "numeric",
		hour: "2-digit",
		minute: "2-digit",
	};
	const date = new Date(dateString);
	return date.toLocaleDateString("pt-BR", options);
};

//Passo4
const lgpd = ref(false)
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

const form = useForm({
	nome_completo: '',
	cpf: '',
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
	turma_id: '',
	tipo_documento: '',
	documento: '',
	lgpd: '',
	habilitacao_item: []
});

function store() {

	form.turma_id = cursoSelected;
	form.post(route('inscricao.store'), {
		preserveScroll: true,
		forceFormData: true,
		onSuccess: (res) => {
			form.reset();
			Notify.create({
				message: "Inscrição realizada com sucesso.",
				color: "secondary"
			});
			estagio.value = 6;
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
				color: "negative"
			});
			estagio.value = 9; // Redireciona de volta à etapa 9 em caso de erro
		}
	});
}

const validateEmail = (email) => {
	const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	return emailRegex.test(email);
};
const validateEmailFields = () => {
	const isEmailValid = validateEmail(form.email);
	const isConfirmationValid = validateEmail(form.email_confirmation);
	if (!isEmailValid) {
		form.errors.email = 'Por favor, insira um e-mail válido.';
	} else {
		form.errors.email = '';
	}
	if (!isConfirmationValid) {
		form.errors.email_confirmation = 'Por favor, insira um e-mail de confirmação válido.';
	} else {
		form.errors.email_confirmation = '';
	}
};

async function buscarEnderecoPorCEP() {
	const cep = form.cep.replace(/\D/g, '')
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

function isCPF(cpf) {
	cpf = cpf.replace(/\D/g, '');
	if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
	var result = true;
	[9, 10].forEach(function (j) {
		var soma = 0, r;
		cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
			soma += parseInt(e) * ((j + 2) - (i + 1));
		});
		r = soma % 11;
		r = (r < 2) ? 0 : 11 - r;
		if (r != cpf.substring(j, j + 1)) result = false;
	});
	return result;
}

const cpfRules = [
	(v) => !!v || 'CPF é obrigatório',
	(v) => isCPF(v) || 'CPF inválido',
];
</script>

<template>
	<Head title="Sistema de Seleção"/>
	<SelecaoLayout>
		<q-dialog v-model="filtersModal">
			<q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
						filtro
						abaixo:
					</div>
				</q-card-section>
				<q-card-section class="q-p-none">
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4 tw-mb-4">
						<div class=" tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CATEGORIA</h5>
							<div v-for="opcao in opcoesTipo"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroTipo" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">MODALIDADE</h5>
							<div v-for="opcao in opcoesModalidade"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroModalidade" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
						<div class=" tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TURNO</h5>
							<div v-for="opcao in opcoesTurno"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroTurno" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
					</div>
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
								 @click="applyCursoFilter">
								APLICAR FILTROS
							</button>
						</div>
					</div>
				</q-card-section>
				<q-card-actions align="right">
				</q-card-actions>
			</q-card>
		</q-dialog>
		<div
			 class="tw-transition-all tw-max-w-[90vw] max-sm:tw-min-w-[80vw] tw-min-w-[40vw] tw-bg-white tw-p-10 tw-pb-4 tw-overflow-x-hidden tw-rounded-2xl">
			<div v-if="estagio == 0" class="tw-justify-center tw-flex tw-flex-col tw-items-center tw-gap-5">
				<img class="tw-h-[60px] tw-w-auto tw-mb-5" src="../../../imgs/logo-efg.svg"/>
				<h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">Olá, seja bem vindo</h5>
				<h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-5">Seu futuro começa
					aqui</h6>
				<p
					 class="lg:tw-max-w-[60vh] md:tw-max-w-[50vh] tw-text-center sm:tw-max-w-auto tw-font-subtitle tw-text-gray-900 tw-text-base tw-leading-5">
					Comece a sua jornada conosco e conquiste o seu sonho. Preencha seus dados básicos e dê o primeiro passo
					para uma
					nova etapa na sua vida.</p>
				<PrimaryButton button-class="tw-text-white tw-bg-primary" @click="avancar">VAMOS LÁ</PrimaryButton>
			</div>
			<div v-if="estagio > 0 && estagio <= 10"
			     class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-justify-around tw-transition-all">
				<div class="tw-flex tw-gap-5 tw-flex-col">
					<h4 class="tw-text-gray-800 tw-font-title tw-font-bold tw-leading-none tw-text-xl">{{
							estagios[estagio].titulo
						}}</h4>
					<div class="tw-flex tw-justify-between">
						<h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">{{
								estagios[estagio].subtitulo
							}}</h5>
						<h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">PASSO {{
								estagio
							}} DE 05
						</h5>
					</div>
					<q-slider v-model="estagio" :max="10" :min="0" class="-tw-mt-4 tw-cursor-none" color="green" dense
					          disable
					          thumb-size="0px" track-size="6px"/>
				</div>
				<div v-if="estagio == 1" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
					<div class="tw-mb-4 ">
						<input v-model="filtroLocal"
						       class="tw-border tw-border-gray-300 tw-py-2 tw-px-4 tw-rounded tw-w-full lg:tw-w-[250px]"
						       placeholder="Pesquisar Local"/>
					</div>
					<div class="tw-flex tw-flex-1 tw-max-h-full">
						<div
							 class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
							<Card v-if="passaFiltroLocal('Online')" :selected="localSelecionado('Online')"
							      icon="typcn:video-outline" title="Online" @click="() => toogleLocal('Online')"/>
							<div v-for="(item, index) in props.escolas" :key="index">
								<Card v-if="passaFiltroLocal(item.municipio.nome)"
								      :description="item.rede + ' em ' + item.nome"
								      :selected="localSelecionado(item.id)" :title="item.municipio.nome"
								      @click="() => toogleLocal(item.id, item.municipio.id)"/>
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								Voltar
							</PrimaryButton>
							<PrimaryButton v-if="localSelected !== ''"
							               button-class="tw-text-white tw-px-14 tw-self-center tw-text-center tw-bg-primary tw-h-10 tw-w-[50%] tw-items-center tw-justify-center"
							               @click="selecionarLocal">
								AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>
				<div v-if="estagio == 2" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
					<div class="tw-flex tw-gap-3">
						<h5 class="tw-text-gray-700 tw-cursor-pointer  tw-text-lg tw-font-body tw-justify-start"
						    @click="filtersModal = true">
							<Icon class="tw-h-10 tw-w-6" icon="ci:filter"/>
						</h5>
						<input v-model="filtroCurso"
						       class="tw-border tw-border-gray-300 tw-py-2 tw-px-4 tw-rounded tw-w-full lg:tw-w-[250px]"
						       placeholder="Pesquisar Local"/>
					</div>
					<div>
						<div v-if="curso.length == 0">
							<q-card
								 style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 20px;">
								<h5 class="tw-text-grey-500 tw-text-xl tw-font-normal tw-font-body">
									{{ 'Não temos Cursos disponíveis' }}
								</h5>
							</q-card>
						</div>
						<div v-else>{{ curso.length }}
							<div v-for="(item, index) in curso" :key="index">
								<q-card v-if="item && passaFiltroCurso(item.nome_curso)"
								        style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 20px;">
									<h5 class="tw-text-grey-500 tw-text-xl tw-font-normal tw-font-body">
										{{ item.nome_curso }}
									</h5>
									<div class="tw-flex tw-justify-end">
										<button @click="openItem(item)">
											<Icon v-if="openItem == !openItem" icon="ep:arrow-up"/>
											<Icon v-else icon="ep:arrow-down"/>
										</button>
									</div>
									<Transition name="fade">
										<div v-if="open == item">
											<p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-3">Local</p>
											{{ item.turmas.map(turma => turma.turma_teste.edital.escola.nome)[0] }}
											<div v-for="(item, index) in item.turmas" :key="index">
												<q-card
													 style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 10px;">
													<q-card-section class="tw-bg-gray-100">
														<q-radio v-model="cursoSelected" :val="item.turma_teste.id"
														         checked-icon="task_alt"
														         unchecked-icon="panorama_fish_eye">
															{{ item.turma_teste.nome }}
														</q-radio>
													</q-card-section>
													<q-card-section v-if="item.turma_teste.habilitacao == '1'"
													                class="tw-bg-gray-100">
														<p class="tw-text-lg tw-text-gray-900">Este curso requer Habilitações</p>
														<div class="tw-flex tw-justify-end">
															<button @click="openPresencial = !openPresencial">
																<Icon v-if="!openPresencial" icon="ep:arrow-down"/>
																<Icon v-if="openPresencial" icon="ep:arrow-up"/>
															</button>
														</div>
														<div v-if="openPresencial">
															<p class="tw-text-lg tw-text-gray-600 tw-font-thin tw-leading-3">Selecione
																as Habilitações:</p>
															<div class="tw-grid tw-grid-cols-6">
																<div v-for="(item, index) in item.turma_teste.tipo_arquivos_habilitacao"
																     :key="index" class="tw-col-span-2">
																	<q-radio v-model:model-value="form.habilitacao_item"
																	         :val="item.habilitacao_id"
																	         checked-icon="task_alt"
																	         class="tw-block" unchecked-icon="panorama_fish_eye"/>
																	{{ item.habilitacao.nome }}
																</div>
															</div>
														</div>
													</q-card-section>
												</q-card>
											</div>
										</div>
									</Transition>
								</q-card>
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								Voltar
							</PrimaryButton>
							<!-- {{ curso['ATENDENTE DE FARMÁCIA E DROGARIA'].turmas.map(item => item.turma_teste.habilitacao) }} -->
							<PrimaryButton v-if="cursoSelected !== ''"
							               button-class="tw-text-white tw-flex tw-bg-primary tw-h-10"
							               @click="avancar">
								AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>
				<div v-if="estagio == 3" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
					<div class="tw-flex tw-flex-col">
						<p class="tw-text-xs tw-text-gray-600 tw-font-thin tw-leading-3">Os campos com <span
							 class="tw-text-red-500">*</span> são obrigatórios.
						</p>
						<div class="tw-flex tw-flex-1 tw-items-start tw-flex-col lg:tw-flex-row">
							<InputLabel for="documento" required value="Documento"/>
							<div class="tw-mt-1 tw-pb-3 tw-flex tw-flex-1 tw-gap-1">
								<q-select v-model="form.tipo_documento" :options="optionsDoc"
								          class="tw-h-[52px] tw-block tw-w-[30%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								          outlined/>
								<InputError :message="form.errors.tipo_documento" class="tw-mt-2"/>
								<q-input id="documento" v-model="form.documento" :error="form.errors.documento"
								         :mask="getMaskForTipoDoc(form.tipo_documento)"
								         autocomplete="documento"
								         autofocus
								         class="tw-h-[52px] tw-block tw-w-[100%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required type="text"/>
								<InputError :message="form.errors.documento" class="tw-mt-2"/>
							</div>
							<InputLabel for="nome_completo" required value="Nome Completo"/>
						</div>
						<div class="tw-mt-1 tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<q-input id="nome_completo" v-model="form.nome_completo" autocomplete="nome_completo" autofocus
							         class=" tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							         outlined
							         required
							         type="text"/>
							<InputError :message="form.errors.nome_completo" class="tw-mt-2"/>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="data_nascimento" required value="Data de Nascimento"/>
								<q-input id="data_nascimento" v-model="form.data_nascimento" autocomplete="data_nascimento"
								         autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-text-gray-600 tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="date"/>
								<InputError :message="form.errors.data_nascimento" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="nome_mae" required value="Nome da Mãe"/>
								<q-input id="nome_mae" v-model="form.nome_mae" autocomplete="nome_mae" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.nome_mae" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="telefone" required value="Telefone"/>
								<q-input id="telefone" v-model="form.telefone" autocomplete="telefone" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         mask="(##) #####-####"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.telefone" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="telefone_alternativo" value="Telefone Alternativo"/>
								<q-input id="telefone_alternativo" v-model="form.telefone_alternativo"
								         autocomplete="telefone_alternativo" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         mask="(##) #####-####"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.telefone_alternativo" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="email" required value="E-mail"/>
								<q-input id="email" v-model="form.email" autocomplete="email" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text" @blur="validateEmailFields"/>
								<InputError :message="form.errors.email" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="email_confirmation" required value="Confirmação de E-mail"/>
								<q-input id="email_confirmation" v-model="form.email_confirmation"
								         autocomplete="email_confirmation" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text" @blur="validateEmailFields"/>
								<InputError :message="form.errors.email_confirmation" class="tw-mt-2"/>
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								VOLTAR
							</PrimaryButton>
							<PrimaryButton button-class="tw-text-white tw-flex tw-bg-primary tw-h-10" @click="avancar">AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>
				<div v-if="estagio == 4" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
					<div class="tw-flex tw-flex-col">
						<p class="tw-text-xs tw-text-gray-600 tw-font-thin tw-leading-3">Os campos com <span
							 class="tw-text-red-500">*</span> são obrigatórios.</p>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="cep" required value="CEP"/>
								<q-input id="cep" v-model="form.cep" autocomplete="cep" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-full md:tw-w-[40%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         mask="#####-###" outlined
								         required
								         type="text" @blur="buscarEnderecoPorCEP"/>
								<InputError :message="form.errors.cep" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="estado" required value="Estado"/>
								<q-select id="estado" v-model="form.estado" :options="estados"
								          class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								          outlined/>
								<InputError :message="form.errors.estado" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="municipio" required value="Municipio"/>
								<q-input id="municipio" v-model="form.municipio" autocomplete="municipio" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.municipio" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="bairro" required value="Bairro"/>
								<q-input id="bairro" v-model="form.bairro" autocomplete="bairro" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.bairro" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-span tw-flex-col">
								<InputLabel for="logradouro" required value="Logradouro"/>
								<q-input id="logradouro" v-model="form.logradouro" autocomplete="logradouro" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.logradouro" class="tw-mt-2"/>
							</div>
							<div class="tw-flex flex-1 tw-w-full lg:tw-w-[31.5%] tw-flex-col">
								<InputLabel for="numero" required value="Número"/>
								<q-input id="numero" v-model="form.numero" autocomplete="numero" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full  tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.numero" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="complemento" value="Complemento"/>
								<q-input id="complemento" v-model="form.complemento" autocomplete="complemento" autofocus
								         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         outlined
								         required
								         type="text"/>
								<InputError :message="form.errors.complemento" class="tw-mt-2"/>
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								VOLTAR
							</PrimaryButton>
							<PrimaryButton button-class="tw-text-white tw-flex tw-bg-primary tw-h-10" @click="avancar">AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>
				<div v-if="estagio == 5" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
					<div class="tw-flex tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded " style="overflow-y: auto;">
						<div class="tw-flex">
							<p class="tw-grid tw-grid-cols-8 tw-gap-7 tw-text-ls tw-font-bold tw-text-gray-600">DADOS
								PESSOAIS</p>
							<div class="tw-flex">
								<Icon class="tw-text-green-700" height="30" icon="basil:edit-outline" value="EDITAR"
								      width="30" @click="irDadosPessoais(4)"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-items-start tw-flex-col lg:tw-flex-row">
							<InputLabel for="documento" required value="Documento"/>
							<div class="tw-pb-3 tw-flex tw-flex-1 tw-gap-1">
								<q-select v-model="form.tipo_documento" :options="optionsDoc"
								          class="tw-h-[52px] tw-block tw-w-[30%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								          disable/>
								<InputError :message="form.errors.tipo_documento" class="tw-mt-2"/>

								<q-input id="cpf" v-model="form.documento" :error="form.errors.cpf" :rules="cpfRules"
								         autocomplete="cpf" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable mask="###.###.###-##" type="text"/>
								<InputError :message="form.errors.documento" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="nome_completo" value="Nome Completo"/>
								<q-input id="nome_completo" v-model="form.nome_completo" autocomplete="nome_completo" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.nome_completo" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="data_nascimento" value="Data de Nascimento"/>
								<q-input id="data_nascimento" v-model="form.data_nascimento" autocomplete="data_nascimento"
								         autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-text-gray-600 tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="date"/>
								<InputError :message="form.errors.data_nascimento" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="nome_mae" value="Nome da Mãe"/>
								<q-input id="nome_mae" v-model="form.nome_mae" autocomplete="nome_mae" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.nome_mae" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="telefone" value="Telefone"/>
								<q-input id="telefone" v-model="form.telefone" autocomplete="telefone" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         mask="(##) #####-####"
								         type="text"/>
								<InputError :message="form.errors.telefone" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="telefone_alternativo" value="Telefone Alternativo"/>
								<q-input id="telefone_alternativo" v-model="form.telefone_alternativo"
								         autocomplete="telefone_alternativo" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         mask="(##) #####-####"
								         type="text"/>
								<InputError :message="form.errors.telefone_alternativo" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="email" value="E-mail"/>
								<q-input id="email" v-model="form.email" autocomplete="email" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         required
								         type="text" @blur="validateEmailFields"/>
								<InputError :message="form.errors.email" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="email_confirmation" value="Confirmação de E-mail"/>
								<q-input id="email_confirmation" v-model="form.email_confirmation"
								         autocomplete="email_confirmation" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text" @blur="validateEmailFields"/>
								<InputError :message="form.errors.email_confirmation" class="tw-mt-2"/>
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded">
						<p class="tw-text-ls tw-font-bold tw-text-gray-600">Endereço</p>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="cep" value="CEP"/>
								<q-input id="cep" v-model="form.cep" autocomplete="cep" autofocus
								         class="tw-h-[52px] tw-block tw-full md:tw-w-[40%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         mask="#####-###"
								         type="text" @blur="buscarEnderecoPorCEP"/>
								<InputError :message="form.errors.cep" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="estado" value="Estado"/>
								<q-select id="estado" v-model="form.estado" :options="estados"
								          class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								          disable/>
								<InputError :message="form.errors.estado" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="municipio" value="Municipio"/>
								<q-input id="municipio" v-model="form.municipio" autocomplete="municipio" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.municipio" class="tw-mt-2"/>
							</div>
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="bairro" value="Bairro"/>
								<q-input id="bairro" v-model="form.bairro" autocomplete="bairro" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.bairro" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
							<div class="tw-flex tw-flex-1 tw-span tw-flex-col">
								<InputLabel for="logradouro" value="Logradouro"/>
								<q-input id="logradouro" v-model="form.logradouro" autocomplete="logradouro" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.logradouro" class="tw-mt-2"/>
							</div>
							<div class="tw-flex flex-1 tw-w-full lg:tw-w-[31.5%] tw-flex-col">
								<InputLabel for="numero" value="Número"/>
								<q-input id="numero" v-model="form.numero" autocomplete="numero" autofocus
								         class="tw-h-[52px] tw-block tw-w-full  tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.numero" class="tw-mt-2"/>
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
							<div class="tw-flex tw-flex-1 tw-flex-col">
								<InputLabel for="complemento" value="Complemento"/>
								<q-input id="complemento" v-model="form.complemento" autocomplete="complemento" autofocus
								         class="tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
								         disable
								         type="text"/>
								<InputError :message="form.errors.complemento" class="tw-mt-2"/>
							</div>
						</div>
					</div>
					<div class="tw-grid tw-grid-cols-1 tw-gap-6 tw-bg-green-50 tw-p-4 tw-rounded">
						<q-checkbox v-model="form.lgpd"
						            class="tw-text-base"
						            color="green"
						            label="Declaro ciência de que para efetivação da matrícula, o termo de consentimento para tratamento de dados pessoais com base na LGPD será disponibilizado pela secretaria da unidade e deverá ser devidamento assinado, podendo ser revogado pelo titular, a qualquer momento mediante solicitação às controladoras. Segue abaixo para leitura o termo de consentimento para tratamento de dados pessoais com base na LGPD"/>
						<span class="tw-text-lg"></span>
						<span class="tw-text-2xl tw-text-blue-600"><a href="*" target="_blank">Visualizar Termo de
                Consentimento</a></span>
					</div>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								VOLTAR
							</PrimaryButton>
							<PrimaryButton v-if="form.lgpd === true" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10"
							               @click="store">AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>
			</div>
			<div v-if="estagio == 6" class="tw-flex tw-flex-1 tw-flex-col tw-gap-6 tw-text-center tw-justify-center ">
				<img class="tw-h-[60px] tw-w-auto tw-mb-5" src="../../../imgs/logo-efg.svg"/>
				<h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">
					Inscrição realizada com sucesso!
				</h5>
				<h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-6 tw-mb-4">
					Você receberá um e-mail de confirmação no e-mail cadastrado. Os próximos passos serão orientados
					via
					e-mail.
				</h6>
				<a class="tw-px-14 tw-inline tw-self-center tw-py-2 tw-rounded-xl tw-font-title tw-text-base tw-text-center tw-uppercase hover:tw-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-primary focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-border-2 tw-border-primary"
				   href="https://efg.org.br/">Voltar
					ao Site</a>
			</div>
		</div>
	</SelecaoLayout>
</template>

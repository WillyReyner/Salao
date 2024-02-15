<template>
	<Head title="Turmas"/>

	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				 class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">Adicionar Turma</h4>
				</div>
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-border-b-2 tw-border-gray-200">
					<p class="tw-font-semibold tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
						INFORMAÇÕES BÁSICAS DA TURMA
					</p>
				</div>
				<!-- Nome da Turma, Curso e Vagas -->
				<div class="tw-flex tw-flex-row tw-mt-8 md:tw-flex-row md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-auto tw-w-80 tw-flex-col">
						<InputLabel for="edital" required value="Vincular Edital"/>
						<q-select v-model="form.edital_id" :options="optionsEditais" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0"
						          outlined use-input
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.edital_id" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
						<InputLabel for="curso_id" required value="Vincular Curso"/>
						<q-select v-model="form.curso_id" :options="optionsCursos" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0"
						          outlined use-input
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.curso_id" class="tw-mt-2"/>
					</div>
				</div>
				<!-- Horas Curso, Nivel, Faixa Etaria -->
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="modalidade" required value="Modalidade"/>
						<q-select v-model="form.modalidade" :options="optionsModalidade" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0" outlined
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.modalidade" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="faixa_etaria" required value="Faixa Etária"/>
						<q-select v-model="form.faixa_etaria" :options="optionsFaixaEtaria" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0" outlined
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.faixa_etaria" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="vagas" required value="Vagas"/>
						<q-input id="vagas" v-model="form.vagas" autocomplete="vagas" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="number"/>
						<InputError :message="form.errors.vagas" class="tw-mt-2"/>
					</div>
				</div>
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-border-b-2 tw-border-gray-200">
					<p class="tw-font-semibold tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
						DATA E HORA
					</p>
				</div>
				<div class="tw-flex tw-flex-row tw-mt-8 md:tw-flex-row md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4">
					<div class="tw-flex tw-flex-auto tw-w-80 tw-flex-col">
						<InputLabel for="dias_semana" value="Dias da Semana"/>
						<q-select v-model="form.dias_semana" :options="optionsDiasSemana" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0"
						          multiple outlined use-chips
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="turno" required value="Turno"/>
						<q-select v-model="form.turno" :options="optionsTurno" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0" outlined
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.turno" class="tw-mt-2"/>
					</div>
					<div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
						<InputLabel for="hora_inicio" value="Hora de Início"/>
						<q-input id="hora_inicio" v-model="form.hora_inicio" autocomplete="hora_inicio" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required
						         type="time"/>
					</div>
					<div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
						<InputLabel for="hora_termino" value="Hora de Termino"/>
						<q-input id="hora_termino" v-model="form.hora_termino" autocomplete="hora_termino" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         type="time"/>
					</div>
					<div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
						<InputLabel for="data_inicio" value="Data de Inicio"/>
						<q-input id="data_inicio" v-model="form.data_inicio" autofocus emit-value map-options outlined
						         type="date"/>
					</div>
				</div>
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-border-b-2 tw-border-gray-200">
					<p class="tw-font-semibold tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
						REQUISITOS
					</p>
				</div>
				<div>
					<div class="tw-flex tw-flex-auto tw-flex-col tw-mt-2">
						<InputLabel for="aptidao" required value="Esse curso necessita de Habilitação?"/>
						<div class="tw-flex tw-flex-row">
							<q-toggle v-model="form.habilitacao" label="Sim" val="Sim"/>
						</div>
						<InputError :message="form.errors.accept" class="tw-mt-2"/>
					</div>
					<div v-if="form.habilitacao" class="tw-flex tw-flex-auto tw-flex-col tw-mt-5">
						<div class="tw-flex tw-flex-auto tw-flex-col tw-py-5">
							<InputLabel for="habilitacoes_exigidas" required value="Testes Exigidos"/>
							<q-select v-model="form.habilitacoes_exigidas" :options="optionsHabilidade" behavior="menu"
							          class="tw-mt-1 tw-h-full tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							          input-debounce="0"
							          multiple outlined use-chips use-input
							          @filter="filterFn">
								<template v-slot:no-option>
									<q-item>
										<q-item-section class="text-grey">
											No results
										</q-item-section>
									</q-item>
								</template>
							</q-select>
						</div>
					</div>
<!--					<div class="tw-flex tw-flex-auto tw-flex-col tw-mt-4">-->
<!--						<InputLabel for="aptidao" required value="Esse curso necessita de Testes de Aptidão?"/>-->
<!--						<div class="tw-flex tw-flex-row">-->
<!--							<q-toggle v-model="form.accept" label="Sim" val="Sim"/>-->
<!--						</div>-->
<!--						<InputError :message="form.errors.accept" class="tw-mt-2"/>-->
<!--					</div>-->
<!--					<div v-if="form.accept" class="tw-flex tw-flex-auto tw-flex-col tw-mt-5">-->
<!--						<div class="tw-flex tw-flex-auto tw-flex-col">-->
<!--							<InputLabel for="local_teste" required value="Onde o teste será realizado?"/>-->
<!--							<div class="tw-flex tw-flex-row">-->
<!--								<q-checkbox v-model="form.local_teste_online" label="Online" name="local_teste_online"-->
<!--								            val="Online"/>-->
<!--								<q-checkbox v-model="form.local_teste_presencial" label="Presencial"-->
<!--								            name="local_teste_presencial"-->
<!--								            val="Presencial"/>-->
<!--							</div>-->
<!--							<InputError :message="form.errors.local_teste" class="tw-mt-2"/>-->
<!--						</div>-->
<!--						<div class="tw-flex tw-flex-auto tw-flex-col tw-py-5">-->
<!--							<InputLabel for="testes_exigidos" required value="Testes Exigidos"/>-->
<!--							<q-select v-model="form.testes_exigidos" :options="optionsDoc" behavior="menu"-->
<!--							          class="tw-mt-1 tw-h-full tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--							          input-debounce="0"-->
<!--							          multiple outlined use-chips use-input-->
<!--							          @filter="filterFn">-->
<!--								<template v-slot:no-option>-->
<!--									<q-item>-->
<!--										<q-item-section class="text-grey">-->
<!--											No results-->
<!--										</q-item-section>-->
<!--									</q-item>-->
<!--								</template>-->
<!--							</q-select>-->
<!--						</div>-->
<!--						<div v-if="form.local_teste_online" class="tw-flex tw-flex-auto tw-flex-col tw-w-[35%]">-->
<!--                            <span class="tw-inline-flex tw-font-body tw-text-base tw-mb-4">Data limite para entrega de teste-->
<!--                                online-->
<!--                                <Icon class="tw-pl-2" icon="ep:arrow-down"/>-->
<!--                            </span>-->
<!--							<InputLabel for="data_limite_teste_online"-->
<!--							            value="Data limite para entrega do teste de aptidão online"/>-->
<!--							<q-input id="data_limite_teste_online" v-model="form.data_limite_teste_online" autofocus-->
<!--							         class="tw-mt-1" emit-value map-options-->
<!--							         outlined-->
<!--							         type="date"/>-->
<!--						</div>-->
<!--						<div v-if="form.local_teste_presencial">-->
<!--                            <span class="tw-inline-flex tw-font-body tw-text-base tw-mt-8">Data limite para entrega de teste-->
<!--                                Presencial-->
<!--                                <Icon class="tw-pl-2" icon="ep:arrow-down"/>-->
<!--                            </span>-->
<!--							<div class="tw-flex tw-flex-auto md:tw-gap-2 tw-pb-4 tw-mt-4">-->
<!--								<div class="tw-flex tw-flex-auto tw-w-60 tw-flex-col">-->
<!--									<InputLabel for="escola" value="Escola"/>-->
<!--									<q-select v-model="form.teste_presencial_escola" :options="optionsEscola" behavior="menu"-->
<!--									          class="tw-mt-1 tw-h-full tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--									          input-debounce="0" label="Escola" outlined use-input-->
<!--									          @filter="filterFn">-->
<!--										<template v-slot:no-option>-->
<!--											<q-item>-->
<!--												<q-item-section class="text-grey">-->
<!--													No results-->
<!--												</q-item-section>-->
<!--											</q-item>-->
<!--										</template>-->
<!--									</q-select>-->
<!--								</div>-->
<!--								<div class="tw-flex tw-flex-auto tw-flex-col">-->
<!--									<InputLabel for="data_limite_teste_presencial" value="Data do teste de aptidão presencial"/>-->
<!--									<q-input id="data_limite_teste_presencial" v-model="form.data_limite_teste_presencial"-->
<!--									         autofocus-->
<!--									         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--									         emit-value map-options outlined type="date"/>-->
<!--								</div>-->
<!--								<div class="tw-flex tw-flex-auto tw-flex-col">-->
<!--									<InputLabel for="hora_limite_teste_presencial" value="Horário do teste de aptidão"/>-->
<!--									<q-input id="hora_limite_teste_presencial" v-model="form.hora_limite_teste_presencial"-->
<!--									         autocomplete="hora_limite_teste_presencial" autofocus-->
<!--									         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--									         outlined-->
<!--									         required-->
<!--									         type="time"/>-->
<!--								</div>-->
<!--								<div class="tw-flex tw-flex-auto tw-flex-col">-->
<!--									<InputLabel for="sala_teste_presencial" required-->
<!--									            value="Adicionar sala onde o teste será realizado"/>-->
<!--									<q-input id="sala_teste_presencial" v-model="form.sala_teste_presencial"-->
<!--									         class="tw-mt-1 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--									         outlined-->
<!--									         placeholder="Preencha a Sala do Teste" type="text"/>-->
<!--									<InputError :message="form.errors.sala_teste_presencial" class="tw-mt-2"/>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--						<div class="tw-flex tw-flex-auto tw-flex-col tw-mt-4">-->
<!--							<InputLabel for="aptidao_idade" required value="Esse curso tem Limite de Idade?"/>-->
<!--							<div class="tw-flex tw-flex-row">-->
<!--								<q-toggle v-model="form.accept_idade" label="Sim" val="Sim"/>-->
<!--							</div>-->
<!--							<InputError :message="form.errors.destaque" class="tw-mt-2"/>-->
<!--						</div>-->
<!--						<div v-if="form.accept_idade" class="tw-flex tw-flex-auto tw-flex-col tw-mt-5 tw-pb-4">-->
<!--							<div class="tw-flex tw-flex-auto tw-flex-col">-->
<!--								<InputLabel for="idade_minima" required-->
<!--								            value="Idade Minima"/>-->
<!--								<q-input id="idade_minima" v-model="form.idade_minima"-->
<!--								         class="tw-mt-1 tw-block tw-w-[10%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
<!--								         min="1" outlined placeholder="Ex: 11 Anos" type="number"/>-->
<!--								<InputError :message="form.errors.idade_minima" class="tw-mt-2"/>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
				</div>
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.turmas')"
					      class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
						CANCELAR
					</Link>
					<span
						 class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center"
						 @click="store()">
                        <Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="fluent:save-16-regular"/>
                        Salvar
                    </span>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/Pages/InputError.vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import {Head, useForm, Link} from "@inertiajs/vue3";
import {Notify} from "quasar";
import {Icon} from "@iconify/vue";
import {ref, computed} from 'vue';

const props = defineProps({
	cursos: {
		type: Array,
		default: [],
	},
	editais: {
		type: Array,
		default: [],
	},
	documentacao: {
		type: Array,
		default: [],
	},
	escolas: {
		type: Array,
		default: [],
	},
	habilitacao: {
		type: Array,
		default: [],
	}
});

const form = useForm({
	nome: "",
	turno: [],
	modalidade: "",
	dias_semana: [],
	faixa_etaria: "",
	edital_id: "",
	curso_id: "",
	vagas: "",
	hora_inicio: "",
	hora_termino: "",
	data_inicio: "",

	habilitacao: "",
	habilitacoes_exigidas: [],

	accept: "",
	local_teste_online: "",
	data_limite_teste_online: '',
	testes_exigidos: [],

	local_teste_presencial: "",
	teste_presencial_escola: "",
	data_limite_teste_presencial: '',
	hora_limite_teste_presencial: '',
	sala_teste_presencial: '',
	accept_idade: "",
	idade_minima: "",
});

const optionsEditais = ref([]);
const optionsCursos = ref([]);
const optionsModalidade = ref([])
const optionsFaixaEtaria = ref([])
const optionsDiasSemana = ref([])
const optionsTurno = ref([])
const optionsEscola = ref([])
const optionsHabilidade = ref([])
const optionsDoc = ref([])

const accept = ref(false)
const local_teste_online = ref([])
const local_teste_presencial = ref([])
const optionsDocInsc = ref([])
const accept_idade = ref(false)

const opcoesDocumentosMatricula = props.documentacao.map(documentacao => ({
	label: documentacao.nome,
	value: documentacao.id
}))
const opcoesEscolas = props.escolas.map(escola => ({label: escola.nome, value: escola.id}))
const opcoesHabilitacao = props.habilitacao.map(habilidade => ({label: habilidade.nome, value: habilidade.id}));
const editaisList = props.editais.map((edital) => ({label: edital.nome, value: edital.id,}));
const cursosList = props.cursos.map((modelo) => ({label: modelo.nome, value: modelo.id,}));

console.log(props.habilitacao)

const opcoesTurno = ["Integral", "Matutino", "Vespertino", "Noturno"];
const opcoesModalidade = ["MOOC", "EAD", "Online", "Presencial"];
const opcoesDiasSemana = ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sabado", "Domingo"];
const opcoesFaixaetaria = ["Infantil", "Infanto-juvenil", "Adulto"];

function filterFn(val, update) {
	if (val === "") {
		update(() => {
			optionsEditais.value = editaisList;
			optionsCursos.value = cursosList;
			optionsModalidade.value = opcoesModalidade;
			optionsFaixaEtaria.value = opcoesFaixaetaria;
			optionsDiasSemana.value = opcoesDiasSemana;
			optionsTurno.value = opcoesTurno;
			optionsDoc.value = opcoesDocumentosMatricula;
			optionsEscola.value = opcoesEscolas;
			optionsHabilidade.value = opcoesHabilitacao;
		});
		return;
	}

	update(() => {
		const needle = val.toLowerCase();
		optionsEditais.value = editaisList.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsCursos.value = cursosList.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsModalidade.value = opcoesModalidade.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsFaixaEtaria.value = opcoesFaixaetaria.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsDiasSemana.value = opcoesDiasSemana.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsTurno.value = opcoesTurno.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsDoc.value = opcoesDocumentosMatricula.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsEscola.value = opcoesEscolas.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
		optionsHabilidade.value = opcoesHabilitacao.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
	});
}


function validateForm() {
	const fieldLabels = {
		edital_id: 'Nome do Edital',
		curso_id: 'Nome do curso',
		modalidade: 'Mmodalidade',
		faixa_etaria: 'Faixa Etária',
		vagas: 'Vagas',
		turno: 'Turno',
	};

	const requiredFields = Object.keys(fieldLabels);

	requiredFields.forEach(field => {
		if (!form[field]) {
			form.errors[field] = `O campo ${fieldLabels[field]} é obrigatório`;
		} else {
			form.errors[field] = null;
		}
	});
}

function capitalizeFirstLetter(str) {
	return str.charAt(0).toUpperCase() + str.slice(1);
}

function store() {
	validateForm();

	form.post(route("painel.turmas.store"), {
		preserveScroll: true,
		forceFormData: true,
		onSuccess: (res) => {
			form.reset();
			Notify.create({
				message: "Turma registrada com sucesso.",
				color: "secondary",
			});
		},
		onError: (err) => {
			console.log(err);
			Notify.create({
				message: "Não foi possível registrar a turma.",
				color: "negative",
			});
		},
	});
}
</script>
